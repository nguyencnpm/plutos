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
class StandardModelPromotions extends JModelList {

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
                'id', 'pt.id',
                'title', 'pt.title',
                'value_mathop', 'pt.value_mathop',
                'value', 'pt.value',
                'currency', 'pt.currency_id',
                'checked_out', 'pt.checked_out',
                'checked_out_time', 'pt.checked_out_time',
                'state', 'pt.state',
                'access', 'pt.access', 'access_level',
                'created', 'pt.created',
                'created_by', 'pt.created_by',
                'created_by_alias', 'pt.created_by_alias',
                'ordering', 'pt.ordering',
                'language', 'pt.language',
                'published', 'pt.published',
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
    protected function populateState($ordering = 'pt.id', $direction = 'desc') {
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
                        'list.select', ' pt.id, pt.title, pt.value_mathop, pt.value, pt.currency_id' .
                        ' , pt.checked_out, pt.checked_out_time, pt.state, pt.access, pt.created, pt.created_by, pt.ordering, pt.language'
                )
        );
        $query->from('#__standard_promotions AS pt');

        // Join over the language
        $query->select('crc.title AS currency')
                ->join('LEFT', $db->quoteName('#__standard_currencies') . ' AS crc ON crc.id = pt.currency_id');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = pt.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=pt.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = pt.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = pt.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('pt.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('pt.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('pt.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(pt.state = 0 OR pt.state = 1)');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('pt.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('pt.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(pt.title LIKE ' . $search . ' OR pt.kind LIKE ' . $search . ' OR pt.value_mathop LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('pt.language = ' . $db->quote($language));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'pt.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'pt.ordering') {
            $orderCol = 'pt.title ' . $orderDirn . ', pt.ordering';
        }

        // SQL server change
        if ($orderCol == 'currency') {
            $orderCol = 'crc.title';
        }

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
                ->join('INNER', '#__standard_promotions AS pt ON pt.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    /**
     * Method to get a list of promotions.
     * Overridden to add a check for access levels.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   1.6.1
     */
    public function getItems() {
        $items = parent::getItems();

        if (JFactory::getApplication()->isSite()) {
            $user = JFactory::getUser();
            $groups = $user->getAuthorisedViewLevels();

            for ($x = 0, $count = count($items); $x < $count; $x++) {
                // Check the access level. Remove promotions the user shouldn't see
                if (!in_array($items[$x]->access, $groups)) {
                    unset($items[$x]);
                }
            }
        }

        return $items;
    }

}
