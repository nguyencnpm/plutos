<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
if (!class_exists('CurrencyHelper')) {
    JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
}

class CalculationHelper {

    protected $_db;
    protected $_shopperGroupId;
    var $_cats;
    protected $_now;
    protected $_nullDate;
    protected $_debug;
    protected $_manufacturerId;
    public $_deliveryCountry;
    public $_deliveryState;
    public $_currencyDisplay;
    var $_cart = null;
    var $productPrices;
    var $allrules = array();

    /* @deprecated */
    public $_amount = 1;
    public $_amountCart = 0.0;
    public $productVendorId;
    public $productCurrency;
    public $product_tax_id = 0;
    public $product_discount_id = 0;
    public $product_marge_id = 0;
    public $vendorCurrency = 0;
    public $inCart = FALSE;
    private $checkAutomaticSelected = false;
    protected $exchangeRateVendor = 0;
    protected $exchangeRateShopper = 0;
    protected $_internalDigits = 9;
    protected $_revert = false;
    protected $_isPriceHasVatTax = 0;
    static $_instance;

    private function __construct($vendorId = 1, $countryId = 0, $stateId = 0) {
        $this->_db = JFactory::getDBO();
        $this->_app = JFactory::getApplication();

        $this->productVendorId = $vendorId;
        $this->_currencyDisplay = CurrencyHelper::getInstance();
        /*
          $this->_debug = false;

          if (!empty($this->_currencyDisplay->_vendorCurrency)) {
          $this->vendorCurrency = $this->_currencyDisplay->_vendorCurrency;
          $this->vendorCurrency_code_3 = $this->_currencyDisplay->_vendorCurrency_code_3;
          $this->vendorCurrency_numeric = $this->_currencyDisplay->_vendorCurrency_numeric;
          }
         */
        $this->_amount = 1;
        $this->_internalDigits = 9;
        $this->_revert = false;
        $this->_isPriceHasVatTax = 0;

        $this->setCountryState($countryId, $stateId);
        $this->setVendorId($this->productVendorId);

        $this->rules['Marge'] = array();
        $this->rules['Tax'] = array();
        $this->rules['VatTax'] = array();
        $this->rules['DBTax'] = array();
        $this->rules['DATax'] = array();

        //round only with internal digits
        //$this->_roundindig = Config->get('roundindig', false);
        $this->_roundindig = false;
    }

    /**
     * Proxy for getModel.
     */
    public function getModel($name = 'Calculation', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_standard/models', 'StandardModel');
        $getModel = JModelLegacy::getInstance($name, $prefix, $config);
        return $getModel;
    }

    public static function getInstance($vendorId = 1, $countryId = 0, $stateId = 0) {
        if (!is_object(self::$_instance)) {
            self::$_instance = new CalculationHelper($vendorId, $countryId, $stateId);
        } else {
            //We store in UTC and use here of course also UTC
            $jnow = JFactory::getDate();
            self::$_instance->_now = $jnow->toSQL();
        }

        return self::$_instance;
    }

    protected function setCountryState($countryId = 0, $stateId = 0) {
        if (!empty($countryId)) {
            $this->_deliveryCountry = $countryId;
            $this->_deliveryState = $stateId;
            return;
        }
        // code here
    }

    public function setVendorId($id) {
        if (empty($this->_calcModel)) :
            $this->_calcModel = $this->getModel('Calculations');
        endif;

        $this->productVendorId = (int) $id;
        if (empty($this->allrules[$this->productVendorId])) :
            $epoints = array("'Marge'", "'Tax'", "'VatTax'", "'DBTax'", "'DATax'");
            $this->allrules[$this->productVendorId]['Marge'] = array();
            $this->allrules[$this->productVendorId]['Tax'] = array();
            $this->allrules[$this->productVendorId]['VatTax'] = array();
            $this->allrules[$this->productVendorId]['DBTax'] = array();
            $this->allrules[$this->productVendorId]['DATax'] = array();

            // Filter by published state
            $this->_calcModel->setState('filter.published', 1);
            $this->_calcModel->setState('filter.epoints', $epoints);
            $this->_calcModel->setState('filter.isStartEndDates', true);
            // get allrules in Model Calculations
            $allrules = $this->_calcModel->getItems();
            // Check data
            if (!$allrules):
                return;
            endif;
            // set allrules...
            foreach ($allrules as $rule) {
                $this->allrules[$this->productVendorId][$rule->kind][$rule->id] = $rule;
            }
        endif;
    }

    public function setProduct($product, $amount = 1.0) {
        // --- set reset isPriceHasVatTax ---
        $params = JComponentHelper::getParams('com_standard');
        if (!empty($params->get('isPriceHasVatTax'))):
            $this->_isPriceHasVatTax = (int) $params->get('isPriceHasVatTax');
        endif;
        // --- /.set reset isPriceHasVatTax ---

        /*
          if (!empty($product->allPrices[$product->selectedPrice])):
          $this->productPrices = $product->allPrices[$product->selectedPrice];

          $this->productCurrency = $this->productPrices['product_currency'];

          $product->product_tax_id = $this->product_tax_id = $this->productPrices['product_tax_id'];
          $this->product_discount_id = $this->productPrices['product_discount_id'];
          endif;
         */
        $this->productCurrency = $product->currency_id;
        /*
          $productVendorId = !empty($product->vendor_id) ? $product->vendor_id : 1;
          $this->setVendorId($productVendorId);
         */
        $productVendorId = !empty($product->vendor_id) ? $product->vendor_id : 1;
        if ($productVendorId != $this->productVendorId):// Toi uu code trong truong hop co 1 nha cung cap (Vendor)
            $this->setVendorId($productVendorId);
        endif;

        $this->_cats = isset($product->catid) ? array($product->catid) : array(); //isset($product->categories)? $product->categories: array();
        $this->_product = $product;
        $this->_product->amount = $amount; //temporary quantity

        if (!isset($this->_product->quantity)) {
            $this->_product->quantity = 1;
        }

        $this->_manufacturerId = array();
        if (!empty($product->manufacturer_ids)):
            if (is_array($product->manufacturer_ids)) :
                $this->_manufacturerId = $product->manufacturer_ids;
            else:
                $this->_manufacturerId = explode(",", preg_replace("/ /", "", $product->manufacturer_ids));
            endif;
        endif;

        // static $vendorCurrencies = array();
        // 
        // $this->vendorCurrency = $vendorCurrencies[$this->productVendorId];
        // 
        // return $this->productPrices;
        // === Set temp thoi -> co thoi gian dieu chinh lai ===
        $product->categories = $this->_cats;
        $product->manufacturer_id = $this->_manufacturerId;
        // === /.Set temp thoi -> co thoi gian dieu chinh lai ===
    }

