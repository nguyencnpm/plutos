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
class DisplayTypeField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'DisplayType';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        '0' => 'COM_STANDARDEXTENSION_USE_GLOBAL',
        '1' => 'COM_STANDARDEXTENSION_ARTICLE',
        '2' => 'COM_STANDARDEXTENSION_TREEVIEW',
        '3' => 'COM_STANDARDEXTENSION_GRID_WORKS',
        '4' => 'COM_STANDARDEXTENSION_MASONRY'
    );

}
