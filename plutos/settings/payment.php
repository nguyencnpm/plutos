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

// --------- Payment Configuration ------------
$params = JComponentHelper::getParams('com_standard');

define("API_PAYMENT", strtoupper($params->get('api_payment')));
define("ENVIROMENT_PAYMENT", (int)$params->get('enviroment_payment'));
define("FIX_AMOUNT_PAYMENT", 100);
define("TIMEOUT_PAYMENT", 1);

if (API_PAYMENT === 'ONEPAY'):
    //--- ---
    switch (ENVIROMENT_PAYMENT) {
        case 1:// use

            // --- Domestic gate ---
            define("SecureSecretDomestic", "A3EFDFABA8653DF2342E8DAC29B51AF0");
            // parameter in url
            define("virtualPaymentClientURLDomestic", "https://mtf.onepay.vn/onecomm-pay/vpc.op");
            define("vpc_MerchantDomestic", "ONEPAY");
            define("vpc_AccessCodeDomestic", "D67342C2");
            define("vpc_VersionDomestic", "2");
            define("vpc_CommandDomestic", "pay");
            define("vpc_UserDomestic", "op01");
            define("vpc_PasswordDomestic", "op123456");

            // --- International gate ---
            define("SecureSecretInternational", "1AC83674D4E408A1757AF19E0E9E4F3A");
            // parameter in url
            define("virtualPaymentClientURLInternational", "https://onepay.vn/vpcpay/vpcpost.op");
            define("vpc_MerchantInternational", "TMGH");
            define("vpc_AccessCodeInternational", "55B8AECC");
            define("vpc_VersionInternational", "2");
            define("vpc_CommandInternational", "pay");
            define("vpc_UserInternational", "op01");
            define("vpc_PasswordInternational", "op123456");

            break;

        case 0:// test
        default:

            // --- Domestic gate ---
            define("SecureSecretDomestic", "A3EFDFABA8653DF2342E8DAC29B51AF0");
            // parameter in url
            define("virtualPaymentClientURLDomestic", "https://mtf.onepay.vn/onecomm-pay/vpc.op");
            define("vpc_MerchantDomestic", "ONEPAY");
            define("vpc_AccessCodeDomestic", "D67342C2");
            define("vpc_VersionDomestic", "2");
            define("vpc_CommandDomestic", "pay");
            define("vpc_UserDomestic", "op01");
            define("vpc_PasswordDomestic", "op123456");

            // --- International gate ---
            define("SecureSecretInternational", "6D0870CDE5F24F34F3915FB0045120DB");
            // parameter in url
            define("virtualPaymentClientURLInternational", "https://mtf.onepay.vn/vpcpay/vpcpay.op");
            define("vpc_MerchantInternational", "TESTONEPAY");
            define("vpc_AccessCodeInternational", "6BEB2546");
            define("vpc_VersionInternational", "2");
            define("vpc_CommandInternational", "pay");
            define("vpc_UserInternational", "op01");
            define("vpc_PasswordInternational", "op123456");

            break;
    }
else:
    //--- Napas ---
    switch (ENVIROMENT_PAYMENT) {
        case 1://use

            // --- Domestic gate ---
            define("SecureSecretDomestic", "198BE3F2E8C75A53F38C1C4A5B6DBA27");
            // parameter in url
            define("virtualPaymentClientURLDomestic", "https://payment.napas.com.vn/gateway/vpcpay.do");
            define("vpc_MerchantDomestic", "SMLTEST");
            define("vpc_AccessCodeDomestic", "ECAFAB");
            define("vpc_VersionDomestic", "2");
            define("vpc_CommandDomestic", "pay");
            define("vpc_UserDomestic", "usertest");
            define("vpc_PasswordDomestic", "passtest");

            // --- International gate ---
            define("SecureSecretInternational", "2512716787B0E940DBB4F7B65E8F2AB7");
            // parameter in url
            define("virtualPaymentClientURLInternational", "https://payment.napas.com.vn/gateway/vpcpay.do");
            define("vpc_MerchantInternational", "HAIAU");
            define("vpc_AccessCodeInternational", "H1A2I3A4U5");
            define("vpc_VersionInternational", "2");
            define("vpc_CommandInternational", "pay");
            define("vpc_UserInternational", "usertest");
            define("vpc_PasswordInternational", "usertest");

            break;

        case 0:// test
        default:

            // --- Domestic gate ---
            define("SecureSecretDomestic", "198BE3F2E8C75A53F38C1C4A5B6DBA27");
            // parameter in url
            define("virtualPaymentClientURLDomestic", "https://sandbox.napas.com.vn/gateway/vpcpay.do");
            define("vpc_MerchantDomestic", "SMLTEST");
            define("vpc_AccessCodeDomestic", "ECAFAB");
            define("vpc_VersionDomestic", "2.0");
            define("vpc_CommandDomestic", "pay");
            define("vpc_UserDomestic", "usertest");
            define("vpc_PasswordDomestic", "passtest");

            // --- International gate ---
            define("SecureSecretInternational", "198BE3F2E8C75A53F38C1C4A5B6DBA27");
            // parameter in url
            define("virtualPaymentClientURLInternational", "https://sandbox.napas.com.vn/gateway/vpcpay.do");
            define("vpc_MerchantInternational", "SMLTEST");
            define("vpc_AccessCodeInternational", "ECAFAB");
            define("vpc_VersionInternational", "2.0");
            define("vpc_CommandInternational", "pay");
            define("vpc_UserInternational", "usertest");
            define("vpc_PasswordInternational", "passtest");

            break;
    }
endif;

class Configuration {

    public static function getConfiguration($type = 'Domestic') {
        $arrConfiguration = array(array());

        // --- Domestic gate ---
        $arrConfiguration['Domestic']['SecureSecret'] = SecureSecretDomestic;
        $arrConfiguration['Domestic']['virtualPaymentClientURL'] = virtualPaymentClientURLDomestic;
        $arrConfiguration['Domestic']['vpc_Merchant'] = vpc_MerchantDomestic;
        $arrConfiguration['Domestic']['vpc_AccessCode'] = vpc_AccessCodeDomestic;
        $arrConfiguration['Domestic']['vpc_Version'] = vpc_VersionDomestic;
        $arrConfiguration['Domestic']['vpc_Command'] = vpc_CommandDomestic;
        $arrConfiguration['Domestic']['vpc_User'] = vpc_UserDomestic;
        $arrConfiguration['Domestic']['vpc_Password'] = vpc_PasswordDomestic;

        // --- International gate ---
        $arrConfiguration['International']['SecureSecret'] = SecureSecretInternational;
        $arrConfiguration['International']['virtualPaymentClientURL'] = virtualPaymentClientURLInternational;
        $arrConfiguration['International']['vpc_Merchant'] = vpc_MerchantInternational;
        $arrConfiguration['International']['vpc_AccessCode'] = vpc_AccessCodeInternational;
        $arrConfiguration['International']['vpc_Version'] = vpc_VersionInternational;
        $arrConfiguration['International']['vpc_Command'] = vpc_CommandInternational;
        $arrConfiguration['International']['vpc_User'] = vpc_UserInternational;
        $arrConfiguration['International']['vpc_Password'] = vpc_PasswordInternational;

        return $arrConfiguration[$type];
    }

}