    public function getProductPrices(&$product, $variant = 0.0, $amount = 0) {
        $app = JFactory::getApplication();
        // --- case Prices: using in admin --- 
        if ($app->isAdmin()):
        // case for admin code here
        else:
        //
        endif;
        // --- /.case Prices: using in admin --- 
        //temporary quantity
        if (empty($amount)) {
            $amount = 1;
        }

        $this->_amount = $amount;

        $this->setProduct($product, $amount); // $prices = $this->setProduct($product, $amount);
        // ========== Price Has VatTax ==========
        $isAfterTax = FALSE;
        if ($this->_isPriceHasVatTax):
            $this->rules['VatTax'] = $this->gatherEffectingRulesForProductPrice('VatTax', $this->product_tax_id);
            if (!empty($this->rules['VatTax'])) :
                $this->_revert = true;
                $priceHasVatTaxCurrency = $this->roundInternal($this->_currencyDisplay->convertCurrencyTo((int) $this->productCurrency, $product->price));
                $afterTax = $this->roundInternal($this->executeCalculation($this->rules['VatTax'], $priceHasVatTaxCurrency), 'salesPrice');
                if (!empty($afterTax)) :
                    $isAfterTax = TRUE;
                    $product->price = $afterTax;
                // $this->productPrices['taxAmount'] = $priceHasVatTaxCurrency - $afterTax;
                endif;

                $this->_revert = false;
            endif;
        endif;
        // ========== /.Price Has VatTax ========

        $this->productPrices['costPrice'] = $product->price;
        if (!$isAfterTax):// converted Currency To on
            $basePriceShopCurrency = $this->roundInternal($this->_currencyDisplay->convertCurrencyTo((int) $this->productCurrency, $product->price));
        else:
            $basePriceShopCurrency = $product->price;
        endif;

        //For Profit, margin, and so on
        $this->rules['Marge'] = $this->gatherEffectingRulesForProductPrice('Marge', $this->product_marge_id);
        $basePriceMargin = $this->roundInternal($this->executeCalculation($this->rules['Marge'], $basePriceShopCurrency));
        $this->basePrice = $basePriceShopCurrency = $this->productPrices['basePrice'] = !empty($basePriceMargin) ? $basePriceMargin : $basePriceShopCurrency;

        if (!empty($variant)) {
            $variant = $this->roundInternal($this->_currencyDisplay->convertCurrencyTo((int) $this->productCurrency, doubleval($variant), true));
            $basePriceShopCurrency = $basePriceShopCurrency + $variant;
            $this->productPrices['basePrice'] = $this->productPrices['basePriceVariant'] = $basePriceShopCurrency;
            $this->productPrices['basePriceVariantFormatted'] = $this->_currencyDisplay->priceDisplay($this->productPrices['basePriceVariant']);
        }

        // --- xem set lai can Phan tich them ---
        if (empty($this->productPrices['basePrice'])) {
            return $this->fillVoidPrices($this->productPrices);
        }

        if (empty($this->productPrices['basePriceVariant'])) {
            $this->productPrices['basePriceVariant'] = $this->productPrices['basePrice'];
            $this->productPrices['basePriceVariantFormatted'] = $this->_currencyDisplay->priceDisplay($this->productPrices['basePriceVariant']);
        }
        // --- /.xem set lai can Phan tich them ---

        $this->rules['Tax'] = $this->gatherEffectingRulesForProductPrice('Tax', $this->product_tax_id);
        $this->productPrices['basePriceWithTax'] = $this->roundInternal($this->executeCalculation($this->rules['Tax'], $this->productPrices['basePrice'], true), 'basePriceWithTax');

        $this->rules['VatTax'] = $this->gatherEffectingRulesForProductPrice('VatTax', $this->product_tax_id);
        if (!empty($this->rules['VatTax'])) {
            $price = !empty($this->productPrices['basePriceWithTax']) ? $this->productPrices['basePriceWithTax'] : $this->productPrices['basePrice'];
            $this->productPrices['basePriceWithTax'] = $this->roundInternal($this->executeCalculation($this->rules['VatTax'], $price, true), 'basePriceWithTax');
        }

        $this->rules['DBTax'] = $this->gatherEffectingRulesForProductPrice('DBTax', $this->product_discount_id);
        $this->productPrices['discountedPriceWithoutTax'] = $this->roundInternal($this->executeCalculation($this->rules['DBTax'], $this->productPrices['basePrice']), 'discountedPriceWithoutTax');

        $override = -1; // fix temp
        /*
          if ($override == -1) {
          $this->productPrices['discountedPriceWithoutTax'] = $product_override_price;
          }
         */

        // ==== ---------- ====
        $priceBeforeTax = !empty($this->productPrices['discountedPriceWithoutTax']) ? $this->productPrices['discountedPriceWithoutTax'] : $this->productPrices['basePrice'];
        $this->productPrices['priceBeforeTax'] = $priceBeforeTax;
        $this->productPrices['salesPrice'] = $this->roundInternal($this->executeCalculation($this->rules['Tax'], $priceBeforeTax, true), 'salesPrice');
        $salesPrice = !empty($this->productPrices['salesPrice']) ? $this->productPrices['salesPrice'] : $priceBeforeTax;

        $this->productPrices['taxAmount'] = $this->roundInternal($salesPrice - $priceBeforeTax);

        if (!empty($this->rules['VatTax'])) {
            $this->productPrices['salesPrice'] = $this->roundInternal($this->executeCalculation($this->rules['VatTax'], $salesPrice), 'salesPrice');
            $salesPrice = !empty($this->productPrices['salesPrice']) ? $this->productPrices['salesPrice'] : $salesPrice;
        }

        $this->rules['DATax'] = $this->gatherEffectingRulesForProductPrice('DATax', $this->product_discount_id);
        $this->productPrices['salesPriceWithDiscount'] = $this->roundInternal($this->executeCalculation($this->rules['DATax'], $salesPrice), 'salesPriceWithDiscount');
        $this->productPrices['salesPrice'] = !empty($this->productPrices['salesPriceWithDiscount']) ? $this->productPrices['salesPriceWithDiscount'] : $salesPrice;
        // ==== --------- ====
        $this->productPrices['salesPriceTemp'] = $this->productPrices['salesPrice'];
        /*
          //Okey, this may not the best place, but atm we handle the override price as salesPrice
          if ($override == 1) {
          $this->productPrices['salesPrice'] = $product_override_price;
          }
         */
        if (!empty($product->product_packaging) and $product->product_packaging != '0.0000') {
            $this->productPrices['unitPrice'] = $this->productPrices['salesPrice'] / $product->product_packaging;
        } else {
            $this->productPrices['unitPrice'] = 0.0;
        }
        // ==== ---------- ====
        if (!empty($this->rules['VatTax'])) {
            $this->_revert = true;
            $afterTax = $this->roundInternal($this->executeCalculation($this->rules['VatTax'], $this->productPrices['salesPrice']), 'salesPrice');

            if (!empty($afterTax)) {
                $this->productPrices['taxAmount'] = $this->productPrices['salesPrice'] - $afterTax;
            }

            $this->_revert = false;
        }

        //The whole discount Amount
        $basePriceWithTax = !empty($this->productPrices['basePriceWithTax']) ? $this->productPrices['basePriceWithTax'] : $this->productPrices['basePrice'];

        //changed
        if (empty($this->rules['DBTax'])) {
            $this->productPrices['discountAmount'] = $this->roundInternal($basePriceWithTax - $this->productPrices['salesPrice']) * -1;
        } else {
            $this->productPrices['discountAmount'] = $this->roundInternal($this->productPrices['discountedPriceWithoutTax'] - $this->productPrices['basePriceVariant']) * -1;
        }
        //price Without Tax but with calculated discounts AFTER Tax. So it just shows how much the shopper saves, regardless which kind of tax
        //$this->productPrices['priceWithoutTax'] = $this->productPrices['salesPrice'] - $this->productPrices['taxAmount']; Gives correct result, but is the same as discountedPriceWithoutTax, with just $salesPrice it is wrong, but the same as the last years.
        $this->productPrices['priceWithoutTax'] = $salesPrice - $this->productPrices['taxAmount'];
        if ($override == 1 || $this->productPrices['discountedPriceWithoutTax'] == 0) {
            $this->productPrices['discountedPriceWithoutTax'] = $this->productPrices['salesPrice'] - $this->productPrices['taxAmount'];
        }
        if (!isset($this->productPrices['discountedPriceWithoutTax']))
            $this->productPrices['discountedPriceWithoutTax'] = 0.0;

        $this->productPrices['variantModification'] = $variant;

        $this->productPrices['DBTax'] = array();
        foreach ($this->rules['DBTax'] as $dbtax) {
            // --- fix temp --- co thoi gian phat trien them cho nay
            $dbtax['shopper_published'] = isset($dbtax['shopper_published']) ? $dbtax['shopper_published'] : 0;
            $dbtax['params'] = isset($dbtax['params']) ? $dbtax['params'] : '';
            $dbtax['vendor_id'] = isset($dbtax['vendor_id']) ? $dbtax['vendor_id'] : 1;
            // --- fix temp ---
            $this->productPrices['DBTax'][$dbtax['id']] = array($dbtax['title'], $dbtax['value'], $dbtax['value_mathop'], $dbtax['shopper_published'], $dbtax['currency'], $dbtax['currency_id'], $dbtax['params'], $dbtax['vendor_id'], $dbtax['id']);
        }

        $this->productPrices['Tax'] = array();
        foreach ($this->rules['Tax'] as $tax) {
            // --- fix temp --- co thoi gian phat trien them cho nay
            $tax['shopper_published'] = isset($tax['shopper_published']) ? $tax['shopper_published'] : 0;
            $tax['params'] = isset($tax['params']) ? $tax['params'] : '';
            $tax['vendor_id'] = isset($tax['vendor_id']) ? $tax['vendor_id'] : 1;
            // --- fix temp ---
            $this->productPrices['Tax'][$tax['id']] = array($tax['title'], $tax['value'], $tax['value_mathop'], $tax['shopper_published'], $tax['currency'], $tax['currency_id'], $tax['params'], $tax['vendor_id'], $tax['id']);
        }

        $this->productPrices['VatTax'] = array();
        foreach ($this->rules['VatTax'] as $vattax) {
            // --- fix temp --- co thoi gian phat trien them cho nay
            $vattax['shopper_published'] = isset($vattax['shopper_published']) ? $vattax['shopper_published'] : 0;
            $vattax['params'] = isset($vattax['params']) ? $vattax['params'] : '';
            $vattax['vendor_id'] = isset($vattax['vendor_id']) ? $vattax['vendor_id'] : 1;
            // --- fix temp ---
            $this->productPrices['VatTax'][$vattax['id']] = array($vattax['title'], $vattax['value'], $vattax['value_mathop'], $vattax['shopper_published'], $vattax['currency'], $vattax['currency_id'], $vattax['currency_id'], $vattax['params'], $vattax['vendor_id'], $vattax['id'],);
        }

        $this->productPrices['DATax'] = array();
        foreach ($this->rules['DATax'] as $datax) {
            // --- fix temp --- co thoi gian phat trien them cho nay
            $datax['shopper_published'] = isset($datax['shopper_published']) ? $datax['shopper_published'] : 0;
            $datax['params'] = isset($datax['params']) ? $datax['params'] : '';
            $datax['vendor_id'] = isset($datax['vendor_id']) ? $datax['vendor_id'] : 1;
            // --- fix temp ---
            $this->productPrices['DATax'][$datax['id']] = array($datax['title'], $datax['value'], $datax['value_mathop'], $datax['shopper_published'], $datax['currency'], $datax['currency_id'], $datax['params'], $datax['vendor_id'], $datax['id']);
        }

        $this->productPrices['Marge'] = array();
        foreach ($this->rules['Marge'] as $marge) {
            // --- fix temp --- co thoi gian phat trien them cho nay
            $marge['shopper_published'] = isset($marge['shopper_published']) ? $marge['shopper_published'] : 0;
            $marge['params'] = isset($marge['params']) ? $marge['params'] : '';
            $marge['vendor_id'] = isset($marge['vendor_id']) ? $marge['vendor_id'] : 1;
            // --- fix temp ---
            $this->productPrices['Marge'][$marge['id']] = array($marge['title'], $marge['value'], $marge['value_mathop'], $marge['shopper_published'], $marge['currency'], $marge['currency_id'], $marge['params'], $marge['vendor_id'], $marge['id']);
        }

        if (!empty($this->rules['VatTax'])) {
            if (empty($this->_cart->cartData['VatTax'])) {
                $this->_cart->cartData['VatTax'] = array();
            }

            foreach ($this->rules['VatTax'] as &$rule) {
                if (isset($this->_cart->cartData['VatTax'][$rule['id']])) {
                    if (!isset($this->_cart->cartData['VatTax'][$rule['id']]['taxAmount'])) {
                        $this->_cart->cartData['VatTax'][$rule['id']]['taxAmount'] = 0.0;
                        $this->_cart->cartData['VatTax'][$rule['id']]['subTotal'] = 0.0;
                    }
                    $this->_cart->cartData['VatTax'][$rule['id']]['taxAmount'] += $this->productPrices['taxAmount'] * $this->_product->amount;
                    $this->_cart->cartData['VatTax'][$rule['id']]['subTotal'] += $this->productPrices['salesPrice'] * $this->_product->amount;
                } else {
                    $this->_cart->cartData['VatTax'][$rule['id']] = $rule;
                    if (!isset($this->_cart->cartData['VatTax'][$rule['id']]['taxAmount']))
                        $this->_cart->cartData['VatTax'][$rule['id']]['taxAmount'] = $this->productPrices['taxAmount'] * $this->_product->amount;
                    if (!isset($this->_cart->cartData['VatTax'][$rule['id']]['subTotal']))
                        $this->_cart->cartData['VatTax'][$rule['id']]['subTotal'] = $this->productPrices['salesPrice'] * $this->_product->amount;
                }
            }
        }

        $tots = array('salesPrice', 'basePriceWithTax', 'discountedPriceWithoutTax', 'priceWithoutTax', 'discountAmount', 'taxAmount');
        foreach ($tots as $name) {
            if (isset($this->productPrices[$name])) {
                $this->productPrices[$name . 'Formatted'] = $this->_currencyDisplay->priceDisplay($this->productPrices[$name]);
                $this->productPrices[$name . 'Tt'] = $this->productPrices[$name] * $amount;
                $this->productPrices[$name . 'FormattedTt'] = $this->_currencyDisplay->priceDisplay($this->productPrices[$name . 'Tt']);
            } else {
                $this->productPrices[$name . 'Formatted'] = 0.0;
                $this->productPrices[$name . 'Tt'] = 0.0;
                $this->productPrices[$name . 'FormattedTt'] = 0.0;
            }
        }

        foreach ($this->productPrices as $k => &$price) {
            if (!is_array($price) and ! empty($price) and is_numeric($price)) {
                $price = round($price, $this->_internalDigits - 4);
            }
        }

        // $this->productPrices = array_merge($prices, $this->productPrices);
        return $this->productPrices;
    }

