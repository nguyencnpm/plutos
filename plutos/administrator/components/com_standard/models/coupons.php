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
class StandardModelCoupons extends JModelList {

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
                'id', 'cp.id',
                'checked_out', 'cp.checked_out',
                'checked_out_time', 'cp.checked_out_time',
                'state', 'cp.state',
                'code', 'cp.code',
                'access', 'cp.access', 'access_level',
                'created', 'cp.created',
                'modified', 'cp.modified',
                'created_by', 'cp.created_by',
                'created_by_alias', 'cp.created_by_alias',
                'ordering', 'cp.ordering',
                'title', 'ct.title',
                // 'language', 'cp.language',
                'published', 'cp.published',
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
    protected function populateState($ordering = 'cp.id', $direction = 'desc') {
        $app = JFactory::getApplication();

        // $forcedLanguage = $app->input->get('forcedLanguage', '', 'cmd');
        // Adjust the context to support modal layouts.
        if ($layout = $app->input->get('layout')) {
            $this->context .= '.' . $layout;
        }
        /*
          // Adjust the context to support forced languages.
          if ($forcedLanguage) {
          $this->context .= '.' . $forcedLanguage;
          }
         */
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access');
        $this->setState('filter.access', $access);

        $authorId = $app->getUserStateFromRequest($this->context . '.filter.author_id', 'filter_author_id');
        $this->setState('filter.author_id', $authorId);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);
        /*
          $language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
          $this->setState('filter.language', $language);
         */
        // List state information.
        parent::populateState($ordering, $direction);
        /*
          // Force a language
          if (!empty($forcedLanguage)) {
          $this->setState('filter.language', $forcedLanguage);
          $this->setState('filter.forcedLanguage', $forcedLanguage);
          }
         */
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
        // $id .= ':' . $this->getState('filter.language');

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
                        'list.select', ' cp.id, cp.code, cp.used'
                        . ', cp.checked_out, cp.checked_out_time, cp.state, cp.access'
                        . ', cp.created, cp.created_by, cp.created_by_alias, cp.ordering'
                )
        );
        $query->from('#__standard_coupons AS cp');

        // Join over the coupons Type
        $query->select('ct.title AS couponstype_title, ct.prefix AS couponstype_prefix')
                ->join('LEFT', $db->quoteName('#__standard_couponstypes') . ' AS ct ON ct.id = cp.coupontype_id');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=cp.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = cp.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = cp.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('cp.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('cp.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('cp.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(cp.state = 0 OR cp.state = 1)');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('cp.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('cp.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(cp.code LIKE ' . $search . ' OR cp.used LIKE ' . $search . ' OR ct.title LIKE ' . $search . ' OR ct.prefix LIKE ' . $search .')');
            }
        }
        /*
          // Filter on the language.
          if ($language = $this->getState('filter.language')) {
          $query->where('cp.language = ' . $db->quote($language));
          }
         */
        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'cp.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'cp.ordering') {
            $orderCol = 'cp.title ' . $orderDirn . ', cp.ordering';
        }

        // SQL server change
        /*
          if ($orderCol == 'language') {
          $orderCol = 'l.title';
          }
         */
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
                ->join('INNER', '#__standard_coupons AS cp ON cp.created_by = u.id')
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
