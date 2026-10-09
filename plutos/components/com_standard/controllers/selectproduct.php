<?php

/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

if (!class_exists('Convert')) {
    jimport('informationtechnology.convert');
}

/**
 * Standard Component Controller
 *
 * @since  1.5
 */
class StandardControllerSelectproduct extends JControllerForm {

    /**
     * The URL view item variable.
     *
     * @var    string
     * @since  1.6
     */
    protected $view_item = 'form';

    /**
     * The URL view list variable.
     *
     * @var    string
     * @since  1.6
     */
    protected $view_list = 'categories';

    /**
     * The URL edit variable.
     *
     * @var    string
     * @since  3.2
     */
    protected $urlVar = 'p.id';

    public function __construct($config = array()) {
        parent::__construct($config);

        // $this->view_list = 'product';
    }

    public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }

    public function getRedirectToItemRequest() {
        // Check for request forgeries.
        $this->checkToken();

        $app = JFactory::getApplication();

        $lang = JFactory::getLanguage();
        $lang_codes = JLanguageHelper::getLanguages('lang_code');
        $lang_sef = $lang_codes[$lang->getTag()]->sef;

        // $data = $this->input->post->get('jform', array(), 'array');
        $aPost = JRequest::get('post');
        $data = $aPost['jform'];
        $paymenttype_id = 0;
        switch (strtolower($aPost['check'])) {
            case 'itinerary':
                $this->option = "com_standard";
                $this->view_item = "itinerary";
                $modelItinerary = $this->getModel('Itinerary');
                $oItinerary = $modelItinerary->getItem($data['tour_id']);
                $paymenttype_id = $oItinerary->paymenttype_id;

                $nowDate = JFactory::getDate()->toSql();
                $checkInDate = JHtml::_('date', $nowDate, 'd-m-Y');
                $oDate = new JDate($checkInDate . ' +' . $oItinerary->number_days . ' day'); // number_nights
                $checkOutDate = $oDate->format('d-m-Y');

                $data['contact_adult'] = $oItinerary->adult;
                $data['contact_children'] = $oItinerary->children;
                $data['contact_infant'] = $oItinerary->infant;

                /*
                  $modelProduct = $this->getModel('Product');
                  $oProduct = $modelProduct->getItem($oItinerary->product_id);
                 */

                break;

            case 'product':
                $modelProduct = $this->getModel('Product');
                $oProduct = $modelProduct->getItem($data['product_id']);
                $paymenttype_id = $oProduct->paymenttype_id;

                $nowDate = JFactory::getDate()->toSql();
                $checkInDate = JHtml::_('date', $nowDate, 'd-m-Y');
                $oDate = new JDate($checkInDate . ' +1 day');
                $checkOutDate = $oDate->format('d-m-Y');

                break;
            case 'checkavailability':
            default:
                $checkInDate = Convert::getConvertDate($data['contact_checkin'], 'd-m-Y');

                $oDate = new JDate($checkInDate . ' +1 day');
                $checkOutDate = $oDate->format('d-m-Y');

                $this->option = "com_standard";
                $this->view_item = "itinerary";
                $modelItinerary = $this->getModel('Itinerary');
                $oItinerary = $modelItinerary->getItem($data['tour_id']);
                $paymenttype_id = $oItinerary->paymenttype_id;
                /*
                $modelProduct = $this->getModel('Product');
                $oProduct = $modelProduct->getItem($oItinerary->product_id);
                */
                break;
        }

        if ((int) $paymenttype_id === 11):
            $this->isForm = 0;
            $url = "https://app-apac.thebookingbutton.com/properties/lazaleecruisesdirect?";
            $url .= "locale={$lang_sef}";
            $url .= "&check_in_date={$checkInDate}";
            $url .= "&check_out_date={$checkOutDate}";

            if (isset($data['coifntact_adult'])):
                $url .= "&number_adults={$data['coifntact_adult']}";
            endif;

            if (isset($data['contact_children'])):
                $url .= "&number_children={$data['contact_children']}";
            endif;

            if (isset($data['contact_infant'])):
                $url .= "&number_infant={$data['contact_infant']}";
            endif;


            $app->redirect($url); // , '_blank'

        else:
            $app->setUserState('com_standard.filter.tour_id', $oItinerary->id);
            $this->isForm = 1;
            // Redirect to the Request contact screen.
            $slug = $oItinerary->id . ':' . $oItinerary->alias;
            $link = JRoute::_(StandardHelperRoute::getItineraryRoute($slug, $oItinerary->itinerarytype_id, $oItinerary->language));
            $this->setRedirect($link);
        /*
          $this->setRedirect(
          JRoute::_(
          'index.php?option=' . $this->option . '&view=' . $this->view_item . '&id=' . $data['tour_id'], false
          )
          );
         */
        endif;

        return true;
    }

    /**
     * Gets the URL arguments to append to an item redirect.
     *
     * @param   integer  $recordId  The primary key id for the item.
     * @param   string   $urlVar    The name of the URL variable for the id.
     *
     * @return  string	The arguments to append to the redirect URL.
     *
     * @since   1.6
     */
    protected function getRedirectToItemAppend($recordId = null, $urlVar = 'i_id') {
        // Need to override the parent method completely.
        $tmpl = $this->input->get('tmpl');

        $append = '';

        // Setup redirect info.
        if ($tmpl) {
            $append .= '&tmpl=' . $tmpl;
        }

        // TODO This is a bandaid, not a long term solution.
        /**
         * if ($layout)
         * {
         * 	$append .= '&layout=' . $layout;
         * }
         */
        $append .= '&layout=edit';

        if ($recordId) {
            $append .= '&' . $urlVar . '=' . $recordId;
        }

        $itemId = $this->input->getInt('Itemid');
        $return = $this->getReturnPage();
        $catId = $this->input->getInt('catid');

        if ($itemId) {
            $append .= '&Itemid=' . $itemId;
        }

        if ($catId) {
            $append .= '&catid=' . $catId;
        }

        if ($return) {
            $append .= '&return=' . base64_encode($return);
        }

        return $append;
    }

    /**
     * Get the return URL.
     *
     * If a "return" variable has been passed in the request
     *
     * @return  string	The return URL.
     *
     * @since   1.6
     */
    protected function getReturnPage() {
        $return = $this->input->get('return', null, 'base64');

        if (empty($return) || !JUri::isInternal(base64_decode($return))) {
            return JUri::base();
        } else {
            return base64_decode($return);
        }
    }

    /**
     * Method to reload a record.
     *
     * @param   string  $key     The name of the primary key of the URL variable.
     * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
     *
     * @return  void
     *
     * @since   3.8.0
     */
    public function reload($key = null, $urlVar = 'i_id') {
        return parent::reload($key, $urlVar);
    }

}
