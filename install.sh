#!/usr/bin/env bash

clear

###################################################################
# Script Name   : PulseISP Installer
# Description   : Automated Installer for PulseISP
# Author        : Mark Cockbain
# Email         : cockbainma@gmail.com
###################################################################

#################################################
# Variables
#################################################

USR_ROOT="root"
USR_ROOT_PWD=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16`
# Set default password for root user
#echo -e "$USR_ROOT_PWD\n$USR_ROOT_PWD\n" | sudo passwd root
OS_VER=`cat /etc/issue |awk '{print $1}'`
TEMP_DIR="temp"
INSTALL_URL="https://github.com/SaltySeaSlug/PulseISP.git"

#################################################
# CONSOLE COLOURS
#################################################

ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"
DIVIDER="$COL_BLUE +-------------------------------------------------------------+ $COL_RESET"

clear

################################################################################################################### MENU
echo -e "$DIVIDER"
echo -e "$COL_BLUE |                     PulseISP Pre Check                      | $COL_RESET"
echo -e "$DIVIDER"
echo

#################################################
# Pre system checks
#################################################

# Checking permissions
echo -e "$COL_YELLOW Verifying user permissions. $COL_RESET"
if [[ $EUID -ne 0 ]]; then
   echo -e "$COL_RED This script must be run as root. $COL_RESET"
   exit 1
else
    echo -e "$COL_GREEN OK. $COL_RESET"
fi

# Verify OS
echo -e "$COL_YELLOW Checking OS distribution. $COL_RESET"
if [[ $OS_VER == Ubuntu ]]; then
    echo -e "$COL_GREEN OK. $COL_RESET"
    sleep 1
else
    echo -e "$COL_RED Sorry, it seems your not running Ubuntu. $COL_RESET"
    exit 1
fi

# Verify Temp Directory
echo -e "$COL_YELLOW Verifying $TEMP_DIR directory. $COL_RESET"
sleep 1
if [ ! -d "/$TEMP_DIR" ]; then
    echo -e "$COL_RED /$TEMP_DIR folder not found. $COL_RESET"
    echo -e "$COL_MAGENTA Creating directory. $COL_RESET"
    echo -e "$COL_GREEN OK. $COL_RESET"
    mkdir /$TEMP_DIR
else
    echo -e "$COL_GREEN OK. $COL_RESET"
fi
cd /$TEMP_DIR || echo "Failure";

rm -fr "/${TEMP_DIR:?}/"*
rm -fr "/${TEMP_DIR:?}/".??*

# Verify Installation URL
echo -e "$COL_YELLOW Checking if install url is accessible. $COL_RESET"
cd /$TEMP_DIR || echo "Unable to access directory."

wget --retry-connrefused --waitretry=1 --read-timeout=20 --timeout=15 -t 0 -q https://raw.githubusercontent.com/SaltySeaSlug/PulseISP/main/.gitignore

if [ ! -f /$TEMP_DIR/.gitignore ]; then
    echo
    echo -e "$COL_RED ERROR: Unable to contact $INSTALL_URL, or possibly internet is not working or your IP is in black list at destination server $COL_RESET"
    echo -e "$COL_RED ERROR: Please check manual if $INSTALL_URL is accessible or not or if it have required files $COL_RESET"
    echo
    exit 0
else
    echo -e "$COL_GREEN OK. $COL_RESET"
fi
rm -fr "/${TEMP_DIR:?}/".gitignore

# Verify GIT
echo -e "$COL_YELLOW Checking if GIT is installed. $COL_RESET"
if ! [ -x "$(command -v git)" ]; then
	echo -e "$COL_RED Error: git is not installed. $COL_RESET" >&2
	sudo apt-get install git
else
    echo -e "$COL_GREEN OK. $COL_RESET"
fi
echo

echo -e "$COL_YELLOW Pre-system check completed. $COL_RESET"
sleep 2

clear

################################################################################################################### MENU
echo -e "$DIVIDER"
echo -e "$COL_BLUE |                   Auto Installer PulseISP                   | $COL_RESET"
echo -e "$DIVIDER"
echo
echo "1. Install"
echo "2. Update"
echo
echo -n "Choose an option: [1] "

read rmver
if [ -z "$rmver" ]; then
rmver="1"
fi

case $rmver in
1 ) echo "Selected: Install"

echo -e "$COL_CYAN Setup starting. $COL_RESET"
echo

# Clone repository to temp directory
sudo git clone "$INSTALL_URL" "/$TEMP_DIR"

#################################################
# Base Package Installation Tasks
#################################################

# Update system
apt update -y && apt upgrade -y && apt autoremove -y && apt clean -y && apt autoclean -y

# Install base packages
apt install -y cron openssh-server vim sysstat man-db wget rsync

#################################################
# Web Server Package Installation Tasks
#################################################

# Variables
WWW_PATH="/var/www/html"

# Apache variables
timeout=30
keep_alive=On
keep_alive_requests=120
keep_alive_timeout=5
prefork_start_servers=4
prefork_min_spare_servers=4
prefork_max_spare_servers=9
prefork_server_limit=`free -m | grep "Mem:" | awk '{print $2/2/15}' | xargs printf "%.0f"`
prefork_max_clients=`free -m | grep "Mem:" | awk '{print $2/2/15}' | xargs printf "%.0f"`
prefork_max_requests_per_child=1000
prefork_listen_backlog=`free -m | grep "Mem:" | awk '{print $2/2/15*2}' | xargs printf "%.0f"`

# PHP variables
max_execution_time=30
memory_limit=64M
error_reporting='E_ALL \& ~E_NOTICE | E_DEPRECATED'
post_max_size=8M
upload_max_filesize=2M
short_open_tag=On
expose_php=Off
session_save_path='/var/lib/php/sessions'

# Install Apache and PHP packages
apt-get install -y libapache2-mod-php libapache2-mod-php apache2 apache2-utils php-cli php-pear php-mysql php-gd php-dev php-curl php-opcache php-mail php-mail-mime php-db php-mbstring php-xml
/usr/sbin/a2dismod mpm_event
/usr/sbin/a2enmod access_compat alias auth_basic authn_core authn_file authz_core authz_groupfile authz_host authz_user autoindex deflate dir env filter mime mpm_prefork negotiation rewrite setenvif socache_shmcb ssl status php7.4 mpm_prefork
/usr/sbin/phpenmod opcache

############################################################################################################## TEST CODE
PHP_VER=`php -v | sed -e '/^PHP/!d' -e 's/.* \([0-9]\+\.[0-9]\+\).*$/\1/'`
/usr/sbin/a2dismod php"$PHP_VER"
apt-get install php-fpm -y
/usr/sbin/a2enmod proxy_fcgi setenvif
/usr/sbin/a2enconf php"$PHP_VER"-fpm
############################################################################################################## TEST CODE

# Copy over templates
mkdir /var/www/vhosts
mkdir -p /var/lib/php/sessions
chown root:www-data /var/lib/php/sessions
chmod 770 /var/lib/php/sessions
cp /$TEMP_DIR/templates/ubuntu/apache/default.template /etc/apache2/sites-available/
cp /$TEMP_DIR/templates/ubuntu/apache/apache2.conf.template /etc/apache2/apache2.conf
cp /$TEMP_DIR/templates/ubuntu/apache/ports.conf.template /etc/apache2/ports.conf
cp /$TEMP_DIR/templates/ubuntu/apache/mpm_prefork.conf.template  /etc/apache2/mods-available/mpm_prefork.conf
cp /$TEMP_DIR/templates/ubuntu/apache/ssl.conf.template  /etc/apache2/mods-available/ssl.conf
cp /$TEMP_DIR/templates/ubuntu/apache/status.conf.template  /etc/apache2/mods-available/status.conf
cp /$TEMP_DIR/templates/ubuntu/php/php.ini.template /etc/php/7.4/apache2/php.ini

# Setup Apache variables
sed -i "s/\$timeout/$timeout/g" /etc/apache2/apache2.conf
sed -i "s/\$keep_alive_setting/$keep_alive/g" /etc/apache2/apache2.conf
sed -i "s/\$keep_alive_requests/$keep_alive_requests/g" /etc/apache2/apache2.conf
sed -i "s/\$keep_alive_timeout/$keep_alive_timeout/g" /etc/apache2/apache2.conf
sed -i "s/\$prefork_start_servers/$prefork_start_servers/g" /etc/apache2/mods-available/mpm_prefork.conf
sed -i "s/\$prefork_min_spare_servers/$prefork_min_spare_servers/g" /etc/apache2/mods-available/mpm_prefork.conf
sed -i "s/\$prefork_max_spare_servers/$prefork_max_spare_servers/g" /etc/apache2/mods-available/mpm_prefork.conf
sed -i "s/\$prefork_server_limit/$prefork_server_limit/g" /etc/apache2/mods-available/mpm_prefork.conf
sed -i "s/\$prefork_max_clients/$prefork_max_clients/g" /etc/apache2/mods-available/mpm_prefork.conf
sed -i "s/\$prefork_max_requests_per_child/$prefork_max_requests_per_child/g" /etc/apache2/mods-available/mpm_prefork.conf
sed -i "s/\$prefork_listen_backlog/$prefork_listen_backlog/g" /etc/apache2/mods-available/mpm_prefork.conf

# Setup PHP variables
sed -i "s/\$memory_limit/$memory_limit/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$short_open_tag/$short_open_tag/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$expose_php/$expose_php/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$max_execution_time/$max_execution_time/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$error_reporting/$error_reporting/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$post_max_size/$post_max_size/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$upload_max_filesize/$upload_max_filesize/g" /etc/php/7.4/apache2/php.ini
sed -i "s@\$session_save_path@$session_save_path@g" /etc/php/7.4/apache2/php.ini

# Secure /server-status behind htaccess
srvstatus_htuser=serverinfo
srvstatus_htpass=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16`
echo "$srvstatus_htuser $srvstatus_htpass" > /root/.serverstatus
htpasswd -b -c /etc/apache2/status-htpasswd $srvstatus_htuser $srvstatus_htpass

