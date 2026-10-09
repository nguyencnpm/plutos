<?php
defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldListCountries extends JFormFieldList {

    protected $type = 'ListCountries';

    protected function getInput() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('ct.id AS value, ct.title AS text');
        $query->from('#__standard_countries AS ct');
        $query->where('ct.published IN (1)');
        $query->order('ct.title');
        // Get the options.
        $db->setQuery($query);
        $data = $db->loadObjectList();

        $html = "<select name='{$this->name}' class='{$this->class}' disabled='{$this->disabled}'>";
        $html.='<option value="0">' . JText::_("Select a country") . '</option>';
        foreach ($data as $value) {
            $select = (intval($this->value) == intval($value->value)) ? " selected" : "";
            $html.="<option value='{$value->value}' {$select}>{$value->text}</option>";
        }
        return $html . "</select>";
    }

}
