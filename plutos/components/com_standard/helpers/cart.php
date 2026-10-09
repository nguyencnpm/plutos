<?php

/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Model class for the cart
 * Very important, use ALWAYS the getCart function, to get the Cart from the session
 * @package	Cart
 * @subpackage Cart
 * @author Binh Nguyen! Project
 */
class Cart {

    var $products = array();
    var $_productAdded = true;
    var $_calculated = false;
    var $_inCheckOut = false;
    var $_inConfirm = false;
    var $_fromCart = false;
    var $_dataValidated = false;
    var $_blockConfirm = false;
    var $_confirmDone = false;
    var $_redirect = false;
    var $_redirected = false;
    var $_redirect_disabled = false;
    var $_lastError = null; // Used to pass errmsg to the cart using addJS()
    //todo multivendor stuff must be set in the add function, first product determines ownership of cart, or a fixed vendor is used
    var $vendorId = 0;
    var $lastVisitedCategoryId = 0;
    var $shipmentmethod_id = 0;
    var $paymentmethod_id = 0;
    var $automaticSelectedShipment = false;
    var $automaticSelectedPayment = false;
    var $BT = 0;
    var $ST = 0;
    var $cartFields = null;
    var $couponCode = '';
    var $order_language = '';
    var $orderDetails = 0;
    var $lists = null;
    var $order_number = null; // added to solve emptying cart for payment notification
    var $order_pass = null;
    var $order_id = false;
    var $customer_number = null;
    var $cartAdv = false;
    var $pricesCurrency = null;
    var $paymentCurrency = null;
    var $paymentCurrencySymbol = null;
    var $paymentCurrencyRate = null;
    var $paymentCurrencyCode3 = null;
    var $STsameAsBT = 1;
    var $selected_shipto = 0;
    var $productParentOrderable = TRUE;
    var $_triesValidateCoupon = array();
    var $cartProductsData = array();
    var $cartData = array();
    var $cartPrices = array();
    var $layout;
    var $layoutPath = '';
    var $orderdoneHtml = false;
    var $cart_id = 0;
    var $customer_notified = false;
    /* @deprecated */
    var $pricesUnformatted = array();
    private static $_cart = null;
    var $useSSL = 1;

    public function __construct() {
        //$this->useSSL = URI::useSSL();
        //$this->useXHTML = false;
        $this->cartProductsData = array();
        //$this->layout = Config::get('cartLayout', 'default');

        if (empty($this->layout)) {
            $this->layout = 'default';
        }
    }

    /**
     * Proxy for getModel.
     */
    public function getModel($name = 'Product', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_standard/models', 'StandardModel');
        $getModel = JModelLegacy::getInstance($name, $prefix, $config);
        return $getModel;
    }

