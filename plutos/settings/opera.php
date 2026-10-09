<?php

/**
 * @author      Binh Nguyen
 * @package     Giaiphapcongnghethongtin.Settings
 * @subpackage  com_hotelsresorts
 *
 * @copyright   Copyright (C) 2017 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_PLATFORM') or die;

// --------- Opera define error ------------
define('ERR_OK', 0);
define('ERR_INTERNAL_FUNCTION', 1);
define('ERR_SOAP_FAULT', 2);
define('ERR_SERVICE_FAULT', 2);
define('HOTEL_CODE', 'VREP');
// ---
define('ERRORSTRING_SOAP_FAULT', "error: SOAP Client Fault");

// --------- Opera Configuration ------------
//define("ENVIROMENT_OPERA", "test");
define("ENVIROMENT_OPERA", "use");

define('CHAINCODE', 'IQ');
define('CHAINCODECAMBODIA', 'VICT');
// ---
define('PREFEREDRATEPLANCODE', 'INTE');
define('PREFEREDRATEPLANCODECAMBODIA', 'INTE');
// ---
define('OPERA_WEBSERVICES_RESERVATION', 'http://webservices.micros.com/og/4.3/Reservation/');
define('OPERA_WEBSERVICES_COMMON', 'http://webservices.micros.com/og/4.3/Common/');
define('OPERA_WEBSERVICES_HOTELCOMMON', 'http://webservices.micros.com/og/4.3/HotelCommon/');
define('OPERA_WEBSERVICES_NAME', 'http://webservices.micros.com/og/4.3/Name/');
// ---
define('OPERA_USE', 'literal');

if (ENVIROMENT_OPERA == "test") {
    define("OWS", "test");
    // ---
    define('OPERA_USERNAME', 'VICTASIA');
    define('OPERA_USERPASSWORD', 'HOTEL123');
    define('OPERA_DOMAIN', 'OPERA');
    define('OPERA_SECURITYID', '2174294');
    define('OPERA_KEY', 'VY19WPKX93ZAR70WG5FH');
} else {
    define("OWS", "ows");
    // ---
    define('OPERA_USERNAME', 'VICTASIA');
    define('OPERA_USERPASSWORD', 'HOTEL123');
    define('OPERA_DOMAIN', 'OPERA');
    define('OPERA_SECURITYID', '2174294');
    define('OPERA_KEY', 'VY19WPKX93ZAR70WG5FH');
}

class OperaConfiguration {

    static public function getConfiguration($service_function = '') {
        $arrConfiguration = array();

        // --- Availability ---
        $arrConfiguration['Availability']['EndPoint'] = "https://" . OWS . ".myfidelio.net/ows/5.1/Availability.asmx";
        $arrConfiguration['Availability']['RequestName'] = "ows/5.1/Availability.wsdl#Availability";
        $arrConfiguration['Availability']['RequestNameSpace'] = "http://webservices.micros.com";
        // --- CreateBooking ---
        $arrConfiguration['CreateBooking']['EndPoint'] = "https://" . OWS . ".myfidelio.net/ows/5.1/Reservation.asmx";
        $arrConfiguration['CreateBooking']['RequestName'] = "ows/5.1/Reservation.wsdl#CreateBooking";
        $arrConfiguration['CreateBooking']['RequestNameSpace'] = "http://webservices.micros.com";
        // --- CancelBooking ---
        $arrConfiguration['CancelBooking']['EndPoint'] = "https://" . OWS . ".myfidelio.net/ows/5.1/Reservation.asmx";
        $arrConfiguration['CancelBooking']['RequestName'] = "ows/5.1/Reservation.wsdl#CancelBooking";
        $arrConfiguration['CancelBooking']['RequestNameSpace'] = "http://webservices.micros.com";

        if (isset($arrConfiguration[$service_function])) {
            return $arrConfiguration[$service_function];
        }
        return array();
    }

}
