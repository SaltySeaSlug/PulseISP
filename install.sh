#!/usr/bin/env bash

#
# Copyright (c) 2021.
# Last Modified : 2021/05/18, 12:29
#

clear

########################################################################################################################
# Script Name   : PulseISP Installer
# Description   : Automated Installer for PulseISP
# Author        : Mark Cockbain | Unitech Solutions TTL
# Email         : mark@unitechsol.co.za
########################################################################################################################

#----------------------------------------------------------------------------------------------------------------------#
# Console Colours
#----------------------------------------------------------------------------------------------------------------------#
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
#COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"
DIVIDER="$COL_BLUE +-------------------------------------------------------------+ $COL_RESET"

#----------------------------------------------------------------------------------------------------------------------#
# Variables
#----------------------------------------------------------------------------------------------------------------------#

# .htaccess username and password
HTUSER=serverinfo
HTPASS=$(< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16)

# Ubuntu username and password
USR_ROOT="pulseisp"
USR_ROOT_PWD=$(< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16)

# Apache
WWW_USR="www-data"
WWW_PATH="/var/www/html/pulseisp/"

# Freeradius Secret
FREERADIUS_SECRET=$(< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16)

# OS Version/Distribution
OS_VER=$(cat < /etc/issue | awk '{print $1}')

# Global variables
TEMP_DIR="/temp"
INSTALL_URL="https://github.com/SaltySeaSlug/PulseISP.git"
BASE_INSTALL_URL="https://github.com/SaltySeaSlug/PulseISP"
BACKUP_DIR="/backup"



APT_LOG="$> ${TEMP_DIR:?}/apt.log"
DEBUG=true



clear

######################################################################################################################## MENU
echo -e "$DIVIDER"
echo -e "$COL_BLUE |                     PulseISP Pre Check                      | $COL_RESET"
echo -e "$DIVIDER"
echo


#----------------------------------------------------------------------------------------------------------------------#
# Pre system checks
#----------------------------------------------------------------------------------------------------------------------#

######################################################################################################################## Checking permissions
echo -e "$COL_YELLOW Verifying user permissions. $COL_RESET"
if [[ $EUID -ne 0 ]]; then
   echo -e "$COL_RED This script must be run as root. $COL_RESET"
   exit 1
else
    echo -e "$COL_GREEN OK. $COL_RESET"
fi

######################################################################################################################## Verify OS
echo -e "$COL_YELLOW Checking OS distribution. $COL_RESET"
if [[ $OS_VER == Ubuntu ]]; then
    echo -e "$COL_GREEN OK. $COL_RESET"
    sleep 1
else
    echo -e "$COL_RED Sorry, it seems your not running Ubuntu. $COL_RESET"
    exit 1
fi

######################################################################################################################## Set timezone

#croncmd="/usr/bin/php ${WWW_PATH:?}/crons/cron.freeradius_cleansession.php 2>&1 >/dev/null"
#cronjob="* * * * * $croncmd"
#( crontab -l | grep -v -F "$croncmd" ; echo "$cronjob" ) | crontab -
# remove
#( crontab -l | grep -v -F "$croncmd" ) | crontab -
######################################################################################################################## Verify Temp Directory
echo -e "$COL_YELLOW Verifying ${TEMP_DIR:?} directory. $COL_RESET"
sleep 1
if [ ! -d "${TEMP_DIR:?}" ]; then
    #echo -e "$COL_RED ${TEMP_DIR:?} folder not found. $COL_RESET"
    #echo -e "$COL_MAGENTA Creating directory. $COL_RESET"
    echo -e "$COL_GREEN OK. $COL_RESET"
    mkdir ${TEMP_DIR:?}
else
    echo -e "$COL_GREEN OK. $COL_RESET"
fi
cd ${TEMP_DIR:?} || echo "Failure";

rm -fr "${TEMP_DIR:?}/"*
rm -fr "${TEMP_DIR:?}/".??*

