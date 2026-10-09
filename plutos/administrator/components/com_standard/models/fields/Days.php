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
class DaysField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'Days';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        '0' => 'SUNDAY',
        '1' => 'MONDAY',
        '2' => 'TUESDAY',
        '3' => 'WEDNESDAY',
        '4' => 'THURSDAY',
        '5' => 'FRIDAY',
        '6' => 'SATURDAY'
    );

}
