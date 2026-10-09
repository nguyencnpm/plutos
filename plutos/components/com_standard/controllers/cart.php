<?php

defined('_JEXEC') or die;
if (!class_exists('Cart')) {
    JLoader::register('Cart', JPATH_SITE . '/components/com_standard/helpers/cart.php');
}

/**
 * The Cart List Controller 
 * Author       : Binh Nguyen
 * @package     : Giaiphapcongnghethongtin.Site
 * @subpackage  : com_standard
 */
class StandardControllerCart extends JControllerLegacy {

    public function getModel($name = 'Information', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }

    /**
     * Add the product to the Cart
     * @access public
     */
    public function add() {
        $app = JFactory::getApplication();
        $cart = Cart::getCart();

        if ($cart) :
            $product_id = $app->input->get('id', 0, 'int');
            $error = false;
            $cart->add($product_id, $error);
            if (!$error) {
                $msg = JText::_('COM_STANDARD_PRODUCT_ADDED_SUCCESSFULLY');
                $type = 'message';
            } else {
                $msg = JText::_('COM_STANDARD_PRODUCT_NOT_ADDED_SUCCESSFULLY');
                $type = 'error';
            }

            $app->enqueueMessage($msg, $type);
            $app->redirect(JRoute::_('index.php?option=com_standard&view=information', FALSE)); // view=cart
        else:
            $app->enqueueMessage(JText::_('COM_STANDARD_CART_DOES_NOT_EXIST'), 'error');
        endif;
    }

    public function updateCart($html = true, $force = null) {

        $aFormPost = $this->input->post->get('jform', array(), 'array');

        $cart = Cart::getCart();
        $cart->_fromCart = true;
        $cart->_redirected = false;
        /*
          if (JRequest::getCmd('cancel', 0)) {
          $cart->_inConfirm = false;
          }

          if ($cart->getInCheckOut()) {
          JRequest::setVar('checkout', true);
          }
         */
        // $cart->saveCartFieldsInCart();

        if ($cart->updateProductCart()) {
            //gpInfo('COM_STANDARD_PRODUCT_UPDATED_SUCCESSFULLY');
        }
        /*
          $STsameAsBT = JRequest::getInt('STsameAsBT', null);
          if (isset($STsameAsBT)) {
          $cart->STsameAsBT = $STsameAsBT;
          }

          $currentUser = JFactory::getUser();
          if (!$currentUser->guest) {
          $cart->selected_shipto = JRequest::getVar('shipto', $cart->selected_shipto);
          if (!empty($cart->selected_shipto)) {
          $userModel = GpModel::getModel('user');
          $stData = $userModel->getUserAddressList($currentUser->id, 'ST', $cart->selected_shipto);

          if (isset($stData[0]) and is_object($stData[0])) {
          $stData = get_object_vars($stData[0]);
          $cart->ST = $stData;
          $cart->STsameAsBT = 0;
          } else {
          $cart->selected_shipto = 0;
          }
          }
          if (empty($cart->selected_shipto)) {
          $cart->STsameAsBT = 1;
          $cart->selected_shipto = 0;
          //$cart->ST = $cart->BT;
          }
          } else {
          $cart->selected_shipto = 0;
          if (!empty($cart->STsameAsBT)) {
          //$cart->ST = $cart->BT;
          }
          }

          if (!isset($force)):
          $force = GpConfig::get('oncheckout_opc', true);
          endif;

          $cart->setShipmentMethod($force, !$html);
          $cart->setPaymentMethod($force, !$html);

          JPluginHelper::importPlugin('gpcustom');
          JPluginHelper::importPlugin('gpextended');
          $dispatcher = JDispatcher::getInstance();
          $dispatcher->trigger('plgGpOnUpdateCart', array(&$cart, &$force, &$html));
         */
        $cart->prepareCartData();
        // ---- set Coupon Code ---
        $coupon_code = trim(JRequest::getString('coupon_code', ''));
        if (!empty($coupon_code)) :
            $msg = $cart->setCouponCode($coupon_code);
            if ($msg):
                $app = JFactory::getApplication();
                $app->enqueueMessage($msg, 'Message');
            endif;
            $cart->setOutOfCheckout();
        endif;

        // ---- /.set Coupon Code ---
        // ---- set Shipment id ---
        //$shipmentmethod_id = JRequest::getInt('shipmentmethod_id', 2);
        $shipmentmethod_id = isset($aFormPost['shipmentmethod_id']) ? $aFormPost['shipmentmethod_id'] : 0;
        $cart->setMethodKey($shipmentmethod_id, 'shipment');
        // ---- /.set Shipment id ---

        if ($html) {
            $this->display();
        } else {
            $json = new stdClass();
            ob_start();
            $this->display();
            $json->msg = ob_get_clean();
            echo json_encode($json);
            jexit();
        }
    }