######################################################################################################################## Verify Installation URL
echo -e "$COL_YELLOW Checking if install url is accessible. $COL_RESET"
cd ${TEMP_DIR:?} || echo "Unable to access directory."

wget --retry-connrefused --waitretry=1 --read-timeout=20 --timeout=15 -t 0 -q https://raw.githubusercontent.com/SaltySeaSlug/PulseISP/main/.gitignore

if [ ! -f ${TEMP_DIR:?}/.gitignore ]; then
    echo
    echo -e "$COL_RED ERROR: Unable to contact $INSTALL_URL, or possibly internet is not working or your IP is in black list at destination server $COL_RESET"
    echo -e "$COL_RED ERROR: Please check manual if $INSTALL_URL is accessible or not or if it have required files $COL_RESET"
    echo
    exit 0
else
    echo -e "$COL_GREEN OK. $COL_RESET"
fi
rm -fr "${TEMP_DIR:?}/".gitignore



echo -e "$COL_GREEN Pre-system check completed. $COL_RESET"
sleep 1

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

read -r rmver
if [ -z "$rmver" ]; then
rmver="1"
fi

case $rmver in
1 ) echo "Selected: Install"

######################################################################################################################## Create new root user (pulseisp)
echo -e "$COL_CYAN Creating user account. $COL_RESET"

adduser --quiet --disabled-password --shell /bin/bash --home /home/$USR_ROOT --gecos "Administrative User" $USR_ROOT
# Set user password
echo "$USR_ROOT:$USR_ROOT_PWD" | chpasswd
# Add user to admin group
usermod -aG sudo $USR_ROOT

echo -e "$COL_CYAN Setup starting. $COL_RESET"
sleep 1
clear

echo -e "$COL_CYAN ########################################################## $COL_RESET"
echo -e "$COL_CYAN Installation Tasks $COL_RESET"
echo -e "$COL_CYAN ########################################################## $COL_RESET"
echo

######################################################################################################################## Update System
timedatectl set-timezone Africa/Johannesburg
#sudo apt update --fix-missing

echo -e "$COL_YELLOW Update System $COL_RESET"

if [ $DEBUG ]; then apt update -y && apt upgrade -y && apt autoremove -y && apt clean -y && apt autoclean -y;
else apt update -y && apt upgrade -y && apt autoremove -y && apt clean -y && apt autoclean -y "$APT_LOG"; fi



#apt update -y && apt upgrade -y && apt autoremove -y && apt clean -y && apt autoclean -y

######################################################################################################################## Verify GIT
echo -e "$COL_YELLOW Checking if GIT is installed. $COL_RESET"
if ! [ -x "$(command -v git)" ]; then
	echo -e "$COL_RED Error: git is not installed. $COL_RESET" >&2
	sudo apt-get install git
else
    echo -e "$COL_GREEN OK. $COL_RESET"
fi
echo

######################################################################################################################## Install base packages
echo -e "$COL_YELLOW Install base packages $COL_RESET"

if [ $DEBUG ]; then apt install -y cron openssh-server vim sysstat man-db wget rsync;
else apt install -y cron openssh-server vim sysstat man-db wget rsync "$APT_LOG"; fi

#apt install -y cron openssh-server vim sysstat man-db wget rsync
git clone "$INSTALL_URL" "${TEMP_DIR:?}"


######################################################################################################################## Start Test Code (26-01-2020)
# Replace variables in files with new ones
sed -i "s/\$FREERADIUS_SECRET/$FREERADIUS_SECRET/g" ${TEMP_DIR}/db/"$MYSQL_SCHEME"

######################################################################################################################## Install NTP service
apt-get -y install ntp ntpdate
cp /usr/share/zoneinfo/Africa/Johannesburg /etc/localtime
sudo /etc/init.d/ntp restart
######################################################################################################################## Disable IPV6


######################################################################################################################## End Test Code (26-01-2020)


