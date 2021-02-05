<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['run_setup'] = FALSE;
$configValues['PULSEISP_VERSION'] = '0.0.0.1';
$configValues['FREERADIUS_VERSION'] = '3';

$config['CONFIG_DB_ENGINE'] = 'mysqli';
$config['CONFIG_DB_HOST'] = 'localhost';
$config['CONFIG_DB_USER'] = 'root';
$config['CONFIG_DB_PASS'] = '';
$config['CONFIG_DB_NAME'] = 'pulseisp_db';

$config['CONFIG_DB_TBL_RADCHECK'] = 'radcheck';
$config['CONFIG_DB_TBL_RADREPLY'] = 'radreply';
$config['CONFIG_DB_TBL_RADGROUPREPLY'] = 'radgroupreply';
$config['CONFIG_DB_TBL_RADGROUPCHECK'] = 'radgroupcheck';
$config['CONFIG_DB_TBL_RADHG'] = 'radhuntgroup';
$config['CONFIG_DB_TBL_RADUSERGROUP'] = 'radusergroup';
$config['CONFIG_DB_TBL_RADNAS'] = 'radnas';
$config['CONFIG_DB_TBL_RADPOSTAUTH'] = 'radpostauth';
$config['CONFIG_DB_TBL_RADACCT'] = 'radacct';
$config['CONFIG_DB_TBL_RADIPPOOL'] = 'radippool';
$config['CONFIG_DB_TBL_RADDICTIONARY'] = 'raddictionary';
