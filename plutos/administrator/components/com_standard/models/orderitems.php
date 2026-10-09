<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * About Page Model
 *
 * @since  1.6
 */
class StandardModelOrderitems extends JModelList {

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
                'id', 'oi.id',
                'state', 'oi.state',
                'access', 'oi.access', 'access_level',
                'created', 'oi.created',
                'created_by', 'oi.created_by',
                'created_by_alias', 'oi.created_by_alias',
                'published', 'oi.published',
                'author_id'
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
                        'list.select', 'oi.*'
                )
        );
        $query->from('#__standard_order_items AS oi');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = oi.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('oi.access = ' . (int) $access);
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('oi.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(oi.state = 0 OR oi.state = 1)');
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('oi.created_by ' . $type . (int) $authorId);
        }

        // Filter by a single or group of categories.
        $order_id = $this->getState('filter.order_id');
       
        if (is_numeric($order_id)) {
            $query->where('oi.order_id = ' . (int) $order_id);
        }  else {
            $query->where('oi.order_id = 0');
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('oi.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('oi.title LIKE ' . $search . ' OR oi.alias LIKE ' . $search);
            }
        }

        // Add the list ordering clause.
        $query->order($db->escape($this->getState('list.ordering', 'oi.order_item_name')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));

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
    protected function populateState($ordering = 'oi.title', $direction = 'asc') {
        parent::populateState($ordering, $direction);
    }

}
