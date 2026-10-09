<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('StandardModelProducts', __DIR__ . '/products.php');

/**
 * Frontpage Component Model
 *
 * @since  1.5
 */
class StandardModelInventory extends StandardModelProducts {

    /**
     * Model context string.
     *
     * @var		string
     */
    public $_context = 'com_standard.inventory';

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   The field to order on.
     * @param   string  $direction  The direction to order on.
     *
     * @return  void.
     *
     * @since   1.6
     */
    protected function populateState($ordering = null, $direction = null) {
        parent::populateState($ordering, $direction);

        $input = JFactory::getApplication()->input;
        $user = JFactory::getUser();

        // List state information
        $limitstart = $input->getUInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

        $params = $this->state->params;
        $limit = $params->get('num_leading_inventory') + $params->get('num_intro_inventory') + $params->get('num_links');
        $this->setState('list.limit', $limit);
        $this->setState('list.links', $params->get('num_links'));

        $this->setState('filter.inventory', true);

        if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
            // Filter on published for those who do not have edit or edit.state rights.
            $this->setState('filter.published', 1);
        } else {
            $this->setState('filter.published', array(0, 1, 2));
        }

        // Check for category selection
        if ($params->get('categories') && implode(',', $params->get('categories')) == true) {
            $categories = $params->get('categories');
            $this->setState('filter.inventory.categories', $categories);
        }

        $productOrderby = $params->get('orderby_sec', 'rdate');
        $productOrderDate = $params->get('order_date');
        $categoryOrderby = $params->def('orderby_pri', '');

        $secondary = StandardHelperQuery::orderbySecondary($productOrderby, $productOrderDate);
        $primary = StandardHelperQuery::orderbyPrimary($categoryOrderby);

        $this->setState('list.ordering', $primary . $secondary . ', p.created DESC');
        $this->setState('list.direction', '');
    }

    /**
     * Method to get a list of inventory.
     *
     * @return  mixed  An array of objects on success, false on failure.
     */
    public function getItems() {
        $params = clone $this->getState('params');
        $limit = $params->get('num_leading_inventory') + $params->get('num_intro_inventory') + $params->get('num_links');

        //if ($limit > 0) {
            $this->setState('list.limit', $limit);

            return parent::getItems();
        //}

        return array();
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
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= $this->getState('filter.inventory');

        return parent::getStoreId($id);
    }

    /**
     * Get the list of items.
     *
     * @return  JDatabaseQuery
     */
    protected function getListQuery() {
        // Create a new query object.
        $query = parent::getListQuery();

        // Filter by categories
        $categories = $this->getState('filter.inventory.categories');

        if (is_array($categories) && !in_array('', $categories)) {
            $query->where('p.catid IN (' . implode(',', $categories) . ')');
        }

        return $query;
    }

}
