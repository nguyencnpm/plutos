<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('StandardModelProducts', __DIR__ . '/products.php');

/**
 * About Page Model
 *
 * @since  1.6
 */
class StandardModelFeatured extends StandardModelProducts {

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'p.id',
                'title', 'p.title',
                'alias', 'p.alias',
                'checked_out', 'p.checked_out',
                'checked_out_time', 'p.checked_out_time',
                'catid', 'p.catid', 'category_title',
                'state', 'p.state',
                'access', 'p.access', 'access_level',
                'created', 'p.created',
                'created_by', 'p.created_by',
                'created_by_alias', 'p.created_by_alias',
                'modified', 'p.modified',
                'modified_by', 'p.modified_by',
                'ordering', 'p.ordering',
                'featured', 'p.featured',
                'language', 'p.language',
                'hits', 'p.hits',
                'publish_up', 'p.publish_up',
                'publish_down', 'p.publish_down',
                'fp.ordering',
                'published', 'p.published',
                'author_id',
                'category_id',
                'level',
                'tag'
            );
        }

        parent::__construct($config);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @param   boolean  $resolveFKs  True to join selected foreign information
     *
     * @return  string
     *
     * @since   1.6
     */
    protected function getListQuery($resolveFKs = true) {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'p.id, p.title, p.alias, p.period_block, p.block_in_date, p.price, p.in_stock, p.ordered, p.images'
                        . ', p.currency_id'
                        . ', p.checked_out, p.checked_out_time, p.catid, p.state, p.access, p.created'
                        . ', p.hits, p.featured, p.language, p.created_by_alias, p.publish_up, p.publish_down'
                )
        );
        $query->from('#__standard_products AS p');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = p.language');

        // Join over the products table.
        $query->select('fp.ordering')
                ->join('INNER', '#__standard_products_frontpage AS fp ON fp.product_id = p.id');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=p.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = p.access');

        // Join over the categories.
        $query->select('c.title AS category_title')
                ->join('LEFT', '#__standard_categories AS c ON c.id = p.catid');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = p.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('p.access = ' . (int) $access);
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('p.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(p.state = 0 OR p.state = 1)');
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
            $query->where('p.catid IN (' . $categoryId . ')');
        }

        // Filter on the level.
        if ($level = $this->getState('filter.level')) {
            $query->where('c.level <= ' . ((int) $level + (int) $baselevel - 1));
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('p.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('p.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('p.title LIKE ' . $search . ' OR p.alias LIKE ' . $search);
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('p.language = ' . $db->quote($language));
        }

        // Filter by a single tag.
        $tagId = $this->getState('filter.tag');

        if (is_numeric($tagId)) {
            $query->where($db->quoteName('tagmap.tag_id') . ' = ' . (int) $tagId)
                    ->join(
                            'LEFT', $db->quoteName('#__contentitem_tag_map', 'tagmap')
                            . ' ON ' . $db->quoteName('tagmap.product_item_id') . ' = ' . $db->quoteName('p.id')
                            . ' AND ' . $db->quoteName('tagmap.type_alias') . ' = ' . $db->quote('com_standard.product')
            );
        }

        // Add the list ordering clause.
        $query->order($db->escape($this->getState('list.ordering', 'p.title')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
        return $query;
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
     * @since   3.5
     */
    protected function populateState($ordering = 'p.title', $direction = 'asc') {
        parent::populateState($ordering, $direction);
    }

}
