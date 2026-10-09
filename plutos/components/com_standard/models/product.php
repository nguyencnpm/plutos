<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Standard Component Product Model
 *
 * @since  1.5
 */
class StandardModelProduct extends JModelItem {

    /**
     * Model context string.
     *
     * @var        string
     */
    protected $_context = 'com_standard.product';
    protected $_products = null;

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since   1.6
     *
     * @return void
     */
    protected function populateState() {
        $app = JFactory::getApplication('site');

        // Load state from the request.
        $pk = $app->input->getInt('id');
        $this->setState('product.id', $pk);

        $offset = $app->input->getUInt('limitstart');
        $this->setState('list.offset', $offset);

        // Load the parameters.
        $params = $app->getParams();
        $this->setState('params', $params);

        // TODO: Tune these values based on other permissions.
        $user = JFactory::getUser();

        if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
            $this->setState('filter.published', 1);
            $this->setState('filter.archived', 2);
        }

        $this->setState('filter.language', JLanguageMultilang::isEnabled());
    }

    /**
     * Method to get product data.
     *
     * @param   integer  $pk  The id of the product.
     *
     * @return  object|boolean|JException  Menu item data object on success, boolean false or JException instance on error
     */
    public function getItem($pk = null) {

        $user = JFactory::getUser();

        $pk = (!empty($pk)) ? $pk : (int) $this->getState('product.id');

        if ($this->_item === null) {
            $this->_item = array();
        }

        if (!isset($this->_item[$pk])) {
            try {
                $db = $this->getDbo();
                /*
                // Fix GROUP_CONCAT() maximum length is 1024 characters.
                $mySQL="SET @@session.group_concat_max_len = 10000;";
                $db->setQuery($mySQL);
                $db->execute();
                */
                $query = $db->getQuery(true)
                        ->select(
                        $this->getState(
                                'item.select', 'p.id, p.asset_id, p.title, p.alias, p.subtitle, p.introtext, p.fulltext'
                                . ', p.descriptions, p.description_column'
                                . ', p.price, p.in_stock, p.ordered'
                                . ', p.currency_id'
                                . ', p.paymenttype_id'
                                . ', p.state, p.catid, p.created, p.created_by, p.created_by_alias'
                                // Use created if modified is 0
                                . ', CASE WHEN p.modified = ' . $db->quote($db->getNullDate()) . ' THEN p.created ELSE p.modified END as modified'
                                . ', p.modified_by, p.checked_out, p.checked_out_time, p.publish_up, p.publish_down'
                                . ', p.images, p.childimages, p.videos, p.aspect_ratio, p.frame_rate'
                                . ', p.banners, p.banners_tablet, p.banners_phone, p.banner_status, p.banner_home'
                                . ', p.plans_mediadisplaytype, p.plans_medialayoutelement'
                                . ', p.plans_displaytype_id, p.plans_layout, p.plans_layoutelement'
                                . ', p.plans_image, p.plans, p.plans_num_leading, p.plans_column_leading, p.plans_num_intro, p.plans_column_intro'
                                . ', p.galleries'
                                . ', p.urls, p.attribs, p.version, p.ordering'
                                . ', p.metakey, p.metadesc, p.access, p.hits, p.metadata, p.featured, p.language, p.xreference'
                        )
                );
                $query->from('#__standard_products AS p')
                        ->where('p.id = ' . (int) $pk);

                // Join on category table.
                $query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access')
                        ->innerJoin('#__standard_categories AS c on c.id = p.catid')
                        ->where('c.published > 0');

                // Join over the manufacturer.
                $query->select('GROUP_CONCAT(m.id SEPARATOR ", ") as manufacturer_ids, GROUP_CONCAT(m.title SEPARATOR ", ") as manufacturer_title')
                        ->join('LEFT', '#__standard_product_manufacturer_map AS map ON map.product_id = p.id')
                        ->join('LEFT', '#__standard_manufacturers AS m ON m.id = map.manufacturer_id and m.state in(1)')
                        ->group('p.id');

                // Join on user table.
                $query->select('u.name AS author')
                        ->join('LEFT', '#__users AS u on u.id = p.created_by');

                // Filter by language
                if ($this->getState('filter.language')) {
                    $query->where('p.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
                }

                // Join over the categories to get parent category titles
                $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
                        ->join('LEFT', '#__standard_categories as parent ON parent.id = c.parent_id');

                // Join on voting table
                $query->select('ROUND(v.rating_sum / v.rating_count, 0) AS rating, v.rating_count as rating_count')
                        ->join('LEFT', '#__content_rating AS v ON p.id = v.content_id');

                if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
                    // Filter by start and end dates.
                    $nullDate = $db->quote($db->getNullDate());
                    $date = JFactory::getDate();

                    $nowDate = $db->quote($date->toSql());

                    $query->where('(p.publish_up = ' . $nullDate . ' OR p.publish_up <= ' . $nowDate . ')')
                            ->where('(p.publish_down = ' . $nullDate . ' OR p.publish_down >= ' . $nowDate . ')');
                }

                // Filter by published state.
                $published = $this->getState('filter.published');
                $archived = $this->getState('filter.archived');

                if (is_numeric($published)) {
                    $query->where('(p.state = ' . (int) $published . ' OR p.state =' . (int) $archived . ')');
                }

                $db->setQuery($query);

                // echo nl2br(str_replace('#__', 'dpjvy_', $query));
                // exit;

                $data = $db->loadObject();

                if (empty($data)) {
                    return JError::raiseError(404, JText::_('COM_STANDARD_ERROR_PRODUCT_NOT_FOUND'));
                }

                // Check for published state if filter set.
                if ((is_numeric($published) || is_numeric($archived)) && (($data->state != $published) && ($data->state != $archived))) {
                    return JError::raiseError(404, JText::_('COM_STANDARD_ERROR_PRODUCT_NOT_FOUND'));
                }

                if (!empty($this->getState('params'))): // Binh Nguyen break in case add order 
                    // Convert parameter fields to objects.
                    $registry = new Registry($data->attribs);

                    $data->params = clone $this->getState('params');
                    $data->params->merge($registry);

                    $data->metadata = new Registry($data->metadata);

                    // Technically guest could edit an product, but lets not check that to improve performance a little.
                    if (!$user->get('guest')) {
                        $userId = $user->get('id');
                        $asset = 'com_standard.product.' . $data->id;

                        // Check general edit permission first.
                        if ($user->authorise('core.edit', $asset)) {
                            $data->params->set('access-edit', true);
                        }

                        // Now check if edit.own is available.
                        elseif (!empty($userId) && $user->authorise('core.edit.own', $asset)) {
                            // Check for a valid user and that they are the owner.
                            if ($userId == $data->created_by) {
                                $data->params->set('access-edit', true);
                            }
                        }
                    }

                    // Compute view access permissions.
                    if ($access = $this->getState('filter.access')) {
                        // If the access filter has been set, we already know this user can view.
                        $data->params->set('access-view', true);
                    } else {
                        // If no access filter is set, the layout takes some responsibility for display of limited information.
                        $user = JFactory::getUser();
                        $groups = $user->getAuthorisedViewLevels();

                        if ($data->catid == 0 || $data->category_access === null) {
                            $data->params->set('access-view', in_array($data->access, $groups));
                        } else {
                            $data->params->set('access-view', in_array($data->access, $groups) && in_array($data->category_access, $groups));
                        }
                    }
                endif;

                $this->_item[$pk] = $data;
            } catch (Exception $e) {
                if ($e->getCode() == 404) {
                    // Need to go thru the error handler to allow Redirect to work.
                    JError::raiseError(404, $e->getMessage());
                } else {
                    $this->setError($e);
                    $this->_item[$pk] = false;
                }
            }
        }

        return $this->_item[$pk];
    }

    /**
     * Increment the hit counter for the product.
     *
     * @param   integer  $pk  Optional primary key of the product to increment.
     *
     * @return  boolean  True if successful; false otherwise and internal error set.
     */
    public function hit($pk = 0) {
        $input = JFactory::getApplication()->input;
        $hitcount = $input->getInt('hitcount', 1);

        if ($hitcount) {
            $pk = (!empty($pk)) ? $pk : (int) $this->getState('product.id');

            $table = JTable::getInstance('Product', 'StandardTable');
            $table->load($pk);
            $table->hit($pk);
        }

        return true;
    }

    /**
     * Save user vote on product
     *
     * @param   integer  $pk    Joomla Product Id
     * @param   integer  $rate  Voting rate
     *
     * @return  boolean          Return true on success
     */
    public function storeVote($pk = 0, $rate = 0) {
        if ($rate >= 1 && $rate <= 5 && $pk > 0) {
            $userIP = $_SERVER['REMOTE_ADDR'];

            // Initialize variables.
            $db = $this->getDbo();
            $query = $db->getQuery(true);

            // Create the base select statement.
            $query->select('*')
                    ->from($db->quoteName('#__content_rating'))
                    ->where($db->quoteName('content_id') . ' = ' . (int) $pk);

            // Set the query and load the result.
            $db->setQuery($query);

            // Check for a database error.
            try {
                $rating = $db->loadObject();
            } catch (RuntimeException $e) {
                JError::raiseWarning(500, $e->getMessage());

                return false;
            }

            // There are no ratings yet, so lets insert our rating
            if (!$rating) {
                $query = $db->getQuery(true);

                // Create the base insert statement.
                $query->insert($db->quoteName('#__content_rating'))
                        ->columns(array($db->quoteName('content_id'), $db->quoteName('lastip'), $db->quoteName('rating_sum'), $db->quoteName('rating_count')))
                        ->values((int) $pk . ', ' . $db->quote($userIP) . ',' . (int) $rate . ', 1');

                // Set the query and execute the insert.
                $db->setQuery($query);

                try {
                    $db->execute();
                } catch (RuntimeException $e) {
                    JError::raiseWarning(500, $e->getMessage());

                    return false;
                }
            } else {
                if ($userIP != $rating->lastip) {
                    $query = $db->getQuery(true);

                    // Create the base update statement.
                    $query->update($db->quoteName('#__content_rating'))
                            ->set($db->quoteName('rating_count') . ' = rating_count + 1')
                            ->set($db->quoteName('rating_sum') . ' = rating_sum + ' . (int) $rate)
                            ->set($db->quoteName('lastip') . ' = ' . $db->quote($userIP))
                            ->where($db->quoteName('content_id') . ' = ' . (int) $pk);

                    // Set the query and execute the update.
                    $db->setQuery($query);

                    try {
                        $db->execute();
                    } catch (RuntimeException $e) {
                        JError::raiseWarning(500, $e->getMessage());

                        return false;
                    }
                } else {
                    return false;
                }
            }

            return true;
        }

        JError::raiseWarning('SOME_ERROR_CODE', JText::sprintf('COM_STANDARD_INVALID_RATING', $rate), "JModelProduct::storeVote($rate)");

        return false;
    }

    public function getRelatedInformations($catid = 0, $id = 0, $limit = 0) {
        if (!$limit) {
            $limit = $this->getState('list.limit');
        }
        if ($this->_products === null && $catid > 0) {
            $model = JModelLegacy::getInstance('Products', 'StandardModel', array('ignore_request' => true));
            $model->setState('params', JFactory::getApplication()->getParams());

            $model->setState('filter.category_id', $catid);
            $model->setState('filter.related_id', $id);

            $model->setState('filter.published', $this->getState('filter.published'));
            $model->setState('filter.access', $this->getState('filter.access'));
            $model->setState('filter.language', $this->getState('filter.language'));
            $model->setState('filter.featured', $this->getState('filter.featured'));
            $model->setState('list.ordering', $this->_buildStandardOrderBy());
            $model->setState('list.start', $this->getState('list.start'));
            $model->setState('list.limit', $limit);
            $model->setState('list.direction', $this->getState('list.direction'));
            $model->setState('list.filter', $this->getState('list.filter'));
            $model->setState('filter.tag', $this->getState('filter.tag'));

            // Filter.subcategories indicates whether to include products from subcategories in the list or blog
            $model->setState('filter.subcategories', $this->getState('filter.subcategories'));
            $model->setState('filter.max_category_levels', $this->getState('filter.max_category_levels'));
            $model->setState('list.links', $this->getState('list.links'));

            if ($limit >= 0) {
                $this->_products = $model->getItems();

                if ($this->_products === false) {
                    $this->setError($model->getError());
                }
            } else {
                $this->_products = array();
            }

            $this->_pagination = $model->getPagination();
        }
        return $this->_products;
    }

    /**
     * Build the orderby for the query
     *
     * @return  string	$orderby portion of query
     *
     * @since   1.5
     */
    protected function _buildStandardOrderBy() {
        $app = JFactory::getApplication('site');
        $db = $this->getDbo();
        $params = $this->state->params;
        $itemid = $app->input->get('id', 0, 'int') . ':' . $app->input->get('Itemid', 0, 'int');
        $orderCol = $app->getUserStateFromRequest('com_standard.category.list.' . $itemid . '.filter_order', 'filter_order', '', 'string');
        $orderDirn = $app->getUserStateFromRequest('com_standard.category.list.' . $itemid . '.filter_order_Dir', 'filter_order_Dir', '', 'cmd');
        $orderby = ' ';
        /*
          if (!in_array($orderCol, $this->filter_fields)) {
          $orderCol = null;
          }
         */
        if (!in_array(strtoupper($orderDirn), array('ASC', 'DESC', ''))) {
            $orderDirn = 'ASC';
        }

        if ($orderCol && $orderDirn) {
            $orderby .= $db->escape($orderCol) . ' ' . $db->escape($orderDirn) . ', ';
        }

        $articleOrderby = $params->get('orderby_sec', 'rdate');
        $articleOrderDate = $params->get('order_date');
        $categoryOrderby = $params->def('orderby_pri', '');
        $secondary = StandardHelperQuery::orderbySecondary($articleOrderby, $articleOrderDate) . ', ';
        $primary = StandardHelperQuery::orderbyPrimary($categoryOrderby);

        $orderby .= $primary . ' ' . $secondary . ' p.created ';

        return $orderby;
    }

    /**
     * Method to get a JPagination object for the data set.
     *
     * @return  JPagination  A JPagination object for the data set.
     *
     * @since   12.2
     */
    public function getPagination() {
        if (empty($this->_pagination)) {
            return null;
        }

        return $this->_pagination;
    }

}
