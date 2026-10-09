<?php

/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Joomla\Utilities\IpHelper;

/**
 * Standard Component Itinerary Model
 *
 * @since  1.5
 */
class StandardModelItinerary extends JModelItem {

    /**
     * Model context string.
     *
     * @var        string
     */
    protected $_context = 'com_standard.itinerary';

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
        
        // --- load page location (section scrolling form) ----
        // List state information "Form Post"
        $aFormPost = $app->input->post->get('jform', array(), 'array');
        if (isset($aFormPost['tour_id'])):
            $app->setUserState('com_standard.filter.tour_id', $aFormPost['tour_id']);
        else:
            $app->setUserState('com_standard.filter.tour_id', $app->getUserState('com_standard.filter.tour_id', 0));
        endif;
        // --- /.load page location (section scrolling form) ----
        
        // Load state from the request.
        $pk = $app->input->getInt('id');
        $this->setState('itinerary.id', $pk);

        $offset = $app->input->getUInt('limitstart');
        $this->setState('list.offset', $offset);

        // Load the parameters.
        $params = $app->getParams();
        $this->setState('params', $params);

        $user = JFactory::getUser();

        // If $pk is set then authorise on complete asset, else on component only
        $asset = empty($pk) ? 'com_standard' : 'com_standard.itinerary.' . $pk;

        if ((!$user->authorise('core.edit.state', $asset)) && (!$user->authorise('core.edit', $asset))) {
            $this->setState('filter.published', 1);
            $this->setState('filter.archived', 2);
        }

