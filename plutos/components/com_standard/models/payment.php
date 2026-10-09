<?php

defined('_JEXEC') or die;

if (!class_exists('Convert')) {
    jimport('informationtechnology.convert');
}

if (!class_exists('DetectUtils')) {
    jimport('informationtechnology.detectutils');
}

class StandardModelPayment extends JModelForm {

    /**
     * The name of the view for a single item
     *
     * @since   1.6
     */
    protected $view_item = 'payment';

    /**
     * A loaded item
     *
     * @since   1.6
     */
    protected $_item = null;

    /**
     * Model context string.
     *
     * @var		string
     */
    protected $_context = 'com_standard.payment';
    protected $cart = null;

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function populateState() {
        $app = JFactory::getApplication('site');
    }

    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = "";
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    /**
     * Returns a Table object, always creating it.
     *
     * @param   string  $type    The table type to instantiate
     * @param   string  $prefix  A prefix for the table class name. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  JTable    A database object
     */
    public function getTable($type = 'Order', $prefix = 'StandardTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    // create ID
    public function getUniqid($prefix = "") {
        return trim($prefix . uniqid());
    }

    // send Reserve
    public function sendReserve($data) {
        if (!class_exists('CurrencyHelper')) {
            JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
        }
        $this->currency = CurrencyHelper::getInstance();

        if (!class_exists('Cart')) {
            JLoader::register('Cart', JPATH_SITE . '/components/com_standard/helpers/cart.php');
        }
        $this->cart = Cart::getCart();
        $this->cart->prepareCartData(false);

        $user = JFactory::getUser();
        $data['user_id'] = $user->id;

        $contact = new stdClass();
        $contact->email_to = $data['contact_email'];
        $contact->name = $data['contact_fullName'];
        $copy_email_activated = FALSE;

        $params = JComponentHelper::getParams('com_standard');
        $lang = JFactory::getLanguage();
        $lang_codes = JLanguageHelper::getLanguages('lang_code');
        $lang_sef = $lang_codes[$lang->getTag()]->sef;
        $data["language"] = $lang->getTag();
        $data["number"] = $this->getUniqid();

        //$mailfrom = $params->get('email_sendmailcontact');
        //$fromname = $params->get("name_sendmailcontact_{$lang_sef}");
        //$subject = $params->get("subject_sendmailcontact_{$lang_sef}");
        $subject = "";
        $data['paymentmethod_id'] = 3;
        if (empty($subject)):
            $data['contact_subject'] = JText::sprintf('SUBJECT_PRODUCT_REQUEST', ""); //$data["title"]
        else:
            $data['contact_subject'] = $subject;
        endif;
        $data['ccemail'] = $params->get('ccemail');

        $data['bccemailteamit'] = $params->get('bccemailteamit');

        $data['params']['show_price'] = $params->get('show_price');

        $data['created'] = JFactory::getDate()->toSql();
        // Prepare email body 
        $data['cart'] = $this->cart;

//        echo '<pre>';
//        print_r($this->cart);
//        exit;
        // ---- save table: #__standard_orders ----
        $data['vendor_id'] = 1; // fix temp

        $data['payment_currency_id'] = $this->cart->paymentCurrency;
        $data['payment_currency_rate'] = $this->cart->paymentCurrencyRate;
        $data['payment_currency_code_3'] = $this->cart->paymentCurrencyCode3;
        $data['payment_currency_symbol'] = $this->cart->paymentCurrencySymbol;

        $data['totalQuantity'] = $this->cart->totalProduct; //$data['quantity'];
        $data['total'] = $this->cart->pricesUnformatted['billTotal']; //$data['payable_amount'];
        $data['salesPrice'] = $this->cart->pricesUnformatted['salesPrice']; //$data['order_price'];
        $data['billTaxAmount'] = $this->cart->pricesUnformatted['taxAmount']; //$data['tax'];
        // --- Format bill for content email ---
        $data['payableAmountFormatted'] = $this->currency->priceDisplay($data['total'], $this->cart->pricesCurrency);
        $data['orderPriceFormatted'] = $this->currency->priceDisplay($data['salesPrice'], $this->cart->pricesCurrency);
        $data['billTaxAmountFormatted'] = $this->currency->priceDisplay($data['billTaxAmount'], $this->cart->pricesCurrency);
        // --- /.Format bill for content email ---
        $data['content_mail'] = stripslashes($this->_contentMailContact($data['paymentmethod_id'], $data));

        $data['order_id'] = $this->saveBooking($data);

        if ($data['order_id']) {
            foreach ($this->cart->products as $pkey => $prow):
                $orderItem = array();
                $orderItem['order_id'] = $data['order_id'];
                $orderItem['vendor_id'] = $data['vendor_id'];
                $orderItem['catid'] = $prow->catid; //$data['catid'];
                $orderItem['product_id'] = $prow->id; //$data['id'];
                //$orderItem['order_item_sku'] = $data['code'];
                $orderItem['order_item_name'] = $prow->title; //$data['title'];
                $orderItem['product_quantity'] = $prow->quantity; //$data['quantity'];
                // --- Phai lam lai cho nay  --- allPrices['price'], .... ;
                $orderItem['product_item_price'] = $prow->price; //$data['price'];
                $orderItem['product_priceWithoutTax'] = $prow->price; //$data['order_price'];
                $orderItem['product_tax'] = $prow->title; //$data['tax'];
                $orderItem['product_basePriceWithTax'] = $prow->price; //$data['payable_amount'];
                //$orderItem['product_discountedPriceWithoutTax'] = $data[''];
                $orderItem['product_final_price'] = $prow->price; //$data['payable_amount'];
                //$orderItem['product_subtotal_discount'] = $data[''];
                $orderItem['product_subtotal_with_tax'] = $prow->price; //$data['payable_amount'];
                $orderItem['order_item_currency'] = $prow->currency_id; //$data['currency_id'];
                $orderItem['order_item_currency_rate'] = $prow->price; //$data['currency_rate'];
                //
                $orderItem['order_status'] = $prow->order_status = 0;
                // --- /.Phai lam lai cho nay  --- allPrices['price'], .... ;
                $this->saveBooking($orderItem, 'Orderitem');

                // --- updateStockInDB TABLE `#__standard_products` ---
                // N New or coming from cart
                $this->handleStockAfterStatusChangedPerProduct($prow->order_status, 'N', $prow, $prow->quantity);
                // --- /.updateStockInDB TABLE `#__standard_products` ---
            endforeach;
        }

        $tableOrder = $this->getTable('Order');
        $tableOrder->id = $data['order_id'];

        $sent = $this->_sendEmail($data, $contact, $data['content_mail'], $copy_email_activated);
        if ("{$sent}" === "1") {
            $payment_status = 1;
            $message = "";
            $tableOrder->email_status = 1;
            $tableOrder->email_message = JText::_('EMAIL_SUCCESS');
        } else {
            $payment_status = 0;
            if (!empty(trim($sent))):
                $message = $sent->get('message');
            else:
                $message = "Unknown";
            endif;

            $tableOrder->email_status = $payment_status;
            $tableOrder->email_message = JText::_('EMAIL_FAIL');
            $tableOrder->message_error = $message;
        }
        $tableOrder->store();

        $aPayment['status'] = $payment_status;
        $aPayment['message'] = $message;
        $aPayment['language'] = $data["language"];

        $this->cart->emptyCart(); //removeCartFromSession();

        return $aPayment;
    }

    public function sendRequest($data) {
        $app = JFactory::getApplication();

        $aPayment = array();

        $contact = new stdClass();
        $contact->email_to = $data['contact_email'];
        $contact->name = $data['contact_fullName'];
        $copy_email_activated = FALSE;

        $params = JComponentHelper::getParams('com_standard');
        $lang = JFactory::getLanguage();
        $lang_codes = JLanguageHelper::getLanguages('lang_code');
        $lang_sef = $lang_codes[$lang->getTag()]->sef;
        $data["language"] = $lang->getTag();


        //$mailfrom = $params->get('email_sendmailcontact');
        //$fromname = $params->get("name_sendmailcontact_{$lang_sef}");
        // $subject = $params->get("subject_sendmailcontact_{$lang_sef}");
        $subject = JText::_('SUBJECT_CONTACT_ENQUIRY');

        $tableCountry = $this->getTable('country');
        $tableCountry->load($data['contact_country_id']);
        $data['country_name'] = $tableCountry->title;

        if (!isset($data['your_request']) || empty($data['your_request'])):
            $itinerarytype_title = isset($data['infoitinerary']->itinerarytype_title) ? $data['infoitinerary']->itinerarytype_title : "";
            $data['your_request'] = JText::sprintf("YOUR_REQUEST", $itinerarytype_title);
        endif;

        $data["number_of_guests"] = $data['contact_adult'] + $data['contact_children'] + $data['contact_infant'];

        $data['paymentmethod_id'] = 4;

        if (empty($subject)):
            $data['contact_subject'] = $sitename = $app->get('sitename');
        else:
            $data['contact_subject'] = $subject;
        endif;

        $data['ccemail'] = $params->get('ccemail');
        $data['bccemailteamit'] = $params->get('bccemailteamit');

        $data['created'] = JFactory::getDate()->toSql();
        // Prepare email body 
        $data['content_mail'] = stripslashes($this->_contentMailContact($data['paymentmethod_id'], $data));

        $sent = $this->_sendEmail($data, $contact, $data['content_mail'], $copy_email_activated);
        $data['sendMail'] = $sent;
        $isCurrencyHistory = false;
        $this->saveBooking($data, "Request", $isCurrencyHistory);

        if ("{$sent}" === "1") {
            $payment_status = 1;
            $message = "";
        } else {
            $payment_status = 0;
            if (!empty(trim($sent))):
                $message = $sent->get('message');
            else:
                $message = "Unknown";
            endif;
        }

        $aPayment['layout'] = $data['layout'];
        $aPayment['confirm_page_type_id'] = $data['confirm_page_type_id'];

        $aPayment['status'] = $payment_status;
        $aPayment['message'] = $message;
        $aPayment['language'] = $data["language"];

        return $aPayment;
    }

    public function sendPromotionRequest($data) {
        $app = JFactory::getApplication();

        $aPayment = array();

        $contact = new stdClass();
        $contact->email_to = $data['contact_email'];
        $contact->name = $data['contact_fullName'];
        $copy_email_activated = FALSE;

        $params = JComponentHelper::getParams('com_standard');
        $lang = JFactory::getLanguage();
        $lang_codes = JLanguageHelper::getLanguages('lang_code');
        $lang_sef = $lang_codes[$lang->getTag()]->sef;
        $data["language"] = $lang->getTag();


        //$mailfrom = $params->get('email_sendmailcontact');
        //$fromname = $params->get("name_sendmailcontact_{$lang_sef}");
        // $subject = $params->get("subject_sendmailcontact_{$lang_sef}");
        $subject = JText::_('SUBJECT_CONTACT_ENQUIRY');

        $tableCountry = $this->getTable('country');
        $tableCountry->load($data['contact_country_id']);
        $data['country_name'] = $tableCountry->title;

        $data['promotion_name'] = '';
        if (isset($data['contact_promotion_id'])):
            $tablePromotion = $this->getTable('promotion');
            $tablePromotion->load($data['contact_promotion_id']);
            $data['promotion_name'] = $tablePromotion->title;
        endif;
        /*
          if (!isset($data['your_request']) || empty($data['your_request'])):
          $itinerarytype_title = isset($data['infoitinerary']->itinerarytype_title) ? $data['infoitinerary']->itinerarytype_title : "";
          $data['your_request'] = JText::sprintf("YOUR_REQUEST", $itinerarytype_title);
          endif;
         */
        $data["infoitinerary"]->title = $data['promotion_name'];

        $data['your_request'] = JText::sprintf("YOUR_REQUEST", JText::_('COM_STANDARD_PROMOTION'));

        $data["number_of_guests"] = $data['contact_adult'] + $data['contact_children'] + $data['contact_infant'];

        $data['paymentmethod_id'] = 4;

        if (empty($subject)):
            $data['contact_subject'] = $sitename = $app->get('sitename');
        else:
            $data['contact_subject'] = $subject;
        endif;

        $data['ccemail'] = $params->get('ccemail');
        $data['bccemailteamit'] = $params->get('bccemailteamit');

        $data['created'] = JFactory::getDate()->toSql();
        // Prepare email body 
        $data['content_mail'] = stripslashes($this->_contentMailContact($data['paymentmethod_id'], $data));

        $sent = $this->_sendEmail($data, $contact, $data['content_mail'], $copy_email_activated);
        $data['sendMail'] = $sent;
        $isCurrencyHistory = false;
        $this->saveBooking($data, "Request", $isCurrencyHistory);

        if ("{$sent}" === "1") {
            $payment_status = 1;
            $message = "";
        } else {
            $payment_status = 0;
            if (!empty(trim($sent))):
                $message = $sent->get('message');
            else:
                $message = "Unknown";
            endif;
        }

        $aPayment['layout'] = $data['layout'];
        $aPayment['confirm_page_type_id'] = $data['confirm_page_type_id'];

        $aPayment['status'] = $payment_status;
        $aPayment['message'] = $message;
        $aPayment['language'] = $data["language"];

        return $aPayment;
    }

    public function sendRegistration($data) {
        $app = JFactory::getApplication();
        $aPayment = array();

        $nowDate = JFactory::getDate()->toSql();
        $data['today'] = JHtml::_('date', $nowDate, JText::_('d-m-Y H:i A'));

        $contact = new stdClass();
        $contact->email_to = $data['email'];
        $contact->name = $data['fullName'];
        $copy_email_activated = FALSE;

        $params = JComponentHelper::getParams('com_standard');
        $lang = JFactory::getLanguage();
        $lang_codes = JLanguageHelper::getLanguages('lang_code');
        $lang_sef = $lang_codes[$lang->getTag()]->sef;
        $data["language"] = $lang->getTag();


        //$mailfrom = $params->get('email_sendmailcontact');
        //$fromname = $params->get("name_sendmailcontact_{$lang_sef}");
        $subject = $params->get("subject_sendmailcontact_{$lang_sef}");
        $subject_team = $params->get("subject_team");

        $data['paymentmethod_id'] = 9;
        if (empty($subject)):
            $data['contact_subject'] = $sitename = $app->get('sitename');
        else:
            $data['contact_subject'] = $subject;
        endif;

        $data['ccemail'] = $params->get('ccemail');
        $data['bccemailteamit'] = $params->get('bccemailteamit');

        $data['created'] = JFactory::getDate()->toSql();
        // Prepare email body 
        $data['content_mail'] = stripslashes($this->_contentMailContact($data['paymentmethod_id'], $data));

        // To Email: Team
        // Prepare email body 
        $data['recipient_email_activated'] = true;
        if (!empty(trim($params->get('recipient_team')))):
            $data['content_mail_team'] = stripslashes($this->_contentMailContact(10, $data));
            $data['toemail'] = $params->get('recipient_team');
            if (empty($subject_team)):
                $data['subject_team'] = $data['contact_subject'];
            else:
                $data['subject_team'] = $subject_team;
            endif;
        endif;

        $sent = $this->_sendEmail($data, $contact, $data['content_mail'], $copy_email_activated);

        $data['sendMail'] = $sent;
        $isCurrencyHistory = false;
        $this->saveBooking($data, "Registration", $isCurrencyHistory);

        if ("{$sent}" === "1") {
            $payment_status = 1;
            $message = "";
        } else {
            $payment_status = 0;
            if (!empty(trim($sent))):
                $message = $sent->get('message');
            else:
                $message = "Unknown";
            endif;
        }

        $aPayment['status'] = $payment_status;
        $aPayment['message'] = $message;
        $aPayment['language'] = $data["language"];

        return $aPayment;
    }

    public function sendContact($data) {
        $app = JFactory::getApplication();
        $aPayment = array();

        $contact = new stdClass();
        $contact->email_to = $data['contact_email'];
        $contact->name = $data['contact_fullName'];
        $copy_email_activated = FALSE;

        $params = JComponentHelper::getParams('com_standard');
        $lang = JFactory::getLanguage();
        $lang_codes = JLanguageHelper::getLanguages('lang_code');
        $lang_sef = $lang_codes[$lang->getTag()]->sef;
        $data["language"] = $lang->getTag();


        //$mailfrom = $params->get('email_sendmailcontact');
        //$fromname = $params->get("name_sendmailcontact_{$lang_sef}");
        // $subject = $params->get("subject_sendmailcontact_{$lang_sef}");
        $subject = $data['contact_subject']; // JText::_('SUBJECT_CONTACT_US');

        $tableCountry = $this->getTable('country');
        $tableCountry->load($data['contact_country_id']);
        $data['country_name'] = $tableCountry->title;


        if (!isset($data['your_request']) || empty($data['your_request'])):
            $itinerarytype_title = isset($data['infoitinerary']->itinerarytype_title) ? $data['infoitinerary']->itinerarytype_title : JText::_('GLOBAL_CONTACT');
            $data['your_request'] = $data['contact_subject']; // JText::sprintf("YOUR_REQUEST", $itinerarytype_title);
        endif;

        $data["number_of_guests"] = 0; //$data['contact_adult'] + $data['contact_children'] + $data['contact_infant'];

        $data['paymentmethod_id'] = 1;
        if (empty($subject)):
            $data['contact_subject'] = $sitename = $app->get('sitename');
        else:
            $data['contact_subject'] = $subject;
        endif;

        $data['ccemail'] = $params->get('ccemail');
        $data['bccemailteamit'] = $params->get('bccemailteamit');

        $data['created'] = JFactory::getDate()->toSql();
        // Prepare email body 
        $data['content_mail'] = stripslashes($this->_contentMailContact($data['paymentmethod_id'], $data));

        $sent = $this->_sendEmail($data, $contact, $data['content_mail'], $copy_email_activated);
        $data['sendMail'] = $sent;
        $isCurrencyHistory = false;
        $this->saveBooking($data, "Request", $isCurrencyHistory);

        if ("{$sent}" === "1") {
            $payment_status = 1;
            $message = "";
        } else {
            $payment_status = 0;
            if (!empty(trim($sent))):
                $message = $sent->get('message');
            else:
                $message = "Unknown";
            endif;
        }

        $aPayment['layout'] = $data['layout'];
        $aPayment['confirm_page_type_id'] = $data['confirm_page_type_id'];
        $aPayment['status'] = $payment_status;
        $aPayment['message'] = $message;
        $aPayment['language'] = $data["language"];

        return $aPayment;
    }

    public function sendQuickContact($data) {
        $contact = new stdClass();
        $contact->email_to = $data['contact_email'];
        $contact->name = $data['contact_fullName'];
        $copy_email_activated = FALSE;

        $params = JComponentHelper::getParams('com_standard');
        $lang = JFactory::getLanguage();
        $lang_codes = JLanguageHelper::getLanguages('lang_code');
        $lang_sef = $lang_codes[$lang->getTag()]->sef;
        $data["language"] = $lang->getTag();

        //$mailfrom = $params->get('email_sendmailcontact');
        //$fromname = $params->get("name_sendmailcontact_{$lang_sef}");
        //$subject = $params->get("subject_sendmailcontact_{$lang_sef}");

        $data['paymentmethod_id'] = 1;
        $data['contact_subject'] = JText::_('SUBJECT_QUICK_CONTACT_REQUEST');
        $data['ccemail'] = $params->get('ccemail');

        // Prepare email body 
        $data['content_mail'] = stripslashes($this->_contentMailContact($data['paymentmethod_id'], $data));
        $sent = $this->_sendEmail($data, $contact, $data['content_mail'], $copy_email_activated);
        return $sent;
    }

    public function saveBooking($data, $typeTable = 'Order', $isCurrencyHistory = true) {

        $app = JFactory::getApplication();
        $tableOrder = $this->getTable($typeTable);
        // --- Detect Utils ---
        $detectUtils = DetectUtils::getDetectUtils();
        $aData = array_merge($data, $detectUtils);

        if ($isCurrencyHistory):
            // add currency history
            $aData["currency_history"] = json_encode($this->getCurrencies());
        endif;
//        echo '<pre>';
//        print_r($data);
//        exit;

        if (isset($aData['contact_birthday'])):
            $ObjContactBirthday = new JDate(Convert::getConvertDate($aData['contact_birthday'], 'Y-m-d'));
            $aData['contact_birthday'] = $ObjContactBirthday->format('Y-m-d');
        endif;

        unset($aData['id']); // fix case Duplicate data and column name "id" in table reservations
        unset($aData['state']);
        unset($aData['access']);

        $isSendMail = array_key_exists('sendMail', $aData); //result  bool(false or true) 
        if ($isSendMail) {
            $sent = $aData['sendMail'];
            if ("{$sent}" === "1") {
                $aData['email_status'] = 1;
                $aData['email_message'] = JText::_('EMAIL_SUCCESS');
            } else {
                $aData['email_status'] = 0;
                $aData['email_message'] = JText::_('EMAIL_FAIL');
                $aData['message_error'] = $sent->get('message');
            }
            if ($typeTable != 'Registration') {
                if ($tableOrder->save($aData)) {
                    $tableOrder->payment_status = 1;
                    $tableOrder->payment_message = JText::_('PAYMENT_SUCCESS');
                } else {
                    $tableOrder->payment_status = 0;
                    $tableOrder->payment_message = JText::_('PAYMENT_ERROR');
                    $tableOrder->message_error = $tableOrder->_errors;
                }
            } else {
                if ($tableOrder->save($aData)) {
                    // --- ---
                } else {
                    $tableOrder->message_error = $tableOrder->_errors;
                }
            }

            if ($tableOrder->store()) {
                return TRUE;
            }
            return FALSE;
        } else {
            // Save reservations before making (online payments or create booking on system opera, smile,...)
            if ($tableOrder->save($aData)) {
                $id = $tableOrder->id;
                return $id;
            }

            return FALSE;
        }
    }

    public function getCurrencies() {
        // Create a new query object.
        $db = $this->getDbo();

        // Construct the query
        $query = $db->getQuery(true)
                ->select('id, title, code_2, code_3, numeric_code, exchange_rate'
                        . ', symbol, decimal_place, decimal_symbol, thousands, positive_style, negative_style'
                        . '')
                ->from('#__standard_currencies')
                ->where('state IN(0, 1)');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    // === Dang Nghien cuu them ===
    // P 	Pending
    // C 	Confirmed
    // X 	Cancelled
    // R 	Refunded
    // S 	Shipped
    // N 	New or coming from cart
    //  TO have no product setted as ordered when added to cart simply delete 'P' FROM array Reserved
    // don't set same values in the 2 arrays !!!
    // stockOut is in normal case shipped product
    //order_stock_handle
    // 'A' : stock Available
    // 'O' : stock Out
    // 'R' : stock reserved
    // the status decreasing real stock ?
    // $stockOut = array('S');
    // === /.Dang Nghien cuu them ===
    public function handleStockAfterStatusChangedPerProduct($newState, $oldState, $tableOrderItems, $quantity) {
        // --- Temp fix ---
        if (!class_exists('HandleStockHelper')) {
            JLoader::register('HandleStockHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/HandleStock.php');
        }
        //$oHandleStockHelper = new HandleStockHelper();
        // N New or coming from cart
        $in_stock = '=';
        $ordered = '+';
        // --- /.Temp fix ---
        // we can have more then one product in case of pack
        // in case of child, ID must be the child ID
        // TO DO use $prod->amount change for packs(eg. 1 computer and 2 HDD)
        if (is_array($tableOrderItems)):
            foreach ($tableOrderItems as $prod):
                HandleStockHelper::updateStockInDB($prod, $quantity, $in_stock, $ordered);
            endforeach;
        else:
            HandleStockHelper::updateStockInDB($tableOrderItems, $quantity, $in_stock, $ordered);
        endif;
    }

    private function _contentMailContact($paymentmethod_id = 0, $data = null) {

        jimport("informationtechnology.smarty.mainsmarty");
        $smarty = MainSmarty::getSmarty();

        // 1 : MALE
        // 2 : FEMALE
        // 3 : OTHER
        $gender = array(
            1 => JText::_('COM_STANDARD_CONTACT_MALE_LABEL'),
            2 => JText::_('COM_STANDARD_CONTACT_FEMALE_LABEL'),
            3 => JText::_('COM_STANDARD_CONTACT_OTHER_LABEL')
        );

        $language = array(
            "dear" => JText::_("DEAR"),
            "quick_contact_content_head_title" => JText::_("QUICK_CONTACT_CONTENT_HEAD_TITLE"),
            "quick_contact_content_head" => JText::_('QUICK_CONTACT_CONTENT_HEAD'),
            "quick_contact_request_title" => JText::_('QUICK_CONTACT_REQUEST_TITLE'),
            "content_head_title" => JText::_("CONTENT_HEAD_TITLE"),
            "content_head" => JText::_('CONTENT_HEAD'),
            "contact_information_title" => JText::_('CONTACT_INFORMATION_TITLE'),
            "order_request_title" => JText::_('ORDER_REQUEST_TITLE'),
            "contact_fullName" => JText::_('COM_STANDARD_CONTACT_FULL_NAME_LABEL'),
            "contact_Name" => JText::_('COM_STANDARD_CONTACT_NAME_LABEL'),
            "contact_gender" => JText::_('COM_STANDARD_CONTACT_GENDER'),
            "contact_birthday" => JText::_('COM_STANDARD_CONTACT_BIRTHDAY_LABEL'),
            "country_of_residence" => JText::_('COM_STANDARD_CONTACT_COUNTRY_OF_RESIDENCE_LABEL'),
            "contact_check_in_date" => JText::_('COM_STANDARD_CONTACT_CHECK_IN_DATE_LABEL'),
            "number_of_guests" => JText::_('COM_STANDARD_CONTACT_NUMBER_OF_GUESTS_LABEL'),
            "contact_email" => JText::_('COM_STANDARD_CONTACT_EMAIL_LABEL'),
            "contact_phone" => JText::_('COM_STANDARD_CONTACT_PHONE_LABEL'),
            "contact_fax" => JText::_('COM_STANDARD_CONTACT_FAX_LABEL'),
            "message" => JText::_('MESSAGE'),
            "category_product" => JText::_('CATEGORY_PRODUCT'),
            "manufacturer" => JText::_('COM_STANDARD_MANUFACTURER'),
            "order_price" => JText::_('ORDER_PRICE'),
            "quantity" => JText::_('QUANTITY'),
            "tax" => JText::_('TAX'),
            "coupon_code" => JText::_('COM_STANDARD_COUPON_CODE'),
            "sales_price_coupon" => JText::_('COM_STANDARD_SALES_PRICE_COUPON'),
            "selected_shipment" => JText::_('COM_STANDARD_CART_SELECTED_SHIPMENT'),
            "shipment_cost" => JText::_('COM_STANDARD_SHIPMENT_COST'),
            "bill_total" => JText::_('COM_STANDARD_BILL_TOTAL'),
            "product_prices_total" => JText::_('PRODUCT_PRICES_TOTAL'),
            "payable_amount" => JText::_('PAYABLE_AMOUNT'),
            "total_amount_payable" => JText::_('TOTAL_AMOUNT_PAYABLE'),
            "address" => JText::_('ADDRESS'),
            "head_office" => JText::_('HEAD_OFFICE'),
            "sales_office" => JText::_('SALES_OFFICE'),
            "best_regards" => JText::_('BEST_REGARDS'),
            "team" => JText::_('TEAM'),
            "order_confirmation_title" => JText::_('ORDER_CONFIRMATION_TITLE'),
            "order_confirmation_confirmation_number" => JText::_('ORDER_CONFIRMATION_CONFIRMATION_NUMBER'),
            "order_confirmation_content_head" => JText::_('ORDER_CONFIRMATION_CONTENT_HEAD'),
            // --- Registration ---
            "dear" => "Thân chào",
            "fullName" => "Họ tên",
            "phone" => "Số điện thoại",
            "email" => 'Email công ty',
            "position" => 'Chức vụ',
            "referrerphonenumber" => 'SĐT người giới thiệu',
            "companyName" => "Tên công ty",
            "rentalCode" => 'Mã số thuê',
            "city" => 'Thành phố',
            "nation" => 'Quốc gia',
            "address" => 'Địa chỉ',
            "typeOfBusiness" => 'Loại hình doanh nghiệp',
            "revenueLevel" => 'Mức doanh thu từ kinh doanh du lịch trung bình/ tháng hiện tại của Quý đại lý',
            "fbWebsite" => "Để tài khoản được duyệt nhanh hơn, vui lòng cung cấp link FB/website bán hàng"
        );

        $data["logo"] = JUri::root() . "images/logo/logo.png";
        $data["logo_footer"] = JUri::root() . "images/logo/logo_footer.png";
        $data['message'] = isset($data['contact_message']) ? strip_tags(nl2br($data['contact_message']), '<br>') : "";
        $data['gender'] = isset($data['contact_gender']) ? $gender[$data['contact_gender']] : "";

        $data["logo_facebook"] = JUri::root() . "images/logo/logo_facebook.png";
        $data["logo_youtube"] = JUri::root() . "images/logo/logo_youtube.png";
        $data["logo_instagram"] = JUri::root() . "images/logo/logo_instagram.png";
        $data["logo_tmg"] = JUri::root() . "images/logo/logo_tmg.png";

//        echo '<pre>';
//        print_r($data);
//        exit;

        switch ($paymentmethod_id) {
            case 1://send contact request
                $smarty->assign('data', $data);
                $smarty->assign('language', $language);
                return iconv('UTF-8', 'UTF-8//IGNORE', $smarty->fetch("request/mailContactRequest.tpl"));

            case 2://send order confirmation
                $smarty->assign('data', $data);
                $smarty->assign('language', $language);
                return iconv('UTF-8', 'UTF-8//IGNORE', $smarty->fetch("order/mailorderconfirmation.tpl"));

            case 3://send Reserve
                $smarty->assign('data', $data);
                $smarty->assign('language', $language);
                return iconv('UTF-8', 'UTF-8//IGNORE', $smarty->fetch("order/mailsendOrderRequest.tpl"));

            case 4://send request
                $smarty->assign('data', $data);
                $smarty->assign('language', $language);
                return iconv('UTF-8', 'UTF-8//IGNORE', $smarty->fetch("request/mailReserveRequest.tpl"));

            case 8:// "quick contact"
                $smarty->assign('data', $data);
                $smarty->assign('language', $language);
                return iconv('UTF-8', 'UTF-8//IGNORE', $smarty->fetch("request/mailquickcontact.tpl"));

            case 9:// "customer: send request Notification"
                $data["logo"] = JUri::root() . "images/logo/email/logo_notification.png";
                $data["footerLogo"] = JUri::root() . "images/logo/email/footerLogo.png";
                $data["line"] = JUri::root() . "images/logo/email/line.jpg";
                $data["logoTMG"] = JUri::root() . "images/logo/email/logoTMG.png";
                $smarty->assign('data', $data);
                $smarty->assign('language', $language);
                return iconv('UTF-8', 'UTF-8//IGNORE', $smarty->fetch("request/mailNotification.tpl"));

            case 10:// "Team: info Registration"
                $data["logo"] = JUri::root() . "images/logo/email/logo.png";
                $smarty->assign('data', $data);
                $smarty->assign('language', $language);
                return iconv('UTF-8', 'UTF-8//IGNORE', $smarty->fetch("request/mailRegistration.tpl"));

            default:
                break;
        }

        return NULL;
    }

    private function _sendEmail($data, $contact, $body, $copy_email_activated) {
        $app = JFactory::getApplication();

        $mailfrom = $app->get('mailfrom');
        $fromname = $app->get('fromname');
        $sitename = $app->get('sitename');


        if (isset($data['mailfrom']) && !empty($data['mailfrom'])):
            $mailfrom = $data['mailfrom'];
        endif;
        if (isset($data['fromname']) && !empty($data['fromname'])):
            $fromname = $data['fromname'];
        endif;

        $name = $app->get('replytoname');
        $email = JStringPunycode::emailToPunycode($app->get('replyto'));
        $subject = $data['contact_subject'];

        if (!empty($data['ccemail'])) {
            $recipient = preg_replace("/ /", "", $data['ccemail']);
            $ccemail = explode(",", $recipient);
        } else {
            $ccemail = null;
        }

        if (!empty($data['bccemailteamit'])) {
            $bccrecipient = preg_replace("/ /", "", $data['bccemailteamit']);
            $bccemailteamit = explode(",", $bccrecipient);
        } else {
            $bccemailteamit = null;
        }

        // Prepare email body 
        //$body = stripslashes($this->_contentMailContact($data['paymentmethod_id'], $data));

        /*
          // Load the custom fields
          if ($data['com_fields'] && $fields = FieldsHelper::getFields('com_standard.mail', $contact, true, $data['com_fields'])) {
          $output = FieldsHelper::render(
          'com_standard.mail', 'fields.render', array('context' => 'com_standard.mail', 'item' => $contact, 'fields' => $fields)
          );
          if ($output) {
          $body .= "\r\n\r\n" . $output;
          }
          }
         */

        $mail = JFactory::getMailer();
        $mail->addRecipient($contact->email_to);
        $mail->addReplyTo($email, $name);
        $mail->addCC($ccemail);
        $mail->setSender(array($mailfrom, $fromname));
        $mail->setSubject($subject);
        $mail->IsHTML(true);
        $mail->setBody($body);
        $sent = $mail->Send();

        if ($data['recipient_email_activated'] == true && !empty($data['toemail'])) {

            $sRecipient = preg_replace("/ /", "", $data['toemail']);
            $toemail = explode(",", $sRecipient);

            $tobody = $data['content_mail_team'];
            $tosubject = $data['subject_team'];

            $mail = JFactory::getMailer();
            $mail->addRecipient($toemail);
            $mail->addReplyTo($email, $name);
            $mail->setSender(array($mailfrom, $fromname));
            $mail->setSubject($tosubject);
            $mail->IsHTML(true);
            $mail->setBody($tobody);
            $sent = $mail->Send();
        }

        // If we are supposed to copy the sender, do so.
        // Check whether email copy function activated
        if ($copy_email_activated == true && !empty($data['contact_email_copy'])) {
            $copytext = JText::sprintf('COM_STANDARD_COPYTEXT_OF', $contact->name, $sitename);
            $copytext .= "\r\n\r\n" . $body;
            $copysubject = JText::sprintf('COM_STANDARD_COPYSUBJECT_OF', $subject);

            $mail = JFactory::getMailer();
            $mail->addRecipient($email);
            $mail->addReplyTo($email, $name);
            $mail->setSender(array($mailfrom, $fromname));
            $mail->setSubject($copysubject);
            $mail->IsHTML(true);
            $mail->setBody($copytext);
            $sent = $mail->Send();
        }

        return $sent;
    }

    public function saveInfomation($data, $typeTable = "Subscribe") {
        $aSave = array();
        $tableInfo = $this->getTable($typeTable);
        // --- Detect Utils ---
        $detectUtils = DetectUtils::getDetectUtils();
        $aData = array_merge($data, $detectUtils);

        $lang = JFactory::getLanguage();
        $data["language"] = $lang->getTag();

        $data['created'] = JFactory::getDate()->toSql();

        $aSave['layout'] = $data['layout'];
        $aSave['confirm_page_type_id'] = $data['confirm_page_type_id'];

        $aSave['status'] = 1;
        $aSave['message'] = JText::_('Success');
        $aSave['language'] = $data["language"];

        if (!$tableInfo->save($aData)) {
            $error = $tableInfo->_errors;
            $aSave['status'] = 0;
            $aSave['message'] = $error[0];
        }

        return $aSave;
    }

}
