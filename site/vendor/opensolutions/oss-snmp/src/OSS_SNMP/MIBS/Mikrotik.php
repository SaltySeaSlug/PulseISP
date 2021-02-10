<?php

namespace OSS_SNMP\MIBS;

use OSS_SNMP\Exception;

/**
 * A class for performing SNMP V2 queries on Huawei
 *
 */
class Mikrotik extends \OSS_SNMP\MIB
{
    const OID_MODEL							= '.1.3.6.1.2.1.1.1.0';
	const OID_IDENTITY						= '.1.3.6.1.2.1.1.5.0';
	const OID_UPTIME						= '.1.3.6.1.2.1.1.3.0';
	const OID_ACTIVE_CONNECTIONS			= '.1.3.6.1.2.1.2.2.1.2';
	const OID_ACTIVE_CONNECTIONS_COUNT		= '.1.3.6.1.4.1.9.9.150.1.1.1.0';
	const OID_CPU_USAGE						= '.1.3.6.1.4.1.2021.11.10.0';
	const OID_SERIAL_NUMBER					= '.1.3.6.1.4.1.14988.1.1.7.3';
	const OID_FIRMWARE_VERSION				= '.1.3.6.1.4.1.14988.1.1.7.4';
	const OID_FIRMWARE_UPGRADE_VERSION		= '.1.3.6.1.4.1.14988.1.1.7.7';
	const OID_SYSTEM_NOTE					= '.1.3.6.1.4.1.14988.1.1.7.5';
	const OID_BUILD_TIME					= '.1.3.6.1.4.1.14988.1.1.7.6';

    /**
     * Get an array of MAU interface indexes
     *
     * @return array An array of MAU interface indexes
     */
    public function index() { }

    // RouterOS RB3011UiAS
	public function model()
	{
		try {
			return $this->getSNMP()->get(self::OID_MODEL);
		} catch (Exception $ex) {
			return null;
		}
	}

	// UNI-HDV_CORE
    public function identity()
    {
    	try {
			return $this->getSNMP()->get(self::OID_IDENTITY);
		} catch (Exception $ex) {
    		return null;
		}
    }

    // (23592700) 2 days, 17:32:07.00
    public function uptime()
    {
    	try {
			return ($this->getSNMP()->get(self::OID_UPTIME) / 100);
		} catch (Exception $ex) {
    		return null;
		}
    }

    public function activePPPoECount($realm = null)
	{
		try {
			$data = array();

			if (empty($realm)) {
				foreach ($this->getSNMP()->walk1d(self::OID_ACTIVE_CONNECTIONS) as $item) {
					if (strpos($item, '<pppoe-') !== false) {
						$data[] = $item;
					}
				}
			} else {

				foreach ($this->getSNMP()->walk1d(self::OID_ACTIVE_CONNECTIONS) as $item) {
					if (strpos($item, $realm) !== false) {
						$data[] = $item;
					}
				}
			}
			return count($data);
		} catch (Exception $ex) {
			return array();
		}
	}
	public function activePPPoEList($realm = null)
	{
    	try {
			$data = array();

			if (empty($realm)) {
				foreach ($this->getSNMP()->walk1d(self::OID_ACTIVE_CONNECTIONS) as $item) {
					if (strpos($item, '<pppoe-') !== false) {
						$data[] = substr($item, 7, -1);
					}
				}
			} else {
				foreach ($this->getSNMP()->walk1d(self::OID_ACTIVE_CONNECTIONS) as $item) {
					if (strpos($item, $realm) !== false) {
						$data[] = substr($item, 7, -1);
					}
				}
			}
			return $data;
		} catch (Exception $ex) {
    		return array();
		}
	}
	// PPPoE users, VPN Connections, etc..
    public function activeConnectionCount()
	{
        try {
            return $this->getSNMP()->get(self::OID_ACTIVE_CONNECTIONS_COUNT);
        } catch (Exception $ex) {
            return 0;
        }
    }
	// 14
    public function getCpuUsage()
	{
        try {
            return $this->getSNMP()->get(self::OID_CPU_USAGE);
        } catch (Exception $ex) {
            return -1;
        }
    }
}