######################################################################################################################## Web Server Package Installation Tasks
echo -e "$COL_YELLOW Web Server Package Installation Tasks $COL_RESET"

######################################################################################################################## Variables
######################################################################################################################## Apache variables
timeout=300
keep_alive=On
keep_alive_requests=120
keep_alive_timeout=5
prefork_start_servers=4
prefork_min_spare_servers=4
prefork_max_spare_servers=9
prefork_server_limit=$(free -m | grep "Mem:" | awk '{print $2/2/15}' | xargs printf "%.0f")
prefork_max_clients=$(free -m | grep "Mem:" | awk '{print $2/2/15}' | xargs printf "%.0f")
prefork_max_requests_per_child=1000
prefork_listen_backlog=$(free -m | grep "Mem:" | awk '{print $2/2/15*2}' | xargs printf "%.0f")

######################################################################################################################## PHP variables
max_execution_time=300
memory_limit=64M
error_reporting='E_ALL \& ~E_NOTICE | E_DEPRECATED'
post_max_size=8M
upload_max_filesize=10M
short_open_tag=On
expose_php=Off
session_save_path='/var/lib/php/sessions'

######################################################################################################################## Install Apache and PHP packages
echo -e "$COL_YELLOW Install Apache and PHP packages $COL_RESET"

apt-get install -y libapache2-mod-php libapache2-mod-php apache2 apache2-utils php-cli php-pear php-mysql php-gd php-dev php-curl php-opcache php-mail php-mail-mime php-db php-mbstring php-xml php-bcmath php-snmp
/usr/sbin/a2dismod mpm_event
/usr/sbin/a2enmod access_compat alias auth_basic authn_core authn_file authz_core authz_groupfile authz_host authz_user autoindex deflate dir env filter mime mpm_prefork negotiation rewrite setenvif socache_shmcb ssl status php7.4 mpm_prefork
/usr/sbin/phpenmod opcache

######################################################################################################################## Enable FPM
#PHP_VER=$(php -v | sed -e '/^PHP/!d' -e 's/.* \([0-9]\+\.[0-9]\+\).*$/\1/')
/usr/sbin/a2dismod php7.4
apt-get install php7.4-fpm -y
/usr/sbin/a2enmod proxy_fcgi setenvif
/usr/sbin/a2enconf php7.4-fpm

######################################################################################################################## Copy over templates
echo -e "$COL_YELLOW Copy over templates $COL_RESET"

mkdir ${WWW_PATH}
mkdir -p /var/lib/php/sessions
chown root:www-data /var/lib/php/sessions
chmod 770 /var/lib/php/sessions
cp ${TEMP_DIR:?}/templates/ubuntu/apache/default.template /etc/apache2/sites-available/
cp ${TEMP_DIR:?}/templates/ubuntu/apache/apache2.conf.template /etc/apache2/apache2.conf
cp ${TEMP_DIR:?}/templates/ubuntu/apache/ports.conf.template /etc/apache2/ports.conf
cp ${TEMP_DIR:?}/templates/ubuntu/apache/mpm_prefork.conf.template  /etc/apache2/mods-available/mpm_prefork.conf
cp ${TEMP_DIR:?}/templates/ubuntu/apache/ssl.conf.template  /etc/apache2/mods-available/ssl.conf
cp ${TEMP_DIR:?}/templates/ubuntu/apache/status.conf.template  /etc/apache2/mods-available/status.conf
cp ${TEMP_DIR:?}/templates/ubuntu/php/php.ini.template /etc/php/7.4/apache2/php.ini
cp ${TEMP_DIR:?}/templates/ubuntu/php/php.ini.template /etc/php/7.4/fpm/php.ini

######################################################################################################################## Setup Apache Variables
echo -e "$COL_YELLOW Setup Apache Variables $COL_RESET"

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

######################################################################################################################## Setup PHP variables
echo -e "$COL_YELLOW Setup PHP Variables $COL_RESET"

