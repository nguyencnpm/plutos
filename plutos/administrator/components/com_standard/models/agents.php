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
class StandardModelAgents extends JModelList {

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
                'id', 'ta.id',
                'title', 'ta.title',
                'alias', 'ta.alias',
                'catid', 'ta.catid',
                'telephone', 'ta.telephone',
                'mobile', 'ta.mobile',
                'fax', 'ta.fax',
                'email', 'ta.email',
                'address', 'ta.address',
                'checked_out_time', 'ta.checked_out_time',
                'state', 'ta.state',
                'access', 'ta.access', 'access_level',
                'created', 'ta.created',
                'created_by', 'ta.created_by',
                'created_by_alias', 'ta.created_by_alias',
                'ordering', 'ta.ordering',
                'language', 'ta.language',
                'published', 'ta.published',
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
    protected function populateState($ordering = 'ta.id', $direction = 'desc') {
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
                        'list.select', ' ta.id, ta.title, ta.alias, ta.telephone, ta.mobile, ta.fax, ta.email, ta.address, ta.country_id, ta.credit'
                        . ', ta.checked_out, ta.checked_out_time, ta.state, ta.access'
                        . ', ta.created, ta.created_by, ta.created_by_alias, ta.ordering, ta.language'
                )
        );
        $query->from('#__standard_agents AS ta');

        // Join over the categories for the checked categories name List, categories Code List.
        //$query->select(' GROUP_CONCAT(h.code , " - ", h.title SEPARATOR "<br />") AS listcategories, GROUP_CONCAT(h.code SEPARATOR ", ") AS listcategoriescode');
        //$query->join("LEFT", "#__standard_categories AS h ON ta.catid REGEXP h.id"); //ta.catid = '1,2,3,...' // where 'dave,henry,jill,maryam' REGEXP x.children
        $query->select(' GROUP_CONCAT(h.code , " - ", h.title SEPARATOR "<br />") AS listcategories, GROUP_CONCAT(h.code SEPARATOR ", ") AS listcategoriescode');
        $query->join("LEFT", "#__standard_agent_categories_map AS map ON ta.id = map.agent_id");
        $query->join("LEFT", "#__standard_categories AS h ON map.catid = h.id and published=1");

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = ta.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=ta.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = ta.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = ta.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('ta.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('ta.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('ta.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(ta.state = 0 OR ta.state = 1)');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('ta.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('ta.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(ta.title LIKE ' . $search . ' OR ta.alias LIKE ' . $search . ' OR ta.address LIKE ' . $search . ' OR ta.email LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('ta.language = ' . $db->quote($language));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'ta.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        // SQL server change
        if ($orderCol == 'language') {
            $orderCol = 'l.title';
        }

        if ($orderCol == 'access_level') {
            $orderCol = 'ag.title';
        }

        // Group by on standard_agent_categories_map for JOIN with component tables to Mapping items
        $query->group("ta.id");

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
                ->join('INNER', '#__standard_agents AS ta ON ta.created_by = u.id')
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
        if(!empty($items)):
            $items = $this->populateExtraData($items);
        endif;

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
        
        // First pass: get list of the agent id's and reset the counts.
        $agentsByKey = array();

        foreach ($items as $item) {
            $agentsByKey[(int) $item->id] = $item;
        }

        $agentIds = array_keys($agentsByKey);

        $db = $this->getDbo();

        // Get List discount and total enabled users in agent.
        $query = $db->getQuery(true);
        // total enabled users in agent
        // Count the objects in the Travel agent agent.
        $query->select('map.agent_id, COUNT(DISTINCT map.user_id) AS user_count')
                ->from($db->quoteName('#__standard_agent_user_map', 'map'))
                ->join('LEFT', $db->quoteName('#__users', 'u') . ' ON ' . $db->quoteName('u.id') . ' = ' . $db->quoteName('map.user_id'))
                ->where($db->quoteName('map.agent_id') . ' IN (' . implode(',', $agentIds) . ')')
                ->where($db->quoteName('u.block') . ' = 0')
                ->group($db->quoteName('map.agent_id'));
        $db->setQuery($query);

        try {
            $countEnabled = $db->loadAssocList('agent_id', 'count_enabled');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Get total disabled users in agent.
        $query->clear('where')
                ->where('map.agent_id IN (' . implode(',', $agentIds) . ')')
                ->where('u.block = 1');
        $db->setQuery($query);

        try {
            $countDisabled = $db->loadAssocList('agent_id', 'count_disabled');
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Inject the values back into the array.
        foreach ($agentsByKey as &$item) {
            $item->count_enabled = isset($countEnabled[$item->id]) ? (int) $countEnabled[$item->id]['user_count'] : 0;
            $item->count_disabled = isset($countDisabled[$item->id]) ? (int) $countDisabled[$item->id]['user_count'] : 0;
            $item->user_count = $item->count_enabled + $item->count_disabled;
        }
        return array_values($agentsByKey);
    }
}
