<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Methods supporting a list of article records.
 *
 * @since  1.6
 */
// [name component]<Model>[name Model]
class StandardModelContractrates extends JModelList {

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
                'id', 'cr.id',
                'title', 'cr.title',
                'code', 'cr.code',
                'checked_out', 'cr.checked_out',
                'checked_out_time', 'cr.checked_out_time',
                'catid', 'cr.catid', 'category_title',
                'state', 'cr.state',
                'access', 'cr.access', 'access_level',
                'created', 'cr.created',
                'created_by', 'cr.created_by',
                'created_by_alias', 'cr.created_by_alias',
                'ordering', 'cr.ordering',
                'language', 'cr.language',
                'published', 'cr.published',
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
    protected function populateState($ordering = 'cr.id', $direction = 'desc') {
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

        $categoryId = $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id');
        $this->setState('filter.category_id', $categoryId);

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
        $id .= ':' . $this->getState('filter.category_id');
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
                        'list.select', ' cr.id, cr.title, cr.code, cr.currency_id'
                        . ' , cr.checked_out, cr.checked_out_time, cr.state, cr.access, cr.created, cr.created_by, cr.ordering, cr.language'
                )
        );
        $query->from('#__standard_contractrates AS cr');

        // Join over the contract group
        $query->select('cg.title AS contractgroup_title')
                ->join('LEFT', $db->quoteName('#__standard_contractgroups') . ' AS cg ON cg.id = cr.contractgroup_id');
        // Join over the categories.
        $query->select('c.title AS category_title')
                ->join('LEFT', '#__standard_categories AS c ON c.id = cr.catid');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = cr.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=cr.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = cr.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = cr.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('cr.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('cr.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('cr.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(cr.state = 0 OR cr.state = 1)');
        }

        // Filter by a single or group of contract groups.
        $contractgroupId = $this->getState('filter.contractgroup_id');

        if (is_numeric($contractgroupId)) {
            $query->where('cr.contractgroup_id = ' . (int) $contractgroupId);
        } elseif (is_array($contractgroupId)) {
            JArrayHelper::toInteger($contractgroupId);
            $contractgroupId = implode(',', $contractgroupId);
            $query->where('cr.contractgroup_id IN (' . $contractgroupId . ')');
        }
        
        // Filter by a single or group of categories.
        $baselevel = 1;
        $categoryId = $this->getState('filter.category_id');

        if (is_numeric($categoryId)) {
            //$cat_tbl = JTable::getInstance('Category', 'JTable');
            $cat_tbl = JTable::getInstance('Category', 'StandardTable');
            $cat_tbl->load($categoryId);
            $rgt = $cat_tbl->rgt;
            $lft = $cat_tbl->lft;
            $baselevel = (int) $cat_tbl->level;
            $query->where('c.lft >= ' . (int) $lft)
                    ->where('c.rgt <= ' . (int) $rgt);
        } elseif (is_array($categoryId)) {
            JArrayHelper::toInteger($categoryId);
            $categoryId = implode(',', $categoryId);
            $query->where('cr.catid IN (' . $categoryId . ')');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('cr.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('cr.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(cr.title LIKE ' . $search . ' OR cr.alias LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('cr.language = ' . $db->quote($language));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'cr.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'cr.ordering') {
            $orderCol = 'cr.title ' . $orderDirn . ', cr.ordering';
        }

        // SQL server change
        if ($orderCol == 'language') {
            $orderCol = 'l.title';
        }

        if ($orderCol == 'access_level') {
            $orderCol = 'ag.title';
        }

        $query->order($db->escape($orderCol . ' ' . $orderDirn));

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
                ->join('INNER', '#__standard_contractrates AS cr ON cr.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    /**
     * Method to get a list of contractrates.
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
          // Check the access level. Remove contractrates the user shouldn't see
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

    private function populateExtraData(array $items) {
        // First pass: get list of the contractrate id's and reset the counts.
        $contractratesByKey = array();
        foreach ($items as $item) {
            $contractratesByKey[(int) $item->id] = $item;
        }
        $contractrateIds = array_keys($contractratesByKey);

        $db = $this->getDbo();
        // Get List contractrate detail.
        $query = $db->getQuery(true);
        // List contractrate detail
        // Group by the objects in the contractrates cr.
        $query->select('rd.*')
                ->from($db->quoteName('#__standard_contractrate_details', 'rd'))
                ->where($db->quoteName('rd.contractrate_id') . ' IN (' . implode(',', $contractrateIds) . ')')
                ->order('rd.contractrate_id ASC, rd.start_date ASC');
        $db->setQuery($query);


        try {
            $temp_contractrateDetails = $db->loadAssocList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        $contractrateDetails = array();
        $row = null;
        $contractrate_id = 0;
        foreach ($temp_contractrateDetails as $key => $value) {
            if ((int) $value['contractrate_id'] != $contractrate_id) {
                $contractrate_id = (int) $value['contractrate_id'];
                $row = &$contractrateDetails[$contractrate_id];
            }
            $row[] = $temp_contractrateDetails[$key];
        }

        // route in Contractrate
        $query->clear(); // clear all
        $query->select('map.contractrate_id, GROUP_CONCAT("<b>", UCASE(r.code), "</b>" , " - ", r.title SEPARATOR "<br />") AS listroute')
                ->from($db->quoteName('#__standard_routecontractrate_map', 'map'))
                ->join('LEFT', $db->quoteName('#__standard_routes', 'r') . ' ON ' . $db->quoteName('r.id') . ' = ' . $db->quoteName('map.route_id'))
                ->where($db->quoteName('map.contractrate_id') . ' IN (' . implode(',', $contractrateIds) . ')')
                ->where($db->quoteName('r.state') . ' IN(0, 1)')
                ->group($db->quoteName('map.contractrate_id'));
        $db->setQuery($query);

        try {
            $ListRoomType = $db->loadAssocList('contractrate_id', 'list_route');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Inject the values back into the array.
        foreach ($contractratesByKey as &$item) {
            $item->list_contractrate_detail = isset($contractrateDetails[$item->id]) ? $contractrateDetails[$item->id] : array();
            $item->list_route = isset($ListRoomType[$item->id]) ? $ListRoomType[$item->id]['listroute'] : '';
        }

        return array_values($contractratesByKey);
    }

}