sed -i "s/\$memory_limit/$memory_limit/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$short_open_tag/$short_open_tag/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$expose_php/$expose_php/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$max_execution_time/$max_execution_time/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$error_reporting/$error_reporting/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$post_max_size/$post_max_size/g" /etc/php/7.4/apache2/php.ini
sed -i "s/\$upload_max_filesize/$upload_max_filesize/g" /etc/php/7.4/apache2/php.ini
sed -i "s@\$session_save_path@$session_save_path@g" /etc/php/7.4/apache2/php.ini

######################################################################################################################## Setup PHP variables for FPM
sed -i "s/\$memory_limit/$memory_limit/g" /etc/php/7.4/fpm/php.ini
sed -i "s/\$short_open_tag/$short_open_tag/g" /etc/php/7.4/fpm/php.ini
sed -i "s/\$expose_php/$expose_php/g" /etc/php/7.4/fpm/php.ini
sed -i "s/\$max_execution_time/$max_execution_time/g" /etc/php/7.4/fpm/php.ini
sed -i "s/\$error_reporting/$error_reporting/g" /etc/php/7.4/fpm/php.ini
sed -i "s/\$post_max_size/$post_max_size/g" /etc/php/7.4/fpm/php.ini
sed -i "s/\$upload_max_filesize/$upload_max_filesize/g" /etc/php/7.4/fpm/php.ini
sed -i "s@\$session_save_path@$session_save_path@g" /etc/php/7.4/fpm/php.ini

######################################################################################################################## Secure /server-status | Write to config file
echo -e "$COL_YELLOW Secure /server-status | Write to config file $COL_RESET"

#srvstatus_htuser=serverinfo
#srvstatus_htpass=$(< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16)
echo "$HTUSER $HTPASS" > /root/.serverstatus
htpasswd -b -c /etc/apache2/status-htpasswd $HTUSER "$HTPASS"

######################################################################################################################## Restart Apache to apply new settings
echo -e "$COL_YELLOW Restart Apache to apply new settings $COL_RESET"

systemctl enable apache2
systemctl restart apache2

######################################################################################################################## Modify Firewall Rules
echo -e "$COL_YELLOW Modify Firewall Rules $COL_RESET"

ufw allow to any port 1812 proto udp && sudo ufw allow to any port 1813 proto udp
iptables -I INPUT -p tcp --dport 80 -j ACCEPT && ufw allow 80 && ufw allow 443
sudo bash -c "echo -e '<?php\nphpinfo();\n?>' > ${WWW_PATH:?}/info.php"

######################################################################################################################## MySQL Server Package Installation Tasks
echo -e "$COL_YELLOW MySQL Server Package Installation Tasks $COL_RESET"

######################################################################################################################## MySQL Variables

# Server details
MYSQL_HOST='localhost'
MYSQL_PORT=3306
MYSQL_DB="pulseisp_db"
MYSQL_SCHEME="pulseisp_db.sql"

# Current details
MYSQL_USR="root"
MYSQL_PASS=$(< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16)

# New user details
MYSQL_RAD_USER="radius"
MYSQL_RAD_PASS=$(< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16)

######################################################################################################################## Install MySQL packages
echo -e "$COL_YELLOW Install MySQL Packages $COL_RESET"

apt-get install -y mysql-server mysql-client libmysqlclient-dev
mkdir -p /etc/mysql/conf.d
mkdir -p /var/lib/mysqltmp
chown mysql:mysql /var/lib/mysqltmp

######################################################################################################################## Set some security
echo -e "$COL_YELLOW Set some security for MySQL $COL_RESET"

mysql -e "CREATE USER '$MYSQL_RAD_USER'@'%' IDENTIFIED BY '$MYSQL_RAD_PASS';"
mysql -e "GRANT ALL PRIVILEGES ON *.* TO '$MYSQL_RAD_USER'@'%';"
mysql -e "CREATE DATABASE $MYSQL_DB;"
mysql $MYSQL_DB < ${TEMP_DIR:?}/db/$MYSQL_SCHEME