# Restart Apache to apply new settings
systemctl enable apache2
systemctl restart apache2

# Open up ports
ufw allow to any port 1812 proto udp && sudo ufw allow to any port 1813 proto udp
iptables -I INPUT -p tcp --dport 80 -j ACCEPT && ufw allow 80 && ufw allow 443
sudo bash -c "echo -e '<?php\nphpinfo();\n?>' > $WWW_PATH/info.php"

#################################################
# MySQL Server Package Installation Tasks
#################################################

# MySQL Variables
MYSQL_USR="root"
MYSQL_PASS=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16`
MYSQL_DB="pulseisp_db"
MYSQL_SCHEME="import_db.sql"
MYSQL_RAD_USER="radius"
MYSQL_RAD_PASS=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16`

# Install MySQL packages
apt-get install -y mysql-server mysql-client libmysqlclient-dev
mkdir -p /etc/mysql/conf.d
mkdir -p /var/lib/mysqltmp
chown mysql:mysql /var/lib/mysqltmp

# Set some info before we secure
mysql -e "CREATE USER '$MYSQL_RAD_USER'@'%' IDENTIFIED BY '$MYSQL_RAD_PASS';"
mysql -e "GRANT ALL PRIVILEGES ON *.* TO '$MYSQL_RAD_USER'@'%';"
mysql -e "CREATE DATABASE $MYSQL_DB;"

