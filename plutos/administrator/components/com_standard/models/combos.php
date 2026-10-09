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
 * Methods supporting a list of combo records.
 *
 * @since  1.6
 */
// [name component]<Model>[name Model]
class StandardModelCombos extends JModelList {

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
                'id', 'cb.id',
                'title', 'cb.title',
                'alias', 'cb.alias',
                'price', 'cb.price',
                'in_stock', 'cb.in_stock',
                'ordered', 'cb.ordered',
                'checked_out', 'cb.checked_out',
                'checked_out_time', 'cb.checked_out_time',
                'catid', 'cb.catid', 'category_title',
                'state', 'cb.state',
                'access', 'cb.access', 'access_level',
                'created', 'cb.created',
                'created_by', 'cb.created_by',
                'created_by_alias', 'cb.created_by_alias',
                'modified', 'cb.modified',
                'modified_by', 'cb.modified_by',
                'ordering', 'cb.ordering',
                'featured', 'cb.featured',
                'language', 'cb.language',
                'hits', 'cb.hits',
                'publish_up', 'cb.publish_up',
                'publish_down', 'cb.publish_down',
                'published', 'cb.published',
                'author_id',
                'category_id',
                'level',
                'tag'
            );

            if (JLanguageAssociations::isEnabled()) {
                $config['filter_fields'][] = 'association';
            }
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
    protected function populateState($ordering = 'cb.id', $direction = 'desc') {
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

        $comboblock = $this->getUserStateFromRequest($this->context . '.filter.comboblock', 'filter_comboblock', '');
        $this->setState('filter.comboblock', $comboblock);

        $level = $this->getUserStateFromRequest($this->context . '.filter.level', 'filter_level');
        $this->setState('filter.level', $level);

        $language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
        $this->setState('filter.language', $language);

        $tag = $this->getUserStateFromRequest($this->context . '.filter.tag', 'filter_tag', '');
        $this->setState('filter.tag', $tag);

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
                        'list.select', 'cb.id, cb.title, cb.alias, cb.period_block, cb.block_in_date, cb.price, cb.in_stock, cb.ordered'
                        . ', cb.images, cb.banners'
                        . ', cb.currency_id'
                        . ', cb.checked_out, cb.checked_out_time, cb.catid'
                        . ', cb.state, cb.access, cb.created, cb.created_by, cb.created_by_alias, cb.ordering, cb.featured, cb.language, cb.hits'
                        . ', cb.publish_up, cb.publish_down'
                )
        );
        $query->from('#__standard_combos AS cb');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = cb.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=cb.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = cb.access');

        // Join over the categories.
        $query->select('c.title AS category_title')
                ->join('LEFT', '#__standard_categories AS c ON c.id = cb.catid');

        // Join over the products.
        $query->select('p.title AS product_title')
                ->join('LEFT', '#__standard_products AS p ON p.id = cb.product_id');
        
        // Join over the itineraries.
        $query->select('i.title AS itinerary_title')
                ->join('LEFT', '#__standard_itineraries AS i ON i.id = cb.itinerary_id');
        
        
        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = cb.created_by');

        // Join over the associations.
        if (JLanguageAssociations::isEnabled()) {
            $query->select('COUNT(asso2.id)>1 as association')
                    ->join('LEFT', '#__associations AS asso ON asso.id = cb.id AND asso.context=' . $db->quote('com_standard.item'))
                    ->join('LEFT', '#__associations AS asso2 ON asso2.key = asso.key')
                    ->group('cb.id, l.title, l.image, uc.name, ag.title, c.title, ua.name');
        }

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('cb.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('cb.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('cb.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(cb.state = 0 OR cb.state = 1)');
        }

        // Filter by combo block state
        $comboblock = $this->getState('filter.comboblock');
        if (is_numeric($comboblock)) {
            $query->where('cb.block_in_date = ' . (int) $comboblock);
        } elseif ($comboblock === '') {
            $comboblock = $this->getState($this->context . '.filter.comboblock', '');
            if (is_numeric($comboblock)) {
                $query->where('cb.block_in_date = ' . (int) $comboblock);
            }
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
            $query->where('cb.catid IN (' . $categoryId . ')');
        }

        // Filter on the level.
        if ($level = $this->getState('filter.level')) {
            $query->where('c.level <= ' . ((int) $level + (int) $baselevel - 1));
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('cb.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('cb.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(cb.title LIKE ' . $search . ' OR cb.alias LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('cb.language = ' . $db->quote($language));
        }

        // Filter by a single tag.
        $tagId = $this->getState('filter.tag');

        if (is_numeric($tagId)) {
            $query->where($db->quoteName('tagmap.tag_id') . ' = ' . (int) $tagId)
                    ->join(
                            'LEFT', $db->quoteName('#__contentitem_tag_map', 'tagmap')
                            . ' ON ' . $db->quoteName('tagmap.content_item_id') . ' = ' . $db->quoteName('cb.id')
                            . ' AND ' . $db->quoteName('tagmap.type_alias') . ' = ' . $db->quote('com_standard.combo')
            );
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'cb.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'cb.ordering' || $orderCol == 'category_title') {
            $orderCol = 'c.title ' . $orderDirn . ', cb.ordering';
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
                ->join('INNER', '#__standard_combos AS cb ON cb.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    /**
     * Method to get a list of combos.
     * Overridden to add a check for access levels.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   1.6.1
     */
    public function getItems() {
        $items = parent::getItems(); // call function class parent "extends JModelList" in [libraries/legacy/model/list.php]

        if (JFactory::getApplication()->isSite()) {
            $user = JFactory::getUser();
            $groups = $user->getAuthorisedViewLevels();

            for ($x = 0, $count = count($items); $x < $count; $x++) {
                // Check the access level. Remove combos the user shouldn't see
                if (!in_array($items[$x]->access, $groups)) {
                    unset($items[$x]);
                }
            }
        }

        return $items;
    }

}
