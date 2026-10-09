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
class StandardModelListProducts extends StandardModelProducts {

    /**
     * Model context string.
     *
     * @var		string
     */
    public $_context = 'com_standard.listproducts';

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
        $app = JFactory::getApplication();
        
        parent::populateState($ordering, $direction);

        $input = JFactory::getApplication()->input;
        $user = JFactory::getUser();

           // List state information "Form Post"
        $aFormPost = $app->input->post->get('jform', array(), 'array');

        if (isset($aFormPost['search'])):
            $this->setState('filter.search', $aFormPost['search']);
            $app->setUserState('com_standard.search.filter.search', $aFormPost['search']);
        else:
            $this->setState('filter.search', $app->getUserState('com_standard.search.filter.search', ''));
            $app->setUserState('com_standard.search.filter.search', $app->getUserState('com_standard.search.filter.search', ''));
        endif;
        
        if (isset($aFormPost['catid'])):
            $this->setState('filter.catid', $aFormPost['catid']);
            $app->setUserState('com_standard.search.filter.catid', $aFormPost['catid']);
        else:
            $this->setState('filter.catid', $app->getUserState('com_standard.search.filter.catid', 0));
            $app->setUserState('com_standard.search.filter.catid', $app->getUserState('com_standard.search.filter.catid', 0));
        endif;
        
        // List state information
        $limitstart = $input->getUInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

        $params = $this->state->params;
        
        $limit = $params->get('num_leading_products') + $params->get('num_intro_products') + $params->get('num_links');
        $this->setState('list.limit', $limit);
        $this->setState('list.links', $params->get('num_links'));

        $this->setState('filter.listproducts', true);

        if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
            // Filter on published for those who do not have edit or edit.state rights.
            $this->setState('filter.published', 1);
        } else {
            $this->setState('filter.published', array(0, 1, 2));
        }

        // Check for category selection
        if ($params->get('categories') && implode(',', $params->get('categories')) == true) {
            $categories = $params->get('categories');
            $this->setState('filter.listproducts.categories', $categories);
        }

        $productOrderby = $params->get('orderby_sec', 'rdate');
        $productOrderDate = $params->get('order_date');
        
        $categoryOrderby = $params->def('orderby_pri', '');
        // ---- sort - Binh Nguyen ----
        /*
        // sort 
        $this->setState('sort.category', 0);
        if ($params->get('layout_form') === 'group_items_category'):
            $this->setState('sort.category', 1);
        endif;
        */
        if ($params->get('layout_form') === 'group_items_category'):
            $categoryOrderby = 'order';// sort case -> order : c.lft "$params->def('orderby_pri', '');"
        endif;
        // ---- /.sort - Binh Nguyen ----
        
        $secondary = StandardHelperQuery::orderbySecondary($productOrderby, $productOrderDate);
        $primary = StandardHelperQuery::orderbyPrimary($categoryOrderby);

        $this->setState('list.ordering', $primary . $secondary . ', p.created DESC');
        $this->setState('list.direction', '');
    }

    /**
     * Method to get a list of products.
     *
     * @return  mixed  An array of objects on success, false on failure.
     */
    public function getItems() {
        $params = clone $this->getState('params');
        $limit = $params->get('num_leading_products') + $params->get('num_intro_products') + $params->get('num_links');

        if ($limit > 0) {
            $this->setState('list.limit', $limit);

            return parent::getItems();
        }

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
        $id .= $this->getState('filter.listproducts');

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
        $categories = $this->getState('filter.listproducts.categories');

        if (is_array($categories) && !in_array('', $categories)) {
            $query->where('p.catid IN (' . implode(',', $categories) . ')');
        }

        return $query;
    }

}