    /**
     * Get the cart from the session
     *
     * @author Binh Nguyen! Project
     * @access public
     * @param array $cart the cart to store in the session
     */
    public static function &getCart($forceNew = false, $options = array(), $cartData = NULL) {
        if (empty(self::$_cart) or $forceNew) :
            self::$_cart = new Cart;
            if (empty($cartData)):
                $session = JFactory::getSession($options);
                $cartSession = $session->get('gpCart', 0, 'gp');
                if (!empty($cartSession)):
                    $sessionCart = (object) json_decode($cartSession, true);
                    if (empty($sessionCart->cartProductsData) or ( $sessionCart->_guest and $sessionCart->_guest != JFactory::getUser()->guest)) :
                        self::$_cart->loadCart($sessionCart);
                    endif;
                endif;

            else:
                $cartSession = $sessionCart = $cartData;
            endif;

            // $userModel = GpModel::getModel('user');
            // self::$_cart->user = $userModel->getCurrentUser();
            self::$_cart->user = JFactory::getUser()->guest;

            $lang = JFactory::getLanguage();
            self::$_cart->order_language = $lang->getTag();

            if (!empty($cartSession)) :

                if (isset($sessionCart->cartProductsData)) :
                    self::$_cart->cartProductsData = $sessionCart->cartProductsData;
                    self::$_cart->vendorId = $sessionCart->vendorId;
                    self::$_cart->lastVisitedCategoryId = $sessionCart->lastVisitedCategoryId;
                    self::$_cart->shipmentmethod_id = $sessionCart->shipmentmethod_id;
                    self::$_cart->paymentmethod_id = $sessionCart->paymentmethod_id;
                    self::$_cart->automaticSelectedShipment = $sessionCart->automaticSelectedShipment;
                    self::$_cart->automaticSelectedPayment = $sessionCart->automaticSelectedPayment;
                    self::$_cart->BT = $sessionCart->BT;
                    self::$_cart->ST = $sessionCart->ST;
                    self::$_cart->cartFields = $sessionCart->cartFields;

                    self::$_cart->couponCode = $sessionCart->couponCode;
                    self::$_cart->_triesValidateCoupon = $sessionCart->_triesValidateCoupon;
                    self::$_cart->order_number = $sessionCart->order_number;
                    self::$_cart->pricesCurrency = $sessionCart->pricesCurrency;
                    self::$_cart->paymentCurrency = $sessionCart->paymentCurrency;

                    self::$_cart->paymentCurrencySymbol = $sessionCart->paymentCurrencySymbol;
                    self::$_cart->paymentCurrencyRate = $sessionCart->paymentCurrencyRate;
                    self::$_cart->paymentCurrencyCode3 = $sessionCart->paymentCurrencyCode3;

                    self::$_cart->_guest = $sessionCart->_guest;
                    self::$_cart->_inCheckOut = $sessionCart->_inCheckOut;
                    self::$_cart->_inConfirm = $sessionCart->_inConfirm;
                    self::$_cart->_dataValidated = $sessionCart->_dataValidated;
                    self::$_cart->_confirmDone = $sessionCart->_confirmDone;
                    self::$_cart->STsameAsBT = $sessionCart->STsameAsBT;
                    self::$_cart->selected_shipto = $sessionCart->selected_shipto;
                    self::$_cart->_fromCart = $sessionCart->_fromCart;
                    self::$_cart->layout = $sessionCart->layout;
                    self::$_cart->layoutPath = $sessionCart->layoutPath;
                    self::$_cart->cart_id = $sessionCart->cart_id;
                endif;
            endif;

        /*
          self::$_cart->loadSetRenderBTSTAddress();

          if (empty(self::$_cart->shipmentmethod_id) && !empty(self::$_cart->user->shipmentmethod_id)) {
          self::$_cart->shipmentmethod_id = self::$_cart->user->shipmentmethod_id;
          }

          if (empty(self::$_cart->paymentmethod_id) && !empty(self::$_cart->user->paymentmethod_id)) {
          self::$_cart->paymentmethod_id = self::$_cart->user->paymentmethod_id;
          }

          if ((!empty(self::$_cart->user->tos) || !empty(self::$_cart->BT['tos'])) && !GpConfig::get('agree_to_tos_onorder', 0)) {
          self::$_cart->BT['tos'] = 1;
          }

          if (!empty(self::$_cart->user->customer_number)) {
          self::$_cart->customer_number = self::$_cart->user->customer_number;
          }

          if (empty(self::$_cart->customer_number) or strpos(self::$_cart->customer_number, 'nonreg_') !== FALSE) {
          $firstName = empty(self::$_cart->BT['first_name']) ? '' : self::$_cart->BT['first_name'];
          $lastName = empty(self::$_cart->BT['last_name']) ? '' : self::$_cart->BT['last_name'];
          $email = empty(self::$_cart->BT['email']) ? '' : self::$_cart->BT['email'];
          $qdate = date("Ymd_His_");
          if (!class_exists('shopFunctionsF'))
          require(GPPATH_SITE . DS . 'helpers' . DS . 'shopfunctionsf.php');
          self::$_cart->customer_number = 'nonreg_' . shopFunctionsF::gpSubstr($firstName, 0, 2) . shopFunctionsF::gpSubstr($lastName, 0, 2) . shopFunctionsF::gpSubstr($email, 0, 2) . $qdate;
          }

          $multixorder = GpConfig::get('multixorder', 0);
          if (!empty($multixorder)) {
          if ($multixorder == 'byvendor' or self::$_cart->vendorId == 1) {
          $vendor = GpModel::getModel('vendor');
          $vId = $vendor->getLoggedVendor();
          if (!empty($vId) and $vId != 1) {
          self::$_cart->vendorId = $vId;
          }
          if (empty(self::$_cart->vendorId))
          self::$_cart->vendorId = 1;
          }
          if ($multixorder == 'byselection') {
          self::$_cart->vendorId = JRequest::getInt('vendor_id', self::$_cart->vendorId);
          }
          }

          //We need to check for the amount of products. A cart in Multix mode using the first product
          // to determine the vendorId is a valid if there is no product in the cart
          $cp = count(self::$_cart->cartProductsData);
          if ($cp > 0 and empty(self::$_cart->vendorId)) {
          self::$_cart->vendorId = 1;
          } else if ($cp == 0 and ! empty($multixorder)) {
          self::$_cart->vendorId = 0;
          }
         */
        endif;

        return self::$_cart;
    }

    /**
     * @author Binh Nguyen
     */
    public function loadCart(&$existingSession) {
        $currentUser = JFactory::getUser(); // user default guest: [guest] => 1 
        /*
          echo '<pre>';
          echo 'loadCart';
          print_r($currentUser);
          exit;
         */
    }

