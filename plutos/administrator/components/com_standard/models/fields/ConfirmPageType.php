<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\Form\Field;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('predefinedlist');

/**
 * Form Field to load a list of states
 *
 * @since  3.2
 */
class ConfirmPageTypeField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'ConfirmPageType';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        '1' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_SEND_CONTACT'
        , '2' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_SEND_REQUEST'
        , '3' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_SEND_ENQUIRY'
        //, '4' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_SEND_REQUEST_QUICK_CONTACT'
        //, '5' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_ORDER_CONFIRMATION'
        //, '6' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_SEND_RESERVE'
        //, '7' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_CREDIT'
        //, '8' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_ONLINE_PAYMENT'
        //, '9' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_PAYMENT_OFFLINE'
        //, '10' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_SEND_BOOKING_PACKAGE'
        //, '11' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_LINK_TO_BOOKING_SITE'
        , '12' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_SEND_PROMOTION'
        , '13' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_SUBSCRIBE'
        , '14' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_PAYMENT_SUCCESS'
        , '15' => 'COM_STANDARD_CONFIRM_PAGE_TYPE_PAYMENT_FAILED'
    );

}
