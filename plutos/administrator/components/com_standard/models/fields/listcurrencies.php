<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldListCurrencies extends JFormFieldList {

    /**
     * The form field type.
     *
     * @var		string
     * @since	1.6
     */
    protected $type = 'ListCurrencies';

    /**
     * Method to get the field options.
     *
     * @return	array	The field option objects.
     * @since	1.6
     */
    /*
    protected function getOptions() {
        // Initialise variables.
        $options = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("id AS value, title AS text");
        $query->from('#__standard_currencies');
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
    */
    protected function getInput() {
        // Initialise variables.
        $options = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("id AS value, title AS text");
        $query->from('#__standard_currencies');
        $query->where('state = 1');
        // Get the options.
        $db->setQuery($query);
        $options = $db->loadObjectList();
        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }
        $disabled = "";
        if($this->readonly){
            $disabled= "disabled={$this->readonly}";
        }
        $html = "<select name='{$this->name}' class='{$this->class}' {$disabled} >";
        $html.='<option value="0">' . JText::_("COM_STANDARD_SELECT_CURRENCY") . '</option>';
        foreach ($options as $value) {
            $select = (intval($this->value) == intval($value->value)) ? " selected" : "";
            $html.="<option value='{$value->value}' {$select}>{$value->text}</option>";
        }
        return $html . "</select>";
        
    }

}