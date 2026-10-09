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
class TypeChartField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'TypeChart';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        'line' => 'LINE_CHART',
        'bar' => 'BAR_CHART',
        'horizontalBar' => 'HORIZONTAL_BAR_CHART',
        'radar' => 'RADAR_CHART',
        'pie' => 'PIE_CHART',
        'doughnut' => 'DOUGHNUT_CHART',
        'polarArea' => 'POLAR_AREA',
        'bubble' => 'BUBBLE_CHART',
        'scatter' => 'SCATTER_CHART'
    );

}
