<?php

namespace Joomla\CMS\Form\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Component\ComponentHelper;

FormHelper::loadFieldClass('list');


class AgentsField extends \JFormFieldList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'Agents';

    /**
     * Cached array of the Agents items.
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
                    ->select('id AS value, title AS text')
                    ->from('#__standard_agents')
                    ->where('state IN (0,1,2)')
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