    /**
     * @author Binh Nguyen
     * Add a product to the Cart
     * @access public
     */
    public function add($product_id = null, &$errorMsg = '') {
        $app = JFactory::getApplication();
        $updateSession = false;
        $aPost = JRequest::get('post');

        if (empty($product_id)) {
            $product_id = $app->input->get('id', 0, 'int'); //is sanitized
        }

        if (empty($product_id)) {
            $app->enqueueMessage(JText::_('COM_STANDARD_CART_ERROR_NO_PRODUCT_IDS'), 'error');
            return false;
        } else {// xoa
            if (is_array($product_id)) {
                $product_id = array_unique($product_id);
            }
        }

        $products = array();
        $this->_productAdded = true;
        // ---- ----
        // ==== call model ====
        $productModel = $this->getModel('Product');
        // $customFieldsModel = $this->getModel('Customfields');
        // ---- ---
        if ($product_id):
            // ==== build Data ====
            $product = false;
            $updateSession = true;
            $productData = array();

            $productData['product_id'] = (int) $product_id;

            if (isset($aPost['quantity'][$product_id])):
                $productData['quantity'] = (int) $aPost['quantity'][$product_id];
            else:
                // ==== addJS ==== Nghien cuu them ====
                $arrData = array();
                $aDataRequest = (json_decode(stripslashes($aPost["datas"]), true));
                foreach ($aDataRequest as $rKey => $arrData):
                    $aData["{$arrData['name']}"] = $arrData['value'];
                endforeach;
                $productData['quantity'] = (int) $aData["quantity[{$aData['id']}]"];
            endif;



            if (!empty($aPost['customProductData'][$product_id])) {
                //$productData['customProductData']
                $customProductData = $aPost['customProductData'][$product_id];
            } else {
                $customProductData = array();
            }

            // Now we check if the delivered customProductData is correct and add missing
            // --- product ---
            $productTemp = $productModel->getItem($productData['product_id']); // case: checkForQuantities
            /*
              $productTemp->modificatorSum = null;
              $product = clone($productTemp);
             */

//            echo '<pre>';
//            print_r($productTemp);
//            exit;
            // -- fix temp --
            $oProduct = new stdClass();
            $oProduct->product_id = $productData['product_id'];
            $oProduct->quantity = $productData['quantity'];
            // --- case: checkForQuantities --- 
            $oProduct->name = $productTemp->title;
            $oProduct->in_stock = $productTemp->in_stock;
            $oProduct->ordered = $productTemp->ordered;
            // --- /.case: checkForQuantities --- 
            $product = clone($oProduct);
            // -- /.fix temp --
            // --- custom Fields ---
            // $product->customFields = $customFieldsModel->getCustomEmbeddedProductCustomFields($product->allIds, 0, 1);
            $customProductDataTmp = array();
            // Some customfields may prevent the product being added to the order
            $customFiltered = false;

            $productData['customProductData'] = $customProductDataTmp;
            // --- /.custom Fields ---
            // ==== /.build Data ====
            // ---- ----
            $unsetA = array();
            $found = false;

            // Now lets check if there is already a product stored with the same id, if yes, increase quantity and recalculate
            foreach ($this->cartProductsData as $k => &$cartProductData) :
                $cartProductData = (array) $cartProductData;
                if (empty($cartProductData['product_id'])) {
                    $unsetA[] = $k;
                    $errorMsg = true;
                } else {
                    if ($cartProductData['product_id'] == $productData['product_id']) {
                        // Okey, the id is already the same, so lets check the customProductData
                        $diff = !$this->deepCompare($cartProductData['customProductData'], $productData['customProductData']);
                        if (!$diff) {
                            $newTotal = $cartProductData['quantity'] + $productData['quantity'];
                            if (!$product) {
                                // $product = $this->getProduct((int) $productData['product_id'], $cartProductData['quantity']);
                            }
                            if (empty($product->product_id)) {
                                // gpWarn('COM_STANDARD_PRODUCT_NOT_FOUND');
                                $unsetA[] = $k;
                            } else {
                                $this->checkForQuantities($product, $newTotal);
                                // gpdebug("add to cart did checkForQuantities", $newTotal, $cartProductData['quantity'], $productData['quantity']);
                                $product->quantity = $newTotal - $cartProductData['quantity'];
                                $cartProductData['quantity'] = $newTotal;
                                // gpdebug('add to cart did $product->quantityAdded  ', $cartProductData['quantity']);
                            }
                            $found = TRUE;
                            break;
                        } else {
                            // gpdebug('product variant is different, I add to cart');
                        }
                    }
                }

                //add products to remove to array
                if ($cartProductData['quantity'] == 0) {
                    $unsetA[] = $k;
                }

            endforeach;

            if (!$found) :
                if (!$product):
                // $product = $this->getProduct($productData['product_id'], $productData['quantity'])
                endif;

                if (!empty($product->product_id)) :
                    $this->checkForQuantities($product, $product->quantity);
                    // --- ---
                    if (!empty($product->quantity)) :
                        $productData['quantity'] = $product->quantity;
                        $this->cartProductsData[] = $productData;
                    else:
                        $errorMsg = true;
                    endif;
                else:
                    $errorMsg = true;
                endif;
            endif;
            // --- /.!$found ---

            if ($product) :
                $products[] = $product;
            endif;

            // -- Remove the products which have quantity=0 --
            foreach ($unsetA as $v) :
                unset($this->cartProductsData[$v]);
            endforeach;
        // -- /.Remove the products which have quantity=0 --
        endif;

        // ==== ====
        //JPluginHelper::importPlugin('extended');
        //$dispatcher = JDispatcher::getInstance();
        //$dispatcher->trigger('plgOnAddToCart', array(&$this));

        if ($updateSession == false):
            return false;
        endif;

        $this->_dataValidated = false;
        // End Iteration through Prod id's

        $this->setCartIntoSession(true);
        return $products;

        // ---- /. ----
    }

