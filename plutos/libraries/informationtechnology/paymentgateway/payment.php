<?php

defined('JPATH_PLATFORM') or die;
require_once JPATH_ROOT . "/settings/payment.php";

class Payment {

    public static function doPayment($data, $gateway = 'Domestic') {//DO
        $app = JFactory::getApplication();
        // --- get Configuration ---
        $arr_conf = Configuration::getConfiguration($gateway);
        $dataPost = array_merge($arr_conf, $data);
        // --- Onepay or napas ---
        $api = $dataPost['api'];
        unset($dataPost['api']);
        // --- /.Onepay or napas ---
        // $SECURE_SECRET = "secure-hash-secret";
        $SECURE_SECRET = $dataPost['SecureSecret'];
        unset($dataPost['SecureSecret']);
        // add the start of the vpcURL querystring parameters
        $vpcURL = $dataPost["virtualPaymentClientURL"] . "?";

        // Remove the Virtual Payment Client URL from the parameter hash as we 
        // do not want to send these fields to the Virtual Payment Client.
        unset($dataPost["virtualPaymentClientURL"]);
        unset($dataPost["vpc_User"]);
        unset($dataPost["vpc_Password"]);

        ksort($dataPost);


        if ($api == "NAPAS") {
            $md5HashData = $SECURE_SECRET;
        } else {
            $md5HashData = ""; // --- Khởi tạo chuỗi dữ liệu mã hóa trống ---
        }

        // set a parameter to show the first pair in the URL
        $appendAmp = 0;

        foreach ($dataPost as $key => $value) {

            // create the md5 input and URL leaving out any fields that have no value
            if (strlen($value) > 0) {

                // this ensures the first paramter of the URL is preceded by the '?' char
                if ($appendAmp == 0) {
                    $vpcURL .= urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;
                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }

                if ($api == "NAPAS") {
                    $md5HashData .= $value; // --- sử dụng cả tên và giá trị tham số để mã hóa ---
                } else {
                    if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                        $md5HashData .= $key . "=" . $value . "&";
                    }
                }
            }
        }
        //xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
        $md5HashData = rtrim($md5HashData, "&");
        // Create the secure hash and append it to the Virtual Payment Client Data if
        // the merchant secret has been provided.
        if (strlen($SECURE_SECRET) > 0) {
            if ($api == "NAPAS") {
                $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
            } else {
                // Thay hàm mã hóa dữ liệu
                $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $SECURE_SECRET)));
            }
        }

        // FINISH TRANSACTION - Redirect the customers using the Digital Order
        // ===================================================================
        //header("Location: " . $vpcURL);
        $app->redirect($vpcURL);
        // *******************
        // END OF MAIN PROGRAM
        // *******************
    }

    public static function doRecoveryPayment($dataGet) {//DR
        $resultPayment = array();
        $gateway = $dataGet['gateway'];
        // --- Onepay or napas (Khac nhau ve ham ma hoa du lieu: SecureSecret) --- 
        $api = $dataGet['api'];
        unset($dataGet["api"]);
        // --- /.Onepay or napas ---
        // --- get Configuration ---
        $arr_conf = Configuration::getConfiguration($gateway);
        // $SECURE_SECRET = "secure-hash-secret";
        $SECURE_SECRET = $arr_conf['SecureSecret'];
        // get and remove the vpc_TxnResponseCode code from the response fields as we
        // do not want to include this field in the hash calculation
        $vpc_Txn_Secure_Hash = $dataGet["vpc_SecureHash"];
        //$vpc_MerchTxnRef = $dataGet["vpc_MerchTxnRef"];
        //$vpc_AcqResponseCode = $dataGet["vpc_AcqResponseCode"];
        unset($dataGet["vpc_SecureHash"]);
        // set a flag to indicate if hash has been validated
        $errorExists = false;
        
        $sResponseCode = "vpc_TxnResponseCode";
        if ($api == "NAPAS") {
            $sResponseCode = "vpc_ResponseCode";
        }

        if (strlen($SECURE_SECRET) > 0 && $dataGet[$sResponseCode] != "7" && $dataGet[$sResponseCode] != "No Value Returned") {

            ksort($dataGet);

            if ($api == "NAPAS") {
                $md5HashData = $SECURE_SECRET;
            } else {
                //khởi tạo chuỗi mã hóa rỗng
                $md5HashData = "";
            }

            // sort all the incoming vpc response fields and leave out any with no value
            foreach ($dataGet as $key => $value) {
                if ($api == "NAPAS") {
                    if ($key != "vpc_SecureHash" or strlen($value) > 0) {
                        $md5HashData .= $value;
                    }
                } else {
                    //chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về
                    if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                        $md5HashData .= $key . "=" . $value . "&";
                    }
                }
            }
            //  Xóa dấu & thừa cuối chuỗi dữ liệu
            $md5HashData = rtrim($md5HashData, "&");
            
            if ($api == "NAPAS") {
                if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(md5($md5HashData))) {
                    // Secure Hash validation succeeded, add a data field to be displayed
                    // later.
                    $hashValidated = "CORRECT";
                } else {
                    // Secure Hash validation failed, add a data field to be displayed
                    // later.
                    $hashValidated = "INVALID HASH";
                }
            } else {
                //    Thay hàm tạo chuỗi mã hóa
                if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $SECURE_SECRET)))) {
                    // Secure Hash validation succeeded, add a data field to be displayed
                    // later.
                    $hashValidated = "CORRECT";
                } else {
                    // Secure Hash validation failed, add a data field to be displayed
                    // later.
                    $hashValidated = "INVALID HASH";
                }
            }
        } else {
            // Secure Hash was not validated, add a data field to be displayed later.
            $hashValidated = "INVALID HASH";
        }


        // Define Variables
        // ----------------
        // Extract the available receipt fields from the VPC Response
        // If not present then let the value be equal to 'No Value Returned'
        // Standard Receipt Data
        $amount = self::_null2unknown($dataGet["vpc_Amount"]);
        $locale = self::_null2unknown($dataGet["vpc_Locale"]);
        //$batchNo = self::_null2unknown($dataGet["vpc_BatchNo"]);
        $command = self::_null2unknown($dataGet["vpc_Command"]);
        //$message = self::_null2unknown($dataGet["vpc_Message"]);
        $version = self::_null2unknown($dataGet["vpc_Version"]);
        //$cardType = self::_null2unknown($dataGet["vpc_Card"]);
        $orderInfo = self::_null2unknown($dataGet["vpc_OrderInfo"]);
        //$receiptNo = self::_null2unknown($dataGet["vpc_ReceiptNo"]);
        $merchantID = self::_null2unknown($dataGet["vpc_Merchant"]);
        //$authorizeID = self::_null2unknown($dataGet["vpc_AuthorizeId"]);
        $merchTxnRef = self::_null2unknown($dataGet["vpc_MerchTxnRef"]);
        //$transactionNo = self::_null2unknown($dataGet["vpc_TransactionNo"]);
        //$acqResponseCode = self::_null2unknown($dataGet["vpc_AcqResponseCode"]);
        $txnResponseCode = self::_null2unknown($dataGet[$sResponseCode]);
        // 3-D Secure Data
        $verType = array_key_exists("vpc_VerType", $dataGet) ? $dataGet["vpc_VerType"] : "No Value Returned";
        $verStatus = array_key_exists("vpc_VerStatus", $dataGet) ? $dataGet["vpc_VerStatus"] : "No Value Returned";
        $token = array_key_exists("vpc_VerToken", $dataGet) ? $dataGet["vpc_VerToken"] : "No Value Returned";
        $verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $dataGet) ? $dataGet["vpc_VerSecurityLevel"] : "No Value Returned";
        $enrolled = array_key_exists("vpc_3DSenrolled", $dataGet) ? $dataGet["vpc_3DSenrolled"] : "No Value Returned";
        $xid = array_key_exists("vpc_3DSXID", $dataGet) ? $dataGet["vpc_3DSXID"] : "No Value Returned";
        $acqECI = array_key_exists("vpc_3DSECI", $dataGet) ? $dataGet["vpc_3DSECI"] : "No Value Returned";
        $authStatus = array_key_exists("vpc_3DSstatus", $dataGet) ? $dataGet["vpc_3DSstatus"] : "No Value Returned";

        // *******************
        // END OF MAIN PROGRAM
        // *******************
        // FINISH TRANSACTION - Process the VPC Response Data
        // =====================================================
        // For the purposes of demonstration, we simply display the Result fields on a
        // web page.
        // Show 'Error' in title if an error condition
        $errorTxt = "";

        // Show this page as an error page if vpc_TxnResponseCode equals '7'
        if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned" || $errorExists) {
            $errorTxt = "Error";
        }

        // The URL link for the receipt to do another transaction.
        // Note: This is ONLY used for this example and is not required for 
        // production code. You would hard code your own URL into your application
        // to allow customers to try another transaction.
        //TK//$againLink = URLDecode($dataGet["AgainLink"]);

        $transStatus = "";
        if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {
            $transStatus = self::getResponseDescription($txnResponseCode); // "Giao dịch thành công - Approved";
        } elseif ($hashValidated == "INVALID HASH" && $txnResponseCode == "0") {
            $transStatus = JText::_("TRANSACTION_PENDING"); //"Giao dịch Đang chờ xử lý - Transaction Pending"
        } else {
            $transStatus = self::getResponseDescription($txnResponseCode);
        }

        switch ($gateway) {
            case "Domestic":
                //
                break;
            case "International":
            default:
                $resultPayment['displayTitle'] = isset($dataGet["Title"]) ? $dataGet["Title"] : ""; // This is the display title for 'Receipt' page 
                break;
        }

        $resultPayment['errorTxt'] = $errorTxt;
        $resultPayment['transStatus'] = $transStatus;
        $resultPayment['responseCode'] = $txnResponseCode;

        return $resultPayment;
    }

    public static function getResponseDescription($responseCode) {

        switch ($responseCode) {
            case "0" :
                $result = JText::_('APPROVED'); //"Giao dịch thành công - Approved";
                break;
            case "1" :
                $result = JText::_('BANK_DECLINED'); //"Ngân hàng từ chối giao dịch - Bank Declined";
                break;
            case "3" :
                $result = JText::_('MERCHANT_NOT_EXIST'); //"Mã đơn vị không tồn tại - Merchant not exist";
                break;
            case "4" :
                $result = JText::_('INVALID_ACCESS_CODE'); //"Không đúng access code - Invalid access code";
                break;
            case "5" :
                $result = JText::_('INVALID_AMOUNT'); //"Số tiền không hợp lệ - Invalid amount";
                break;
            case "6" :
                $result = JText::_('INVALID_CURRENCY_CODE'); //"Mã tiền tệ không tồn tại - Invalid currency code";
                break;
            case "7" :
                $result = JText::_('UNSPECIFIED_FAILURE'); //"Lỗi không xác định - Unspecified Failure ";
                break;
            case "8" :
                $result = JText::_('INVALID_CARD_NUMBER'); //"Số thẻ không đúng - Invalid card Number";
                break;
            case "9" :
                $result = JText::_('INVALID_CARD_NAME'); //"Tên chủ thẻ không đúng - Invalid card name";
                break;
            case "10" :
                $result = JText::_('EXPIRED_CARD'); //"Thẻ hết hạn/Thẻ bị khóa - Expired Card";
                break;
            case "11" :
                $result = JText::_('CARD_NOT_REGISTED_SERVICE_INTERNET_BANKING'); //"Thẻ chưa đăng ký sử dụng dịch vụ - Card Not Registed Service(internet banking)";
                break;
            case "12" :
                $result = JText::_('INVALID_CARD_DATE'); //"Ngày phát hành/Hết hạn không đúng - Invalid card date";
                break;
            case "13" :
                $result = JText::_('EXIST_AMOUNT'); //"Vượt quá hạn mức thanh toán - Exist Amount";
                break;
            case "21" :
                $result = JText::_('NSUFFICIENT_FUND'); //"Số tiền không đủ để thanh toán - Insufficient fund";
                break;
            case "99" :
                $result = JText::_('USER_CANCEL'); //"Người sủ dụng hủy giao dịch - User cancel";
                break;
            default :
                $result = JText::_('FAILURED'); //"Giao dịch thất bại - Failured";
        }
        return $result;
    }

    // If input is null, returns string "No Value Returned", else returns input
    private static function _null2unknown($data) {
        if ($data == "") {
            return JText::_("NO_VALUE_RETURNED");
        } else {
            return $data;
        }
    }

}

?>