mysql -e "DELETE FROM mysql.user WHERE User='';"
mysql -e "DELETE FROM mysql.user WHERE User='$MYSQL_USR' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
mysql -e "DROP DATABASE test;"
mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\_%';"
mysql -e "ALTER USER '$MYSQL_USR'@'localhost' IDENTIFIED WITH mysql_native_password BY '$MYSQL_PASS';"
mysql -e "FLUSH PRIVILEGES;"

systemctl restart mysql

######################################################################################################################## WRITE TO CONFIG FILE
######################################################################################################################## Set MySQL root password in /root/.my.cnf
cp ${TEMP_DIR:?}/templates/ubuntu/mysql/dot.my.cnf.template /root/.my.cnf
sed -i "s/\$mysqlrootpassword/$MYSQL_PASS/g" /root/.my.cnf
sed -i "s/\$mysqlrootusername/$MYSQL_USR/g" /root/.my.cnf

######################################################################################################################## Restart MySQL to apply changes
rm -f /var/lib/mysql/ib_logfile0
rm -f /var/lib/mysql/ib_logfile1
systemctl enable mysql
systemctl restart mysql


########################################################################################################################
# Holland Installation Tasks
########################################################################################################################

######################################################################################################################## Setup Holland repo
. /etc/os-release
echo "deb https://download.opensuse.org/repositories/home:/holland-backup/x${NAME}_${VERSION_ID}/ ./" >> /etc/apt/sources.list
wget -qO - https://download.opensuse.org/repositories/home:/holland-backup/x"${NAME}"_"${VERSION_ID}"/Release.key | apt-key add -

######################################################################################################################## Install Holland packages
apt-get update
apt-get install -y holland python3-mysqldb

######################################################################################################################## Copy over templates and configure backup directory
cp ${TEMP_DIR:?}/templates/ubuntu/holland/default.conf.template /etc/holland/backupsets/default.conf

######################################################################################################################## Setup nightly cronjob
echo "30 3 * * * root /usr/sbin/holland -q bk" > /etc/cron.d/holland

######################################################################################################################## Run holland
/usr/sbin/holland -q bk


########################################################################################################################
# PHPMyAdmin Installation Tasks
########################################################################################################################

######################################################################################################################## PHPMyAdmin variables

######################################################################################################################## Install PHPMyAdmin package
export DEBIAN_FRONTEND=noninteractive
apt-get install -y phpmyadmin

######################################################################################################################## Copy over templates
cp ${TEMP_DIR:?}/templates/ubuntu/phpmyadmin/phpMyAdmin.conf.template /etc/phpmyadmin/phpMyAdmin.conf

######################################################################################################################## WRITE TO CONFIG FILE
######################################################################################################################## Setup PHPMyAdmin variables
echo "$HTUSER $HTPASS" > /root/.phpmyadminpass

######################################################################################################################## Set PHPMyAdmin before htaccess file
htpasswd -b -c /etc/phpmyadmin/phpmyadmin-htpasswd $HTUSER "$HTPASS"

######################################################################################################################## Symlink in apache config and restart apache
ln -s /etc/phpmyadmin/phpMyAdmin.conf /etc/apache2/conf-enabled/phpMyAdmin.conf
systemctl restart apache2







########################################################################################################################
# FreeRadius Installation Tasks
########################################################################################################################

######################################################################################################################## FreeRadius Variables
apt-get install -y freeradius freeradius-mysql freeradius-utils freeradius-rest

FREERADIUS_VERSION=$(freeradius -v | sed -e '/^radiusd/!d' -e 's/.* \([0-9]\+\.[0-9]\+\).*$/\1/');

case $FREERADIUS_VERSION in
1.0) FREERADIUS_PATH="";;
2.0) FREERADIUS_PATH="";;
3.0) FREERADIUS_PATH="/etc/freeradius/3.0";;
esac