    /** Checks if the quantity is correct
     *
     * @author Binh Nguyen
     */
    private function checkForQuantities($product, &$quantity = 0) {
        $app = JFactory::getApplication();
        // $stockhandle = GpConfig::get('stockhandle_products', false) && $product->product_stockhandle ? $product->product_stockhandle : GpConfig::get('stockhandle', 'none');
        $params = JComponentHelper::getParams('com_standard');
        if (!empty($params->get('stockhandle'))):
            $stockhandle = $params->get('stockhandle');
        endif;

//        echo '<pre>';
//        print_r($product);
//        exit;
        // Check for a valid quantity
        if (!is_numeric($quantity)) :
            $product->errorMsg = JText::sprintf('COM_STANDARD_CART_ERROR_NO_VALID_QUANTITY', $product->name);
            //gpWarn($product->errorMsg);
            $type = 'error';
            $app->enqueueMessage($product->errorMsg, $type);
            return false;
        endif;
        // Check for negative quantity
        if ($quantity < 1) :
            $product->errorMsg = JText::sprintf('COM_STANDARD_CART_ERROR_NO_VALID_QUANTITY', $product->name);
            //gpWarn($product->errorMsg);
            $type = 'error';
            $app->enqueueMessage($product->errorMsg, $type);
            return false;
        endif;

        $checkForDisable = false;
        if ($stockhandle != 'none' && $stockhandle != 'risetime'):
            $checkForDisable = true;
        endif;
        // fix temp
        $min = 1;
        /*
          // Check for the minimum and maximum quantities
          $min = $product->min_order_level;
          if ($min != 0 && $quantity < $min) :
          $quantity = $min;
          $product->errorMsg = JText::sprintf('COM_STANDARD_CART_MIN_ORDER', $min, $product->name);
          //gpWarn($product->errorMsg);
          $type = 'error';
          $app->enqueueMessage($product->errorMsg, $type);
          if (!$checkForDisable):
          return false;
          endif;
          endif;

          $max = $product->max_order_level;
          if ($max != 0 && $quantity > $max) :
          $quantity = $max;
          $product->errorMsg = JText::sprintf('COM_STANDARD_CART_MAX_ORDER', $max, $product->name);
          //gpWarn($product->errorMsg);
          $type = 'error';
          $app->enqueueMessage($product->errorMsg, $type);
          if (!$checkForDisable):
          return false;
          endif;
          endif;

          $step = $product->step_order_level;
          if ($step != 0 && ($quantity % $step) != 0) :
          $quantity = $quantity + ($quantity % $step);
          $product->errorMsg = JText::sprintf('COM_STANDARD_CART_STEP_ORDER', $step);
          //gpWarn($product->errorMsg);
          $type = 'error';
          $app->enqueueMessage($product->errorMsg, $type);
          if (!$checkForDisable):
          return false;
          endif;
          endif;
         */
        // Check to see if checking stock quantity
        if ($checkForDisable) :
            $productsleft = $product->in_stock - $product->ordered;
            if ($quantity > $productsleft) :
                //gpdebug('my products left ' . $productsleft . ' and my quantity ' . $quantity);
                if ($productsleft >= $min) :
                    $quantity = $productsleft;
                    //$product->errorMsg = JText::sprintf('COM_STANDARD_CART_PRODUCT_OUT_OF_QUANTITY', $product->name, $quantity);
                    $product->errorMsg = JText::sprintf('COM_STANDARD_CART_PRODUCT_OUT_OF_QUANTITY', $product->product_title, $quantity);
                    //gpWarn($product->errorMsg);
                    $type = 'error';
                    $app->enqueueMessage($product->errorMsg, $type);
                else:
                    $quantity = 0;
                    $product->errorMsg = JText::_('COM_STANDARD_CART_PRODUCT_OUT_OF_STOCK');
                    //gpWarn($product->errorMsg);
                    $type = 'error';
                    $app->enqueueMessage($product->errorMsg, $type);
                    return false;

                endif;
            endif;
        endif;

        return true;
    }

