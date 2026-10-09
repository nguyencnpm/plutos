<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldListPromotions extends JFormFieldList {

    /**
     * The form field type.
     *
     * @var		string
     * @since	1.6
     */
    protected $type = 'ListPromotions';

    /**
     * Method to get the field options.
     *
     * @return	array	The field option objects.
     * @since	1.6
     */
    protected function getInput() {
        // Initialise variables.
        $options = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("id AS value, title AS text");
        $query->from('#__standard_promotions');
        $query->where('state = 1');
        // Get the options.
        $db->setQuery($query);
        $options = $db->loadObjectList();
        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }
        $html = "<select name='{$this->name}' class='{$this->class}'>";
        $html.='<option value="-1">' . JText::_("COM_STANDARD_PROMOTION_NONE") . '</option>';
        $html.='<option value="0">' . JText::_("COM_STANDARD_PROMOTION_NO_SPECIAL") . '</option>';
        foreach ($options as $value) {
            $select = (intval($this->value) == intval($value->value)) ? " selected" : "";
            $html.="<option value='{$value->value}' {$select}>{$value->text}</option>";
        }
        return $html . "</select>";
        
    }

}