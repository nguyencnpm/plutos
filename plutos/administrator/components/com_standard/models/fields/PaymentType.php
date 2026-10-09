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
class PaymentTypeField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'PaymentType';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        '1' => 'COM_STANDARD_PAYMENT_METHOD_SEND_CONTACT'
        //, '2' => 'COM_STANDARD_PAYMENT_METHOD_SEND_REQUEST'
        //, '3' => 'COM_STANDARD_PAYMENT_METHOD_SEND_ENQUIRY'
        //, '4' => 'COM_STANDARD_PAYMENT_METHOD_SEND_REQUEST_QUICK_CONTACT'
        //, '5' => 'COM_STANDARD_PAYMENT_METHOD_ORDER_CONFIRMATION'
        // '6' => 'COM_STANDARD_PAYMENT_METHOD_SEND_RESERVE'
        // , '7' => 'COM_STANDARD_PAYMENT_METHOD_CREDIT'
        // , '8' => 'COM_STANDARD_PAYMENT_METHOD_ONLINE_PAYMENT'
        //, '9' => 'COM_STANDARD_PAYMENT_METHOD_PAYMENT_OFFLINE'
        //, '10' => 'COM_STANDARD_PAYMENT_METHOD_SEND_BOOKING_PACKAGE'
        , '11' => 'COM_STANDARD_PAYMENT_METHOD_LINK_TO_BOOKING_SITE'
    );

}
