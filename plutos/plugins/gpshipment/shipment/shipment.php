<?php

/**
 * @package     Giaiphapcongnghethongtin.vn.Plugin
 * @subpackage  Gpshipment.Shipment
 * @author      Binh Nguyen
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// use Joomla\Registry\Registry;

/**
 * Shipment Plugin
 *
 * @since  3.2
 */
class PlgGpshipmentShipment extends JPlugin {

    protected $db;

    // ====== /.Calculate Price Shipment ==== 
    /**
     * @param Cart $cart
     * @param array          $cart_prices
     * @param                $cart_prices_name
     * @return bool|null
     */
    public function plgOnSelectedCalculatePriceShipment(Cart $cart, array &$cart_prices, &$cart_prices_name) {

        return $this->onSelectedCalculatePrice($cart, $cart_prices, $cart_prices_name);
    }

    /*
     * onSelectedCalculatePrice
     * Calculate the price (value, tax_id) of the selected method
     * It is called by the calculator
     * This function does NOT to be reimplemented. If not reimplemented, then the default values from this function are taken.
     * @author Binh Nguyen
     * @cart: Cart the current cart
     * @cart_prices: array the new cart prices
     * @return null if the method was not selected, false if the shipping rate is not valid any more, true otherwise
     *
     */

    public function onSelectedCalculatePrice(Cart $cart, array &$cart_prices, &$cart_prices_name) {

        $idName = $this->_idName;

        if (!($method = $this->selectedThisByMethodId($cart->$idName))) {
            return NULL; // Another method was selected, do nothing
        }

        if (!$method = $this->getGpPluginMethod($cart->$idName) or empty($method->$idName)) {
            return NULL;
        }

        $cart_prices_name = '';
        $cart_prices['cost'] = 0;

        if (!$this->checkConditions($cart, $method, $cart_prices)) {
            return FALSE;
        }


        $cart_prices_name = $this->renderPluginName($method);

        $this->setCartPrices($cart, $cart_prices, $method);

        return TRUE;
    }

    /**
     * Checks if this plugin should be active by the trigger
     *
     * We should avoid this function, is expensive
     *
     * @author Binh Nguyen
     *
     * @param int/array $id the registered plugin id(s) of the joomla table
     */
    function selectedThisByMethodId($id = 'type') {

        //if($psType!=$this->_psType) return false;

        if ($id === 'type') {
            return TRUE;
        } else {
            $db = JFactory::getDBO();

            $q = 'SELECT gp.* FROM `' . $this->_configTable . '` AS gp,
						#__extensions AS j WHERE gp.`' . $this->_idName . '` = "' . $id . '"
						AND gp.' . $this->_psType . '_jplugin_id = j.extension_id ';
            if (JFactory::getApplication()->isSite()) {
                $q .= 'AND gp.published = 1 ';
            }
            $q .= 'AND j.element = "' . $this->_name . '"';
            /*
              echo '<pre>';
              echo nl2br(str_replace('#__', 'i84yr_', $q));
              echo '</pre>';
              exit;
             */
            $db->setQuery($q);
            if (!$res = $db->loadObject()) {
                // 				gpError('selectedThisByMethodId '.$db->getQuery());
                return FALSE;
            } else {
                return $res;
            }
        }
    }

    /**
     * @param $int
     * @return mixed
     */
    protected function getPluginMethod($int, $cache = true) {

        if ($this->_gppCtable === 0 || !$cache) {
            $db = JFactory::getDBO();

            if (!class_exists($this->_configTableClassName)) {
                require(VMPATH_ADMIN . '/tables/' . $this->_configTableFileName . '.php');
            }
            $this->_gppCtable = new $this->_configTableClassName($db);
            if ($this->_xParams !== 0) {
                $this->_gppCtable->setParameterable($this->_configTableFieldName, $this->_varsToPushParam);
            }

            if ($this->_cryptedFields) {
                $this->_gppCtable->setCryptedFields($this->_cryptedFields);
            }
        }
        /*
          echo '<pre>';
          print_r($this->_gppCtable);
          echo '</pre>';
          exit;
         */
        return $this->_gppCtable->load($int);
    }

    protected function renderPluginName($plugin) {

        static $c = array();
        $idN = 'standard_' . $this->_psType . 'method_id';

        if (isset($c[$this->_psType][$plugin->$idN])) {
            return $c[$this->_psType][$plugin->$idN];
        }

        $return = '';
        $plugin_name = $this->_psType . '_name';
        $plugin_desc = $this->_psType . '_desc';
        $description = '';
        $logosFieldName = $this->_psType . '_logos';
        $logos = property_exists($plugin, $logosFieldName) ? $plugin->$logosFieldName : array();
        if (!empty($logos)) {
            $return = $this->displayLogos($logos) . ' ';
        }
        if (!empty($plugin->$plugin_desc)) {
            $description = '<span class="' . $this->_type . '_description">' . $plugin->$plugin_desc . '</span>';
        }
        $c[$this->_psType][$plugin->$idN] = $return . '<span class="' . $this->_type . '_name">' . $plugin->$plugin_name . '</span>' . $description;

        return $c[$this->_psType][$plugin->$idN];
    }

