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
class StatusOrderField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'StatusOrder';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        '0' => 'COM_STANDARD_TOGGLE_UNPUBLISHED',
        '1' => 'COM_STANDARD_TOGGLE_PUBLISHED',
        '2' => 'COM_STANDARD_TOGGLE_ARCHIVE',
        '-2' => 'COM_STANDARD_TOGGLE_TRASH',
        '*' => 'JALL',
    );

}
