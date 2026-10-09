<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldListManufacturers extends JFormFieldList {

    /**
     * The form field type.
     *
     * @var		string
     * @since	1.6
     */
    protected $type = 'ListManufacturers';

    /**
     * Method to get the field options.
     *
     * @return	array	The field option objects.
     * @since	1.6
     */
    protected function getOptions() {
        // Initialise variables.
        $options = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("id AS value, title AS text");
        $query->from('#__standard_manufacturers');
        $query->where('state = 1');
        // Get the options.
        $db->setQuery($query);
        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }
        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}