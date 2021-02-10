<?php

// Works with sysDescr such as:
//
// 'Huawei Integrated Access Software'
// 'HUAWEI TECH. INC. SNMP AGENT FOR MA5300'
// RouterOS RB3011UiAS
if(substr(strtolower($sysDescr),0,8 ) == 'routeros')
{
    $this->setVendor( 'Mikrotik' );

    preg_match( '/(?<=RouterOS\s).*([a-zA-Z]+).+?$/', $sysDescr, $matches);

    $this->setModel($matches[0]);
    $this->setOs('RouterOS');
    $this->setOsVersion($this->getSNMPHost()->get('1.3.6.1.4.1.14988.1.1.7.4.0'));
    $this->setOsDate($this->getSNMPHost()->get('.1.3.6.1.4.1.14988.1.1.7.6.0'));
    $this->setSerialNumber($this->getSNMPHost()->get('1.3.6.1.4.1.14988.1.1.7.3.0'));
}