    public function setRevert($revert) {
        $this->_revert = $revert;
    }

    public function fillVoidPrices(&$prices) {

        if (!isset($prices['basePrice']))
            $prices['basePrice'] = null;
        if (!isset($prices['basePriceVariant']))
            $prices['basePriceVariant'] = null;
        if (!isset($prices['basePriceWithTax']))
            $prices['basePriceWithTax'] = null;
        if (!isset($prices['discountedPriceWithoutTax']))
            $prices['discountedPriceWithoutTax'] = null;
        if (!isset($prices['priceBeforeTax']))
            $prices['priceBeforeTax'] = null;
        if (!isset($prices['taxAmount']))
            $prices['taxAmount'] = null;
        if (!isset($prices['salesPriceWithDiscount']))
            $prices['salesPriceWithDiscount'] = null;
        if (!isset($prices['salesPriceTemp']))
            $prices['salesPriceTemp'] = null;
        if (!isset($prices['salesPrice']))
            $prices['salesPrice'] = null;
        if (!isset($prices['discountAmount']))
            $prices['discountAmount'] = null;
        if (!isset($prices['priceWithoutTax']))
            $prices['priceWithoutTax'] = null;
        if (!isset($prices['variantModification']))
            $prices['variantModification'] = null;
        if (!isset($prices['unitPrice']))
            $prices['unitPrice'] = null;
        return $prices;
    }

