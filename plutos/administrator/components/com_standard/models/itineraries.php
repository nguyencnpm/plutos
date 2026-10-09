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
 * Methods supporting a list of product records.
 *
 * @since  1.6
 */
// [name component]<Model>[name Model]
class StandardModelItineraries extends JModelList {

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
                'id', 'i.id',
                'title', 'i.title',
                'alias', 'i.alias',
                'price', 'i.price',
                'in_stock', 'i.in_stock',
                'ordered', 'i.ordered',
                'checked_out', 'i.checked_out',
                'checked_out_time', 'i.checked_out_time',
                'itinerarytype_id', 'i.itinerarytype_id', 'itinerarytype_title',
                'state', 'i.state',
                'access', 'i.access', 'access_level',
                'created', 'i.created',
                'created_by', 'i.created_by',
                'created_by_alias', 'i.created_by_alias',
                'modified', 'i.modified',
                'modified_by', 'i.modified_by',
                'ordering', 'i.ordering',
                'featured', 'i.featured',
                'language', 'i.language',
                'hits', 'i.hits',
                'publish_up', 'i.publish_up',
                'publish_down', 'i.publish_down',
                'published', 'i.published',
                'author_id',
                'itinerarytype_id',
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
    protected function populateState($ordering = 'i.id', $direction = 'desc') {
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

        $itinerarytypeId = $this->getUserStateFromRequest($this->context . '.filter.itinerarytype_id', 'filter_itinerarytype_id');
        $this->setState('filter.itinerarytype_id', $itinerarytypeId);
        
         $productblock = $this->getUserStateFromRequest($this->context . '.filter.productblock', 'filter_productblock', '');
        $this->setState('filter.productblock', $productblock);

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
        $id .= ':' . $this->getState('filter.itinerarytype_id');
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
                        'list.select', 'i.id, i.title, i.alias, i.period_block, i.block_in_date, i.price, i.in_stock, i.ordered, i.images'
                        . ', i.currency_id'
                        . ', i.checked_out, i.checked_out_time, i.itinerarytype_id'
                        . ', i.state, i.access, i.created, i.created_by, i.created_by_alias, i.ordering, i.featured, i.language, i.hits'
                        . ', i.publish_up, i.publish_down'
                )
        );
        $query->from('#__standard_itineraries AS i');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = i.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=i.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = i.access');

        // Join over the itinerarytypes.
        $query->select('it.title AS itinerarytype_title')
                ->join('LEFT', '#__standard_itinerary_types AS it ON it.id = i.itinerarytype_id');
        // Join over the products.
        $query->select('i.title AS product_title')
                ->join('LEFT', '#__standard_products AS p ON p.id = i.product_id');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = i.created_by');

        // Join over the associations.
        if (JLanguageAssociations::isEnabled()) {
            $query->select('COUNT(asso2.id)>1 as association')
                    ->join('LEFT', '#__associations AS asso ON asso.id = i.id AND asso.context=' . $db->quote('com_standard.item'))
                    ->join('LEFT', '#__associations AS asso2 ON asso2.key = asso.key')
                    ->group('i.id, l.title, l.image, uc.name, ag.title, it.title, ua.name');
        }

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('i.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('i.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('i.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(i.state = 0 OR i.state = 1)');
        }

        // Filter by product block state
        $productblock = $this->getState('filter.productblock');
        if (is_numeric($productblock)) {
            $query->where('i.block_in_date = ' . (int) $productblock);
        } elseif ($productblock === '') {
            $productblock = $this->getState($this->context . '.filter.productblock', '');
            if (is_numeric($productblock)) {
                $query->where('i.block_in_date = ' . (int) $productblock);
            }
        }
        
        // Filter by a single or group of itinerarytypes.
        $baselevel = 1;
        $itinerarytypeId = $this->getState('filter.itinerarytype_id');

        if (is_numeric($itinerarytypeId)) {
            //$IType_tbl = JTable::getInstance('Category', 'JTable');
            $IType_tbl = JTable::getInstance('ItineraryType', 'StandardTable');
            $IType_tbl->load($itinerarytypeId);
            $rgt = $IType_tbl->rgt;
            $lft = $IType_tbl->lft;
            $baselevel = (int) $IType_tbl->level;
            $query->where('it.lft >= ' . (int) $lft)
                    ->where('it.rgt <= ' . (int) $rgt);
        } elseif (is_array($itinerarytypeId)) {
            JArrayHelper::toInteger($itinerarytypeId);
            $itinerarytypeId = implode(',', $itinerarytypeId);
            $query->where('i.itinerarytype_id IN (' . $itinerarytypeId . ')');
        }

        // Filter on the level.
        if ($level = $this->getState('filter.level')) {
            $query->where('it.level <= ' . ((int) $level + (int) $baselevel - 1));
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('i.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('i.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(i.title LIKE ' . $search . ' OR i.alias LIKE ' . $search . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('i.language = ' . $db->quote($language));
        }

        // Filter by a single tag.
        $tagId = $this->getState('filter.tag');

        if (is_numeric($tagId)) {
            $query->where($db->quoteName('tagmap.tag_id') . ' = ' . (int) $tagId)
                    ->join(
                            'LEFT', $db->quoteName('#__contentitem_tag_map', 'tagmap')
                            . ' ON ' . $db->quoteName('tagmap.content_item_id') . ' = ' . $db->quoteName('i.id')
                            . ' AND ' . $db->quoteName('tagmap.type_alias') . ' = ' . $db->quote('com_standard.product')
            );
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'i.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'i.ordering' || $orderCol == 'itinerarytype_title') {
            $orderCol = 'it.title ' . $orderDirn . ', i.ordering';
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
                ->join('INNER', '#__standard_itineraries AS i ON i.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

    /**
     * Method to get a list of itineraries.
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
                // Check the access level. Remove itineraries the user shouldn't see
                if (!in_array($items[$x]->access, $groups)) {
                    unset($items[$x]);
                }
            }
        }

        return $items;
    }

}