        $this->setState('filter.language', JLanguageMultilang::isEnabled());
    }

    /**
     * Method to get itinerary data.
     *
     * @param   integer  $pk  The id of the itinerary.
     *
     * @return  object|boolean|JException  Menu item data object on success, boolean false or JException instance on error
     */
    public function getItem($pk = null) {
        $user = JFactory::getUser();

        $pk = (!empty($pk)) ? $pk : (int) $this->getState('itinerary.id');

        if ($this->_item === null) {
            $this->_item = array();
        }

        if (!isset($this->_item[$pk])) {
            try {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                        ->select(
                        $this->getState(
                                'item.select', 'i.id, i.asset_id, i.title, i.alias, i.introtext, i.fulltext'
                                . ', i.state, i.itinerarytype_id, i.product_id, i.paymenttype_id'
                                . ', i.created, i.created_by, i.created_by_alias'
                                . ', i.currency_id, i.price, i.in_stock, i.ordered'
                                . ', i.number_days, i.number_nights'
                                . ', i.max_adult, i.max_children, i.max_infant'
                                . ', i.adult, i.children, i.infant'

                                // Use created if modified is 0
                                . ', CASE WHEN i.modified = ' . $db->quote($db->getNullDate()) . ' THEN i.created ELSE i.modified END as modified'
                                . ', i.modified_by, i.checked_out, i.checked_out_time, i.publish_up, i.publish_down'
                                . ', i.images, i.childimages'
                                . ', i.banners, i.banners_tablet, i.banners_phone, i.banner_status, i.banner_home'
                                . ', i.gallery_mediadisplaytype, i.gallery_layout, i.gallery_medialayoutelement, i.galleries'
                                . ', i.videos, i.aspect_ratio, i.frame_rate, i.urls'
                                . ', i.overview'
                                . ', i.itinerary_layoutelement, i.itinerary_title, i.itinerary_displaytype_id, i.itinerary_column, i.itinerary'
                                . ', i.displaytype_id, i.description_title, i.descriptions, i.description_column, i.merge_column'
                                . ', i.attribs, i.version, i.ordering'
                                . ', i.metakey, i.metadesc, i.access, i.hits, i.metadata, i.featured, i.language, i.xreference'
                        )
                );
                $query->from('#__standard_itineraries AS i')
                        ->where('i.id = ' . (int) $pk);
                /*
                  // Join on category table.
                  $query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access')
                  ->innerJoin('#__categories AS c on c.id = i.catid')
                  ->where('c.published > 0');
                 */

                // Join on itinerarytype table.
                $query->select('it.title AS itinerarytype_title, it.alias AS itinerarytype_alias, it.access AS itinerarytype_access')
                        ->innerJoin('#__standard_itinerary_types AS it on it.id = i.itinerarytype_id')
                        ->where('it.published > 0');

                // Join on user table.
                $query->select('u.name AS author')
                        ->join('LEFT', '#__users AS u on u.id = i.created_by');

                // Filter by language
                if ($this->getState('filter.language')) {
                    $query->where('i.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
                }
                /*
                  // Join over the categories to get parent category titles
                  $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
                  ->join('LEFT', '#__categories as parent ON parent.id = c.parent_id');
                 */

                // Join over the categories to get parent itinerarytype titles
                $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
                        ->join('LEFT', '#__standard_itinerary_types as parent ON parent.id = it.parent_id');

                // Join on voting table
                $query->select('ROUND(v.rating_sum / v.rating_count, 0) AS rating, v.rating_count as rating_count')
                        ->join('LEFT', '#__standard_itineraries_rating AS v ON i.id = v.itinerary_id');

                if ((!$user->authorise('core.edit.state', 'com_standard.itinerary.' . $pk)) && (!$user->authorise('core.edit', 'com_standard.itinerary.' . $pk))) {
                    // Filter by start and end dates.
                    $nullDate = $db->quote($db->getNullDate());
                    $date = JFactory::getDate();

                    $nowDate = $db->quote($date->toSql());

                    $query->where('(i.publish_up = ' . $nullDate . ' OR i.publish_up <= ' . $nowDate . ')')
                            ->where('(i.publish_down = ' . $nullDate . ' OR i.publish_down >= ' . $nowDate . ')');
                }

                // Filter by published state.
                $published = $this->getState('filter.published');
                $archived = $this->getState('filter.archived');

                if (is_numeric($published)) {
                    $query->where('(i.state = ' . (int) $published . ' OR i.state =' . (int) $archived . ')');
                }

                $db->setQuery($query);

                $data = $db->loadObject();

                if (empty($data)) {
                    return JError::raiseError(404, JText::_('COM_CONTENT_ERROR_ARTICLE_NOT_FOUND'));
                }

                // Check for published state if filter set.
                if ((is_numeric($published) || is_numeric($archived)) && (($data->state != $published) && ($data->state != $archived))) {
                    return JError::raiseError(404, JText::_('COM_CONTENT_ERROR_ARTICLE_NOT_FOUND'));
                }

                // Convert parameter fields to objects.
                $registry = new Registry($data->attribs);

                $data->params = clone $this->getState('params');
                $data->params->merge($registry);

                $data->metadata = new Registry($data->metadata);

                // Technically guest could edit an itinerary, but lets not check that to improve performance a little.
                if (!$user->get('guest')) {
                    $userId = $user->get('id');
                    $asset = 'com_standard.itinerary.' . $data->id;

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

                    if ($data->itinerarytype_id == 0 || $data->itinerarytype_access === null) {
                        $data->params->set('access-view', in_array($data->access, $groups));
                    } else {
                        $data->params->set('access-view', in_array($data->access, $groups) && in_array($data->itinerarytype_access, $groups));
                    }
                }

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
     * Increment the hit counter for the itinerary.
     *
     * @param   integer  $pk  Optional primary key of the itinerary to increment.
     *
     * @return  boolean  True if successful; false otherwise and internal error set.
     */
    public function hit($pk = 0) {
        $input = JFactory::getApplication()->input;
        $hitcount = $input->getInt('hitcount', 1);

        if ($hitcount) {
            $pk = (!empty($pk)) ? $pk : (int) $this->getState('itinerary.id');

            $table = JTable::getInstance('Itinerary', 'StandardTable');
            $table->load($pk);
            $table->hit($pk);
        }

        return true;
    }

    /**
     * Save user vote on itinerary
     *
     * @param   integer  $pk    Giaiphapcongnghethongtin Itinerary Id
     * @param   integer  $rate  Voting rate
     *
     * @return  boolean          Return true on success
     */
    public function storeVote($pk = 0, $rate = 0) {
        if ($rate >= 1 && $rate <= 5 && $pk > 0) {
            $userIP = IpHelper::getIp();

            // Initialize variables.
            $db = $this->getDbo();
            $query = $db->getQuery(true);

            // Create the base select statement.
            $query->select('*')
                    ->from($db->quoteName('#__standard_itineraries_rating'))
                    ->where($db->quoteName('itinerary_id') . ' = ' . (int) $pk);

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
                $query->insert($db->quoteName('#__standard_itineraries_rating'))
                        ->columns(array($db->quoteName('itinerary_id'), $db->quoteName('lastip'), $db->quoteName('rating_sum'), $db->quoteName('rating_count')))
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
                    $query->update($db->quoteName('#__standard_itineraries_rating'))
                            ->set($db->quoteName('rating_count') . ' = rating_count + 1')
                            ->set($db->quoteName('rating_sum') . ' = rating_sum + ' . (int) $rate)
                            ->set($db->quoteName('lastip') . ' = ' . $db->quote($userIP))
                            ->where($db->quoteName('itinerary_id') . ' = ' . (int) $pk);

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

            $this->cleanCache();

            return true;
        }

        JError::raiseWarning(500, JText::sprintf('COM_CONTENT_INVALID_RATING', $rate), "JModelArticle::storeVote($rate)");

        return false;
    }

    public function getForm($data = array(), $loadData = true) {
        // Get an instance of the generic products model
        $model = JModelLegacy::getInstance('Contact', 'StandardModel', array('ignore_request' => true));
        // Retrieve Standard
        $form = $model->getForm(array(), true, 'contactRequest');
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    public function getLink($item) {
        $link = '';
        $app = JFactory::getApplication();

        if (isset($item)):
            // Convert the links field to an array.
            $registry = new Registry($item);
            $aLinks = $registry->toArray();
            if (!empty($aLinks) && sizeof($aLinks) > 0):
                switch ($aLinks['linktype']) {
                    case 'menu':

                        if ($menuid = $aLinks['linkmenu']) {

                            $menu = $app->getMenu();
                            $menuitem = $menu->getItem($menuid);

                            if ($menuitem)
                                switch ($menuitem->type) {
                                    case 'component':
                                        $link = JRoute::_($menuitem->link . '&Itemid=' . $menuid);
                                        break;
                                    case 'url':
                                    case 'alias':
                                        $link = JRoute::_($menuitem->link);
                                        break;
                                }
                        }
                        break;

                    case 'linkurl':

                        if ($itemurl = $aLinks['link_url']) {
                            $link = JRoute::_($itemurl);
                        }
                        break;

                    case 'linkarticle':

                        break;
                }
            endif;
        endif;

        return $link;
    }

    /**
     * Cleans the cache of com_standard and content modules
     *
     * @param   string   $group     The cache group
     * @param   integer  $clientId  The ID of the client
     *
     * @return  void
     *
     * @since   3.9.9
     */
    protected function cleanCache($group = null, $clientId = 0) {
        parent::cleanCache('com_standard');
        parent::cleanCache('mod_product_itineraries');
    }

}