    function cancel() {

        $cart = Cart::getCart();
        if ($cart) {
            $cart->setOutOfCheckout();
        }
        $this->display();
    }

    /* ---- Using Ajax ---- */

    /**
     * Add the product to the cart, with JS
     * @access public
     */
    public function addJS() {
        $app = JFactory::getApplication();
        $this->json = new stdClass();
        $aData = array();
        $cart = Cart::getCart();
        if ($cart):
            // Get the document object.
            $vName = 'information';
            $view = $this->getView($vName, 'json');

            $aPost = JRequest::get('post');
            $aDataRequest = (json_decode(stripslashes($aPost["datas"]), true));
            foreach ($aDataRequest as $rKey => $arrData):
                $aData["{$arrData['name']}"] = $arrData['value'];
            endforeach;

            $product_id = $aData['id'];
            $quantity = $aData["quantity[{$aData['id']}]"];

            $errorMsg = 0;
            $products = $cart->add((int) $product_id, $errorMsg);

            $view->setLayout('padded');

            $this->json->stat = '1';
            
            $this->json->products = $products;
            
            $product_name = $aData['pname'];
            if (!$products or count($products) == 0):
                if (!empty($errorMsg)):
                    $this->json->stat = '2';
                    $view->setLayout('perror');
                endif;
            endif;
            $this->json->productInfo = $quantity . ' x ' . $product_name;
            $this->json->msg = ob_get_clean();
        else:
            $this->json->productInfo = $quantity . ' x ' . $product_name;
            $this->json->msg = '<a href="' . JRoute::_('index.php?option=com_standard', FALSE) . '" >' . vmText::_('COM_STANDARD_CONTINUE_SHOPPING') . '</a>';
            $this->json->msg .= '<p>' . vmText::_('COM_STANDARD_MINICART_ERROR') . '</p>';
            $this->json->stat = '0';
        endif;

        // ob_start();
        // $this->display();

        echo json_encode($this->json);
        $app->close();
    }

    function fetchCart() {
        $cart = Cart::getCart();
        $cart->prepareCartData(false);

        $total_price_format = "";
        $total_item = 0;

        $HeaderProductName = JText::_("COM_STANDARD_CART_PRODUCT_TITLE");
        $HeaderQuantity = JText::_("COM_STANDARD_QUANTITY");

        $output = "<div class=\"table-responsive\" id=\"order_table\">
            <table class=\"table table-bordered table-striped\">
                <tr>  
                    <th>{$HeaderProductName}</th>  
                    <th>{$HeaderQuantity}</th>
                </tr>
        ";
        if ($cart->totalProduct > 0):
            foreach ($cart->products as $pkey => $prow):
                $output .= '
		<tr>
                    <td>' . $prow->title . '</td>
                    <td>' . $prow->quantity . '</td>
		</tr>
		';
            endforeach;

            $total_item = $cart->totalProduct;

        else:

            $output .= '
		<tr>
                    <td colspan="2">' . JText::_("COM_STANDARD_YOUR_CART_IS_EMPTY") . '</td>
		</tr>
		';
        endif;

        $data = array(
            'cart_details' => $output,
            'total_price' => $total_price_format,
            'total_item' => $total_item
        );
        $output .= '</table></div>';
        echo json_encode($data);
        jexit();
    }

    /* ---- /.Using Ajax ---- */
}