    /**
     * @param Cart $cart
     * @param $cart_prices
     * @param $method
     * @param bool $progressive
     * @return mixed
     */
    function setCartPrices(Cart $cart, &$cart_prices, $method, $progressive = true) {

        $calculator = calculationHelper::getInstance();

        echo $_psType = ucfirst($this->_psType);
        exit('dd: ' . $_psType);

        if ($this->_toConvert) {
            $this->convertToVendorCurrency($method);
        }
        $cart_prices[$this->_psType . 'Value'] = $calculator->roundInternal($this->getCosts($cart, $method, $cart_prices), 'salesPrice');
        if (!isset($cart_prices[$this->_psType . 'Value']))
            $cart_prices[$this->_psType . 'Value'] = 0.0;
        if (!isset($cart_prices[$this->_psType . 'Tax']))
            $cart_prices[$this->_psType . 'Tax'] = 0.0;

        if ($this->_psType == 'payment') {
            $cartTotalAmountOrig = $this->getCartAmount($cart_prices);

            if (!isset($method->cost_percent_total))
                $method->cost_percent_total = 0.0;
            if (!isset($method->cost_per_transaction))
                $method->cost_per_transaction = 0.0;

            if (!$progressive) {
                //Simple
                $cartTotalAmount = ($cartTotalAmountOrig + $method->cost_per_transaction) * (1 + ($method->cost_percent_total * 0.01));
                //gpdebug('Simple $cartTotalAmount = ('.$cartTotalAmountOrig.' + '.$method->cost_per_transaction.') * (1 + ('.$method->cost_percent_total.' * 0.01)) = '.$cartTotalAmount );
                //gpdebug('Simple $cartTotalAmount = '.($cartTotalAmountOrig + $method->cost_per_transaction).' * '. (1 + $method->cost_percent_total * 0.01) .' = '.$cartTotalAmount );
            } else {
                //progressive
                $cartTotalAmount = ($cartTotalAmountOrig + $method->cost_per_transaction) / (1 - ($method->cost_percent_total * 0.01));
                //gpdebug('Progressive $cartTotalAmount = ('.$cartTotalAmountOrig.' + '.$method->cost_per_transaction.') / (1 - ('.$method->cost_percent_total.' * 0.01)) = '.$cartTotalAmount );
                //gpdebug('Progressive $cartTotalAmount = '.($cartTotalAmountOrig + $method->cost_per_transaction) .' / '. (1 - $method->cost_percent_total * 0.01) .' = '.$cartTotalAmount );
            }

            $cart_prices[$this->_psType . 'Value'] = $cartTotalAmount - $cartTotalAmountOrig;
            if (!empty($method->cost_min_transaction) and $method->cost_min_transaction != '' and $cart_prices[$this->_psType . 'Value'] < $method->cost_min_transaction) {
                $cart_prices[$this->_psType . 'Value'] = $method->cost_min_transaction;
            }
        }

        if (!isset($cart_prices['salesPrice' . $_psType]))
            $cart_prices['salesPrice' . $_psType] = $cart_prices[$this->_psType . 'Value'];

        $taxrules = array();
        if (isset($method->tax_id) and (int) $method->tax_id === -1) {
            
        } else if (!empty($method->tax_id)) {
            $cart_prices[$this->_psType . '_calc_id'] = $method->tax_id;

            $db = JFactory::getDBO();
            $q = 'SELECT * FROM #__standard_calcs WHERE `standard_calc_id`="' . $method->tax_id . '" ';
            $db->setQuery($q);
            $taxrules = $db->loadAssocList();

            if (!empty($taxrules)) {
                foreach ($taxrules as &$rule) {
                    if (!isset($rule['subTotal']))
                        $rule['subTotal'] = 0;
                    if (!isset($rule['taxAmount']))
                        $rule['taxAmount'] = 0;
                    $rule['subTotalOld'] = $rule['subTotal'];
                    $rule['taxAmountOld'] = $rule['taxAmount'];
                    $rule['taxAmount'] = 0;
                    $rule['subTotal'] = $cart_prices[$this->_psType . 'Value'];
                    $rule['psType'] = $this->_psType;
                    $cart_prices[$this->_psType . 'TaxPerID'][$rule['standard_calc_id']] = $calculator->roundInternal($calculator->roundInternal($calculator->interpreteMathOp($rule, $rule['subTotal'])) - $rule['subTotal'], 'salesPrice');
                    $cart_prices[$this->_psType . 'Tax'] += $cart_prices[$this->_psType . 'TaxPerID'][$rule['standard_calc_id']];
                }
            }
        } else {

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
                    if (!isset($rule['calc_kind']))
                        $rule = (array) GpModel::getModel('calc')->getCalc($rule['standard_calc_id']);

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
                    $cart_prices[$this->_psType . 'TaxPerID'][$rule['standard_calc_id']] = $calculator->roundInternal($calculator->roundInternal($calculator->interpreteMathOp($rule, $rule['subTotal'])) - $rule['subTotal'], 'salesPrice');
                    $cart_prices[$this->_psType . 'Tax'] += $cart_prices[$this->_psType . 'TaxPerID'][$rule['standard_calc_id']];
                }
            }
        }

        if (empty($method->cost_per_transaction))
            $method->cost_per_transaction = 0.0;
        if (empty($method->cost_min_transaction))
            $method->cost_min_transaction = 0.0;
        if (empty($method->cost_percent_total))
            $method->cost_percent_total = 0.0;

        if (count($taxrules) > 0) {

            $cart_prices['salesPrice' . $_psType] = $calculator->roundInternal($calculator->executeCalculation($taxrules, $cart_prices[$this->_psType . 'Value'], true, false), 'salesPrice');
//			$cart_prices[$this->_psType . 'Tax'] = $calculator->roundInternal (($cart_prices['salesPrice' . $_psType] -  $cart_prices[$this->_psType . 'Value']), 'salesPrice');
            reset($taxrules);

            foreach ($taxrules as &$rule) {
                if (!isset($cart_prices[$this->_psType . '_calc_id']) or ! is_array($cart_prices[$this->_psType . '_calc_id']))
                    $cart_prices[$this->_psType . '_calc_id'] = array();
                $cart_prices[$this->_psType . '_calc_id'][] = $rule['standard_calc_id'];

                if (isset($rule['subTotalOld']))
                    $rule['subTotal'] += $rule['subTotalOld'];
                if (isset($rule['taxAmountOld']))
                    $rule['taxAmount'] += $rule['taxAmountOld'];
                if (isset($rule['psType']))
                    unset($rule['psType']);
            }
        } else {

            $cart_prices['salesPrice' . $_psType] = $cart_prices[$this->_psType . 'Value'];
            $cart_prices[$this->_psType . 'Tax'] = 0;
            $cart_prices[$this->_psType . '_calc_id'] = 0;
        }
        //$c[$this->_psType][$method->$idN] =& $cart_prices;
        //if($_psType='Shipment')gpTrace('setCartPrices '.$cart_prices['salesPrice' . $_psType]);
        return $cart_prices['salesPrice' . $_psType];
    }

    // ====== /.Calculate Price Shipment ==== 

    /**
     * plgOnCheckAutomaticSelected
     * Checks how many plugins are available. If only one, the user will not have the choice. Enter edit_xxx page
     * The plugin must check first if it is the correct type
     *
     * @author Binh Nguyen
     * @param Cart cart: the cart object
     * @return null if no plugin was found, 0 if more then one plugin was found,  xxx_id if only one plugin is found
     *
     */
    function plgOnCheckAutomaticSelectedShipment(Cart $cart, array $cart_prices, &$shipCounter) {
        return $this->onCheckAutomaticSelected($cart, $cart_prices, $shipCounter);
    }

    /**
     * onCheckAutomaticSelected
     * Checks how many plugins are available. If only one, the user will not have the choice. Enter edit_xxx page
     * The plugin must check first if it is the correct type
     *
     * @author Binh Nguyen
     * @param Cart cart: the cart object
     * @return null if no plugin was found, 0 if more then one plugin was found,  standard_xxx_id if only one plugin is found
     *
     */
    function onCheckAutomaticSelected(Cart $cart, array $cart_prices = array(), &$methodCounter = 0) {

        $standard_pluginmethod_id = 0;

        $nbMethod = $this->getSelectable($cart, $standard_pluginmethod_id, $cart_prices);
        $methodCounter += $nbMethod;

        if ($nbMethod == NULL) {
            return NULL;
        } else {
            if ($nbMethod == 1) {
                return $standard_pluginmethod_id;
            } else {
                return 0;
            }
        }
    }

    /**
     * getSelectable
     * This method returns the number of valid methods
     *
     * @param Cart cart: the cart object
     * @param $method_id eg $standard_shipmentmethod_id
     *
     */
    function getSelectable(Cart $cart, &$method_id, $cart_prices) {

        $nbMethod = 0;

        if ($this->getPluginMethods($cart->vendorId) === 0) {
            return FALSE;
        }

        foreach ($this->methods as $k => $method) {
            if ($nb = (int) $this->checkConditions($cart, $method, $cart_prices)) {
                $nbMethod = $nbMethod + $nb;
                $idName = $this->_idName;
                $method_id = $method->$idName;
            } else {
                unset($this->methods[$k]);
            }
        }
        return $nbMethod;
    }

    /**
     * Fill the array with all plugins found with this plugin for the current vendor
     * Todo it would be nicer to use here the correct gptable methods
     * @return True when plugins(s) was (were) found for this vendor, false otherwise
     * @author Binh Nguyen
     */
    protected function getPluginMethods($vendorId) {
        return 0;
        /*
          static $mC = array();

          $h = $vendorId . $this->_psType . $this->_name;

          if (isset($mC[$h])) {
          $this->methods = $mC[$h];
          //gpdebug('getPluginMethods return cached '.$h);
          return count($this->methods);
          }

          $usermodel = GpModel::getModel('user');
          $user = $usermodel->getUser();
          $user->shopper_groups = (array) $user->shopper_groups;

          $db = JFactory::getDBO();
          if (empty($vendorId))
          $vendorId = 1;
          $select = 'SELECT i.*, ';

          $extPlgTable = '#__extensions';
          $extField1 = 'extension_id';
          $extField2 = 'element';

          $select .= 'j.`' . $extField1 . '`,j.`name`, j.`type`, j.`element`, j.`folder`, j.`client_id`, j.`enabled`, j.`access`, j.`protected`, j.`manifest_cache`,
          j.`params`, j.`custom_data`, j.`system_data`, j.`checked_out`, j.`checked_out_time`, j.`state`,  s.standard_shoppergroup_id ';

          if (!GpConfig::$gplang) {
          gpLanguage::initialise();
          }

          $joins = array();

          $langFields = array($this->_psType . '_name', $this->_psType . '_desc');

          $select .= ', ' . implode(', ', GpModel::joinLangSelectFields($langFields));

          $joins = GpModel::joinLangTables('#__standard_' . $this->_psType . 'methods', 'i', 'standard_' . $this->_psType . 'method_id');
          array_unshift($joins, ' FROM #__standard_' . $this->_psType . 'methods as i');

          $joins[] = ' LEFT JOIN `' . $extPlgTable . '` as j ON j.`' . $extField1 . '` =  i.`' . $this->_psType . '_jplugin_id` ';
          $joins[] = ' LEFT OUTER JOIN `#__standard_' . $this->_psType . 'method_shoppergroups` AS s ON i.`standard_' . $this->_psType . 'method_id` = s.`standard_' . $this->_psType . 'method_id` ';

          $q = $select . implode(' ' . "\n", $joins);
          $q .= ' WHERE i.`published` = "1" AND j.`' . $extField2 . '` = "' . $this->_name . '"
          AND  (i.`standard_vendor_id` = "' . $vendorId . '" OR i.`standard_vendor_id` = "0" OR i.`shared` = "1")
          AND  (';

          foreach ($user->shopper_groups as $groups) {
          $q .= ' s.`standard_shoppergroup_id`= "' . (int) $groups . '" OR';
          }
          $q .= ' (s.`standard_shoppergroup_id`) IS NULL ) GROUP BY i.`standard_' . $this->_psType . 'method_id` ORDER BY i.`ordering`';


          $db->setQuery($q);
          $this->methods = $db->loadObjectList();
          if ($err = $db->getErrorMsg()) {
          gpError('Error in slq gppsplugin.php function getPluginMethods ' . $err);
          }

          if ($this->methods) {
          foreach ($this->methods as $method) {
          GpTable::bindParameterable($method, $this->_xParams, $this->_varsToPushParam);
          $this->decryptFields($method);
          }
          } else if ($this->methods === null or empty($this->methods)) {
          $this->methods = array();
          //gpError ('Error reading getPluginMethods ' . $q);
          }

          $mC[$h] = $this->methods;
          //gpdebug('getPluginMethods my query ',str_replace('#__',$db->getPrefix(),$db->getQuery()));
          return count($this->methods);
         * 
         */
    }

    /**
     *
     * Enter description here ...
     *
     * @author Binh Nguyen
     * @param Cart $cart
     * @param int            $method
     * @param array          $cart_prices
     */
    protected function checkConditions($cart, $method, $cart_prices) {

        // gpAdminInfo('gpPsPlugin function checkConditions not overriden, gives always back FALSE');
        return FALSE;
    }

}