    public function deleteCart() {
        /*
          $model = new GpModel();
          $carts = $model->getTable('carts');

          if (!empty($this->cart_id)) {
          $carts->delete($this->cart_id, 'cart_id');
          } else {
          $currentUser = JFactory::getUser();
          if (!empty($currentUser->id)) {
          $carts->delete($currentUser->id);
          }
          }
         */
    }

    /**
     * Set the cart in the session
     *
     * @access public
     * @param array $cart the cart to store in the session
     */
    public function setCartIntoSession($storeDb = false, $forceWrite = false) {
        $session = JFactory::getSession();

        $sessionCart = $this->getCartDataToStore();
        $sessionCart = json_encode($sessionCart);
        $session->set('gpCart', $sessionCart, 'gp');

        if ($forceWrite) :
            session_write_close();
            session_start();
        endif;

        if ($storeDb) :
        // $this->storeCart();
        endif;
    }

    public function getCartDataToStore() {
        $sessionCart = new stdClass();

        $sessionCart->cartProductsData = $this->cartProductsData;
        $sessionCart->vendorId = $this->vendorId;
        $sessionCart->lastVisitedCategoryId = $this->lastVisitedCategoryId;
        $sessionCart->shipmentmethod_id = $this->shipmentmethod_id;
        $sessionCart->paymentmethod_id = $this->paymentmethod_id;
        $sessionCart->automaticSelectedShipment = $this->automaticSelectedShipment;
        $sessionCart->automaticSelectedPayment = $this->automaticSelectedPayment;
        $sessionCart->order_number = $this->order_number;

        $sessionCart->BT = $this->BT;
        $sessionCart->ST = $this->ST;
        $sessionCart->cartFields = $this->cartFields;

        $sessionCart->couponCode = $this->couponCode;
        $sessionCart->_triesValidateCoupon = $this->_triesValidateCoupon;
        $sessionCart->order_language = $this->order_language;

        $sessionCart->pricesCurrency = $this->pricesCurrency;
        $sessionCart->paymentCurrency = $this->paymentCurrency;

        $sessionCart->paymentCurrencySymbol = $this->paymentCurrencySymbol;
        $sessionCart->paymentCurrencyRate = $this->paymentCurrencyRate;
        $sessionCart->paymentCurrencyCode3 = $this->paymentCurrencyCode3;

        //private variables
        //We nee to store this, so that we now if a user logged in before
        $sessionCart->_guest = JFactory::getUser()->guest;
        $sessionCart->_inCheckOut = $this->_inCheckOut;
        $sessionCart->_inConfirm = $this->_inConfirm;
        $sessionCart->_dataValidated = $this->_dataValidated;
        $sessionCart->_confirmDone = $this->_confirmDone;
        $sessionCart->STsameAsBT = $this->STsameAsBT;
        $sessionCart->selected_shipto = $this->selected_shipto;
        $sessionCart->_fromCart = $this->_fromCart;
        $sessionCart->layout = $this->layout;
        $sessionCart->layoutPath = $this->layoutPath;
        $sessionCart->cart_id = $this->cart_id;
        $sessionCart->orderdoneHtml = $this->orderdoneHtml;
        $sessionCart->order_id = $this->order_id;

        return $sessionCart;
    }

    /*
      public function storeCart($cartDataToStore = false) {
      $adminID = gpAccess::getBgManagerId();
      $currentUser = JFactory::getUser();
      if (!$currentUser->guest && (!$adminID || $adminID == $currentUser->id)) {
      $model = new GpModel();
      $carts = $model->getTable('carts');
      if (!$cartDataToStore)
      $cartDataToStore = json_encode($this->getCartDataToStore());

      $cObj = new StdClass();
      if (!empty($this->cart_id))
      $cObj->cart_id = (int) $this->cart_id;
      $cObj->user_id = (int) $currentUser->id;
      $cObj->vendor_id = (int) $this->vendorId;
      $cObj->cartData = $cartDataToStore;
      $carts->bindChecknStore($cObj);

      if (!empty($cObj->cart_id)) {
      $this->cart_id = $cObj->cart_id;
      }
      }
      }
     */

    static public function deepCompare($a, $b) {
        if (is_object($a) && is_object($b)) {
            if (get_class($a) != get_class($b)) {
                return false;
            }
            foreach ($a as $key => $val) {
                if (!self::deepCompare($val, $b->$key)) {
                    return false;
                }
            }
            return true;
        } else if (is_array($a) && is_array($b)) {
            while (!is_null(key($a)) && !is_null(key($b))) {
                if (key($a) !== key($b) || !self::deepCompare(current($a), current($b))) {
                    return false;
                }
                next($a);
                next($b);
            }
            return is_null(key($a)) && is_null(key($b));
        } else {
            return $a === $b;
        }
    }