## ISSUE HERE
mysql -e "ALTER USER '$MYSQL_USR'@'localhost' IDENTIFIED WITH mysql_native_password BY '$MYSQL_PASS';"
mysql -e "DELETE FROM mysql.user WHERE User='';"
mysql -e "DELETE FROM mysql.user WHERE User='$MYSQL_USR' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
mysql -e "DROP DATABASE test;"
mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\_%';"
mysql -e "FLUSH PRIVILEGES;"

#mysql -e "DROP USER ''@'localhost'"
#mysql -e "DROP USER ''@'$(hostname)'"
#mysql -e "DROP DATABASE test"
#mysql -e "FLUSH PRIVILEGES;"

#mysql -e "DELETE FROM mysql.user WHERE USER='$MYSQL_USR' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
#mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test_%';"

systemctl restart mysql

# Set MySQL root password in /root/.my.cnf
cp /$TEMP_DIR/templates/ubuntu/mysql/dot.my.cnf.template /root/.my.cnf
sed -i "s/\$mysqlrootpassword/$MYSQL_PASS/g" /root/.my.cnf
sed -i "s/\$mysqlrootusername/$MYSQL_USR/g" /root/.my.cnf

# Restart MySQL to apply changes
rm -f /var/lib/mysql/ib_logfile0
rm -f /var/lib/mysql/ib_logfile1
systemctl enable mysql
systemctl restart mysql


#################################################
# Holland Installation Tasks
#################################################

# Setup Holland repo
. /etc/os-release
echo "deb https://download.opensuse.org/repositories/home:/holland-backup/x${NAME}_${VERSION_ID}/ ./" >> /etc/apt/sources.list
wget -qO - https://download.opensuse.org/repositories/home:/holland-backup/x${NAME}_${VERSION_ID}/Release.key | apt-key add -

# Install Holland packages
apt-get update
apt-get install -y holland python3-mysqldb

# Copy over templates and configure backup directory
cp /$TEMP_DIR/templates/ubuntu/holland/default.conf.template /etc/holland/backupsets/default.conf

# Setup nightly cronjob
echo "30 3 * * * root /usr/sbin/holland -q bk" > /etc/cron.d/holland

# Run holland
/usr/sbin/holland -q bk


#################################################
# PHPMyAdmin Installation Tasks
#################################################

