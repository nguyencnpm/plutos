<?php
/**
 * @author Binh Nguyen
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\CMS\Form\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Component\ComponentHelper;

FormHelper::loadFieldClass('list');


class RouteField extends \JFormFieldList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'Route';

    /**
     * Cached array of the Route items.
     *
     * @var    array
     * @since  3.2
     */
    protected static $options = array();

    /**
     * Method to get the options to populate list
     *
     * @return  array  The field option objects.
     *
     * @since   3.2
     */
    protected function getOptions() {
        // Accepted modifiers
        $hash = md5($this->element);

        if (!isset(static::$options[$hash])) {
            static::$options[$hash] = parent::getOptions();

            $db = Factory::getDbo();

            // Construct the query
            $query = $db->getQuery(true)
                    ->select('id AS value, title AS text, GROUP_CONCAT("data-dayOfWeek=", departure_day) as optionattr')
                    ->from('#__standard_routes')
                    ->where('state IN (1)')
                    ->group($db->quoteName('id'))
                    ->order('title');

            // Setup the query
            $db->setQuery($query);

            // Return the result
            if ($options = $db->loadObjectList()) {
                static::$options[$hash] = array_merge(static::$options[$hash], $options);
            }
        }

        return static::$options[$hash];
    }

}