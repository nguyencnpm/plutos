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
class StandardModelRates extends JModelList {

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
                'id', 'rate.id',
                'title', 'rate.title',
                'code', 'rate.code',
                'checked_out', 'rate.checked_out',
                'checked_out_time', 'rate.checked_out_time',
                'catid', 'rate.catid', 'category_title',
                'state', 'rate.state',
                'access', 'rate.access', 'access_level',
                'created', 'rate.created',
                'created_by', 'rate.created_by',
                'created_by_alias', 'rate.created_by_alias',
                'ordering', 'rate.ordering',
                'language', 'rate.language',
                'published', 'rate.published',
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
    protected function populateState($ordering = 'rate.id', $direction = 'desc') {
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
                        'list.select', ' rate.id, rate.title, rate.code, rate.currency_id'
                        . ' , rate.checked_out, rate.checked_out_time, rate.state, rate.access, rate.created, rate.created_by, rate.ordering, rate.language'
                )
        );
        $query->from('#__standard_rates AS rate');

        // Join over the categories.
        $query->select('c.title AS category_title')
                ->join('LEFT', '#__standard_categories AS c ON c.id = rate.catid');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = rate.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=rate.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = rate.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = rate.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('rate.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('rate.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('rate.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(rate.state = 0 OR rate.state = 1)');
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
            $query->where('rate.catid IN (' . $categoryId . ')');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('rate.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('rate.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(rate.title LIKE ' . $search . ' OR rate.alias LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('rate.language = ' . $db->quote($language));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'rate.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'rate.ordering') {
            $orderCol = 'rate.title ' . $orderDirn . ', rate.ordering';
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
                ->join('INNER', '#__standard_rates AS rate ON rate.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    /**
     * Method to get a list of rates.
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
          // Check the access level. Remove rates the user shouldn't see
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
        // First pass: get list of the rate id's and reset the counts.
        $ratesByKey = array();
        foreach ($items as $item) {
            $ratesByKey[(int) $item->id] = $item;
        }
        $rateIds = array_keys($ratesByKey);

        $db = $this->getDbo();
        // Get List rate detail.
        $query = $db->getQuery(true);
        // List rate detail
        // Group by the objects in the rates rate.
        $query->select('rd.*')
                ->from($db->quoteName('#__standard_rate_details', 'rd'))
                ->where($db->quoteName('rd.rate_id') . ' IN (' . implode(',', $rateIds) . ')')
                ->order('rd.rate_id ASC, rd.start_date ASC');
        $db->setQuery($query);


        try {
            $temp_rateDetails = $db->loadAssocList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        $rateDetails = array();
        $row = null;
        $rate_id = 0;
        foreach ($temp_rateDetails as $key => $value) {
            if ((int) $value['rate_id'] != $rate_id) {
                $rate_id = (int) $value['rate_id'];
                $row = &$rateDetails[$rate_id];
            }
            $row[] = $temp_rateDetails[$key];
        }

        // route in Rate
        $query->clear(); // clear all
        $query->select('map.rate_id, GROUP_CONCAT("<b>", UCASE(r.code), "</b>" , " - ", r.title SEPARATOR "<br />") AS listroute')
                ->from($db->quoteName('#__standard_routerate_map', 'map'))
                ->join('LEFT', $db->quoteName('#__standard_routes', 'r') . ' ON ' . $db->quoteName('r.id') . ' = ' . $db->quoteName('map.route_id'))
                ->where($db->quoteName('map.rate_id') . ' IN (' . implode(',', $rateIds) . ')')
                ->where($db->quoteName('r.state') . ' IN(0, 1)')
                ->group($db->quoteName('map.rate_id'));
        $db->setQuery($query);
        /*
          $query->select('map.rate_id, GROUP_CONCAT("<b>", UCASE(r.code), "</b>" , " - ", lt_from.title, " to ", lt_to.title SEPARATOR "<br />") AS listroute')
          ->from($db->quoteName('#__standard_routerate_map', 'map'))
          ->join('LEFT', $db->quoteName('#__standard_routes', 'r') . ' ON ' . $db->quoteName('r.id') . ' = ' . $db->quoteName('map.route_id'))
          // Join over the standard_locations for the locations.
          ->join('LEFT', '#__standard_locations AS lt_from ON lt_from.id = r.from_id')
          // Join over the standard_locations for the locations.
          ->join('LEFT', '#__standard_locations AS lt_to ON lt_to.id = r.to_id')
          ->where($db->quoteName('map.rate_id') . ' IN (' . implode(',', $rateIds) . ')')
          ->where($db->quoteName('r.state') . ' IN(0, 1)')
          ->group($db->quoteName('map.rate_id'));
          $db->setQuery($query);
         */

        try {
            $Products = $db->loadAssocList('rate_id', 'list_route');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Inject the values back into the array.
        foreach ($ratesByKey as &$item) {
            $item->list_rate_detail = isset($rateDetails[$item->id]) ? $rateDetails[$item->id] : array();
            $item->list_route = isset($Products[$item->id]) ? $Products[$item->id]['listroute'] : '';
        }

        return array_values($ratesByKey);
    }

}