# PHPMyAdmin variables
htuser=serverinfo
htpass=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16`

# Install PHPMyAdmin package
export DEBIAN_FRONTEND=noninteractive
apt-get install -y phpmyadmin

# Copy over templates
cp /$TEMP_DIR/templates/ubuntu/phpmyadmin/phpMyAdmin.conf.template /etc/phpmyadmin/phpMyAdmin.conf

# Setup PHPMyAdmin variables
echo "$htuser $htpass" > /root/.phpmyadminpass

# Set PHPMyAdmin before htaccess file
htpasswd -b -c /etc/phpmyadmin/phpmyadmin-htpasswd $htuser $htpass

# Symlink in apache config and restart apache
ln -s /etc/phpmyadmin/phpMyAdmin.conf /etc/apache2/conf-enabled/phpMyAdmin.conf
systemctl restart apache2







#################################################
# FreeRadius Installation Tasks
#################################################

# FreeRadius Variables
FREERADIUS_PATH="/etc/freeradius"
FREERADIUS_SECRET=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16`

apt-get install -y freeradius freeradius-mysql freeradius-utils freeradius-rest

# Copy over templates
#cp /$TEMP_DIR/templates/freeradius/mods-available/sql.template /etc/freeradius/3.0/mods-available/sql
#cp /$TEMP_DIR/templates/freeradius/mods-available/sqlcounter.template /etc/freeradius/3.0/mods-available/sqlcounter
#cp /$TEMP_DIR/templates/freeradius/sites-available/default.template /etc/freeradius/3.0/sites-available/default

# Setup Apache variables
#sed -i "s/\$MYSQL_USR/$MYSQL_USR/g" /etc/freeradius/3.0/mods-available/sql
#sed -i "s/\$MYSQL_PASS/$MYSQL_PASS/g" /etc/freeradius/3.0/mods-available/sql
#sed -i "s/\$MYSQL_DB/$MYSQL_DB/g" /etc/freeradius/3.0/mods-available/sql

# Setup Symbolic Links
ln -s /etc/freeradius/3.0/mods-available/sql /etc/freeradius/3.0/mods-enabled/
ln -s /etc/freeradius/3.0/mods-available/sqlcounter /etc/freeradius/3.0/mods-enabled/
ln -s /etc/freeradius/3.0/mods-available/rest /etc/freeradius/3.0/mods-enabled/

# Setup ownership user and group
chgrp -h freerad /etc/freeradius/3.0/mods-available/sql
chown -R freerad:freerad /etc/freeradius/3.0/mods-enabled/sql\

systemctl enable --now freeradius
systemctl restart freeradius
ufw allow to any port 1812 proto udp && ufw allow to any port 1813 proto udp



#################################################
# PulseISP Installation Tasks
#################################################

# Variables
WWW_USR="www-data"

# Import Database
#mysql -u$MYSQL_USR -p$MYSQL_PASS -e "CREATE DATABASE $MYSQL_DB;"

RESULT=`mysql --skip-column-names -e "SHOW DATABASES LIKE '$MYSQL_DB'"`
if [ "$RESULT" == "$MYSQL_DB" ]; then
  echo -e "$COL_GREEN -$DB database exist OK $COL_RESET"
else
  echo -e "$COL_RED -$DB database does not exist! Probably either mysql not accessible or wrong credentials provided. $COL_RESET"
  exit 1
fi

mysql -u$MYSQL_USR -p$MYSQL_PASS -e "$MYSQL_DB < /$TEMP_DIR/db/$MYSQL_SCHEME;"

systemctl restart mysql

# Copy web GUI to Apache public folder
cp -fr /$TEMP_DIR/site/. ${WWW_PATH:?}/
cp /$TEMP_DIR/templates/site/database.php.template /${WWW_PATH:?}/application/config/database.php
sed -i "s/\$mysqlrootuser/$MYSQL_RAD_USER/g" /${WWW_PATH:?}/application/config/database.php
sed -i "s/\$mysqlrootpass/$MYSQL_RAD_PASS/g" /${WWW_PATH:?}/application/config/database.php
sed -i "s/\$mysqldatabase/$MYSQL_DB/g" /${WWW_PATH:?}/application/config/database.php


systemctl restart apache2


# Set MySQL root password in /root/.my.cnf
cp /$TEMP_DIR/templates/ubuntu/misc/misc.template /root/.misc.cnf
sed -i "s/\$radiususer/$MYSQL_RAD_USER/g" /root/.misc.cnf
sed -i "s/\$radiuspassword/$MYSQL_RAD_PASS/g" /root/.misc.cnf
sed -i "s/\$freeradiussecret/$FREERADIUS_SECRET/g" /root/.misc.cnf


