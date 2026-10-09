<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class CurrencyHelper {

    static $_instance = array();
    private $_currencyConverter;
    // --- ---
    public $_currency_id = '0';  // string ID related with the currency (ex : language)
    private $_symbol = 'udef'; // Printable symbol
    private $_nbDecimal = 2; // Number of decimals past colon (or other)
    private $_decimal = ','; // Decimal symbol ('.', ',', ...)
    private $_thousands = ' ';  // Thousands separator ('', ' ', ',')
    private $_positivePos = '{number}{symbol}'; // Currency symbol position with Positive values :
    private $_negativePos = '{sign}{number}{symbol}'; // Currency symbol position with Negative values :
    private $_numeric_code = 0;
    // --- ---
    var $_priceConfig = array(); //holds arrays of 0 and 1 first is if price should be shown, second is rounding
    var $exchangeRateShopper = 1.0;
    var $_vendorCurrency = 0;
    var $_vendorCurrency_code_3 = 0;
    var $_vendorCurrency_numeric = 0;
    // --- ---
    public $_exchange_rate;
    public $_code_3;
    // --- ---
    // --- Foreign --- 
    public $_currency_id_foreign = '0';  // string ID related with the currency (ex : language)
    public $_symbol_foreign = 'udef'; // Printable symbol
    public $_nbDecimal_foreign = 2; // Number of decimals past colon (or other)
    public $_decimal_foreign = ','; // Decimal symbol ('.', ',', ...)
    public $_thousands_foreign = ' ';  // Thousands separator ('', ' ', ',')
    public $_positivePos_foreign = '{number}{symbol}'; // Currency symbol position with Positive values :
    public $_negativePos_foreign = '{sign}{number}{symbol}'; // Currency symbol position with Negative values :
    public $_numeric_code_foreign = 0;
    var $_priceConfig_foreign = array(); //holds arrays of 0 and 1 first is if price should be shown, second is rounding
    var $exchangeRateShopper_foreign = 1.0;
    var $_vendorCurrency_foreign = 0;
    var $_vendorCurrency_code_3_foreign = 0;
    var $_vendorCurrency_numeric_foreign = 0;
    public $_exchange_rate_foreign;
    public $_code_3_foreign;
    // --- /. Foreign ---

    public static $priceNames = array('basePrice', 'variantModification', 'basePriceVariant',
        'basePriceWithTax', 'discountedPriceWithoutTax', 'discountedPriceWithoutTaxTt',
        'salesPrice', 'salesPriceTt', 'priceWithoutTax', 'priceWithoutTaxTt',
        'salesPriceWithDiscount', 'discountAmount', 'discountAmountTt', 'taxAmount', 'taxAmountTt', 'unitPrice');

    /**
     * Constructor.
     */
    private function __construct($vendorId = 0) {
        if (empty($vendorId)) :
            $vendorId = 1;
        endif;

        // Get the model.
        $vendorModel = self::getModel("Vendor"); // Hien tai chua lam "Vendor" => co thoi gian lam them cho nay
        $vendorCurrency = $vendorModel ? $vendorModel->getVendorCurrency($vendorId) : new stdClass();

        if (sizeof((array) $vendorCurrency) > 0):
            $this->_vendorCurrency = $vendorCurrency->vendor_currency;
        // -- Lam them cho truong hop nay sau --
        // $this->_vendorCurrency_code_3 = $vendorCurrency->currency_code_3;
        // $this->_vendorCurrency_numeric = $vendorCurrency->currency_numeric_code;
        // -- /.Lam them cho truong hop nay sau --
        else:
            $params = JComponentHelper::getParams('com_standard');
            if (!empty($params->get('currency_id'))):
                $this->_vendorCurrency = (int) $params->get('currency_id');
            // -- Lam them cho truong hop nay sau --
            // $this->_vendorCurrency_code_3 = $vendorCurrency->currency_code_3;
            // $this->_vendorCurrency_numeric = $vendorCurrency->currency_numeric_code;
            // -- /.Lam them cho truong hop nay sau --
            endif;

            if (!empty($params->get('currency_id_foreign'))):
                $this->_vendorCurrency_foreign = (int) $params->get('currency_id_foreign');
            endif;

        endif;
    }

    /**
     * Get helper object
     * @return ObjectExtendable
     */
    public static function getInstance($currencyId = 0, $currencyIdForeign = 0, $vendorId = 0) {
        /*
          $h = $currencyId . '.' . $vendorId;
          if (!isset(self::$_instance[$h])) {
          self::$_instance[$h] = new CurrencyHelper($vendorId);
          if (empty($currencyId)) {
          $app = JFactory::getApplication();
          if ($app->isSite()) {// isSite: 1 else(admin): bool(false)
          self::$_instance[$h]->_currency_id = $app->getUserStateFromRequest('currency_id', 'currency_id', JRequest::getInt('currency_id', self::$_instance[$h]->_vendorCurrency));
          }
          } else {
          self::$_instance[$h]->_currency_id = $currencyId;
          }

          // Get the model.
          $model = self::$_instance[$h]->getModel();
          $style = $model->getItem(self::$_instance[$h]->_currency_id);
          if (!empty($style)) {
          self::$_instance[$h]->setCurrencyDisplayToStyleStr($style); //style
          }
          }
          self::$_instance[$h]->setPriceArray();
          return self::$_instance[$h];
         */
        if (!self::$_instance) {
            self::$_instance = new CurrencyHelper($vendorId);
        }

        // Get the model.
        $model = self::$_instance->getModel();
        // --- default (VN) ---
        if (empty($currencyId)) {
            $app = JFactory::getApplication();
            if ($app->isSite()) {// isSite: 1 else(admin): bool(false) 
                self::$_instance->_currency_id = $app->getUserStateFromRequest('currency_id', 'currency_id', JRequest::getInt('currency_id', self::$_instance->_vendorCurrency));
            }
        } else {
            self::$_instance->_currency_id = $currencyId;
        }

        $style = $model->getItem(self::$_instance->_currency_id);
        if (!empty($style)) {
            self::$_instance->setCurrencyDisplayToStyleStr($style); //style
        }
      
        self::$_instance->setPriceArray();

        // --- /. default (VN) ---
        // --- Foreign --- 
        if (empty($currencyIdForeign)) {
            $app = JFactory::getApplication();
            if ($app->isSite()) {// isSite: 1 else(admin): bool(false) 
                self::$_instance->_currency_id_foreign = $app->getUserStateFromRequest('currency_id_foreign', 'currency_id_foreign', JRequest::getInt('currency_id_foreign', self::$_instance->_vendorCurrency_foreign));
            }
        } else {
            self::$_instance->_currency_id_foreign = $currencyIdForeign;
        }

        $style_foreign = $model->getItem(self::$_instance->_currency_id_foreign);
        if (!empty($style_foreign)) {
            self::$_instance->setCurrencyDisplayToStyleStrForeign($style_foreign); //style foreign
        }
        
        self::$_instance->setPriceArrayForeign();
        // --- /. Foreign ---

        return self::$_instance;
    }

    /**
     * Proxy for getModel.
     */
    public function getModel($name = 'Currency', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_standard/models');
        JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_standard/tables');
        $getModel = JModelLegacy::getInstance($name, $prefix, $config);
        return $getModel;
    }

    /**
     * Parse the given currency display string into the currency diplsy values.
     *
     * This function takes the currency style string as saved in the vendor
     * record and parses it into its appropriate values.  An example style
     * string would be 1|&euro;|2|,|.|0|0
     *
     * @author Binh Nguyen
     * @param String $currencyStyle String containing the currency display settings
     */
    private function setCurrencyDisplayToStyleStr($style) {
        $this->_currency_id = $style->id;
        $this->_symbol = $style->symbol;
        $this->_nbDecimal = $style->decimal_place;
        $this->_decimal = $style->decimal_symbol;
        $this->_numeric_code = (int) $style->numeric_code;
        $this->_thousands = $style->thousands;
        $this->_positivePos = $style->positive_style;
        $this->_negativePos = $style->negative_style;
        $this->_exchange_rate = $style->exchange_rate;
        $this->_code_3 = $style->code_3;
    }

    private function setCurrencyDisplayToStyleStrForeign($style) {
        $this->_currency_id_foreign = $style->id;
        $this->_symbol_foreign = $style->symbol;
        $this->_nbDecimal_foreign = $style->decimal_place;
        $this->_decimal_foreign = $style->decimal_symbol;
        $this->_numeric_code_foreign = (int) $style->numeric_code;
        $this->_thousands_foreign = $style->thousands;
        $this->_positivePos_foreign = $style->positive_style;
        $this->_negativePos_foreign = $style->negative_style;
        $this->_exchange_rate_foreign = (empty($style->exchange_rate) ? 1.0 : intval($style->exchange_rate) == 0) ? 1.0 : $style->exchange_rate;
        $this->_code_3_foreign = $style->code_3;
    }

    /**
     * This function sets an array, which holds the information if
     * a price is to be shown and the number of rounding digits
     *
     * @author Binh Nguyen
     */
    function setPriceArray() {
        if (count($this->_priceConfig) > 0):
            return true;
        endif;

        if (!count($this->_priceConfig)) {
            foreach (self::$priceNames as $name) {
                //$this->_priceConfig[$name] = array(0, 0, 0);// array(Show Price, Show Label, Rounding Digits)
                $this->_priceConfig[$name] = array(1, 0, 0); // fix temp: 1 Show Price
            }
        }
    }

    /**
     * This function sets an array, which holds the information if
     * a price is to be shown and the number of rounding digits
     *
     * @author Binh Nguyen
     */
    function setPriceArrayForeign() {
        if (count($this->_priceConfig_foreign) > 0):
            return true;
        endif;

        if (!count($this->_priceConfig_foreign)) {
            foreach (self::$priceNames as $name) {
                //$this->_priceConfig_foreign[$name] = array(0, 0, 0);// array(Show Price, Show Label, Rounding Digits)
                $this->_priceConfig_foreign[$name] = array(1, 0, 0); // fix temp: 1 Show Price
            }
        }
    }
    /**
     * function to create a div to show the prices, is necessary for JS
     *
     * @author Binh Nguyen
     * @param string name of the price
     * @param String description key
     * @param array the prices of the product
     * return a div for prices which is visible according to config and have all ids and class set
     */
    public function createPrice($name, $description, $product_price, $priceOnly = false, $switchSequel = false, $quantity = 1.0, $forceNoLabel = false, $force = false) {

        if (empty($product_price) and $name != 'billTotal' and $name != 'billTaxAmount'):
            return '';
        endif;

        //The fallback, when this price is not configured
        if (empty($this->_priceConfig[$name])) {
            $this->_priceConfig[$name] = $this->_priceConfig['salesPrice'];
        }

        //This is a fallback because we removed the "salesPriceWithDiscount" ;
        if (is_array($product_price)) {
            if (isset($product_price[$name])) {
                $price = $product_price[$name];
            } else {
                return '';
            }
        } else {
            $price = $product_price;
        }

        //This could be easily extended by product specific settings
        if (!empty($this->_priceConfig[$name][0]) or $force) {
            if (!empty($price) or $name == 'billTotal' or $name == 'billTaxAmount') {
                $vis = " gp-display gp-price-value";
                // $priceFormatted = $this->priceDisplay($price, 0, (float) $quantity, $this->_priceConfig[$name][1]);
                $priceFormatted = $this->priceDisplay($price, 0, (float) $quantity);
            } else {
                $priceFormatted = '';
                $vis = " gp-nodisplay";
            }
            if ($priceOnly) {
                return $priceFormatted;
            }
            if ($this->_priceConfig[$name][2] and ! $forceNoLabel) {
                $descr = JText::_($description);
                if ($switchSequel) {
                    return '<div class="Price' . $name . $vis . '"><span class="Price' . $name . '">' . $priceFormatted . '</span>' . $descr . '</div>';
                } else {
                    return '<div class="Price' . $name . $vis . '"><span class="gp-price-desc">' . $descr . '</span><span class="Price' . $name . '">' . $priceFormatted . '</span></div>';
                }
            } else {
                return '<div class="Price' . $name . $vis . '"><span class="Price' . $name . '">' . $priceFormatted . '</span></div>';
            }
        }
    }

    /**
     * getCurrencyForDisplay: get The actual displayed Currency
     * Use this only in a view, plugin or modul, never in a model
     *
     * @param integer $currencyId
     * return integer $currencyId: displayed Currency
     */
    public function getCurrencyForDisplay($currencyId = 0) {
        return $this->_currency_id;
    }

    public function getPaymentCurrency($currencyId = 0) {
        $PaymentCurrency = new stdClass();
        if ((int) $currencyId === (int) $this->_currency_id) {
            $PaymentCurrency->paymentCurrency = $this->_currency_id;
            $PaymentCurrency->paymentCurrencySymbol = $this->_symbol;
            $PaymentCurrency->paymentCurrencyNBDecimal = $this->_nbDecimal;
            $PaymentCurrency->paymentCurrencyDecimal = $this->_decimal;
            $PaymentCurrency->paymentCurrencyNumericCode = $this->_numeric_code;
            $PaymentCurrency->paymentCurrencyThousands = $this->_thousands;
            $PaymentCurrency->paymentCurrencyPositivePos = $this->_positivePos;
            $PaymentCurrency->paymentCurrencyNegativePos = $this->_negativePos;
            $PaymentCurrency->paymentCurrencyRate = $this->_exchange_rate;
            $PaymentCurrency->paymentCurrencyCode3 = $this->_code_3;
            return $PaymentCurrency;
        }
        // Get the model.
        $model = self::getModel();
        $oPaymentCurrency = $model->getItem($currencyId);
        $PaymentCurrency->paymentCurrency = $oPaymentCurrency->id;
        $PaymentCurrency->paymentCurrencySymbol = $oPaymentCurrency->symbol;
        $PaymentCurrency->paymentCurrencyNBDecimal = $oPaymentCurrency->decimal_place;
        $PaymentCurrency->paymentCurrencyDecimal = $oPaymentCurrency->decimal_symbol;
        $PaymentCurrency->paymentCurrencyNumericCode = $oPaymentCurrency->numeric_code;
        $PaymentCurrency->paymentCurrencyThousands = $oPaymentCurrency->thousands;
        $PaymentCurrency->paymentCurrencyPositivePos = $oPaymentCurrency->positive_style;
        $PaymentCurrency->paymentCurrencyNegativePos = $oPaymentCurrency->negative_style;
        $PaymentCurrency->paymentCurrencyRate = $oPaymentCurrency->exchange_rate;
        $PaymentCurrency->paymentCurrencyCode3 = $oPaymentCurrency->code_3;
        return $PaymentCurrency;
    }

    /**
     * This function is for the gui only!
     * Use this only in a view, plugin or modul, never in a model
     * TODO for remove quantity option
     * @param float $price
     * @param integer $currencyId
     * return string formatted price
     */
    public function priceDisplay($price, $currencyId = 0, $quantity = 1.0, $nb = -1) {

        $price = $this->roundForDisplay($price, $currencyId, $quantity, $nb);
        return $this->getFormattedCurrency($price, $nb);
        //return $this->getFormatCurrency((float) $price * (float) $quantity, $currencyId, $nb);
    }

    public function roundForDisplay($price, $currencyId = 0, $quantity = 1.0, $nb = -1) {

        if (empty($currencyId))
            $currencyId = $this->getCurrencyForDisplay($currencyId);
        if ($nb == -1) {
            $nb = $this->_nbDecimal;
        }
        $price = $this->convertCurrencyTo($currencyId, $price);

        /*
          if (GPConfig::get('roundindig')) {
          $price = round((float) $price * (float) $quantity, $nb);
          } else {
          $price = round((float) $price, $nb) * (float) $quantity;
          }

          if ($this->_numeric_code === 756 and GPConfig::get('rappenrundung', FALSE) == "1") {
          //$price = (float)$price * (float)$quantity;
          $price = round((float) $price * 2, 1) * 0.5;
          }
         */

        $price = round((float) $price * (float) $quantity, $nb);
        return $price;
    }

    /**
     * Format, Round and Display Value
     * @author Binh Nguyen
     * @param val number
     */
    public function getFormattedCurrency($price, $nbDecimal = -1) {

        //TODO $this->_nbDecimal is the config of the currency and $nbDecimal is the config of the price type.
        if ($nbDecimal == -1)
            $nbDecimal = $this->_nbDecimal;
        if ($price >= 0) {
            $format = $this->_positivePos;
            $sign = '+';
        } else {
            $format = $this->_negativePos;
            $sign = '-';
            $price = abs($price);
        }

        //$res = $this->formatNumber($price, $nbDecimal, $this->_thousands, $this->_decimal);
        $res = number_format((float) $price, (int) $nbDecimal, $this->_decimal, $this->_thousands);
        $search = array('{sign}', '{number}', '{symbol}');
        $replace = array($sign, $res, $this->_symbol);

        $formattedRounded = str_replace($search, $replace, $format);

        return $formattedRounded;
    }

    public function getFormattedCurrencyForeign($price, $nbDecimal = -1) {

        //TODO $this->_nbDecimal is the config of the currency and $nbDecimal is the config of the price type.
        if ($nbDecimal == -1)
            $nbDecimal = $this->_nbDecimal_foreign;
        if ($price >= 0) {
            $format = $this->_positivePos_foreign;
            $sign = '+';
        } else {
            $format = $this->_negativePos_foreign;
            $sign = '-';
            $price = abs($price);
        }

        //$res = $this->formatNumber($price, $nbDecimal, $this->_thousands, $this->_decimal);
        $res = number_format((float) $price, (int) $nbDecimal, $this->_decimal_foreign, $this->_thousands_foreign);
        $search = array('{sign}', '{number}', '{symbol}');
        $replace = array($sign, $res, $this->_symbol_foreign);

        $formattedRounded = str_replace($search, $replace, $format);

        return $formattedRounded;
    }

    /**
     * Format, Round and Display Value
     * @author Binh Nguyen
     * @param val number
     */
    public function getFormatCurrency($price, $currID, $nbDecimal = -1) {
        // Get the model.
        $model = self::getModel();
        $style = $model->getItem($currID);
        if (!empty($style)) {
            $this->setCurrencyDisplayToStyleStr($style);
        }

        //TODO $this->_nbDecimal is the config of the currency and $nbDecimal is the config of the price type.
        if ($nbDecimal == -1)
            $nbDecimal = $this->_nbDecimal;
        if ($price >= 0) {
            $format = $this->_positivePos;
            $sign = '+';
        } else {
            $format = $this->_negativePos;
            $sign = '-';
            $price = abs($price);
        }

        //$res = $this->formatNumber($price, $nbDecimal, $this->_thousands, $this->_decimal);
        $res = number_format((float) $price, (int) $nbDecimal, $this->_decimal, $this->_thousands);
        $search = array('{sign}', '{number}', '{symbol}');
        $replace = array($sign, $res, $this->_symbol);

        $formattedRounded = str_replace($search, $replace, $format);

        return $formattedRounded;
    }

    public function getCurrencyRate($currID) {
        $model = self::getModel();
        $style = $model->getItem($currID);
        return $style->exchange_rate;
    }

    /**
     * @author Binh Nguyen
     * @param int $currA currency ID
     * @param float $price
     */
    function convertCurrencyTo($currA, $price) {
        if ((int) $currA === (int) $this->_currency_id) {
            return $price;
        }
        // Get the model.
        $model = self::getModel();
        $oCurrencyA = $model->getItem($currA);

        $valA = (empty($oCurrencyA->exchange_rate) ? 1.0 : intval($oCurrencyA->exchange_rate) == 0) ? 1.0 : $oCurrencyA->exchange_rate;
        $valB = (empty($this->_exchange_rate) ? 1.0 : intval($this->_exchange_rate) == 0) ? 1.0 : $this->_exchange_rate;
        $val = (float) $price * (float) $valB / (float) $valA;

        return $val;
    }

    /**
     * @author Binh Nguyen [HU] http://www.giaiphapcongnghethongtin.vn
     * @author Binh Nguyen
     * @param float $amountA
     * @param int $currA currency ID
     * @param int $currB currency ID
     * @return mixed The converted amount when successful, false on failure
     */
    /*
    function convertCurrency($amountA, $currA = 0, $currB = 0, $relatedCurrency = 'EUR') {
        $PrefixExchangeRate = "_exchange_rate";
        // Get the model.
        $model = self::getModel();
        if ((int) $currB != (int) $this->_currency_id):
            $oCurrencyB = $model->getItem($currB);
            if (!empty($oCurrencyB)) :
                $this->setCurrencyDisplayToStyleStr($oCurrencyB); //style
            endif;
            $PrefixExchangeRate = "exchange_rate";
        else :
            $oCurrencyB = clone($this);
        endif;

        if ($currA == $currB) {
            return $amountA;
        }

        $oCurrencyA = $model->getItem($currA);

        $valA = empty($oCurrencyA->exchange_rate) ? 1.0 : intval($oCurrencyA->exchange_rate) == 0 ? 1.0 : $oCurrencyA->exchange_rate;
        $valB = empty($oCurrencyB->$PrefixExchangeRate) ? 1.0 : intval($oCurrencyB->$PrefixExchangeRate) == 0 ? 1.0 : $oCurrencyB->$PrefixExchangeRate;

        $val = (float) $amountA * (float) $valB / (float) $valA;

        return $val;
    }
    */
    /**
     * @author Binh Nguyen [HU] http://www.giaiphapcongnghethongtin.vn
     * @author Binh Nguyen
     * @param float $amountA
     * @param int $currA currency ID
     * @param int $currB currency ID
     * @return mixed The converted amount when successful, false on failure
     */
    function convertCurrency($amountA, $currA = 0, $currB = 0, $foreign = FALSE, $style = FALSE, $relatedCurrency = 'EUR') {
        switch ($foreign) {
            case TRUE:
                $PrefixExchangeRate = "_exchange_rate_foreign";
                // Get the model.
                $model = self::getModel();
                if ((int) $currB != (int) $this->_currency_id_foreign) {
                    $currBCurrency = $model->getItem($currB);
                    if (!empty($currBCurrency)) {//  && $style //xem lai "$style" nay
                        $this->setCurrencyDisplayToStyleStrForeign($currBCurrency); //style
                    }
                    $PrefixExchangeRate = "exchange_rate";
                } else {
                    $currBCurrency = clone($this);
                }

                break;

            default:
                $PrefixExchangeRate = "_exchange_rate";
                // Get the model.
                $model = self::getModel();
                if ((int) $currB != (int) $this->_currency_id) {
                    $currBCurrency = $model->getItem($currB);
                    if (!empty($currBCurrency)) {//  && $style // xem lai "$style" nay
                        $this->setCurrencyDisplayToStyleStr($currBCurrency); //style
                    }
                    $PrefixExchangeRate = "exchange_rate";
                } else {
                    $currBCurrency = clone($this);
                }

                break;
        }


        if ($currA == $currB) {
            return $amountA;
        }

        $currACurrency = $model->getItem($currA);

        $valA = (empty($currACurrency->exchange_rate) ? 1.0 : intval($currACurrency->exchange_rate) == 0) ? 1.0 : $currACurrency->exchange_rate;
        $valB = (empty($currBCurrency->$PrefixExchangeRate) ? 1.0 : intval($currBCurrency->$PrefixExchangeRate) == 0) ? 1.0 : $currBCurrency->$PrefixExchangeRate;

        $val = (float) $amountA * (float) $valB / (float) $valA;

        return $val;
    }

    /**
     *
     * @author Binh Nguyen [HU] http://www.giaiphapcongnghethongtin.vn
     * @author Binh Nguyen
     * @param double $number
     * @param int $decimals
     * @param string $thousand_separator
     * @param string $decimal_point
     */
    public function formatNumber($number, $decimals = 2, $decimal_point = '.', $thousand_separator = '&nbsp;') {
        return number_format($number, $decimals, $decimal_point, $thousand_separator);
    }

    /**
     * Return the currency symbol
     */
    public function getSymbol() {
        return($this->_symbol);
    }

    /**
     * Return the currency ID
     */
    public function getId() {
        return($this->_currency_id);
    }

    /* --- orders --- */

    /**
     * @param float $amountA
     * @param object $oCurrA
     * @param object $oCurrB
     * @return mixed The converted amount when successful, false on failure
     */
    public static function convert($amountA, $oCurrA, $oCurrB) {

        if ($oCurrA->id == $oCurrB->id):
            return $amountA;
        endif;

        $valA = (empty($oCurrA->exchange_rate) ? 1.0 : intval($oCurrA->exchange_rate) == 0) ? 1.0 : $oCurrA->exchange_rate;
        $valB = (empty($oCurrB->exchange_rate) ? 1.0 : intval($oCurrB->exchange_rate) == 0) ? 1.0 : $oCurrB->exchange_rate;

        $val = (float) $amountA * (float) $valB / (float) $valA;

        return $val;
    }

    /**
     * Format, Round and Display Value
     * @author Binh Nguyen
     * @param val number
     */
    public static function displayFormattedCurrency($price, $oStyle) {
        if ($price >= 0) {
            $format = $oStyle->positive_style;
            $sign = '+';
        } else {
            $format = $oStyle->negative_style;
            $sign = '-';
            $price = abs($price);
        }

        $res = number_format((float) $price, (int) $oStyle->decimal_place, $oStyle->decimal_symbol, $oStyle->thousands);
        $search = array('{sign}', '{number}', '{symbol}');
        $replace = array($sign, $res, $oStyle->symbol);

        $formattedRounded = str_replace($search, $replace, $format);

        return $formattedRounded;
    }

    /* --- /. orders --- */
}