    /** function to start the calculation, here it is for the invoice in the checkout
     * This function is partly implemented !
     *
     * The function calls getProductPrices for every product except it is already known (maybe changed and adjusted with product amount value
     * The single prices gets added in an array and already summed up.
     *
     * Then simular to getProductPrices first the effecting rules are determined and calculated.
     * Ah function to determine the coupon that effects the calculation is already implemented. But not completly in the calculation.
     *
     * 		Subtotal + Tax + Discount =	Total
     *
     * @author Binh Nguyen
     * @param int $productIds 	The Ids of the products
     * @param int $cartVendorId The Owner of the cart, this can be ignored in gp1.5
     * @return int $prices		An array of the prices
     * 							'resultWithOutTax'	The summed up baseprice of all products
     * 							'resultWithTax'  	The final price of all products with their tax, discount and so on
     * 							'discountBeforeTax'	discounted price without tax which affects only the checkout (the tax of the products is in it)
     * 							'discountWithTax'	discounted price taxed
     * 							'discountAfterTax'	final result
     *
     */
    //public function getCheckoutPrices(&$cart, $checkAutomaticSelected=true) {
    public function getCheckoutPrices(&$cart) {

        //gpdebug('in function getCheckoutPrices in function getCheckoutPrices');
        $this->_cart = &$cart;
        $this->inCart = TRUE;
        //$pricesPerId = array();

        $resultWithTax = 0.0;
        $resultWithOutTax = 0.0;
        $this->_cart->cartData['VatTax'] = array();
        $this->_cart->cartPrices = array();
        $this->_cart->cartPrices['basePrice'] = 0;
        $this->_cart->cartPrices['basePriceWithTax'] = 0;
        $this->_cart->cartPrices['discountedPriceWithoutTax'] = 0;
        $this->_cart->cartPrices['salesPrice'] = 0;
        $this->_cart->cartPrices['taxAmount'] = 0;
        $this->_cart->cartPrices['salesPriceWithDiscount'] = 0;
        $this->_cart->cartPrices['discountAmount'] = 0;
        $this->_cart->cartPrices['priceWithoutTax'] = 0;
        $this->_cart->cartPrices['subTotalProducts'] = 0;
        $this->_cart->cartPrices['billTotal'] = 0;
        $this->_cart->cartData['duty'] = 1;

        $this->_cart->cartData['payment'] = 0; //could be automatically set to a default set in the globalconfig
        $this->_cart->cartData['paymentName'] = '';
        // $cartpaymentTax = 0;

        $this->_amountCart = 0;

        // $customfieldModel = GpModel::getModel('customfields');

        foreach ($this->_cart->products as $cprdkey => $productCart) {

            if (empty($this->_cart->products[$cprdkey]->quantity) || empty($this->_cart->products[$cprdkey]->id)) {//--- root: product_id = id ---
                if (!is_object($this->_cart->products[$cprdkey])) {
                    //gpdebug( 'Error the product for calculation is not an object',$product);
                } else {
                    //gpError('Error the quantity of the product for calculation is 0, please notify the shopowner, the product id ' . $this->_cart->products[$cprdkey]->product_id);
                }
                continue;
            }

            $this->productCurrency = isset($this->_cart->products[$cprdkey]->currency_id) ? $this->_cart->products[$cprdkey]->currency_id : 0; // --- product_currency = currency_id ---

            $variantmod = 0; // $customfieldModel->calculateModificators($this->_cart->products[$cprdkey]);
            $productPrice = $this->getProductPrices($this->_cart->products[$cprdkey], $variantmod, $this->_cart->products[$cprdkey]->quantity);
            //gpTrace('getProductPrices $productPrice '.$variantmod.' '.$productPrice['basePriceVariant'].' '.$productPrice['salesPrice']);
            //gpdebug('getCheckoutPrices ',$productPrice['salesPrice']);
//            echo '<pre>';
//            print_r($this);
//            exit;

            $selectedPrice = $this->_cart->products[$cprdkey]->selectedPrice;
            $this->_cart->products[$cprdkey]->allPrices[$selectedPrice] = array_merge($this->_cart->products[$cprdkey]->allPrices[$selectedPrice], $productPrice);

            $this->_cart->cartPrices[$cprdkey] = $productPrice; //$this->_cart->products[$cprdkey]->allPrices[$selectedPrice];

            $this->_amountCart += $this->_cart->products[$cprdkey]->quantity;

            if ($this->_currencyDisplay->_priceConfig['basePrice'])
                $this->_cart->cartPrices['basePrice'] += self::roundInternal($this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['basePrice'], 'basePrice') * $this->_cart->products[$cprdkey]->quantity;
            if ($this->_currencyDisplay->_priceConfig['basePriceWithTax'])
                $this->_cart->cartPrices['basePriceWithTax'] += self::roundInternal($this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['basePriceWithTax']) * $this->_cart->products[$cprdkey]->quantity;
            if ($this->_currencyDisplay->_priceConfig['discountedPriceWithoutTax'])
                $this->_cart->cartPrices['discountedPriceWithoutTax'] += self::roundInternal($this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['discountedPriceWithoutTax'], 'discountedPriceWithoutTax') * $this->_cart->products[$cprdkey]->quantity;

            if ($this->_currencyDisplay->_priceConfig['salesPrice']) {
                $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal_with_tax'] = self::roundInternal($this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['salesPrice'], 'salesPrice') * $this->_cart->products[$cprdkey]->quantity;
                $this->_cart->cartPrices['salesPrice'] += $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal_with_tax'];
                $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'] = $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal_with_tax'];
            }

            if ($this->_currencyDisplay->_priceConfig['taxAmount']) {
                $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal_tax_amount'] = self::roundInternal($this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['taxAmount'], 'taxAmount') * $this->_cart->products[$cprdkey]->quantity;
                $this->_cart->cartPrices['taxAmount'] += $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal_tax_amount'];
            }

            if ($this->_currencyDisplay->_priceConfig['salesPriceWithDiscount'])
                $this->_cart->cartPrices['salesPriceWithDiscount'] += self::roundInternal($this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['salesPriceWithDiscount'], 'salesPriceWithDiscount') * $this->_cart->products[$cprdkey]->quantity;
            if ($this->_currencyDisplay->_priceConfig['discountAmount']) {
                $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal_discount'] = self::roundInternal($this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['discountAmount'], 'discountAmount') * $this->_cart->products[$cprdkey]->quantity;
                $this->_cart->cartPrices['discountAmount'] += $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal_discount'];
            }
            if ($this->_currencyDisplay->_priceConfig['priceWithoutTax']) {
                $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal'] = self::roundInternal($this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['priceWithoutTax'], 'priceWithoutTax') * $this->_cart->products[$cprdkey]->quantity;
                $this->_cart->cartPrices['priceWithoutTax'] += $this->_cart->products[$cprdkey]->allPrices[$selectedPrice]['subtotal'];
            }
            $this->_cart->products[$cprdkey]->prices = $this->_cart->products[$cprdkey]->allPrices[$selectedPrice];
        }

        $this->_product = null;
        $this->_cart->cartData['DBTaxRulesBill'] = $this->gatherEffectingRulesForBill('DBTaxBill');
        $this->_cart->cartData['taxRulesBill'] = $this->gatherEffectingRulesForBill('TaxBill');
        $this->_cart->cartData['DATaxRulesBill'] = $this->gatherEffectingRulesForBill('DATaxBill');

        $this->_cart->cartPrices['salesPriceDBT'] = array();
        $this->_cart->cartPrices['taxRulesBill'] = array();
        $this->_cart->cartPrices['DATaxRulesBill'] = array();


        foreach ($this->_cart->products as $cprdkey => $product) {
            //for Rules with Categories / Manufacturers
            foreach ($this->_cart->cartData['DBTaxRulesBill'] as &$dbrule) {
                $applyRule = FALSE;
                if (!empty($dbrule['categories']) || !empty($dbrule['manufacturers'])) {
                    if (!isset($dbrule['subTotal']))
                        $dbrule['subTotal'] = 0.0;
                    $setCat = !empty($dbrule['categories']) ? array_intersect($dbrule['categories'], $product->categories) : array();
                    $setMan = !empty($dbrule['manufacturers']) ? array_intersect($dbrule['manufacturers'], $product->manufacturer_id) : array();
                    if (!empty($dbrule['categories']) && !empty($dbrule['manufacturers'])) {
                        if (count($setCat) > 0 && count($setMan) > 0) {
                            $applyRule = TRUE;
                        }
                    } else {
                        if (count($setCat) > 0 || count($setMan) > 0) {
                            $applyRule = TRUE;
                        }
                    }
                } else {
                    $applyRule = TRUE;
                }
                if ($applyRule) {
                    if (!isset($dbrule['subTotal']))
                        $dbrule['subTotal'] = 0.0;
                    $dbrule['subTotal'] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                    // subarray with subTotal for each taxID necessary to calculate tax correct if there are more than one VatTaxes
                    if (!isset($dbrule['subTotalPerTaxID']))
                        $dbrule['subTotalPerTaxID'] = array();
                    if ($product->product_tax_id != 0) {
                        if (!isset($dbrule['subTotalPerTaxID'][$product->product_tax_id]))
                            $dbrule['subTotalPerTaxID'][$product->product_tax_id] = 0.0;
                        $dbrule['subTotalPerTaxID'][$product->product_tax_id] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                    } else {
                        $taxRules = array_merge($this->allrules[$product->vendor_id]['VatTax'], $this->_cart->cartData['taxRulesBill']);
                        foreach ($taxRules as $id => $rule) {
                            if (!empty($rule['categories']) || !empty($rule['manufacturers'])) {
                                $setCat = !empty($rule['categories']) ? array_intersect($rule['categories'], $product->categories) : array();
                                $setMan = !empty($rule['manufacturers']) ? array_intersect($rule['manufacturers'], $product->manufacturer_id) : array();
                                if (!empty($rule['categories']) && !empty($rule['manufacturers'])) {
                                    if (count($setCat) > 0 && count($setMan) > 0) {
                                        if (!isset($dbrule['subTotalPerTaxID'][$rule['id']]))
                                            $dbrule['subTotalPerTaxID'][$rule['id']] = 0.0;
                                        $dbrule['subTotalPerTaxID'][$rule['id']] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                                    }
                                } else {
                                    if (count($setCat) > 0 || count($setMan) > 0) {
                                        if (!isset($dbrule['subTotalPerTaxID'][$rule['id']]))
                                            $dbrule['subTotalPerTaxID'][$rule['id']] = 0.0;
                                        $dbrule['subTotalPerTaxID'][$rule['id']] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                                    }
                                }
                            } else {
                                if (!isset($dbrule['subTotalPerTaxID'][$rule['id']]))
                                    $dbrule['subTotalPerTaxID'][$rule['id']] = 0.0;
                                $dbrule['subTotalPerTaxID'][$rule['id']] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                            }
                        }
                    }
                }
            }

            // subTotal for each taxID necessary, equal if categories exists ore not
            if (!empty($this->_cart->cartData['taxRulesBill'])) {
                foreach ($this->_cart->cartData['taxRulesBill'] as $k => &$trule) {
                    if (empty($trule['subTotal']))
                        $trule['subTotal'] = 0.0;
                    if ($product->product_tax_id != 0) {
                        if ($product->product_tax_id == $k) {
                            $trule['subTotal'] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                        }
                    } else if (!empty($trule['categories']) || !empty($trule['manufacturers'])) {
                        $setCat = !empty($trule['categories']) ? array_intersect($trule['categories'], $product->categories) : array();
                        $setMan = !empty($trule['manufacturers']) ? array_intersect($trule['manufacturers'], $product->manufacturer_id) : array();
                        if (!empty($trule['categories']) && !empty($trule['manufacturers'])) {
                            if (count($setCat) > 0 && count($setMan) > 0) {
                                $trule['subTotal'] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                            }
                        } else {
                            if (count($setCat) > 0 || count($setMan) > 0) {
                                $trule['subTotal'] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                            }
                        }
                    } else {
                        $trule['subTotal'] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                    }
                    //gpdebug('$this->_cart->cartData["taxRulesBill"]',$this->_cart->cartPrices[$cprdkey]);
                }
            }

            foreach ($this->_cart->cartData['DATaxRulesBill'] as &$darule) {
                if (!empty($darule['categories']) || !empty($darule['manufacturers'])) {
                    if (!isset($darule['subTotal']))
                        $darule['subTotal'] = 0.0;
                    $setCat = !empty($darule['categories']) ? array_intersect($darule['categories'], $product->categories) : array();
                    $setMan = !empty($darule['manufacturers']) ? array_intersect($darule['manufacturers'], $product->manufacturer_id) : array();
                    if (!empty($darule['categories']) && !empty($darule['manufacturers'])) {
                        if (count($setCat) > 0 && count($setMan) > 0) {
                            $darule['subTotal'] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                        }
                    } else {
                        if (count($setCat) > 0 || count($setMan) > 0) {
                            $darule['subTotal'] += $this->_cart->cartPrices[$cprdkey]['subtotal_with_tax'];
                        }
                    }
                }
            }
        }