#################################################
# Setup Report
#################################################

# Setup report variables
txtbld=$(tput bold)
lightblue=`tput setaf 6`
nc=`tput sgr0`
real_ip=`curl --silent -4 icanhazip.com 2>&1`

clear


# Generate setup report

cat << EOF > /root/setup_report

${txtbld}---------------------------------------------------------------
                 LAMP Installation Complete
---------------------------------------------------------------${nc}

The LAMP installation has been completed!  Some important information is
posted below.  A copy of this setup report exists in /root/setup_report.

${txtbld}---------------------------------------------------------------
                 Security Credentials
---------------------------------------------------------------${nc}

${lightblue}Apache Server Status URL:${nc}   http://$real_ip/server-status
${lightblue}Apache Server Status User:${nc}  serverinfo
${lightblue}Apache Server Status Pass:${nc}  $srvstatus_htpass

${lightblue}PHPMyAdmin URL:${nc}  http://$real_ip/phpmyadmin
${lightblue}PHPMyAdmin User:${nc} serverinfo    /    root
${lightblue}PHPMyAdmin Pass:${nc} $htpass       /    $MYSQL_PASS

${lightblue}MySQL Root User:${nc}  $MYSQL_USR
${lightblue}MySQL Root Pass:${nc}  $MYSQL_PASS
${lightblue}Radius User:${nc} $MYSQL_RAD_USER
${lightblue}Radius Pass:${nc} $MYSQL_RAD_PASS

${lightblue}Freeradius Secret:${nc} $FREERADIUS_SECRET

** For security purposes, there is an htaccess file in front of phpmyadmin.
So when the popup window appears, use the serverinfo username and password.
Once your on the phpmyadmin landing page, use the root MySQL credentials.

If you lose this setup report, the credentials can be found in:
${lightblue}Apache Server Status:${nc}  /root/.serverstatus
${lightblue}PHPMyAdmin:${nc}            /root/.phpmyadmin
${lightblue}MySQL Credentials:${nc}     /root/.my.cnf
${lightblue}Misc Credentials:${nc}      /root/.misc.cnf

${txtbld}---------------------------------------------------------------
                 Nightly MySQL Backups
---------------------------------------------------------------${nc}

MySQL backups are being performed via Holland (www.hollandbackup.org) and
is set to run nightly at 3:30AM server time.

The critical information about Holland is below:

${lightblue}Backup directory:${nc}  /var/spool/holland
${lightblue}Backups run time:${nc}  Nightly at 3:30AM server time
${lightblue}Retention rate:${nc}    7 days

${lightblue}Holland log file:${nc}  /var/log/holland/holland.log
${lightblue}Holland configs:${nc}   /etc/holland/holland.conf
                   /etc/holland/backupsets/default.conf
                   /etc/cron.d/holland

${txtbld}---------------------------------------------------------------${nc}

EOF

cat /root/setup_report
;;
2 ) echo "Selected: Update"
#----------------------------------------------------------------------- DOWNLOADING


sed -n -e '/user/ s/.*= *//p' "/root/.serverstatus"
sed -n -e '/password/ s/.*= *//p' "/root/.serverstatus"
sed -n -e '/freeradius/ s/.*= *//p' "/root/.serverstatus"

sed -n -e '/user/ s/.*= *//p' "/root/.phpmyadmin"
sed -n -e '/password/ s/.*= *//p' "/root/.phpmyadmin"
sed -n -e '/freeradius/ s/.*= *//p' "/root/.phpmyadmin"

sed -n -e '/user/ s/.*= *//p' "/root/.my.cnf"
sed -n -e '/password/ s/.*= *//p' "/root/.my.cnf"
sed -n -e '/freeradius/ s/.*= *//p' "/root/.my.cnf"

sed -n -e '/user/ s/.*= *//p' "/root/.misc.cnf"
sed -n -e '/password/ s/.*= *//p' "/root/.misc.cnf"
sed -n -e '/freeradius/ s/.*= *//p' "/root/.misc.cnf"
echo
;;

3 ) echo "Selected: Test"
#----------------------------------------------------------------------- DOWNLOADING
sudo apt-get install git
#sudo git clone "$INSTALL_URL" "/$TEMP_DIR"
#################################################
# MySQL Server Package Installation Tasks
#################################################

# Install MySQL packages
mysql -uroot -p7wRRl9arWvNwioDV -e pulseisp_db < /temp/db/import_db.sql

;;

* ) echo "Invalid selection. Installation aborted."
echo
exit
;;
esac

exit