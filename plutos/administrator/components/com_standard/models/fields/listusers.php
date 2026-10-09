<?php
defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldListUsers extends JFormFieldList {

    protected $type = 'ListUsers';

    protected function getInput() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('u.id AS value, u.name AS text');
        $query->from('#__users AS u');
       // $query->where('u.published IN (1)');
        //$query->leftJoin('#__travel_agents AS ta');
       // $query->where('u.id <> ta.user_id ');
        $query->order('u.name');
        // Get the options.
        $db->setQuery($query);
        $data = $db->loadObjectList();

        $html = "<select name='{$this->name}' class='{$this->class}' >";
        $html.='<option value="0">' . JText::_("Select a user") . '</option>';
        foreach ($data as $value) {
            $select = (intval($this->value) == intval($value->value)) ? " selected" : "";
            $html.="<option value='{$value->value}' {$select}>{$value->text}</option>";
        }
        return $html . "</select>";
    }

}
