<?php
/**
 * @author      Binh Nguyen
 * @package     Giaiphapcongnghethongtin.Libraries
 */
defined('JPATH_PLATFORM') or die;
jimport('informationtechnology.ip2location.IP2Location');
define("IP2DB_PATH", dirname(__FILE__) . "/db/IP-COUNTRY.BIN");

class IpService {

    static public function getCountryCode($ip = "127.0.0.1") {
        $countryCode = "VN";
        $ip = $ip == "::1" ? "127.0.0.1" : $ip;
        try {
            $loc = new IP2Location(IP2DB_PATH, IP2Location::MEMORY_CACHE);
            $record = $loc->lookup($ip, IP2Location::ALL);
            if ($record->countryCode !== '-') {
                $countryCode = $record->countryCode;
            }
        } catch (Exception $ex) {
            
        }
        return $countryCode;
    }

}

?>