######################################################################################################################## Copy over templates
cp ${TEMP_DIR:?}/templates/freeradius/mods-available/sql.template ${FREERADIUS_PATH:?}/mods-available/sql
#cp ${TEMP_DIR:?}/templates/freeradius/mods-available/sqlcounter.template /etc/freeradius/3.0/mods-available/sqlcounter
cp ${TEMP_DIR:?}/templates/freeradius/sites-available/default.template ${FREERADIUS_PATH:?}/sites-available/default
cp ${TEMP_DIR:?}/templates/freeradius/clients.conf.template ${FREERADIUS_PATH:?}/clients.conf
cp ${TEMP_DIR:?}/templates/freeradius/mods-config/ippool.mysql.queries.conf.template ${FREERADIUS_PATH:?}/mods-config/sql/ippool/mysql/queries.conf
cp ${TEMP_DIR:?}/templates/freeradius/mods-config/sql.main.mysql.queries.config.template ${FREERADIUS_PATH:?}/mods-config/sql/main/mysql/queries.conf


sed -i "s/\$MYSQL_RAD_USER/$MYSQL_RAD_USER/g" ${FREERADIUS_PATH:?}/mods-available/sql
sed -i "s/\$MYSQL_RAD_PASS/$MYSQL_RAD_PASS/g" ${FREERADIUS_PATH:?}/mods-available/sql
sed -i "s/\$MYSQL_DB/$MYSQL_DB/g" ${FREERADIUS_PATH:?}/mods-available/sql

######################################################################################################################## Start Test Code (2020-01-26)

#sed -i 's/password = "radpass"/password = "'$RADIUS_PWD'"/' /etc/freeradius/3.0/mods-available/sql.conf
#sed -i 's/#port = 3306/port = 3306/' /etc/freeradius/3.0/mods-available/sql.conf

sed -i -e "s/$INCLUDE sql.conf/\n$INCLUDE sql.conf/g" ${FREERADIUS_PATH:?}/radiusd.conf
sed -i -e "s|$INCLUDE sql/mysql/counter.conf|\n$INCLUDE sql/mysql/counter.conf|g" ${FREERADIUS_PATH:?}/radiusd.conf
sed -i -e 's|authorize {|authorize {\nsql|' ${FREERADIUS_PATH:?}/sites-available/inner-tunnel
sed -i -e 's|session {|session {\nsql|' ${FREERADIUS_PATH:?}/sites-available/inner-tunnel
sed -i -e 's|authorize {|authorize {\nsql|' ${FREERADIUS_PATH:?}/sites-available/default
sed -i -e 's|session {|session {\nsql|' ${FREERADIUS_PATH:?}/sites-available/default
sed -i -e 's|accounting {|accounting {\nsql|' ${FREERADIUS_PATH:?}/sites-available/default
sed -i "s/\adminsecret/$FREERADIUS_SECRET/g" ${FREERADIUS_PATH}/sites-available/status
sed -i "s/\$FREERADIUS_SECRET/$FREERADIUS_SECRET/g" ${FREERADIUS_PATH:?}/clients.conf

# Install SNMP Native
#apt-get install snmpd snmp libsnmp-dev
######################################################################################################################## End Test Code (2020-01-26)





######################################################################################################################## Setup Symbolic Links
ln -s ${FREERADIUS_PATH:?}/mods-available/sql ${FREERADIUS_PATH:?}/mods-enabled/
ln -s ${FREERADIUS_PATH:?}/mods-available/sqlippool ${FREERADIUS_PATH:?}/mods-enabled/
ln -s ${FREERADIUS_PATH:?}/sites-available/status ${FREERADIUS_PATH:?}/sites-enabled/status