    function prepareCartData($force = true) {
        $app = JFactory::getApplication();
        // Clean the cache
        // $this->cleanCache();
        //$this->totalProduct = 0;
        if (count($this->products) != count($this->cartProductsData) or $this->_productAdded) {
            $productsModel = $this->getModel('Product');
            $this->totalProduct = 0;
            $this->productsQuantity = array();
            // $customFieldsModel = $this->getModel('Customfields');

            foreach ($this->cartProductsData as $k => &$productdata) {
                $productdata = (array) $productdata;

                if (isset($productdata['product_id'])) {
                    if (empty($productdata['product_id']) or empty($productdata['quantity'])) {
                        unset($this->cartProductsData[$k]);
                        continue;
                    }

                    $productdata['quantity'] = (int) $productdata['quantity'];
                    //Important, must not use calculation, would lead to wrong prices, because the full order is not know yet.
                    $productTemp = $productsModel->getItem($productdata['product_id']); //$productsModel->getProduct($productdata['product_id'], TRUE, FALSE, TRUE, $productdata['quantity']);
                    //--- Set code temp ---
                    $productTemp->allPrices[] = array();
                    $productTemp->selectedPrice = 0;
                    // --- /.Set code temp ---

                    if (empty($productTemp->id)) {// id => product_id
                        $app->enqueueMessage(JText::_('prepareCartData product_id is empty', 'The product is no longer available'));
                        unset($this->cartProductsData[$k]);
                        continue;
                    }

                    //Very important! must be cloned, else all products with same id get the same productCustomData due the product cache
                    $productTemp->modificatorSum = null;
                    $product = clone($productTemp);

                    $productdata['product_id'] = (int) $productdata['product_id'];

                    $product->customProductData = $productdata['customProductData'];
                    $product->quantity = $productdata['quantity'];

                    // No full link because Mail want absolute path and in shop is better relative path
                    $product->slug = $product->alias ? ($product->id . ':' . $product->alias) : $product->id;
                    $product->url = JRoute::_(StandardHelperRoute::getProductRoute($product->slug, $product->catid, $product->language));
                    $product->cart_item_id = $k;
                    /*
                      if (GpConfig::get('oncheckout_show_images')) {
                      $productsModel->addImages($product, 1);
                      }

                      $product->customfields = $customFieldsModel->getCustomEmbeddedProductCustomFields($product->allIds, 0, 1);
                     */
                    $enough = $this->checkForQuantities($product, $product->quantity);


                    if ($product->quantity <= 0) {
                        unset($this->cartProductsData[$k]);
                        continue;
                    }
                    $this->products[$k] = $product;
                    $this->totalProduct += $product->quantity;
                    $productdata['quantity'] = $product->quantity;
                    if (isset($this->productsQuantity[$product->id])) {
                        $this->productsQuantity[$product->id] += $product->quantity;
                    } else {
                        $this->productsQuantity[$product->id] = $product->quantity;
                    }

                    $product = null;
                } else {
                    unset($this->cartProductsData[$k]);
                    $app->enqueueMessage(JText::_('prepareCartData $productdata[product_id] was empty'));
                }
            }
            $this->setCartIntoSession();
        } else {
            
        }

        $this->getCartPrices($force);
        /*
          if (!class_exists('gpPSPlugin'))
          require(GPPATH_PLUGINLIBS . DS . 'gppsplugin.php');
          JPluginHelper::importPlugin('gppayment');
          $dispatcher = JDispatcher::getInstance();
          $returnValues = $dispatcher->trigger('plgGpgetPaymentCurrency', array($this->paymentmethod_id, &$this->paymentCurrency));
         */
        $this->_productAdded = false;

        return $this->cartData;
    }

    /**
     * Function Description
     *
     * @author Binh Nguyen
     * @access public
     * @param array $cart the cart to get the products for
     * @return array of product objects
     */
    public function getCartPrices($force = false) {

        if (empty($this->cartPrices) or ! $this->_calculated or $force) {
            if (!class_exists('CalculationHelper')) {
                JLoader::register('CalculationHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/calculation.php');
            }

            $calculator = CalculationHelper::getInstance();
            // pricesCurrency "prices Currency id"
            $this->pricesCurrency = $calculator->_currencyDisplay->getCurrencyForDisplay();
            // === payment Currency === Nghien cu them - lam trong case thanh toan online ex: OnePay (chap nhan tien te nao) ===
            $oPaymentCurrency = $calculator->_currencyDisplay->getPaymentCurrency($this->pricesCurrency);
            $this->paymentCurrency = $oPaymentCurrency->paymentCurrency;
            $this->paymentCurrencySymbol = $oPaymentCurrency->paymentCurrencySymbol;
            $this->paymentCurrencyRate = $oPaymentCurrency->paymentCurrencyRate;
            $this->paymentCurrencyCode3 = $oPaymentCurrency->paymentCurrencyCode3;
            // === /.payment Currency ===
            $calculator->getCheckoutPrices($this);

            //Fallback for old extensions
            $this->pricesUnformatted = $this->cartPrices;

            //We must do this here, otherwise if we have a product more than one time in the cart
            //it has always the same price
            foreach ($this->products as $k => $product) {
                $this->products[$k]->prices = &$product->allPrices[$product->selectedPrice];
            }
            $this->_calculated = true;
            //$this->setCartIntoSession();
        }

        return $this->cartPrices;
    }

