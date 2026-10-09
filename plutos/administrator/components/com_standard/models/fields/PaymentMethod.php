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
class PaymentMethodField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'PaymentMethod';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        '1' => 'COM_STANDARD_PAYMENT_METHOD_PAYMENT_ONLINE',
        '2' => 'COM_STANDARD_PAYMENT_METHOD_SEND_RESERVE',
        '3' => 'COM_STANDARD_PAYMENT_METHOD_SEND_BOOKING_PACKAGE',
        '4' => 'COM_STANDARD_PAYMENT_METHOD_SEND_REQUEST',
        '5' => 'COM_STANDARD_PAYMENT_METHOD_PAYMENT_OFFLINE',
        '6' => 'COM_STANDARD_PAYMENT_METHOD_SEND_CONTACT',
        '7' => 'COM_STANDARD_PAYMENT_METHOD_SEND_ENQUIRY',
        '8' => 'COM_STANDARD_PAYMENT_METHOD_SEND_QUICK_CONTACT',
    );

}