#ln -s /etc/freeradius/3.0/mods-available/sqlcounter /etc/freeradius/3.0/mods-enabled/
#ln -s /etc/freeradius/3.0/mods-available/rest /etc/freeradius/3.0/mods-enabled/

######################################################################################################################## Setup Apache variables

######################################################################################################################## Setup ownership user and group
#chgrp -h freerad /etc/freeradius/3.0/mods-available/sql
#chown -R freerad:freerad /etc/freeradius/3.0/mods-enabled/sql

systemctl enable --now freeradius
systemctl restart freeradius
ufw allow to any port 1812 proto udp && ufw allow to any port 1813 proto udp && ufw allow to any port 161 proto udp


########################################################################################################################
# PulseISP Installation Tasks
########################################################################################################################

######################################################################################################################## Variables

######################################################################################################################## Import Database

######################################################################################################################## Copy web GUI to Apache public folder


apt-get install -y curl php-cli php-mbstring git unzip
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer


rm -fr "${WWW_PATH:?}/"*
cp -fr ${TEMP_DIR:?}/site/. ${WWW_PATH:?}/

cd ${WWW_PATH:?}/ || exit 1
sudo composer -n install

# Check if production directory exists, if not create
if [ ! -d "${WWW_PATH:?}/application/config/production" ]
then
  mkdir ${WWW_PATH:?}/application/config/production
fi

# Check if session directory exists, if not create
if [ ! -d "${WWW_PATH:?}/application/session" ]
then
  mkdir ${WWW_PATH:?}/application/session
fi

if [ -d "${WWW_PATH:?}/application/config/development" ]
then
  rm -r ${WWW_PATH:?}/application/config/development
fi


# Copy custom_config template to production folder
cp ${TEMP_DIR:?}/templates/site/custom_config.php.template ${WWW_PATH:?}/application/config/production/custom_config.php

# Replace custom_config values
sed -i "s/\$config\['CONFIG_DB_HOST'\] = .*;/\$config\['CONFIG_DB_HOST'\] = '$MYSQL_HOST';/" ${WWW_PATH:?}/application/config/production/custom_config.php
sed -i "s/\$config\['CONFIG_DB_PORT'\] = .*;/\$config\['CONFIG_DB_PORT'\] = '$MYSQL_PORT';/" ${WWW_PATH:?}/application/config/production/custom_config.php
sed -i "s/\$config\['CONFIG_DB_PASS'\] = .*;/\$config\['CONFIG_DB_PASS'\] = '$MYSQL_RAD_PASS';/" ${WWW_PATH:?}/application/config/production/custom_config.php
sed -i "s/\$config\['CONFIG_DB_USER'\] = .*;/\$config\['CONFIG_DB_USER'\] = '$MYSQL_RAD_USER';/" ${WWW_PATH:?}/application/config/production/custom_config.php
sed -i "s/\$config\['CONFIG_DB_NAME'\] = .*;/\$config\['CONFIG_DB_NAME'\] = '$MYSQL_DB';/" ${WWW_PATH:?}/application/config/production/custom_config.php

# Set environment to production
sed -i "/ENVIRONMENT/ s/\development/production/g" ${WWW_PATH:?}/index.php


######################################################################################################################## WRITE TO CONFIG FILE
######################################################################################################################## Set MySQL root password in /root/.my.cnf
cp ${TEMP_DIR:?}/templates/ubuntu/misc/misc.template /root/.misc.cnf
sed -i "s/\$radiususer/$MYSQL_RAD_USER/g" /root/.misc.cnf
sed -i "s/\$radiuspassword/$MYSQL_RAD_PASS/g" /root/.misc.cnf
sed -i "s/\$freeradiussecret/$FREERADIUS_SECRET/g" /root/.misc.cnf

######################################################################################################################## Update sudo file - allow www-user exec access


#chmod 777 var/www/html/application/config/database.php
#chmod 777 /var/www/html/application/session
#rm ${WWW_PATH:?}/install
#rm /var/www/html/install