        // Calculate the discount from all rules before tax to calculate billTotal
        $cartdiscountBeforeTax = $this->roundInternal($this->cartRuleCalculation($this->_cart->cartData['DBTaxRulesBill'], $this->_cart->cartPrices['salesPrice']));

        // We need the discount for each taxID to reduce the total discount before calculate percentage from hole cart discounts
        foreach ($this->_cart->cartData['DBTaxRulesBill'] as &$rule) {
            if (!empty($rule['subTotalPerTaxID'])) {
                foreach ($rule['subTotalPerTaxID'] as $k => $DBTax) {
                    $this->roundInternal($this->cartRuleCalculation($this->_cart->cartData['DBTaxRulesBill'], $this->_cart->cartPrices['salesPrice'], $k, true));
                }
            }
        }

        // combine the discounts before tax for each taxID
        foreach ($this->_cart->cartData['VatTax'] as &$rule) {
            if (!empty($rule['DBTax'])) {
                $sum = 0;
                foreach ($rule['DBTax'] as $key => $val) {
                    $sum += $val;
                }
                $rule['DBTax'] = $sum;
            }
        }

        // calculate the new subTotal with discounts before tax, necessary for billTotal
        $this->_cart->cartPrices['toTax'] = $this->_cart->cartPrices['salesPrice'] + $cartdiscountBeforeTax;

        //Avalara wants to calculate the tax of the shipment. Only disadvantage to set shipping here is that the discounts per bill respectivly the tax per bill
        // is not considered. Todo create a generic system, for example a param for billing rules, excluding/including shipment/payment
        $shipmentCalculated = false;
        if (!empty($this->_cart->cartData['taxRulesBill'])) {
            foreach ($this->_cart->cartData['taxRulesBill'] as $taxRulesBill) {
                if (!empty($taxRulesBill['value_mathop']) and $taxRulesBill['value_mathop'] == 'avalara') {
                    $this->calculateShipmentPrice();
                    $shipmentCalculated = true;
                }
            }
        }

        // next step is handling a coupon, if given
        $this->_cart->cartData['gpVat'] = TRUE;
        $this->_cart->cartPrices['salesPriceCoupon'] = 0.0;
        $this->_cart->cartPrices['salesPriceCouponFormatted'] = 0.0;
        if (!empty($this->_cart->couponCode)) {
            $this->couponHandler($this->_cart->couponCode);
        }

        // now calculate the discount for whole cart and reduce subTotal for each taxRulesBill, to calculate correct tax, also if there are more than one tax rules
        $totalDiscountBeforeTax = $this->_cart->cartPrices['salesPriceCoupon'];
        foreach ($this->_cart->cartData['taxRulesBill'] as $k => &$rule) {

            if (!empty($rule['subTotal'])) {
                if (isset($this->_cart->cartData['VatTax'][$k]['DBTax'])) {
                    $rule['subTotal'] += $this->_cart->cartData['VatTax'][$k]['DBTax'];
                }
                if (!isset($rule['percentage']) && $rule['subTotal'] < $this->_cart->cartPrices['salesPrice']) {
                    $rule['percentage'] = $rule['subTotal'] / ($this->_cart->cartPrices['salesPrice'] + $cartdiscountBeforeTax);
                } else if (!isset($rule['percentage'])) {
                    $rule['percentage'] = 1;
                }
                $rule['subTotal'] += $totalDiscountBeforeTax * $rule['percentage'];
            } else {
                $rule['subTotal'] = $this->_cart->cartPrices['toTax'];
            }
        }

        // now each taxRule subTotal is reduced with DBTax and we can calculate the cartTax
        $this->_cart->cartPrices['cartTax'] = $this->roundInternal($this->cartRuleCalculation($this->_cart->cartData['taxRulesBill'], $this->_cart->cartPrices['toTax']));

        // toDisc is new subTotal after tax, now it comes discount afterTax and we can calculate the final cart price with tax.
        $toDisc = $this->_cart->cartPrices['toTax'] + $this->_cart->cartPrices['cartTax'];
        $cartdiscountAfterTax = $this->roundInternal($this->cartRuleCalculation($this->_cart->cartData['DATaxRulesBill'], $toDisc));
        $this->_cart->cartPrices['withTax'] = $toDisc + $cartdiscountAfterTax;

        // gpSetStartTime('methods');
        if (!$shipmentCalculated) {
            $this->calculateShipmentPrice();
        }
        $this->calculatePaymentPrice();
        // gpTime('Time consumed for shipment/payment plugins', 'methods');

        if ($this->_currencyDisplay->_priceConfig['salesPrice'])
            $this->_cart->cartPrices['billSub'] = $this->_cart->cartPrices['basePrice'] + $this->_cart->cartPrices['shipmentValue'] + $this->_cart->cartPrices['paymentValue'];
        if ($this->_currencyDisplay->_priceConfig['discountAmount'])
            $this->_cart->cartPrices['billDiscountAmount'] = $this->_cart->cartPrices['discountAmount'] + $cartdiscountBeforeTax + $cartdiscountAfterTax; // + $this->_cart->cartPrices['shipmentValue'] + $this->_cart->cartPrices['paymentValue'] ;
        if ($this->_cart->cartPrices['salesPriceShipment'] < 0)
            $this->_cart->cartPrices['billDiscountAmount'] += $this->_cart->cartPrices['salesPriceShipment'];
        if ($this->_cart->cartPrices['salesPricePayment'] < 0)
            $this->_cart->cartPrices['billDiscountAmount'] += $this->_cart->cartPrices['salesPricePayment'];
        if ($this->_currencyDisplay->_priceConfig['taxAmount'])
            $this->_cart->cartPrices['billTaxAmount'] = $this->_cart->cartPrices['taxAmount'] + $this->_cart->cartPrices['shipmentTax'] + $this->_cart->cartPrices['paymentTax'] + $this->_cart->cartPrices['cartTax'];

