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
class StandardModelCalculations extends JModelList {

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
                'id', 'calc.id',
                'title', 'calc.title',
                'descr', 'calc.descr',
                'kind', 'calc.kind',
                'value_mathop', 'calc.value_mathop',
                'value', 'calc.value',
                'currency', 'calc.currency_id',
                'checked_out', 'calc.checked_out',
                'checked_out_time', 'calc.checked_out_time',
                'state', 'calc.state',
                'access', 'calc.access', 'access_level',
                'created', 'calc.created',
                'created_by', 'calc.created_by',
                'created_by_alias', 'calc.created_by_alias',
                'ordering', 'calc.ordering',
                'language', 'calc.language',
                'published', 'calc.published',
                'epoints',
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
    protected function populateState($ordering = 'calc.id', $direction = 'desc') {
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

        $taxId = $app->getUserStateFromRequest($this->context . '.filter.tax_id', 'filter_tax_id');
        $this->setState('filter.tax_id', $taxId);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        $language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
        $this->setState('filter.language', $language);

        $epoints = $this->getUserStateFromRequest($this->context . '.filter.epoints', 'filter_epoints');
        $this->setState('filter.epoints', $epoints);

        $isStartEndDates = $this->getUserStateFromRequest($this->context . '.filter.isStartEndDates', 'filter_isStartEndDates');
        $this->setState('filter.isStartEndDates', $isStartEndDates);


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
        $id .= ':' . $this->getState('filter.tax_id');
        $id .= ':' . $this->getState('filter.language');
        // $id .= ':' . $this->getState('filter.epoints');
        $id .= ':' . $this->getState('filter.isStartEndDates');

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
                        'list.select', ' calc.id, calc.title, calc.descr, calc.kind, calc.value_mathop, calc.value, calc.currency_id' .
                        ' , calc.checked_out, calc.checked_out_time, calc.state, calc.access'
                        . ', calc.created, calc.created_by, calc.created_by_alias, calc.ordering, calc.language'
                )
        );
        $query->from('#__standard_calculations AS calc');

        // Join over the language
        $query->select('crc.title AS currency')
                ->join('LEFT', $db->quoteName('#__standard_currencies') . ' AS crc ON crc.id = calc.currency_id');
        
        // Join over the categories.
        $query->select('GROUP_CONCAT(" - ", c.title SEPARATOR "\n") AS category_names')
                ->join("LEFT", "#__standard_calc_categories_map AS map ON calc.id = map.calculation_id")
                ->join('LEFT', '#__standard_categories AS c ON map.catid = c.id');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = calc.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=calc.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = calc.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = calc.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('calc.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('calc.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('calc.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(calc.state = 0 OR calc.state = 1)');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('calc.created_by ' . $type . (int) $authorId);
        }

        // Filter by Tax id
        $tax_id = $this->getState('filter.tax_id');
        if (is_numeric($tax_id)) { // calc.id
            $type = $this->getState('filter.tax_id.include', true) ? '= ' : '<>';
            $query->where('calc.id ' . $type . (int) $tax_id);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('calc.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(calc.title LIKE ' . $search . ' OR calc.descr LIKE ' . $search . ' OR calc.kind LIKE ' . $search . ' OR calc.value_mathop LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('calc.language = ' . $db->quote($language));
        }

        // Filter on the kind (epoints).
        $epoints = $this->getState('filter.epoints');
        if (is_numeric($epoints)) {
            $query->where('calc.kind = ' . (int) $epoints);
        } elseif (is_array($epoints)) {
            JArrayHelper::toString($epoints);
            $epoints = implode(',', $epoints);
            $query->where('calc.kind IN (' . $epoints . ')');
        }
        // check is Filter by start and end dates.
        $isStartEndDates = $this->getState('filter.isStartEndDates');
        if ($isStartEndDates):
            // Define null and now dates
            $nullDate = $db->quote($db->getNullDate());
            $nowDate = $db->quote(JFactory::getDate()->toSql());

            // Filter by start and end dates.
            $query->where('(calc.publish_up = ' . $nullDate . ' OR calc.publish_up <= ' . $nowDate . ')')
                    ->where('(calc.publish_down = ' . $nullDate . ' OR calc.publish_down >= ' . $nowDate . ')');
        endif;

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'calc.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'calc.ordering') {
            $orderCol = 'calc.title ' . $orderDirn . ', calc.ordering';
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

        // Group by - using for select GROUP_CONCAT()
        $query->group("calc.id");

        $query->order($db->escape($orderCol . ' ' . $orderDirn));
        //echo nl2br(str_replace('#__', 'dpjvy_', $query));
        //exit;
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
                ->join('INNER', '#__standard_calculations AS calc ON calc.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    /**
     * Method to get a list of calculations.
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
          // Check the access level. Remove calculations the user shouldn't see
          if (!in_array($items[$x]->access, $groups)) {
          unset($items[$x]);
          }
          }
          }
         */
        return $items;
    }

    /**
     * Retrieve the detail record for the current $id if the data has not already been loaded.
     *
     * @author Binh Nguyen
     */
    public function getCalc($id = 0) {
        return $id;
        /*
          if (!empty($id)):
          $this->_id = (int) $id;
          endif;

          if (empty($this->_cache[$this->_id])) :

          $this->_cache[$this->_id] = $this->getTable('calcs');
          $this->_cache[$this->_id]->load((int) $this->_id);

          $xrefTable = $this->getTable('calc_categories');
          $this->_cache[$this->_id]->calc_categories = $xrefTable->load($this->_id);

          $xrefTable = $this->getTable('calc_shoppergroups');
          $this->_cache[$this->_id]->shoppergroup_ids = $xrefTable->load($this->_id);

          $xrefTable = $this->getTable('calc_countries');
          $this->_cache[$this->_id]->calc_countries = $xrefTable->load($this->_id);

          $xrefTable = $this->getTable('calc_states');
          $this->_cache[$this->_id]->state_ids = $xrefTable->load($this->_id);

          $xrefTable = $this->getTable('calc_manufacturers');
          $this->_cache[$this->_id]->manufacturers = $xrefTable->load($this->_id);

          JPluginHelper::importPlugin('gpcalculation');
          $dispatcher = JDispatcher::getInstance();
          $dispatcher->trigger('plgGpGetPluginInternalDataCalc', array(&$this->_cache[$this->_id]));
          endif;

          return $this->_cache[$this->_id];
         * 
         */
    }

}