    function saveCartFieldsInCart() {
        //$this->setCartIntoSession();
    }

    /**
     * Update a product in the cart
     *
     * @author Binh Nguyen
     * @param array $cart_id the cart IDs to remove from the cart
     * @access public
     */
    public function updateProductCart() {

        if (isset($_POST['clear_cart'])):
            $this->emptyCart();
            return true;
        endif;

        $quantities = JRequest::getVar('quantity');
        if (empty($quantities))
            return false;
        $updated = false;

        foreach ($quantities as $key => $quantity) {
            if (isset($this->cartProductsData[$key]) and ! empty($quantity) and ! isset($_POST['delete_' . $key])) {
                if ($quantity != $this->cartProductsData[$key]['quantity']) {
                    $this->cartProductsData[$key]['quantity'] = $quantity;
                    $updated = true;
                    //gpInfo('COM_STANDARD_PRODUCT_UPDATED_SUCCESSFULLY');
                }
            } else {
                unset($this->cartProductsData[$key]);
                //gpInfo('COM_STANDARD_PRODUCT_REMOVED_SUCCESSFULLY');
                $updated = true;
            }
        }

        $this->setCartIntoSession(true);
        return $updated;
    }

    /**
     * Validate the coupon code. If ok,. set it in the cart
     * @param string $coupon_code Coupon code as entered by the user
     * @author Binh Nguyen
     * TODO Change the coupon total/used in DB ?
     * @access public
     * @return string On error the message text, otherwise an empty string
     */
    public function setCouponCode($coupon_code) {

        if (empty($coupon_code) or $coupon_code == JText::_('COM_STANDARD_COUPON_CODE_ENTER')) {
            $this->couponCode = '';
            return false;
        } else if ($this->couponCode == $coupon_code) {
            return;
        }

        $this->prepareCartData();

        $msg = $this->validateCoupon($coupon_code);
        //$this->getCartPrices();
        if (empty($msg)) {
            $this->couponCode = $coupon_code;

            $this->prepareCartData(true);
            $this->setCartIntoSession(true, true);
            return JText::_('COM_STANDARD_CART_COUPON_VALID');
        } else {
            $this->couponCode = '';
            $this->setCartIntoSession(true, true);
            return $msg;
        }
    }

    public function validateCoupon($coupon_code) {

        $timeDeleteTries = time() - (24 * 60 * 60);
        foreach ($this->_triesValidateCoupon as $k => $v) {
            if ($k < 8 or $k < $timeDeleteTries) {
                unset($this->_triesValidateCoupon[$k]);
            }
        }

        $couponTryTime = (string) time();
        if (!in_array($coupon_code, $this->_triesValidateCoupon)) {
            $this->_triesValidateCoupon[$couponTryTime] = $coupon_code;
        }

        if (count($this->_triesValidateCoupon) < 8) {
            if (!class_exists('CouponHelper')) {
                JLoader::register('CouponHelper', JPATH_SITE . '/components/com_standard/helpers/coupon.php');
            }
            $msg = CouponHelper::ValidateCouponCode($coupon_code, $this->cartPrices['salesPrice']);
            if (empty($msg)) {
                $this->_triesValidateCoupon = array(); //A valid couponcode means we had a normal customer
            }
        } else {
            $msg = JText::_('COM_STANDARD_CART_COUPON_TOO_MANY_TRIES');
        }

        if (!empty($msg)) {
            $this->_dataValidated = false;
            $this->_blockConfirm = true;
            return $msg;
        }

        return '';
    }

    /**
     * @author Binh Nguyen
     * @param $type
     * @return bool
     */
    public function setMethodKey($method_id, $type = "") {
        $method_name = $type . 'method_id';
        if (count($this->products) == 0) {
            return false;
        }

        $this->$method_name = $method_id;
        $this->prepareCartData(true);
        // $this->setCartIntoSession(true, true); // in function prepareCartData() called setCartIntoSession()
        return true;
    }

    /**
     * Remove the cart from the session
     *
     * @author Binh Nguyen
     * @access public
     */
    /*
      public function removeCartFromSession() {
      $session = JFactory::getSession();
      $session->set('gpCart', 0, 'gp');
      }

      public function setDataValidation($valid = false) {
      $this->_dataValidated = $valid;
      }

      public function getDataValidated() {
      return $this->_dataValidated;
      }

      public function getInCheckOut() {
      return $this->_inCheckOut;
      }
     */

