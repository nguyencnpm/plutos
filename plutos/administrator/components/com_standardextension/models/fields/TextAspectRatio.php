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
class TextAspectRatioField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'TextAspectRatio';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        '1' => 'COM_STANDARDEXTENSION_TEXT_1BY1',
        '2' => 'COM_STANDARDEXTENSION_TEXT_2BY1',
        '3' => 'COM_STANDARDEXTENSION_TEXT_3BY1',
        '4' => 'COM_STANDARDEXTENSION_TEXT_4BY1'
    );

}
