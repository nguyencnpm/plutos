<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Methods supporting a list of article records.
 *
 * @since  1.6
 */
// [name component]<Model>[name Model]
class StandardModelShipmentMethods extends JModelList {

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
                'id', 'sm.id',
                'title', 'sm.title',
                'price', 'sm.price',
                'tax', 'sm.tax',
                'currency', 'sm.currency_id',
                'checked_out', 'sm.checked_out',
                'checked_out_time', 'sm.checked_out_time',
                'state', 'sm.state',
                'access', 'sm.access', 'access_level',
                'created', 'sm.created',
                'created_by', 'sm.created_by',
                'created_by_alias', 'sm.created_by_alias',
                'ordering', 'sm.ordering',
                'language', 'sm.language',
                'published', 'sm.published',
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
    protected function populateState($ordering = 'sm.id', $direction = 'desc') {
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
                        'list.select', ' sm.id, sm.tax_id, sm.title'
                        . ', sm.price, sm.currency_id'
                        . ', sm.checked_out, sm.checked_out_time, sm.state, sm.access'
                        . ', sm.created, sm.created_by, sm.created_by_alias, sm.ordering, sm.language'
                )
        );
        $query->from('#__standard_shipmentmethods AS sm');

        // Join over the language
        $query->select('crc.title AS currency')
                ->join('LEFT', $db->quoteName('#__standard_currencies') . ' AS crc ON crc.id = sm.currency_id');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = sm.language');

        // Join over the categories.
        $query->select('calc.title AS tax_title')
                ->join('LEFT', '#__standard_calculations AS calc ON calc.id = sm.tax_id');
        
        // Join over the categories.
        $query->select('GROUP_CONCAT(" - ", c.title SEPARATOR "\n") AS category_names')
                ->join("LEFT", "#__standard_shipmentmethod_categories_map AS map ON sm.id = map.shipmentmethod_id")
                ->join('LEFT', '#__standard_categories AS c ON map.catid = c.id');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=sm.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = sm.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = sm.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('sm.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('sm.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('sm.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(sm.state = 0 OR sm.state = 1)');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('sm.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('sm.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(sm.title LIKE ' . $search . $search . ' OR sm.price LIKE ' . $search . ' OR calc.title LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('sm.language = ' . $db->quote($language));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'sm.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'sm.ordering') {
            $orderCol = 'sm.title ' . $orderDirn . ', sm.ordering';
        }

        // SQL server change
        if ($orderCol == 'currency') {
            $orderCol = 'crc.title';
        }

        if ($orderCol == 'language') {
            $orderCol = 'l.title';
        }

        if ($orderCol == 'tax') {
            $orderCol = 'calc.title';
        }

        if ($orderCol == 'access_level') {
            $orderCol = 'ag.title';
        }

        // Group by - using for select GROUP_CONCAT()
        $query->group("sm.id");
        
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
                ->join('INNER', '#__standard_shipmentmethods AS sm ON sm.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    /**
     * Method to get a list of coupons.
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
          // Check the access level. Remove coupons the user shouldn't see
          if (!in_array($items[$x]->access, $groups)) {
          unset($items[$x]);
          }
          }
          }
         */
        return $items;
    }

}
