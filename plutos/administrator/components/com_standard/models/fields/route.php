<?php

namespace Joomla\CMS\Form\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;

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
     * Cached array of the category items.
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
                    ->select('r.id AS value, GROUP_CONCAT(UPPER(r.code), " - ", lt_from.title, " To ", lt_to.title) AS text');
            $query->from('#__standard_routes AS r');

            // Join over the standard_locations for the locations.
            $query->join('LEFT', '#__standard_locations AS lt_from ON lt_from.id = r.from_id');

            // Join over the standard_locations for the locations.
            $query->join('LEFT', '#__standard_locations AS lt_to ON lt_to.id = r.to_id');

            $query->where('r.state IN (0,1,2)')
                    ->group($db->quoteName('r.id'))
                    ->order('lt_from.title desc');
            // Setup the query
            $db->setQuery($query);
            //echo nl2br(str_replace('#__', 'brle6_', $query));
            //exit;
            // Return the result
            if ($options = $db->loadObjectList()) {
                static::$options[$hash] = array_merge(static::$options[$hash], $options);
            }
        }

        return static::$options[$hash];
    }

}