        //The coupon handling is only necessary if a salesPrice is displayed, otherwise we have a kind of catalogue mode
        if ($this->_currencyDisplay->_priceConfig['salesPrice']) {
            $this->_cart->cartPrices['billTotal'] = $this->_cart->cartPrices['salesPriceShipment'] + $this->_cart->cartPrices['salesPricePayment'] + $this->_cart->cartPrices['withTax'] + $this->_cart->cartPrices['salesPriceCoupon'];

            if (empty($this->_cart->cartPrices['billTotal']) or $this->_cart->cartPrices['billTotal'] < 0) {
                $this->_cart->cartPrices['billTotal'] = 0.0;
            }

            if ($this->_cart->cartData['gpVat'] and ( !empty($cartdiscountBeforeTax) and isset($this->_cart->cartData['VatTax']) and count($this->_cart->cartData['VatTax']) > 0) or ! empty($this->_cart->couponCode)) {

                $totalDiscountToTax = $this->_cart->cartPrices['salesPriceCoupon'];

                foreach ($this->_cart->cartData['VatTax'] as &$vattax) {

                    if (isset($vattax['subTotal']) && !isset($vattax['percentage'])) {
                        if (isset($vattax['DBTax'])) {
                            $vattax['subTotal'] += $vattax['DBTax'];
                        }
                        if ($vattax['subTotal'] < $this->_cart->cartPrices['salesPrice']) {
                            $vattax['percentage'] = $vattax['subTotal'] / ($this->_cart->cartPrices['salesPrice'] + $cartdiscountBeforeTax);
                        } else {
                            $vattax['percentage'] = 1;
                        }
                    }
                    if (isset($vattax['value']) && isset($vattax['percentage'])) {
                        if (!isset($vattax['DBTax']))
                            $vattax['DBTax'] = 0.0;
                        $vattax['discountTaxAmount'] = round(($totalDiscountToTax * $vattax['percentage'] + $vattax['DBTax']) / (100 + $vattax['value']) * $vattax['value'], $this->_currencyDisplay->_priceConfig['taxAmount'][1]);
                    }
                    if (isset($vattax['discountTaxAmount']))
                        $this->_cart->cartPrices['billTaxAmount'] += $vattax['discountTaxAmount'];
                }
            }

            if ($this->_cart->cartPrices['billTaxAmount'] < 0) {
                $this->_cart->cartPrices['billTaxAmount'] = 0.0;
            }
        }

        //Calculate VatTax result
        if ($this->_cart->cartPrices['shipment_calc_id']) {
            if (!is_array($this->_cart->cartPrices['shipment_calc_id']))
                $this->_cart->cartPrices['shipment_calc_id'] = array($this->_cart->cartPrices['shipment_calc_id']);
            foreach ($this->_cart->cartPrices['shipment_calc_id'] as $calcID) {
                if (isset($this->_cart->cartPrices['shipmentTaxPerID'][$calcID])) {
                    $this->_cart->cartData['VatTax'][$calcID]['shipmentTax'] = $this->_cart->cartPrices['shipmentTaxPerID'][$calcID];
                    if (!isset($this->_cart->cartData['VatTax'][$calcID]['id']))
                        $this->_cart->cartData['VatTax'][$calcID]['id'] = $calcID;
                }
            }
        }
        if ($this->_cart->cartPrices['payment_calc_id']) {
            if (!is_array($this->_cart->cartPrices['payment_calc_id']))
                $this->_cart->cartPrices['payment_calc_id'] = array($this->_cart->cartPrices['payment_calc_id']);
            foreach ($this->_cart->cartPrices['payment_calc_id'] as $calcID) {
                if (isset($this->_cart->cartPrices['paymentTaxPerID'][$calcID])) {
                    $this->_cart->cartData['VatTax'][$calcID]['paymentTax'] = $this->_cart->cartPrices['paymentTaxPerID'][$calcID];
                    if (!isset($this->_cart->cartData['VatTax'][$calcID]['id']))
                        $this->_cart->cartData['VatTax'][$calcID]['id'] = $calcID;
                }
            }
        }

        foreach ($this->_cart->cartData['VatTax'] as &$vattax) {
            $vattax['result'] = isset($vattax['taxAmount']) ? $vattax['taxAmount'] : 0;
            if (isset($vattax['discountTaxAmount']))
                $vattax['result'] += $vattax['discountTaxAmount'];
            if (isset($vattax['shipmentTax']))
                $vattax['result'] += $vattax['shipmentTax'];
            if (isset($vattax['paymentTax']))
                $vattax['result'] += $vattax['paymentTax'];
            if (!isset($vattax['id']))
                $vattax['id'] = $this->getCalcRuleData($vattax['id'])->id;
            if (!isset($vattax['title']))
                $vattax['title'] = $this->getCalcRuleData($vattax['id'])->title;
            if (!isset($vattax['value']))
                $vattax['value'] = $this->getCalcRuleData($vattax['id'])->value;
        }

