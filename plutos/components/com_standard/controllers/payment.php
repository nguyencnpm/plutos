<?php

defined('_JEXEC') or die;

/**
 * Standard Component Controller
 *
 * @since  1.5
 */
class StandardControllerPayment extends JControllerForm {

    public function __construct($config = array()) {
        parent::__construct($config);

        $this->view_list = 'confirm';
    }

    //$this->view_list = 'featured';

    public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }

    public function reserve() {
        // Check for request forgeries.
        $this->checkToken();
        $app = JFactory::getApplication();
        // recaptcha Check Answer
        $this->recaptchaCheckAnswer();
        //
        //$OjbData = $app->getUserState('com_standard.payment.contact.data');
        //$arrData = json_decode(json_encode($OjbData), True);
        $data = $this->input->post->get('jform', array(), 'array');
        //$resultData = array_merge($arrData, $data);

        $model = $this->getModel('payment');
        $aResult = $model->sendReserve($data);
        $aResult['layout'] = "request";
        // Flush the data from the session
        // $app->setUserState('com_standard.payment.contact.data', null);
        // Set Redirect - Result Data
        $app->setUserState("com_standard.result.data", $aResult);
        $this->setRedirect(JRoute::_('index.php?option=com_standard&view=confirm'));
    }

    public function request() {
        // Check for request forgeries.
        $this->checkToken();
        $app = JFactory::getApplication();
        // recaptcha Check Answer
        $this->recaptchaCheckAnswer();

        $aData = $this->input->post->get('jform', array(), 'array');

        $modelItinerary = $this->getModel('itinerary');
        $aData['infoitinerary'] = clone $modelItinerary->getItem($aData['tour_id']);

        $model = $this->getModel('payment');
        $aResult = $model->sendRequest($aData);
        // Set Redirect - Result Data
        $app->setUserState("com_standard.result.data", $aResult);
        $this->setRedirect(JRoute::_(StandardHelperRoute::getLinkMenuItemRoute("index.php?option=com_standard&view=confirm&id={$aResult['confirm_page_type_id']}")));
    }

    public function promotionRequest() {
        // Check for request forgeries.
        $this->checkToken();
        $app = JFactory::getApplication();
        // recaptcha Check Answer
        $this->recaptchaCheckAnswer();

        $aData = $this->input->post->get('jform', array(), 'array');

        // $modelPromotion = $this->getModel('promotion');
        // $aData['infopromotion'] = clone $modelPromotion->getItem($aData['tour_id']);

        $model = $this->getModel('payment');
        $aResult = $model->sendPromotionRequest($aData);
        // Set Redirect - Result Data
        $app->setUserState("com_standard.result.data", $aResult);
        $this->setRedirect(JRoute::_(StandardHelperRoute::getLinkMenuItemRoute("index.php?option=com_standard&view=confirm&id={$aResult['confirm_page_type_id']}")));
    }

    public function contact() {
        // Check for request forgeries.
        $this->checkToken();
        $app = JFactory::getApplication();
        // recaptcha Check Answer
        $this->recaptchaCheckAnswer();

        $aData = $this->input->post->get('jform', array(), 'array');

        if (isset($aData['tour_id'])):
            $modelItinerary = $this->getModel('itinerary');
            $aData['infoitinerary'] = clone $modelItinerary->getItem($aData['tour_id']);
        endif;

        $model = $this->getModel('payment');
        $aResult = $model->sendContact($aData);
        // Set Redirect - Result Data
        $app->setUserState("com_standard.result.data", $aResult);
        $this->setRedirect(JRoute::_(StandardHelperRoute::getLinkMenuItemRoute("index.php?option=com_standard&view=confirm&id={$aResult['confirm_page_type_id']}")));
        // $this->setRedirect(JRoute::_('index.php?option=com_standard&view=confirm'));
    }

    public function quickcontact() {
        // Check for request forgeries.
        $this->checkToken();
        $app = JFactory::getApplication();

        $data = $this->input->post->get('jform', array(), 'array');
        $model = $this->getModel('payment');
        $result = $model->sendQuickContact($data);

        $message = "";
        if (!$result) {
            $message = "Error";
        }

        // Flush the data from the session
        $app->setUserState('com_standard.layout', 'quickcontactrequest');

        $this->setRedirect(JRoute::_('index.php?option=com_standard&view=confirm'));
    }

    public function subscribe() {
        // Check for request forgeries.
        $this->checkToken();
        $app = JFactory::getApplication();

        $aData = $this->input->post->get('jform', array(), 'array');
        $model = $this->getModel('payment');
        $aResult = $model->saveInfomation($aData);
        // Set Redirect - Result Data
        $app->setUserState("com_standard.result.data", $aResult);
        $this->setRedirect(JRoute::_(StandardHelperRoute::getLinkMenuItemRoute("index.php?option=com_standard&view=confirm&id={$aResult['confirm_page_type_id']}")));
    }

    public function recaptchaCheckAnswer() {
        $app = JFactory::getApplication();
        $captchaSet = $app->get('captcha', '0');
        foreach (JPluginHelper::getPlugin('captcha') as $plugin) {
            if ($captchaSet === $plugin->name) {
                $post = JRequest::get('post');
                JPluginHelper::importPlugin('captcha');
                $dispatcher = JDispatcher::getInstance();
                $res = $dispatcher->trigger('onCheckAnswer', $post['g-recaptcha-response']);
                if (!$res[0]) {
                    $app->enqueueMessage(JText::_('PLG_RECAPTCHA_ERROR_EMPTY_SOLUTION'), JText::_('Invalid Captcha'));
                    $app->redirect(htmlspecialchars(JUri::getInstance()->toString()));
                    return false;
                }

                break;
            }
        }
        return true;
    }

    public function registrationJS() {
        $app = JFactory::getApplication();
        $aData = JRequest::get('post');
        $model = $this->getModel('payment');
        $aResult = $model->sendRegistration($aData);
        echo $aResult['status'];
        $app->close();
    }

}
