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
class LayoutElementField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'LayoutElement';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        'using-max-width' => 'EXTRA_SMALL',
        'using-max-width-sm' => 'SMALL',
        'using-max-width-md' => 'MEDIUM',
        'using-max-width-lg' => 'LARGE'
    );

}