        foreach ($this->_cart->cartData['taxRulesBill'] as &$rule) {
            $this->_cart->cartData['VatTax'][$rule['id']]['result'] = isset($this->_cart->cartData['VatTax'][$rule['id']]['result']) ? $this->_cart->cartData['VatTax'][$rule['id']]['result'] : 0;
            $this->_cart->cartData['VatTax'][$rule['id']]['result'] += $this->roundInternal($this->_cart->cartPrices[$rule['id'] . 'Diff']);
            if (!isset($this->_cart->cartData['VatTax'][$rule['id']]['id']))
                $this->_cart->cartData['VatTax'][$rule['id']]['id'] = $rule['id'];
            if (!isset($this->_cart->cartData['VatTax'][$rule['id']]['title']))
                $this->_cart->cartData['VatTax'][$rule['id']]['title'] = $rule['title'];
            if (!isset($this->_cart->cartData['VatTax'][$rule['id']]['value']))
                $this->_cart->cartData['VatTax'][$rule['id']]['value'] = $rule['value'];
        }
    }

    /**
     * Get the data of the CalcRule ID if it is not there
     * @author Binh Nguyen
     * @param $VatTaxID ID of the taxe rule
     */
    protected function getCalcRuleData($calcRuleID) {
        if (empty($this->_calcModel)) {
            $this->_calcModel = $this->getModel('Calculations');
        }
        $calcRule = $this->_calcModel->getCalc($calcRuleID);
        return $calcRule;
    }

    /**
     * Get coupon details and calculate the value
     * @author Binh Nguyen
     * @param $_code Coupon code
     */
    protected function couponHandler($_code) {
        /*
          JPluginHelper::importPlugin('gpcoupon');
          $dispatcher = JDispatcher::getInstance();
          $returnValues = $dispatcher->trigger('plgGpCouponHandler', array($_code, &$this->_cart->cartData, &$this->_cart->cartPrices));
          if (!empty($returnValues)) {
          foreach ($returnValues as $returnValue) {
          if ($returnValue !== null) {
          return $returnValue;
          }
          }
          }
         */

        if (!class_exists('CouponHelper')) {
            JLoader::register('CouponHelper', JPATH_SITE . '/components/com_standard/helpers/coupon.php');
        }
        if (!($_data = CouponHelper::getCouponDetails($_code))) {
            return; // TODO give some error here
        }

        $this->_cart->cartData['couponCode'] = $_code;

        //$sign = substr($_data->value_mathop, 0, 1);
        if (strlen($_data->value_mathop) == 2) : // (-%)
            $this->_cart->cartPrices['salesPriceCoupon'] = ($this->_cart->cartPrices['salesPrice'] * ($_data->value / 100)) * -1;
            $this->_cart->cartData['couponDescr'] = rtrim(rtrim($_data->value, '0'), '.') . ' %';
        else:
            $this->_cart->cartPrices['salesPriceCoupon'] = $this->_currencyDisplay->convertCurrencyTo($_data->currency_id, $_data->value) * -1;
            $this->_cart->cartData['couponDescr'] = $this->_currencyDisplay->getFormattedCurrency($this->_cart->cartPrices['salesPriceCoupon']);
        // $this->_cart->cartPrices['salesPriceCoupon'] = $this->_cart->cartPrices['salesPriceCoupon'] * -1;
        endif;

        $this->_cart->cartPrices['couponTax'] = 0;
        $this->_cart->cartPrices['couponValue'] = $this->_cart->cartPrices['salesPriceCoupon'] - $this->_cart->cartPrices['couponTax'];

        $this->_cart->cartPrices['salesPriceCouponFormatted'] = $this->_currencyDisplay->priceDisplay($this->_cart->cartPrices['salesPriceCoupon']);
        $this->_cart->cartPrices['couponValueFormatted'] = $this->_currencyDisplay->priceDisplay($this->_cart->cartPrices['couponValue']);
        $this->_cart->cartPrices['couponTaxFormatted'] = $this->_currencyDisplay->priceDisplay($this->_cart->cartPrices['couponTax']);
    }

    /**
     * Gatheres the rules which affects the product.
     *
     *
     * @copyright Copyright (c) 2018 Giaiphapcongnghethongtin.vn Team. All rights reserved.
     * @author Binh Nguyen
     * @param	$entrypoint The entrypoint how it should behave. Valid values should be
     * 						Profit (Commission is a profit rule that is shared, maybe we remove shared and make a new entrypoint called profit)
     * 						DBTax (Discount for wares, coupons)
     * 						Tax
     * 						DATax (Discount on money)
     * 						Duty
     * @return	$rules The rules that effects the product as Ids
     */
    function gatherEffectingRulesForProductPrice($entrypoint, $id) {
        $testedRules = array();
        if ($id === -1):
            return $testedRules;
        endif;

        $countries = '';
        $states = '';
        $shopperGroup = '';
        $entrypoint = (string) $entrypoint;

        if (empty($this->allrules[$this->productVendorId][$entrypoint])):
            return $testedRules;
        endif;

        foreach ($this->allrules[$this->productVendorId][$entrypoint] as $i => &$rule) :
            $rule = (array) $rule;
            if (!empty($id)) {
                if ($rule['id'] == $id) {
                    $testedRules[$rule['id']] = $rule;
                }
                continue;
            }
            /*
              if (!empty($rule['for_override'])) {
              continue;
              }
             */
            // --- categories ---
            if (!isset($rule['categories'])) :
                $sql = 'SELECT `catid` FROM #__standard_calc_categories_map WHERE `calculation_id`="' . $rule['id'] . '"';
                $this->_db->setQuery($sql);
                $rule['categories'] = $this->_db->loadColumn();
            endif;

            $hitsCategory = true;
            if (isset($this->_cats)) :
                $hitsCategory = $this->testRulePartEffecting($rule['categories'], $this->_cats);
            endif;
            // --- /.categories ---
            // --- manufacturers ---
            if (!isset($rule['manufacturers'])) {
                $sql = 'SELECT `manufacturer_id` FROM #__standard_calc_manufacturer_map WHERE `calculation_id`="' . $rule['id'] . '"';
                $this->_db->setQuery($sql);
                $rule['manufacturers'] = $this->_db->loadColumn();
            }

            $hitsManufacturer = true;
            if (isset($this->_manufacturerId)) {
//                echo '<pre>';
//                print_r($this->_manufacturerId);
//                exit;
                $hitsManufacturer = $this->testRulePartEffecting($rule['manufacturers'], $this->_manufacturerId);
            }
            // --- /.manufacturers ---
            // ---- -----
            if ($hitsCategory or $hitsManufacturer) :
                $testedRules[$rule['id']] = $rule;
            endif;
            // ---- /. -----
        endforeach;

        return $testedRules;
    }

    /**
     * @author Binh Nguyen
     * Can test the tablefields Category, Country, State
     *  If the the data is 0 false is returned
     */
    function testRulePartEffecting($rule, $data) {

        if (!isset($rule)):
            return true;
        endif;

        if (!isset($data)):
            return false;
        endif;

        if (is_array($rule)) :
            if (count($rule) == 0):
                return false; // true
            endif;
        else:
            $rule = array($rule);
        endif;

        if (!is_array($data)):
            $data = array($data);
        endif;

        $intersect = array_intersect($rule, $data);

        if ($intersect) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function to execute the calculation of the gathered rules Ids.
     *
     * @copyright Copyright (c) 2009 Giaiphapcongnghethongtin Team. All rights reserved.
     * @author Binh Nguyen
     * @param 		$rules 		The Ids of the products
     * @param 		$price 		The input price, if no rule is affecting, 0 gets returned
     * @return int 	$price  	the endprice
     */
    function executeCalculation($rules, $baseprice, $relateToBaseAmount = false, $setCartPrices = true) {

        if (empty($rules)):
            return 0;
        endif;

        $rulesEffSorted = $this->record_sort($rules, 'ordering', $this->_revert);

//        echo '<pre>';
//        print_r($rulesEffSorted);
//        exit;
        $price = $baseprice;
        $finalprice = $baseprice;
        if (isset($rulesEffSorted)) {

            foreach ($rulesEffSorted as $rule) {

                if (isset($rule['subTotal'])) {
                    $cIn = $rule['subTotal'];
                } else if ($relateToBaseAmount) {
                    $cIn = $baseprice;
                } else {
                    $cIn = $price;
                }

                $cOut = $this->interpreteMathOp($rule, $cIn);
                $tmp = $this->roundInternal($this->roundInternal($cOut) - $cIn);

                if ($setCartPrices) {
                    $this->_cart->cartPrices[$rule['id'] . 'Diff'] = $tmp;
                }
                //okey, this is a bit flawless logic, but should work
                if ($relateToBaseAmount) {
                    $finalprice = $finalprice + $tmp;
                } else {
                    $price = $cOut;
                }
            }
        }

        //okey done with it
        if (!$relateToBaseAmount) {
            $finalprice = $price;
        }

        return $finalprice;
    }

    /**
     * This functions interprets the String that is entered in the value_mathop field
     * The first char is the signum of the function. The more this function can be enhanced
     * maybe with function that works like operators, the easier it will be to make more complex disount/commission/profit formulas
     * progressive, nonprogressive and so on.
     *
     * @copyright Copyright (c) 2009 Giaiphapcongnghethongtin Team. All rights reserved.
     * @author Binh Nguyen
     * @param 	$mathop 	String reprasentation of the mathematical operation, valid ('+','-','+%','-%')
     * @param	$value 	float	The value that affects the price
     * @param 	$currency int	the currency which should be used
     * @param	$price 	float	The price to calculate
     */
    function interpreteMathOp($rule, $price) {

        $mathop = $rule['value_mathop'];
        $value = (float) $rule['value'];
        $currency = $rule['currency_id'];
        $coreMathOp = array('+', '-', '+%', '-%');

        if (!$this->_revert) {
            $plus = '+';
            $minus = '-';
        } else {
            $plus = '-';
            $minus = '+';
        }

        if (in_array($mathop, $coreMathOp)) {
            $sign = substr($mathop, 0, 1);

            $calculated = false;
            if (strlen($mathop) == 2) {
                $cmd = substr($mathop, 1, 2);
                if ($cmd == '%') {
                    if (!$this->_revert) {
                        $calculated = $price * $value / 100.0;
                    } else {
                        if (!empty($value)) {
                            if ($sign == $plus) {
                                $calculated = abs($price / (1 - (100.0 / $value)));
                            } else {
                                $calculated = abs($price / (1 + (100.0 / $value)));
                            }
                        } else {
                            //gpdebug('interpreteMathOp $value is empty ' . $rule['title']);
                        }
                    }
                }
            } else if (strlen($mathop) == 1) {
                $calculated = $this->_currencyDisplay->convertCurrencyTo($currency, $value);
            }

            if ($sign == $plus) {
                return $price + (float) $calculated;
            } else if ($sign == $minus) {
                return $price - (float) $calculated;
            } else {
                //GpError('Unrecognised mathop ' . $mathop . ' in calculation rule found');
                return $price;
            }
        } else {
            /*
              JPluginHelper::importPlugin('gpcalculation');
              $dispatcher = JDispatcher::getInstance();

              $calculated = $dispatcher->trigger('plgGpInterpreteMathOp', array($this, $rule, $price, $this->_revert));
              if ($calculated) {
              foreach ($calculated as $calc) {
              if ($calc)
              return $calc;
              }
              } else {
              //GpError('Unrecognised mathop ' . $mathop . ' in calculation rule found, seems you created this rule with plugin not longer accesible (deactivated, uninstalled?)');
              return $price;
              }
             */
        }
    }

    /*
     * * @author Binh Nguyen
     */

    function interpreteMathOpRevert($rule, $price, $revert = true) {
        $this->_revert = $revert;
        $priceRevert = $this->interpreteMathOp($rule, $price);
        $this->_revert = false;
        return $priceRevert;
    }

    /**
     * Standard round function, we round every number with 6 fractionnumbers
     * We need at least 4 to calculate something like 9.25% => 0.0925
     * 2 digits
     * Should be setable via config (just for the crazy case)
     */
    function roundInternal($value, $name = 0) {
        /*
        if (!$this->_roundindig and $name !== 0) {
            if (isset($this->_currencyDisplay->_priceConfig[$name][1])) {
                return round($value, $this->_currencyDisplay->_priceConfig[$name][1]);
            } else {
                return round($value, $this->_internalDigits);
            }
        } else {
            return round($value, $this->_internalDigits);
        }
        */
        return $value;
    }

    /** Sorts indexed 2D array by a specified sub array key
     *
     * Copyright richard at happymango dot me dot uk
     * @author Binh Nguyen
     */
    function record_sort($records, $field, $reverse = false) {
        if (is_array($records)) {
            $hash = array();

            foreach ($records as $record) {
                if (isset($record[$field])) {
                    $keyToUse = $record[$field];
                    while (array_key_exists($keyToUse, $hash)) {
                        $keyToUse = $keyToUse + 1;
                    }
                    $hash[$keyToUse] = $record;
                }
            }
            ($reverse) ? krsort($hash) : ksort($hash);
            $records = array();
            foreach ($hash as $record) {
                $records [] = $record;
            }
        }
        return $records;
    }

    /**
     * Gathers the effecting rules for the calculation of the bill
     *
     * @copyright Copyright (c) 2009-2014 giaiphapcongnghethongtin.vn Team. All rights reserved.
     * @author Binh Nguyen
     * @param	$entrypoint
     * @param	$cartVendorId
     * @return $rules The rules that effects the Bill as Ids
     */
    function gatherEffectingRulesForBill($entrypoint, $cartVendorId = 1) {

        static $testedRulesCached = array();
        $testedRules = array();
        if (isset($testedRulesCached[$cartVendorId][$entrypoint])) {
            return $testedRulesCached[$cartVendorId][$entrypoint];
        }
        if (empty($this->_calcModel)) {
            $this->_calcModel = $this->getModel('Calculations');
        }

        //Test if calculation affects the current entry point
        //shared rules counting for every vendor seems to be not necessary
        // === code here ===
        // --- ---
        $testedRulesCached[$cartVendorId][$entrypoint] = $testedRules;
        return $testedRules;
    }

    /**
     * Function to calculate discount/tax of cart rules.
     *
     * @copyright Copyright (c) 2009 giaiphapcongnghethongtin.vn Team. All rights reserved.
     * @author Binh Nguyen
     *
     * @return int 	$price  	the discount/tax
     */
    function cartRuleCalculation($rules, $baseprice, $TaxID = 0, $DBTax = false) {

        if (empty($rules))
            return 0;

        $rulesEffSorted = $this->record_sort($rules, 'ordering', $this->_revert);

        if (isset($rulesEffSorted)) {

            $discount = 0;

            foreach ($rulesEffSorted as &$rule) {
                if (isset($rule['subTotal'])) {
                    $cIn = $rule['subTotal'];
                } else {
                    $cIn = $baseprice;
                }

                $cOut = $this->interpreteMathOp($rule, $cIn);
                //gpdebug('my cout ',$cIn,$cOut,$TaxID,$rule);
                $this->_cart->cartPrices[$rule['id'] . 'Diff'] = $this->roundInternal($this->roundInternal($cOut) - $cIn);
                //$discount += round($this->_cart->cartPrices[$rule['id'] . 'Diff'],$this->_currencyDisplay->_priceConfig['salesPrice'][1]);
                $discount += $this->roundInternal($this->_cart->cartPrices[$rule['id'] . 'Diff']);
                //gpdebug('my cout ',$cOut,$discount,$rule['subTotal'],$TaxID);
                if (isset($rule['subTotal']) and $TaxID != 0 and $DBTax == true) {
                    if (isset($rule['subTotalPerTaxID'][$TaxID])) {
                        $cIn = $rule['subTotalPerTaxID'][$TaxID];
                        $cOut = $this->interpreteMathOp($rule, $cIn);
                        $this->_cart->cartData['VatTax'][$TaxID]['DBTax'][$rule['id'] . 'DBTax'] = round($this->roundInternal($this->roundInternal($cOut) - $cIn), $this->_currencyDisplay->_priceConfig['salesPrice'][1]);
                        if (!isset($this->_cart->cartData['VatTax'][$TaxID]['id']))
                            $this->_cart->cartData['VatTax'][$TaxID]['id'] = $TaxID;
                    }
                } else {
                    //gpdebug('cartRuleCalculation is missing a condition and is not calculated ',$rule,$TaxID);
                }
            }
        }

        return $discount;
    }

    /**
     * Calculates the effecting Shipment prices for the calculation
     * @copyright (c) 2009 giaiphapcongnghethongtin.vn Team. All rights reserved.
     * @author Binh Nguyen
     * @param 	$code 	The Id of the coupon
     * @return 	$rules 	ids of the coupons
     */
    function calculateShipmentPrice() {
        $this->_cart->cartData['shipmentName'] = JText::_('COM_STANDARD_CART_NO_SHIPMENT_SELECTED');
        $this->_cart->cartPrices['shipmentName'] = "";
        $this->_cart->cartPrices['shipmentValue'] = 0; //could be automatically set to a default set in the globalconfig
        $this->_cart->cartPrices['shipmentTax'] = 0;
        $this->_cart->cartPrices['salesPriceShipment'] = 0;
        $this->_cart->cartPrices['shipment_calc_id'] = 0;

        $this->_cart->cartPrices['shipmentValueFormatted'] = 0; //could be automatically set to a default set in the globalconfig
        $this->_cart->cartPrices['shipmentTaxFormatted'] = 0;
        $this->_cart->cartPrices['salesPriceShipmentFormatted'] = 0;
        /*
         * --- No Using temp off ----
          // Handling shipment plugins
          JPluginHelper::importPlugin('gpshipment');
          $this->_cart->checkAutomaticSelectedPlug('shipment');
          if (empty($this->_cart->shipmentmethod_id)):
          return;
          endif;

          $dispatcher = JDispatcher::getInstance();
          $returnValues = $dispatcher->trigger('plgOnSelectedCalculatePriceShipment', array($this->_cart, &$this->_cart->cartPrices, &$this->_cart->cartData['shipmentName']));
          //Plugin return true if shipment rate is still valid false if not any more
          $shipmentValid = 0;
          foreach ($returnValues as $returnValue) {
          $shipmentValid += $returnValue;
          }
          if (!$shipmentValid) {
          // gpdebug('calculateShipmentPrice $shipment INVALID set cart->shipmentmethod_id = 0 ', $this->_cart->shipmentmethod_id);
          $this->_cart->shipmentmethod_id = 0;
          $this->_cart->setCartIntoSession(false, true);
          }
         * --- /.No Using temp off ----
         */

        if (!class_exists('ShipmentmethodHelper')) {
            JLoader::register('ShipmentmethodHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/shipmentmethod.php');
        }
        $this->_shipmentmethod = ShipmentmethodHelper::getInstance();
        $oMethod = $this->_shipmentmethod->getShipmentmethod($this->_cart->shipmentmethod_id);
        $this->_shipmentmethod->setCartPrices($this->_cart, $this->_cart->cartPrices, $oMethod);

        return $this->_cart->cartPrices;
    }

    /**
     * Calculates the effecting Payment prices for the calculation
     * @copyright Copyright (c) 2009 giaiphapcongnghethongtin.vn Team. All rights reserved.
     * @author Binh Nguyen
     * @param 	$code 	The Id of the paymentmethod
     * @param	$value	amount of the money to transfere
     * @param	$value	$cartVendorId
     * @return 	$paymentCosts 	The amount of money the customer has to pay. Calculated in shop currency
     */
    function calculatePaymentPrice() {

        $this->_cart->cartData['paymentName'] = JText::_('COM_STANDARD_CART_NO_PAYMENT_SELECTED');
        $this->_cart->cartPrices['paymentValue'] = 0; //could be automatically set to a default set in the globalconfig
        $this->_cart->cartPrices['paymentTax'] = 0;
        $this->_cart->cartPrices['paymentTotal'] = 0;
        $this->_cart->cartPrices['salesPricePayment'] = 0;
        $this->_cart->cartPrices['payment_calc_id'] = 0;
        /*
          // JPluginHelper::importPlugin('gppayment');

          $this->_cart->checkAutomaticSelectedPlug('payment');
          if (empty($this->_cart->paymentmethod_id))
          return;

          $dispatcher = JDispatcher::getInstance();
          $returnValues = $dispatcher->trigger('plgGponSelectedCalculatePricePayment', array($this->_cart, &$this->_cart->cartPrices, &$this->_cart->cartData['paymentName']));

          // Plugin return true if payment plugin is  valid false if not  valid anymore only one value is returned
          $paymentValid = 0;
          foreach ($returnValues as $returnValue) {
          $paymentValid += $returnValue;
          }
          if (!$paymentValid) {
          $this->_cart->paymentmethod_id = 0;
          $this->_cart->setCartIntoSession();
          }
         */
        return $this->_cart->cartPrices;
    }

}
