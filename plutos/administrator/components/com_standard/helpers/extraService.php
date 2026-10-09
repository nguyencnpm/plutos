<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class extraServiceHelper {

    static $_instance;
    protected $_toConvert = false;
    protected $_psType = "extra";
    public $services = null;

    private function __construct() {
        $this->_psType = 'extra';
    }

    public static function getInstance() {
        if (!is_object(self::$_instance)) {
            self::$_instance = new extraServiceHelper();
        } else {
            //We store in UTC and use here of course also UTC
            $jnow = JFactory::getDate();
            self::$_instance->_now = $jnow->toSQL();
        }

        return self::$_instance;
    }

    /**
     * Proxy for getModel.
     */
    private function getModel($name = 'Extra', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_standard/models', 'StandardModel');
        $getModel = JModelLegacy::getInstance($name, $prefix, $config);
        return $getModel;
    }

    public function getExtraService($extraService_id) {
        $extraServiceModel = self::getModel('Extra');
        // case get list
        // $extraServiceModel->setState('filter.published', 1);
        // Retrieve Content
        return $extraServiceModel->getItem($extraService_id);
    }

    public function setCartPrices($cart, $cart_prices, $service, $quantity) {
        if (!class_exists('CalculationHelper')) {
            JLoader::register('CalculationHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/calculation.php');
        }
        $calculator = CalculationHelper::getInstance();
        $_psType = ucfirst($this->_psType);
        // $cart_prices[$this->_psType . 'Value'] = $calculator->roundInternal($this->getCosts($cart, $service, $cart_prices), 'salesPrice');
        $cart_prices['extra_quantity'] = $quantity;
        $cart_prices[$this->_psType . 'Name'] = $service->title;
        $cart_prices[$this->_psType . 'Value'] = $calculator->_currencyDisplay->convertCurrencyTo($service->currency_id, $service->price);
        $cart_prices[$this->_psType . 'ValueFormatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices[$this->_psType . 'Value']);

        $cart_prices[$this->_psType . 'ValueQuantity'] = $calculator->_currencyDisplay->convertCurrencyTo($service->currency_id, $service->price * $quantity);
        $cart_prices[$this->_psType . 'ValueQuantityFormatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices[$this->_psType . 'ValueQuantity']);

        if (!isset($cart_prices[$this->_psType . 'Value'])):
            $cart_prices[$this->_psType . 'Value'] = 0.0;
            $cart_prices[$this->_psType . 'ValueFormatted'] = 0.0;
        endif;

        if (!isset($cart_prices[$this->_psType . 'ValueQuantity'])):
            $cart_prices[$this->_psType . 'ValueQuantity'] = 0.0;
            $cart_prices[$this->_psType . 'ValueQuantityFormatted'] = 0.0;
        endif;

        if (!isset($cart_prices[$this->_psType . 'Tax'])):
            $cart_prices[$this->_psType . 'Tax'] = 0.0;
            $cart_prices[$this->_psType . 'TaxFormatted'] = 0.0;
        endif;

        if (!isset($cart_prices[$this->_psType . 'TaxQuantity'])):
            $cart_prices[$this->_psType . 'TaxQuantity'] = 0.0;
            $cart_prices[$this->_psType . 'TaxQuantityFormatted'] = 0.0;
        endif;
        // --- ---
        if (!isset($cart_prices['salesPrice' . $_psType])):
            $cart_prices['salesPrice' . $_psType] = $cart_prices[$this->_psType . 'Value'];
            $cart_prices['salesPrice' . $_psType . 'Formatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices['salesPrice' . $_psType]);
        endif;

        if (!isset($cart_prices['salesPriceQuantity' . $_psType])):
            $cart_prices['salesPriceQuantity' . $_psType] = $cart_prices[$this->_psType . 'ValueQuantity'];
            $cart_prices['salesPriceQuantity' . $_psType . 'Formatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices['salesPriceQuantity' . $_psType]);
        endif;

        $taxrules = array();
        if (isset($service->tax_id) and (int) $service->tax_id === -1) :

        elseif (!empty($service->tax_id)) :
            $cart_prices[$this->_psType . '_calc_id'] = $service->tax_id;
            $calculationsModel = self::getModel('Calculations');
            // set Status
            $calculationsModel->setState('filter.published', 1);
            $calculationsModel->setState('filter.tax_id', $service->tax_id);

            // Retrieve Content
            $taxrules = $calculationsModel->getItems();

            /*
              $db = JFactory::getDBO();
              $q = 'SELECT * FROM #__standard_calcs WHERE `standard_calc_id`="' . $service->tax_id . '" ';
              $db->setQuery($q);
              $taxrules = $db->loadAssocList();
             */

            if (!empty($taxrules)) :
                $tempSubTotal = $cart_prices[$this->_psType . 'Value'];
                $tempSubTotalQuantity = $cart_prices[$this->_psType . 'ValueQuantity'];
                foreach ($taxrules as &$rule) :
                    $rule = (array) $rule;
                    if (!isset($rule['subTotal'])):
                        $rule['subTotal'] = 0;
                    endif;
                    if (!isset($rule['subTotalQuantity'])):
                        $rule['subTotalQuantity'] = 0;
                    endif;

                    if (!isset($rule['taxAmount'])):
                        $rule['taxAmount'] = 0;
                    endif;
                    if (!isset($rule['taxAmountQuantity'])):
                        $rule['taxAmountQuantity'] = 0;
                    endif;

                    $rule['subTotalOld'] = $rule['subTotal'];
                    $rule['taxAmountOld'] = $rule['taxAmount'];
                    $rule['taxAmount'] = 0;

                    $rule['subTotalOldQuantity'] = $rule['subTotalQuantity'];
                    $rule['taxAmountOldQuantity'] = $rule['taxAmountQuantity'];
                    $rule['taxAmountQuantity'] = 0;
                    // --- set reset is Price Has Vat Tax ---
                    $params = JComponentHelper::getParams('com_standard');
                    if (!empty($params->get('isPriceHasVatTax'))):// only true in case of a tax --- co thoi gian nghien cuu them --- 
                        $afterTax = $calculator->roundInternal($calculator->interpreteMathOpRevert($rule, $tempSubTotal), 'salesPrice');
                        if (!empty($afterTax)) :
                            $cart_prices[$this->_psType . 'Value'] = $afterTax;
                            $cart_prices[$this->_psType . 'ValueFormatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices[$this->_psType . 'Value']);
                        endif;

                        $afterTaxQuantity = $calculator->roundInternal($calculator->interpreteMathOpRevert($rule, $tempSubTotalQuantity), 'salesPrice');
                        if (!empty($afterTaxQuantity)) :
                            $cart_prices[$this->_psType . 'ValueQuantity'] = $afterTaxQuantity;
                            $cart_prices[$this->_psType . 'ValueQuantityFormatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices[$this->_psType . 'ValueQuantity']);
                        endif;

                    endif;
                    // --- /.set reset is Price Has Vat Tax ---
                    $rule['subTotal'] = $cart_prices[$this->_psType . 'Value'];
                    $rule['subTotalQuantity'] = $cart_prices[$this->_psType . 'ValueQuantity'];

                    $rule['psType'] = $this->_psType;

                    $cart_prices[$this->_psType . 'TaxPerID'][$rule['id']] = $calculator->roundInternal($calculator->roundInternal($calculator->interpreteMathOp($rule, $rule['subTotal'])) - $rule['subTotal'], 'salesPrice');
                    $cart_prices[$this->_psType . 'TaxPerIDQuantity'][$rule['id']] = $calculator->roundInternal($calculator->roundInternal($calculator->interpreteMathOp($rule, $rule['subTotalQuantity'])) - $rule['subTotalQuantity'], 'salesPrice');

                    $cart_prices[$this->_psType . 'Tax'] += $cart_prices[$this->_psType . 'TaxPerID'][$rule['id']];
                    $cart_prices[$this->_psType . 'TaxQuantity'] += $cart_prices[$this->_psType . 'TaxPerIDQuantity'][$rule['id']];

                    $cart_prices[$this->_psType . 'TaxPerIDFormatted'][$rule['id']] = $calculator->_currencyDisplay->priceDisplay($cart_prices[$this->_psType . 'TaxPerID'][$rule['id']]);
                    $cart_prices[$this->_psType . 'TaxPerIDQuantityFormatted'][$rule['id']] = $calculator->_currencyDisplay->priceDisplay($cart_prices[$this->_psType . 'TaxPerIDQuantity'][$rule['id']]);

                endforeach;
                $cart_prices[$this->_psType . 'TaxFormatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices[$this->_psType . 'Tax']);
                $cart_prices[$this->_psType . 'TaxQuantityFormatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices[$this->_psType . 'TaxQuantity']);
            endif;
        else :
        /*
          if (!isset($cart->cartData['taxRulesBill'])) {
          $cart->cartData['taxRulesBill'] = array();
          }
          if (!isset($cart->cartData['DBTaxRulesBill'])) {
          $cart->cartData['DBTaxRulesBill'] = array();
          }
          // end code addition
          $taxrules = array_merge($cart->cartData['VatTax'], $cart->cartData['taxRulesBill']);
          $cartdiscountBeforeTax = $calculator->roundInternal($calculator->cartRuleCalculation($cart->cartData['DBTaxRulesBill'], $cart->cartPrices['salesPrice']));

          if (!empty($taxrules)) {

          foreach ($taxrules as &$rule) {
          //Quickn dirty
          if (!isset($rule['kind']))
          $rule = (array) GpModel::getModel('calc')->getCalc($rule['id']);

          if (!isset($rule['subTotal']))
          $rule['subTotal'] = 0;
          if (!isset($rule['taxAmount']))
          $rule['taxAmount'] = 0;
          if (!isset($rule['DBTax']))
          $rule['DBTax'] = 0;
          if (!isset($rule['percentage']) && $rule['subTotal'] < $cart->cartPrices['salesPrice']) {
          $rule['percentage'] = ($rule['subTotal'] + $rule['DBTax']) / ($cart->cartPrices['salesPrice'] + $cartdiscountBeforeTax);
          } else if (!isset($rule['percentage'])) {
          $rule['percentage'] = 1;
          }
          $rule['subTotalOld'] = $rule['subTotal'];
          $rule['subTotal'] = 0;
          $rule['taxAmountOld'] = $rule['taxAmount'];
          $rule['taxAmount'] = 0;
          }

          foreach ($taxrules as &$rule) {
          $rule['subTotal'] = $cart_prices[$this->_psType . 'Value'] * $rule['percentage'];
          $rule['psType'] = $this->_psType;

          if (!isset($cart_prices[$this->_psType . 'Tax']))
          $cart_prices[$this->_psType . 'Tax'] = 0.0;
          $cart_prices[$this->_psType . 'TaxPerID'][$rule['id']] = $calculator->roundInternal($calculator->roundInternal($calculator->interpreteMathOp($rule, $rule['subTotal'])) - $rule['subTotal'], 'salesPrice');
          $cart_prices[$this->_psType . 'Tax'] += $cart_prices[$this->_psType . 'TaxPerID'][$rule['id']];
          }
          }
         */
        endif;

        if (empty($service->cost_per_transaction))
            $service->cost_per_transaction = 0.0;
        if (empty($service->cost_min_transaction))
            $service->cost_min_transaction = 0.0;
        if (empty($service->cost_percent_total))
            $service->cost_percent_total = 0.0;

        if (count($taxrules) > 0):
            $cart_prices['salesPrice' . $_psType] = $calculator->roundInternal($calculator->executeCalculation($taxrules, $cart_prices[$this->_psType . 'Value'], true, false), 'salesPrice');
            $cart_prices['salesPrice' . $_psType . 'Formatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices['salesPrice' . $_psType]);

            $cart_prices['salesPriceQuantity' . $_psType] = $calculator->roundInternal($calculator->executeCalculation($taxrules, $cart_prices[$this->_psType . 'ValueQuantity'], true, false), 'salesPriceQuantity');
            $cart_prices['salesPriceQuantity' . $_psType . 'Formatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices['salesPriceQuantity' . $_psType]);
            reset($taxrules);

            foreach ($taxrules as &$rule) :
                if (!isset($cart_prices[$this->_psType . '_calc_id']) or ! is_array($cart_prices[$this->_psType . '_calc_id']))
                    $cart_prices[$this->_psType . '_calc_id'] = array();
                $cart_prices[$this->_psType . '_calc_id'][] = $rule['id'];

                if (isset($rule['subTotalOld'])){
                    $rule['subTotal'] += $rule['subTotalOld'];
                }
                if (isset($rule['taxAmountOld'])){
                    $rule['taxAmount'] += $rule['taxAmountOld'];
                }
                if (isset($rule['psType'])){
                    unset($rule['psType']);
                }
                
                if (isset($rule['subTotalOldQuantity'])){
                    $rule['subTotalQuantity'] += $rule['subTotalOldQuantity'];
                }
                if (isset($rule['taxAmountOldQuantity'])){
                    $rule['taxAmountQuantity'] += $rule['taxAmountOldQuantity'];
                }
                
            endforeach;
        else :
            $cart_prices['salesPrice' . $_psType] = $cart_prices[$this->_psType . 'Value'];
            $cart_prices['salesPriceQuantity' . $_psType] = $cart_prices[$this->_psType . 'ValueQuantity'];
            $cart_prices[$this->_psType . 'Tax'] = 0;
            $cart_prices[$this->_psType . 'TaxQuantity'] = 0;
            $cart_prices[$this->_psType . '_calc_id'] = 0;

            $cart_prices['salesPrice' . $_psType . 'Formatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices['salesPrice' . $_psType]);
            $cart_prices['salesPriceQuantity' . $_psType . 'Formatted'] = $calculator->_currencyDisplay->priceDisplay($cart_prices['salesPriceQuantity' . $_psType]);
            $cart_prices[$this->_psType . 'TaxFormatted'] = 0;
        endif;

        return $cart_prices;
    }

    function getCosts($cart, $service, $cart_prices) {
        //$sign = substr($service->value_mathop, 0, 1);
        /*
         * 
          if (!isset($service->cost_percent_total))
          $service->cost_percent_total = 0.0;
          if (preg_match('/%$/', $service->cost_percent_total)) {
          $service->cost_percent_total = substr($service->cost_percent_total, 0, -1);
          } else {
          if (empty($service->cost_percent_total)) {
          $service->cost_percent_total = 0;
          }
          }
          $cartPrice = !empty($cart->cartPrices['withTax']) ? $cart->cartPrices['withTax'] : $cart->cartPrices['salesPrice'];

          if (empty($service->cost_per_transaction))
          $service->cost_per_transaction = 0.0;
          if (empty($service->cost_percent_total))
          $service->cost_percent_total = 0.0;

          $costs = $service->cost_per_transaction + $cartPrice * $service->cost_percent_total * 0.01;
          if (!empty($service->cost_min_transaction) and $service->cost_min_transaction != '' and $costs < $service->cost_min_transaction) {
          return $service->cost_min_transaction;
          } else {
          return $costs;
          }
         * 
         */
    }

}