    public function setOutOfCheckout() {
        $this->_inCheckOut = false;
        $this->_dataValidated = false;
        $this->_blockConfirm = true;
        $this->_redirected = true;
        $this->_redirect = false;
        $this->setCartIntoSession(false, true);
    }

    /*
      public function blockConfirm() {
      $this->_blockConfirm = true;
      }
     */

    /**
     * emptyCart: Used for payment handling.
     *
     * @author Binh Nguyen
     *
     */
    public function emptyCart() {
        self::emptyCartValues($this);
    }

    /**
     * emptyCart: Used for payment handling.
     *
     * @author Binh Nguyen
     *
     */
    static public function emptyCartValues(&$cart, $session = true) {

        //if we used a coupon, we must set it in final use now
        $couponCode = '';
        if (!empty($cart->couponCode)) {
            $couponCode = $cart->couponCode;
        } else if (!empty($cart->cartData['couponCode'])) {
            $couponCode = $cart->cartData['couponCode'];
        }
        if (!empty($cart->couponCode)) {
            CouponHelper::setInUseCoupon($couponCode, true, 1);
        }

        //We delete the old stuff
        $cart->products = array();
        $cart->cartProductsData = array();
        $cart->cartData = array();
        $cart->cartPrices = array();
        $cart->cartfields = array();
        $cart->_inCheckOut = false;
        $cart->_dataValidated = false;
        $cart->_confirmDone = false;
        $cart->couponCode = '';
        $cart->order_language = '';
        $cart->shipmentmethod_id = 0; //OSP 2012-03-14
        $cart->paymentmethod_id = 0;
        $cart->order_number = null;
        $cart->_fromCart = false;
        $cart->_inConfirm = false;
        $cart->totalProduct = false;
        $cart->productsQuantity = array();
        $cart->order_id = false;
        $cart->layout = 'default'; // GpConfig::get('cartlayout', 'default');
        if ($session) {
            $cart->deleteCart();
            $cart->setCartIntoSession(false, true);
        }
    }

    /**
     * @author Binh Nguyen
     * @param $type
     * @return bool
     */
    /*
      function checkAutomaticSelectedPlug($type) {
      $gp_method_name = $type . 'method_id';

      //        if (count($this->products) == 0 or GPConfig::get('set_automatic_' . $type, '0') == '-1') {
      //            return false;
      //        }

      if (count($this->products) == 0) :
      return false;
      endif;

      $counter = 0;
      // JPluginHelper::importPlugin('gpshipment');
      $dispatcher = JDispatcher::getInstance();
      $returnValues = $dispatcher->trigger('plgOnCheckAutomaticSelected' . ucfirst($type), array($this, $this->cartPrices, &$counter));

      $nb = 0;
      $method_id = 0;
      foreach ($returnValues as $returnValue) {
      if (isset($returnValue)) {
      $nb ++;
      if ($returnValue)
      $method_id = $returnValue;
      }
      }

      $gp_autoSelected_name = 'automaticSelected' . ucfirst($type);
      if ($nb == 1 && $method_id) {
      $this->$gp_method_name = $method_id;
      $this->$gp_autoSelected_name = true;
      $this->setCartIntoSession();
      //gpdebug('FOUND automatic SELECTED '.$type.' !!',$this->$gp_method_name);
      return true;
      } else {
      if ($nb == 0) {
      $this->$gp_method_name = 0;
      }
      $this->$gp_autoSelected_name = false;
      return false;
      }
      }
     */
    /*
     * CheckAutomaticSelectedShipment
     * If only one shipment is available for this amount, then automatically select it
     * @deprecated
     * @author Binh Nguyen
     */
    /*
      function CheckAutomaticSelectedShipment() {
      return $this->checkAutomaticSelectedPlug('shipment');
      }
     */

    /**
     * Clean the cache
     *
     * @param   string   $group      The cache group
     * @param   integer  $client_id  The ID of the client
     *
     * @return  void
     *
     * @since   3.0
     */
    protected function cleanCache($group = null, $client_id = 0) {
        /*
          $cache = JFactory::getCache();
          $cache->clean('com_standard');
         */

        $conf = \JFactory::getConfig();

        $options = array(
            'defaultgroup' => $group ?: (isset($this->option) ? $this->option : \JFactory::getApplication()->input->get('option')),
            'cachebase' => $client_id ? JPATH_ADMINISTRATOR . '/cache' : $conf->get('cache_path', JPATH_SITE . '/cache'),
            'result' => true,
        );

        try {
            /** @var \JCacheControllerCallback $cache */
            $cache = \JCache::getInstance('callback', $options);
            $cache->clean();
        } catch (\JCacheException $exception) {
            $options['result'] = false;
        }

        // Trigger the onContentCleanCache event.
        \JEventDispatcher::getInstance()->trigger($this->event_clean_cache, $options);
    }

}
