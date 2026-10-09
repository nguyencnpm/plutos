<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Methods supporting a list of Travel agent group records.
 *
 * @since  1.6
 */
class StandardModelUsergroups extends JModelList {

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'tag.id',
                'parent_id', 'tag.parent_id',
                'title', 'tag.title',
                'lft', 'tag.lft',
                'rgt', 'tag.rgt',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function populateState($ordering = 'tag.lft', $direction = 'asc') {
        $app = JFactory::getApplication();

        $forcedLanguage = $app->input->get('forcedLanguage', '', 'cmd');

        // Adjust the context to support modal layouts.
        if ($layout = $app->input->get('layout')) {
            $this->context .= '.' . $layout;
        }

        // Adjust the context to support forced languages.
        if ($forcedLanguage) {
            $this->context .= '.' . $forcedLanguage;
        }
        // Load the filter state.
        $this->setState('filter.search', $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search', '', 'string'));

        // Load the parameters.
        $params = JComponentHelper::getParams('com_standard');
        $this->setState('params', $params);

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string  $id  A prefix for the store id.
     *
     * @return  string  A store id.
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');

        return parent::getStoreId($id);
    }

    /**
     * Gets the list of groups and adds expensive joins to the result set.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   1.6
     */
    public function getItems() {
        // Get a storage key.
        $store = $this->getStoreId();

        // Try to load the data from internal storage.
        if (empty($this->cache[$store])) {
            $items = parent::getItems();

            // Bail out on an error or empty list.
            if (empty($items)) {
                $this->cache[$store] = $items;

                return $items;
            }

            try {
                $items = $this->populateExtraData($items);
            } catch (RuntimeException $e) {
                $this->setError($e->getMessage());

                return false;
            }

            // Add the items to the internal cache.
            $this->cache[$store] = $items;
        }

        return $this->cache[$store];
    }

    /**
     * Build an SQL query to load the list datag.
     *
     * @return  JDatabaseQuery
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'tag.*'
                )
        );
        $query->from($db->quoteName('#__usergroups') . ' AS tag');
        // Join over the categories.
        $query->select('cgug.contractgroup_id, cg.title AS contractgroup_title');
        $query->join("LEFT", "#__standard_contractgroup_usergroup_map AS cgug ON tag.id = cgug.usergroup_id");
        $query->join("LEFT", "#__standard_contractgroups AS cg ON cgug.contractgroup_id = cg.id and cg.state=1");

        // List category
        $query->select('GROUP_CONCAT("<b>", UCASE(h.code), "</b>" , " - ", h.title SEPARATOR "\n") AS listcategory, GROUP_CONCAT(h.code SEPARATOR ", ") AS listcategorycode');
        $query->join("LEFT", "#__standard_usergroup_categories_map AS map ON tag.id = map.usergroup_id");
        $query->join("LEFT", "#__standard_categories AS h ON map.catid = h.id and h.published=1");

        // Filter the comments over the search string if set.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('tag.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('tag.title LIKE ' . $search);
            }
        }

        // Group by on standard_usergroup_categories_map for JOIN with component tables to Mapping items
        $query->group("tag.id");

        // Add the list ordering clause.
        $query->order($db->escape($this->getState('list.ordering', 'tag.lft')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
//        echo nl2br(str_replace('#__', 'hicq6_', $query));
//        exit;
        return $query;
    }

    /**
     * Populate level & path for items.
     *
     * @param   array  $items  Array of stdClass objects
     *
     * @return  array
     *
     * @since   3.6.3
     */
    private function populateExtraData(array $items) {
        // First pass: get list of the group id's and reset the counts.
        $groupsByKey = array();

        foreach ($items as $item) {
            $groupsByKey[(int) $item->id] = $item;
        }

        $groupIds = array_keys($groupsByKey);

        $db = $this->getDbo();

        // Get List discount and total enabled users in group.
        $query = $db->getQuery(true);
        /*
        // List discount
        // Group by the objects in the discounts group.
        $query->select('dug.usergroup_id as group_id, d.value , d.value_mathop, d.currency_id')
                ->from($db->quoteName('#__standard_discount_usergroups', 'dug'))
                ->join('LEFT', $db->quoteName('#__standard_discounts', 'd') . ' ON ' . $db->quoteName('dug.discount_id') . ' = ' . $db->quoteName('d.id'))
                ->where($db->quoteName('dug.usergroup_id') . ' IN (' . implode(',', $groupIds) . ')')
                ->where($db->quoteName('d.state') . ' = 1')
                ->order('dug.usergroup_id ASC, d.value DESC');
        $db->setQuery($query);


        try {
            $temp_discount_usergroups = $db->loadAssocList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        $discount_usergroups = array();
        $row = null;
        $group_id = 0;
        foreach ($temp_discount_usergroups as $key => $value) {
            if ((int) $value['group_id'] != $group_id) {
                $group_id = (int) $value['group_id'];
                $row = &$discount_usergroups[$group_id];
            }
            $row[] = $temp_discount_usergroups[$key];
        }
        */
        // List contract detail
        // Group by the objects in the contracts contract.
        $query->clear(); // clear all
        $query->select('cgug.usergroup_id as group_id, cd.*, ct.title as contract_title, ct.catid as contract_catid, ct.currency_id as contract_currency_id')
                ->from($db->quoteName('#__standard_contractrate_details', 'cd'))
                ->join("LEFT", $db->quoteName('#__standard_contractrates', 'ct') . ' ON ' . $db->quoteName('cd.contractrate_id') . ' = ' . $db->quoteName('ct.id'))
                ->join('LEFT', $db->quoteName('#__standard_contractgroup_usergroup_map', 'cgug') . ' ON ' . $db->quoteName('cgug.contractgroup_id') . ' = ' . $db->quoteName('ct.contractgroup_id'));
        // Join over the categories.
        $query->select('h.title AS category_title')
                ->join('LEFT', '#__standard_categories AS h ON h.id = ct.catid');

        // products in Contract
        $query->select('GROUP_CONCAT("<b>", UCASE(rt.code), "</b>" , " - ", rt.title SEPARATOR "<br />") AS products')
                ->join("LEFT", $db->quoteName('#__standard_productcontractrate_map', 'map') . ' ON ' . $db->quoteName('map.contractrate_id') . ' = ' . $db->quoteName('ct.id'))
                ->join('LEFT', $db->quoteName('#__standard_products', 'rt') . ' ON ' . $db->quoteName('rt.id') . ' = ' . $db->quoteName('map.product_id'));

        $query->where($db->quoteName('ct.state') . ' IN (1)')
                ->where($db->quoteName('cgug.usergroup_id') . ' IN (' . implode(',', $groupIds) . ')')
                // products
                ->where($db->quoteName('rt.state') . ' IN(0, 1)')
                ->group('cgug.usergroup_id, cd.contractrate_id, cd.id') // GROUP_CONCAT - products
                
                ->order('cgug.usergroup_id ASC, cd.contractrate_id ASC');
        $db->setQuery($query);
        //echo nl2br(str_replace('#__', 'hicq6_', $query));
        //exit;
        try {
            $temp_contractDetails = $db->loadAssocList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        $contractDetails = array();
        $rowcd = null;
        $contractgroup_id = 0;
        foreach ($temp_contractDetails as $key => $value) {
            if ((int) $value['group_id'] != $contractgroup_id) {
                $contractgroup_id = (int) $value['group_id'];
                $rowcd = &$contractDetails[$contractgroup_id];
            }
            $rowcd[] = $temp_contractDetails[$key];
        }
        
        //echo '<pre>';
        //print_r($contractDetails);
        //exit;
        
        // total contracts in contract group.
        $query->clear(); // clear all
        $query->select('cgug.usergroup_id as group_id, ct.contractgroup_id, COUNT(ct.id) AS contract_count')
                ->from($db->quoteName('#__standard_contractrates', 'ct'))
                ->join('LEFT', $db->quoteName('#__standard_contractgroup_usergroup_map', 'cgug') . ' ON ' . $db->quoteName('cgug.contractgroup_id') . ' = ' . $db->quoteName('ct.contractgroup_id'));
        $query->where($db->quoteName('ct.state') . ' IN (1)')
                ->where($db->quoteName('cgug.usergroup_id') . ' IN (' . implode(',', $groupIds) . ')')
                ->group('cgug.usergroup_id, ct.contractgroup_id');
        //echo nl2br(str_replace('#__', 'hicq6_', $query));
        //exit;
        try {
            $countContractPublished = $db->loadAssocList('group_id', 'count_contractPublished');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }
        //echo '<pre>';
        //print_r($countContractPublished);
        //exit;
        // total enabled users in group
        // Count the objects in the Travel agent group.
        $query->clear(); // clear all
        $query->select('map.group_id, COUNT(DISTINCT map.user_id) AS user_count')
                ->from($db->quoteName('#__user_usergroup_map', 'map'))
                ->join('LEFT', $db->quoteName('#__users', 'u') . ' ON ' . $db->quoteName('u.id') . ' = ' . $db->quoteName('map.user_id'))
                ->where($db->quoteName('map.group_id') . ' IN (' . implode(',', $groupIds) . ')')
                ->where($db->quoteName('u.block') . ' = 0')
                ->group($db->quoteName('map.group_id'));
        $db->setQuery($query);

        try {
            $countEnabled = $db->loadAssocList('group_id', 'count_enabled');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Get total disabled users in group.
        $query->clear('where')
                ->where('map.group_id IN (' . implode(',', $groupIds) . ')')
                ->where('u.block = 1');
        $db->setQuery($query);

        try {
            $countDisabled = $db->loadAssocList('group_id', 'count_disabled');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Inject the values back into the array.
        foreach ($groupsByKey as &$item) {
            $item->list_discount = isset($discount_usergroups[$item->id]) ? $discount_usergroups[$item->id] : array();
            $item->count_contractPublished = isset($countContractPublished[$item->id]) ? (int) $countContractPublished[$item->id]['contract_count'] : 0;
            $item->list_contract_detail = isset($contractDetails[$item->id]) ? $contractDetails[$item->id] : array();
            $item->count_enabled = isset($countEnabled[$item->id]) ? (int) $countEnabled[$item->id]['user_count'] : 0;
            $item->count_disabled = isset($countDisabled[$item->id]) ? (int) $countDisabled[$item->id]['user_count'] : 0;
            $item->user_count = $item->count_enabled + $item->count_disabled;
        }

        $groups = new JHelperUsergroups($groupsByKey);

        return array_values($groups->getAll());
    }

}
