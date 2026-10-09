<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
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
class CalculationRuleField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'CalculationRule';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        'Marge' => 'COM_STANDARD_PRICE_MODIFIER_FOR_PROFIT_MARKUP',
        'DBTax' => 'COM_STANDARD_PRICE_MODIFIER_BEFORE_TAX',
        'Tax' => 'COM_STANDARD_TAX_PER_PRODUCT',
        'VatTax' => 'COM_STANDARD_VAT_TAX_PER_PRODUCT',
        'PortTax' => 'COM_STANDARD_PORT_TAX_PER_PRODUCT',
        'DATax' => 'COM_STANDARD_PRICE_MODIFIER_AFTER_TAX',
        'DBTaxBill' => 'COM_STANDARD_PRICE_MODIFIER_BEFORE_TAX_PER_BILL',
        'TaxBill' => 'COM_STANDARD_TAX_PER_BILL',
        'DATaxBill' => 'COM_STANDARD_PRICE_MODIFIER_AFTER_TAX_PER_BILL',
    );

}