######################################################################################################################## Configure Permissions
# Add www_data to sudo file (allows execution of
cp /etc/sudoers /etc/sudoers.bak
echo "%admin ALL=(ALL) ALL $WWW_USR ALL=(ALL) NOPASSWD: ALL" | sudo tee -a /etc/sudoers > /dev/null


# Add pulseisp user to freerad group
usermod -a -G freerad $USR_ROOT
# Add pulseisp user to www-data group
usermod -a -G $WWW_USR $USR_ROOT

# Set permissions for path
chgrp -R $WWW_USR ${WWW_PATH}
chmod -R g+w ${WWW_PATH}

# Set all directories GID
find /var/www -type d -exec chmod 2775 {} \;
# Set all files in path and add r/w permissions for owner and group
find /var/www -type f -exec chmod ug+rw {} \;


chmod -R 0755 ${WWW_PATH:?}/
chmod -R ug+rw ${WWW_PATH:?}/

chown $WWW_USR:$WWW_USR ${WWW_PATH:?}/ -R
chown -R $USR_ROOT:root ${WWW_PATH}/

# Set correct permissions for session folder
chmod -R 0777 ${WWW_PATH:?}/application/session

######################################################################################################################## Install mail server
#apt-get install sendmail
#sendmailconfig -y
######################################################################################################################## RESTART
systemctl restart freeradius
systemctl restart apache2



########################################################################################################################
# Setup Report
########################################################################################################################

######################################################################################################################## Setup report variables
txtbld=$(tput bold)
lightblue=$(tput setaf 6)
nc=$(tput sgr0)
real_ip=$(curl --silent -4 icanhazip.com 2>&1)

clear


######################################################################################################################## Generate setup report

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
${lightblue}Apache Server Status User:${nc}  $HTUSER
${lightblue}Apache Server Status Pass:${nc}  $HTPASS

${lightblue}PHPMyAdmin URL:${nc}  http://$real_ip/phpmyadmin
${lightblue}PHPMyAdmin User:${nc} $HTUSER    /    root
${lightblue}PHPMyAdmin Pass:${nc} $HTPASS       /    $MYSQL_PASS

${lightblue}MySQL Root User:${nc}  $MYSQL_USR
${lightblue}MySQL Root Pass:${nc}  $MYSQL_PASS
${lightblue}Radius User:${nc} $MYSQL_RAD_USER
${lightblue}Radius Pass:${nc} $MYSQL_RAD_PASS

${lightblue}Freeradius Secret:${nc} $FREERADIUS_SECRET
${lightblue}User Misc :${nc} $CURRENTUSER

${lightblue}Front-end Username:${nc} superadmin
${lightblue}Front-end Password:${nc} 12345

${lightblue}PulseISP Linux User:${nc} $USR_ROOT
${lightblue}PulseISP Linux Password:${nc} $USR_ROOT_PWD

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

git clone "$INSTALL_URL" "${TEMP_DIR:?}"

mkdir $BACKUP_DIR

cp ${WWW_PATH:?}/application/config/database.php /backup/database.php

rm -fr "${WWW_PATH:?}/"*
cp -fr ${TEMP_DIR:?}/site/. ${WWW_PATH:?}/

cp /backup/database.php ${WWW_PATH:?}/application/config/database.php

cd ${WWW_PATH:?}/ || exit 1
sudo composer -n install

# Set permissions for path
chgrp -R $WWW_USR ${WWW_PATH}
chmod -R g+w ${WWW_PATH}
chown -R pulseisp:root ${WWW_PATH}

# Set all directories GID
find ${WWW_PATH} -type d -exec chmod 2775 {} \;
# Set all files in path and add r/w permissions for owner and group
find ${WWW_PATH} -type f -exec chmod ug+rw {} \;

chmod 777 ${WWW_PATH} -R



systemctl restart apache2

echo
;;

* ) echo "Invalid selection. Installation aborted."
echo
exit
;;
esac

exit