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
 * Methods supporting a list of article records.
 *
 * @since  1.6
 */
// [name component]<Model>[name Model]
class StandardModelContractgroups extends JModelList {

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @since   1.6
     * @see     JController
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'ctg.id',
                'title', 'ctg.title',
                'alias', 'ctg.alias',
                'user_id', 'ctg.user_id',
                'hotel_id', 'ctg.hotel_id',
                'telephone', 'ctg.telephone',
                'mobile', 'ctg.mobile',
                'fax', 'ctg.fax',
                'email', 'ctg.email',
                'address', 'ctg.address',
                'checked_out_time', 'ctg.checked_out_time',
                'state', 'ctg.state',
                'access', 'ctg.access', 'access_level',
                'created', 'ctg.created',
                'created_by', 'ctg.created_by',
                'created_by_alias', 'ctg.created_by_alias',
                'ordering', 'ctg.ordering',
                'language', 'ctg.language',
                'published', 'ctg.published',
                'author_id'
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
    protected function populateState($ordering = 'ctg.id', $direction = 'desc') {
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

        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access');
        $this->setState('filter.access', $access);

        $authorId = $app->getUserStateFromRequest($this->context . '.filter.author_id', 'filter_author_id');
        $this->setState('filter.author_id', $authorId);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        $language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
        $this->setState('filter.language', $language);

        // List state information.
        parent::populateState($ordering, $direction);

        // Force a language
        if (!empty($forcedLanguage)) {
            $this->setState('filter.language', $forcedLanguage);
            $this->setState('filter.forcedLanguage', $forcedLanguage);
        }
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
     *
     * @since   1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.access');
        $id .= ':' . $this->getState('filter.published');
        $id .= ':' . $this->getState('filter.author_id');
        $id .= ':' . $this->getState('filter.language');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $user = JFactory::getUser();
        $app = JFactory::getApplication();

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', ' ctg.id, ctg.title, ctg.alias'
                        . ', ctg.checked_out, ctg.checked_out_time, ctg.state, ctg.access'
                        . ', ctg.created, ctg.created_by, ctg.created_by_alias, ctg.ordering, ctg.language'
                )
        );
        $query->from('#__standard_contractgroups AS ctg');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = ctg.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=ctg.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = ctg.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = ctg.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('ctg.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('ctg.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('ctg.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(ctg.state = 0 OR ctg.state = 1)');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('ctg.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('ctg.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(ctg.title LIKE ' . $search . ' OR ctg.alias LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('ctg.language = ' . $db->quote($language));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'ctg.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        // SQL server change
        if ($orderCol == 'language') {
            $orderCol = 'l.title';
        }

        if ($orderCol == 'access_level') {
            $orderCol = 'ag.title';
        }

        // Group by on standard_travelagent_hotel_map for JOIN with component tables to Mapping items
        $query->group("ctg.id");

        $query->order($db->escape($orderCol . ' ' . $orderDirn));

//        echo nl2br(str_replace('#__', 'hicq6_', $query));
//        exit;

        return $query;
    }

    /**
     * Build a list of authors
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    public function getAuthors() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('u.id AS value, u.name AS text')
                ->from('#__users AS u')
                ->join('INNER', '#__standard_contractgroups AS ctg ON ctg.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    /**
     * Method to get a list of articles.
     * Overridden to add a check for access levels.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   1.6.1
     */
    public function getItems() {
        $items = parent::getItems();
        /*
          if (JFactory::getApplication()->isSite()) {
          $user = JFactory::getUser();
          $groups = $user->getAuthorisedViewLevels();

          for ($x = 0, $count = count($items); $x < $count; $x++) {
          // Check the access level. Remove articles the user shouldn't see
          if (!in_array($items[$x]->access, $groups)) {
          unset($items[$x]);
          }
          }
          }
         */
        if (!empty($items)) {
            $items = $this->populateExtraData($items);
        }
        return $items;
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
        // First pass: get list of the contractgroup id's and reset the counts.
        $contractgroupsByKey = array();

        foreach ($items as $item) {
            $contractgroupsByKey[(int) $item->id] = $item;
        }

        $contractgroupIds = array_keys($contractgroupsByKey);

        $db = $this->getDbo();

        // Get total published contracts in contractgroup.
        $query = $db->getQuery(true);

        /*
         * === count Items ===
         * count_published;
         * count_unpublished;
         * count_archived;
         * count_trashed;         
         */
        // Count the objects in the contract contractgroup.
        $query->select('ct.contractgroup_id, COUNT(ct.id) AS contract_count') // COUNT(DISTINCT ct.id)
                ->from($db->quoteName('#__standard_contractrates', 'ct'))
                ->where($db->quoteName('ct.contractgroup_id') . ' IN (' . implode(',', $contractgroupIds) . ')')
                ->where($db->quoteName('ct.state') . ' = 1')
                ->group($db->quoteName('ct.contractgroup_id'));
        $db->setQuery($query);
        //echo nl2br(str_replace('#__', 'hicq6_', $query));
        //exit;
        try {
            $countPublished = $db->loadAssocList('contractgroup_id', 'count_published');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Get total unpublished contracts in contractgroup.
        $query->clear('where')
                ->where('ct.contractgroup_id IN (' . implode(',', $contractgroupIds) . ')')
                ->where($db->quoteName('ct.state') . ' = 0');
        $db->setQuery($query);

        try {
            $countUnpublished = $db->loadAssocList('contractgroup_id', 'count_unpublished');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Get total archived contracts in contractgroup.
        $query->clear('where')
                ->where('ct.contractgroup_id IN (' . implode(',', $contractgroupIds) . ')')
                ->where($db->quoteName('ct.state') . ' = 2');
        $db->setQuery($query);

        try {
            $countArchived = $db->loadAssocList('contractgroup_id', 'count_archived');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Get total trashed contracts in contractgroup.
        $query->clear('where')
                ->where('ct.contractgroup_id IN (' . implode(',', $contractgroupIds) . ')')
                ->where($db->quoteName('ct.state') . ' = -2');
        $db->setQuery($query);

        try {
            $countTrashed = $db->loadAssocList('contractgroup_id', 'count_trashed');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // List contract detail
        // Group by the objects in the contracts contract.
        $query->clear(); // clear all
        $query->select('ct.contractgroup_id'
                        . ', ct.code'
                        . ', ct.title as contract_title'
                        . ', ct.id as contract_id'
                        . ', ct.currency_id as contract_currency_id'
                        . ', cd.*'
                        . '')
                ->from($db->quoteName('#__standard_contractrate_details', 'cd'))
                ->join("LEFT", $db->quoteName('#__standard_contractrates', 'ct') . ' ON ' . $db->quoteName('cd.contractrate_id') . ' = ' . $db->quoteName('ct.id'));
        // Join over the categories.
        $query->select('c.title AS category_title')
                ->join('LEFT', '#__standard_categories AS c ON c.id = ct.catid');
        
        // product in Contract
        $query->select('map.contractrate_id, GROUP_CONCAT("<b>", UCASE(rt.code), "</b>" , " - ", rt.title SEPARATOR "<br />") AS listproduct')
                ->join("LEFT", $db->quoteName('#__standard_productcontractrate_map', 'map') . ' ON ' . $db->quoteName('map.contractrate_id') . ' = ' . $db->quoteName('ct.id'))
                ->join('LEFT', $db->quoteName('#__standard_products', 'rt') . ' ON ' . $db->quoteName('rt.id') . ' = ' . $db->quoteName('map.product_id'));

        $query->where($db->quoteName('ct.state') . ' IN (1)')
                ->where($db->quoteName('ct.contractgroup_id') . ' IN (' . implode(',', $contractgroupIds) . ')')
                // listproduct
                ->where($db->quoteName('rt.state') . ' IN(0, 1)')
                ->group($db->quoteName('cd.id')) // GROUP_CONCAT - listproduct
                
                ->order('ct.contractgroup_id ASC, cd.contractrate_id ASC');
        $db->setQuery($query);
        // echo nl2br(str_replace('#__', 'hicq6_', $query));
        // exit;
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
            if ((int) $value['contractgroup_id'] != $contractgroup_id) {
                $contractgroup_id = (int) $value['contractgroup_id'];
                $rowcd = &$contractDetails[$contractgroup_id];
            }
            $rowcd[] = $temp_contractDetails[$key];
        }
//        echo '<pre>';
//        print_r($contractDetails);
//        exit;
        // Joining the groups with the main query is a performance hog.
        /*
         * usergroup_count = 0
         * usergroup_names = ''
         */
        // Join over the group mapping table.
        $query->clear(); // clear all 
        $query->select('map.contractgroup_id, COUNT(map.usergroup_id) AS usergroup_count, GROUP_CONCAT(ug.title SEPARATOR "\n") AS usergroup_names')
                ->from('#__standard_contractgroup_usergroup_map AS map')
                ->where('map.contractgroup_id IN (' . implode(',', $contractgroupIds) . ')')
                ->group('map.contractgroup_id')
                // Join over the user groups table.
                ->join('LEFT', '#__usergroups AS ug ON ug.id = map.usergroup_id');

        $db->setQuery($query);

        // Load the counts into an array indexed on the user id field.
        try {
            $userGroups = $db->loadAssocList('contractgroup_id', 'user_groups');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Inject the values back into the array.
        foreach ($contractgroupsByKey as &$item) {
            $item->count_published = isset($countPublished[$item->id]) ? (int) $countPublished[$item->id]['contract_count'] : 0;
            $item->count_unpublished = isset($countUnpublished[$item->id]) ? (int) $countUnpublished[$item->id]['contract_count'] : 0;
            $item->count_archived = isset($countArchived[$item->id]) ? (int) $countArchived[$item->id]['contract_count'] : 0;
            $item->count_trashed = isset($countTrashed[$item->id]) ? (int) $countTrashed[$item->id]['contract_count'] : 0;
            $item->contract_count = $item->count_published + $item->count_unpublished + $item->count_archived + $item->count_trashed;
            $item->list_contract_detail = isset($contractDetails[$item->id]) ? $contractDetails[$item->id] : array();
            $item->user_groups = isset($userGroups[$item->id]) ? $userGroups[$item->id] : array();
        }

        return array_values($contractgroupsByKey);
    }

}
