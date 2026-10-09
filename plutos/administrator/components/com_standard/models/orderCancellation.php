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
class StandardModelOrderCancellation extends JModelList {

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
        // Filter by a single or group of contract groups.
        $iOrderid = $this->getState('filter.orderid');
        $iCancelid = $this->getState('filter.cancelid');
        // Select the required fields from the table.
        /*
        $query->select(
                $this->getState(
                        'list.select', 'o.id as oid'
                )
        );
        */
        $query->from('#__standard_orders AS o');
        $query->where('o.id =' . (int) $iOrderid);

        // Join over the language
        $query->select('oi.*')
                ->join('INNER', $db->quoteName('#__standard_order_items') . ' AS oi ON oi.order_id = o.id');
        $query->where('oi.id = ' . (int) $iCancelid);
        return $query;
    }

    /**
     * Method to get a list of products.
     * Overridden to add a check for access levels.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   1.6.1
     */
    public function getItems() {
        $items = parent::getItems(); // call function class parent "extends JModelList" in [libraries/legacy/model/list.php]
        return $items;
    }

}
