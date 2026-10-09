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
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;

JLoader::register('StandardHelperAssociation', JPATH_SITE . '/components/com_standard/helpers/association.php');

/**
 * This models supports retrieving lists of itineraries.
 *
 * @since  1.6
 */
class StandardModelItineraries extends JModelList {

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
                'id', 'i.id',
                'title', 'i.title',
                'alias', 'i.alias',
                'checked_out', 'i.checked_out',
                'checked_out_time', 'i.checked_out_time',
                'itinerarytype_id', 'i.itinerarytype_id', 'itinerarytype_title',
                'state', 'i.state',
                'access', 'i.access', 'access_level',
                'created', 'i.created',
                'created_by', 'i.created_by',
                'ordering', 'i.ordering',
                'featured', 'i.featured',
                'language', 'i.language',
                'hits', 'i.hits',
                'publish_up', 'i.publish_up',
                'publish_down', 'i.publish_down',
                'images', 'i.images',
                'urls', 'i.urls',
                'lft', 'it.lft',
                'rgt', 'it.rgt',
                'level', 'it.level',
                'path', 'it.path',
                'filter_tag',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * This method should only be called once per instantiation and is designed
     * to be called on the first call to the getState() method unless the model
     * configuration flag to ignore the request is set.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   3.0.1
     */
    protected function populateState($ordering = 'ordering', $direction = 'ASC') {
        $app = JFactory::getApplication();

        // List state information
        $value = $app->input->get('limit', $app->get('list_limit', 0), 'uint');
        $this->setState('list.limit', $value);

        $value = $app->input->get('limitstart', 0, 'uint');
        $this->setState('list.start', $value);

        $value = $app->input->get('filter_tag', 0, 'uint');
        $this->setState('filter.tag', $value);

        $orderCol = $app->input->get('filter_order', 'i.ordering');

        if (!in_array($orderCol, $this->filter_fields)) {
            $orderCol = 'i.ordering';
        }

        $this->setState('list.ordering', $orderCol);

        $listOrder = $app->input->get('filter_order_Dir', 'ASC');

        if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', ''))) {
            $listOrder = 'ASC';
        }

        $this->setState('list.direction', $listOrder);

        $params = $app->getParams();
        $this->setState('params', $params);
        $user = JFactory::getUser();

        if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
            // Filter on published for those who do not have edit or edit.state rights.
            $this->setState('filter.published', 1);
        }

        $this->setState('filter.language', JLanguageMultilang::isEnabled());

        // Process show_noauth parameter
        if ((!$params->get('show_noauth')) || (!JComponentHelper::getParams('com_standard')->get('show_noauth'))) {
            $this->setState('filter.access', true);
        } else {
            $this->setState('filter.access', false);
        }

        $this->setState('layout', $app->input->getString('layout'));
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
        $id .= ':' . serialize($this->getState('filter.published'));
        $id .= ':' . $this->getState('filter.access');
        $id .= ':' . $this->getState('filter.featured');
        $id .= ':' . serialize($this->getState('filter.itinerary_id'));
        $id .= ':' . $this->getState('filter.itinerary_id.include');
        $id .= ':' . serialize($this->getState('filter.itinerarytype_id'));
        $id .= ':' . $this->getState('filter.itinerarytype_id.include');
        $id .= ':' . serialize($this->getState('filter.author_id'));
        $id .= ':' . $this->getState('filter.author_id.include');
        $id .= ':' . serialize($this->getState('filter.author_alias'));
        $id .= ':' . $this->getState('filter.author_alias.include');
        $id .= ':' . $this->getState('filter.date_filtering');
        $id .= ':' . $this->getState('filter.date_field');
        $id .= ':' . $this->getState('filter.start_date_range');
        $id .= ':' . $this->getState('filter.end_date_range');
        $id .= ':' . $this->getState('filter.relative_date');
        $id .= ':' . serialize($this->getState('filter.tag'));

        return parent::getStoreId($id);
    }

    /**
     * Get the master query for retrieving a list of itineraries subject to the model state.
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    protected function getListQuery() {
        // Get the current user for authorisation checks
        $user = JFactory::getUser();

        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'i.id, i.title, i.alias, i.introtext, i.fulltext, i.merge_column'
                        . ', i.currency_id, i.price, i.in_stock, i.ordered'
                        . ', i.itinerarytype_id, i.product_id, i.paymenttype_id'
                        . ', i.number_days, i.number_nights'
                        . ', i.max_adult, i.max_children, i.max_infant'
                        . ', i.adult, i.children, i.infant'
                        . ', i.checked_out, i.checked_out_time'
                        . ', i.created, i.created_by, i.created_by_alias'

                        // Published/archived itinerary in archive itinerarytype is treats as archive itinerary
                        // If itinerarytype is not published then force 0
                        . ', CASE WHEN it.published = 2 AND i.state > 0 THEN 2 WHEN it.published != 1 THEN 0 ELSE i.state END as state'
                        // Use created if modified is 0
                        . ', CASE WHEN i.modified = ' . $db->quote($db->getNullDate()) . ' THEN i.created ELSE i.modified END as modified'
                        . ', i.modified_by, uam.name as modified_by_name'
                        // Use created if publish_up is 0
                        . ', CASE WHEN i.publish_up = ' . $db->quote($db->getNullDate()) . ' THEN i.created ELSE i.publish_up END as publish_up'
                        . ', i.publish_down'
                        . ', i.images, i.childimages, i.banners, i.banner_status, i.urls'
                        . ', i.attribs, i.metadata, i.metakey, i.metadesc, i.access'
                        . ', i.hits, i.xreference, i.featured, i.language, ' . ' ' . $query->length('i.fulltext') . ' AS readmore, i.ordering'
                )
        );

        $query->from('#__standard_itineraries AS i');

        $params = $this->getState('params');
        $orderby_sec = $params->get('orderby_sec');

        // Join over the frontpage itineraries if required.
        if ($this->getState('filter.frontpage')) {
            if ($orderby_sec === 'front') {
                $query->select('fp.ordering');
                $query->join('INNER', '#__standard_itineraries_frontpage AS fp ON fp.content_id = i.id');
            } else {
                $query->where('i.featured = 1');
            }
        } elseif ($orderby_sec === 'front' || $this->getState('list.ordering') === 'fp.ordering') {
            $query->select('fp.ordering');
            $query->join('LEFT', '#__standard_itineraries_frontpage AS fp ON fp.content_id = i.id');
        }

        // Join over the itinerary types.
        $query->select('it.id AS itinerarytypeID, it.title AS itinerarytype_title, it.alias AS itinerarytype_alias'
                        . ', it.path AS itinerarytype_route, it.access AS itinerarytype_access'
                        . ', it.description AS itinerarytype_description')
                ->select('it.published, it.published AS parents_published, it.lft')
                ->join('LEFT', '#__standard_itinerary_types AS it ON it.id = i.itinerarytype_id');
        /*
        // Join over the products.
        $query->select('p.id as productID, p.paymenttype_id')
                ->join('LEFT', '#__standard_products AS p ON i.product_id = p.id');
        */
        // Join over the users for the author and modified_by names.
        $query->select("CASE WHEN i.created_by_alias > ' ' THEN i.created_by_alias ELSE ua.name END AS author")
                ->select('ua.email AS author_email')
                ->join('LEFT', '#__users AS ua ON ua.id = i.created_by')
                ->join('LEFT', '#__users AS uam ON uam.id = i.modified_by');

        // Join over the itinerary types to get parent itinerarytype titles
        $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
                ->join('LEFT', '#__standard_itinerary_types as parent ON parent.id = it.parent_id');

        if (JPluginHelper::isEnabled('content', 'vote')) {
            // Join on voting table
            $query->select('COALESCE(NULLIF(ROUND(v.rating_sum  / v.rating_count, 0), 0), 0) AS rating,
							COALESCE(NULLIF(v.rating_count, 0), 0) as rating_count')
                    ->join('LEFT', '#__standard_itineraries_rating AS v ON i.id = v.content_id');
        }

        // Filter by access level.
        if ($this->getState('filter.access', true)) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('i.access IN (' . $groups . ')')
                    ->where('it.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published) && $published == 2) {
            /**
             * If itinerarytype is archived then itinerary has to be published or archived.
             * Or categogy is published then itinerary has to be archived.
             */
            $query->where('((it.published = 2 AND i.state > 0) OR (it.published = 1 AND i.state = 2))');
        } elseif (is_numeric($published)) {
            // Category has to be published
            $query->where('it.published = 1 AND i.state = ' . (int) $published);
        } elseif (is_array($published)) {
            $published = ArrayHelper::toInteger($published);
            $published = implode(',', $published);

            // Category has to be published
            $query->where('it.published = 1 AND i.state IN (' . $published . ')');
        }

        // Filter by featured state
        $featured = $this->getState('filter.featured');

        switch ($featured) {
            case 'hide':
                $query->where('i.featured = 0');
                break;

            case 'only':
                $query->where('i.featured = 1');
                break;

            case 'show':
            default:
                // Normally we do not discriminate between featured/unfeatured items.
                break;
        }

        // Filter by a single or group of itineraries.
        $itineraryId = $this->getState('filter.itinerary_id');

        if (is_numeric($itineraryId)) {
            $type = $this->getState('filter.itinerary_id.include', true) ? '= ' : '<> ';
            $query->where('i.id ' . $type . (int) $itineraryId);
        } elseif (is_array($itineraryId)) {
            $itineraryId = ArrayHelper::toInteger($itineraryId);
            $itineraryId = implode(',', $itineraryId);
            $type = $this->getState('filter.itinerary_id.include', true) ? 'IN' : 'NOT IN';
            $query->where('i.id ' . $type . ' (' . $itineraryId . ')');
        }

        // Filter by a single or group of itinerary types
        $itinerarytypeId = $this->getState('filter.itinerarytype_id');

        if (is_numeric($itinerarytypeId)) {
            $type = $this->getState('filter.itinerarytype_id.include', true) ? '= ' : '<> ';

            // Add subitinerarytype check
            $includeSubitinerarytypes = $this->getState('filter.subitinerarytypes', false);
            $itinerarytypeEquals = 'i.itinerarytype_id ' . $type . (int) $itinerarytypeId;

            if ($includeSubitinerarytypes) {
                $levels = (int) $this->getState('filter.max_itinerarytype_levels', '1');

                // Create a subquery for the subitinerarytype list
                $subQuery = $db->getQuery(true)
                        ->select('sub.id')
                        ->from('#__standard_itinerary_types as sub')
                        ->join('INNER', '#__standard_itinerary_types as this ON sub.lft > this.lft AND sub.rgt < this.rgt')
                        ->where('this.id = ' . (int) $itinerarytypeId);

                if ($levels >= 0) {
                    $subQuery->where('sub.level <= this.level + ' . $levels);
                }

                // Add the subquery to the main query
                $query->where('(' . $itinerarytypeEquals . ' OR i.itinerarytype_id IN (' . (string) $subQuery . '))');
            } else {
                $query->where($itinerarytypeEquals);
            }
        } elseif (is_array($itinerarytypeId) && (count($itinerarytypeId) > 0)) {
            $itinerarytypeId = ArrayHelper::toInteger($itinerarytypeId);
            $itinerarytypeId = implode(',', $itinerarytypeId);

            if (!empty($itinerarytypeId)) {
                $type = $this->getState('filter.itinerarytype_id.include', true) ? 'IN' : 'NOT IN';
                $query->where('i.itinerarytype_id ' . $type . ' (' . $itinerarytypeId . ')');
            }
        }

        // Filter by a single or group of Related Informations
        $productId = $this->getState('filter.product_id');
        if (is_numeric($productId)) {
            $query->where('i.product_id =' . $productId);
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');
        $authorWhere = '';

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<> ';
            $authorWhere = 'i.created_by ' . $type . (int) $authorId;
        } elseif (is_array($authorId)) {
            $authorId = array_filter($authorId, 'is_numeric');

            if ($authorId) {
                $authorId = implode(',', $authorId);
                $type = $this->getState('filter.author_id.include', true) ? 'IN' : 'NOT IN';
                $authorWhere = 'i.created_by ' . $type . ' (' . $authorId . ')';
            }
        }

        // Filter by author alias
        $authorAlias = $this->getState('filter.author_alias');
        $authorAliasWhere = '';

        if (is_string($authorAlias)) {
            $type = $this->getState('filter.author_alias.include', true) ? '= ' : '<> ';
            $authorAliasWhere = 'i.created_by_alias ' . $type . $db->quote($authorAlias);
        } elseif (is_array($authorAlias)) {
            $first = current($authorAlias);

            if (!empty($first)) {
                foreach ($authorAlias as $key => $alias) {
                    $authorAlias[$key] = $db->quote($alias);
                }

                $authorAlias = implode(',', $authorAlias);

                if ($authorAlias) {
                    $type = $this->getState('filter.author_alias.include', true) ? 'IN' : 'NOT IN';
                    $authorAliasWhere = 'i.created_by_alias ' . $type . ' (' . $authorAlias .
                            ')';
                }
            }
        }

        if (!empty($authorWhere) && !empty($authorAliasWhere)) {
            $query->where('(' . $authorWhere . ' OR ' . $authorAliasWhere . ')');
        } elseif (empty($authorWhere) && empty($authorAliasWhere)) {
            // If both are empty we don't want to add to the query
        } else {
            // One of these is empty, the other is not so we just add both
            $query->where($authorWhere . $authorAliasWhere);
        }

        // Define null and now dates
        $nullDate = $db->quote($db->getNullDate());
        $nowDate = $db->quote(JFactory::getDate()->toSql());

        // Filter by start and end dates.
        if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
            $query->where('(i.publish_up = ' . $nullDate . ' OR i.publish_up <= ' . $nowDate . ')')
                    ->where('(i.publish_down = ' . $nullDate . ' OR i.publish_down >= ' . $nowDate . ')');
        }

        // Filter by Date Range or Relative Date
        $dateFiltering = $this->getState('filter.date_filtering', 'off');
        $dateField = $this->getState('filter.date_field', 'i.created');

        switch ($dateFiltering) {
            case 'range':
                $startDateRange = $db->quote($this->getState('filter.start_date_range', $nullDate));
                $endDateRange = $db->quote($this->getState('filter.end_date_range', $nullDate));
                $query->where(
                        '(' . $dateField . ' >= ' . $startDateRange . ' AND ' . $dateField .
                        ' <= ' . $endDateRange . ')'
                );
                break;

            case 'relative':
                $relativeDate = (int) $this->getState('filter.relative_date', 0);
                $query->where(
                        $dateField . ' >= ' . $query->dateAdd($nowDate, -1 * $relativeDate, 'DAY')
                );
                break;

            case 'off':
            default:
                break;
        }

        // Process the filter for list views with user-entered filters
        if (is_object($params) && ($params->get('filter_field') !== 'hide') && ($filter = $this->getState('list.filter'))) {
            // Clean filter variable
            $filter = StringHelper::strtolower($filter);
            $monthFilter = $filter;
            $hitsFilter = (int) $filter;
            $filter = $db->quote('%' . $db->escape($filter, true) . '%', false);

            switch ($params->get('filter_field')) {
                case 'author':
                    $query->where(
                            'LOWER( CASE WHEN i.created_by_alias > ' . $db->quote(' ') .
                            ' THEN i.created_by_alias ELSE ua.name END ) LIKE ' . $filter . ' '
                    );
                    break;

                case 'hits':
                    $query->where('i.hits >= ' . $hitsFilter . ' ');
                    break;

                case 'month':
                    if ($monthFilter != '') {
                        $query->where(
                                $db->quote(date("Y-m-d", strtotime($monthFilter)) . ' 00:00:00') . ' <= CASE WHEN i.publish_up = ' .
                                $db->quote($db->getNullDate()) . ' THEN i.created ELSE i.publish_up END'
                        );

                        $query->where(
                                $db->quote(date("Y-m-t", strtotime($monthFilter)) . ' 23:59:59') . ' >= CASE WHEN i.publish_up = ' .
                                $db->quote($db->getNullDate()) . ' THEN i.created ELSE i.publish_up END'
                        );
                    }
                    break;

                case 'title':
                default:
                    // Default to 'title' if parameter is not valid
                    $query->where('LOWER( i.title ) LIKE ' . $filter);
                    break;
            }
        }

        // Filter by language
        if ($this->getState('filter.language')) {
            $query->where('i.language IN (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
        }

        // Filter by a single or group of tags.
        $tagId = $this->getState('filter.tag');

        if (is_array($tagId) && count($tagId) === 1) {
            $tagId = current($tagId);
        }

        if (is_array($tagId)) {
            $tagId = implode(',', ArrayHelper::toInteger($tagId));

            if ($tagId) {
                $subQuery = $db->getQuery(true)
                        ->select('DISTINCT itinerary_item_id')
                        ->from($db->quoteName('#__standard_itineraries_item_tag_map'))
                        ->where('tag_id IN (' . $tagId . ')')
                        ->where('type_alias = ' . $db->quote('com_standard.itinerary'));

                $query->innerJoin('(' . (string) $subQuery . ') AS tagmap ON tagmap.itinerary_item_id = i.id');
            }
        } elseif ($tagId) {
            $query->innerJoin(
                    $db->quoteName('#__standard_itineraries_item_tag_map', 'tagmap')
                    . ' ON tagmap.tag_id = ' . (int) $tagId
                    . ' AND tagmap.itinerary_item_id = i.id'
                    . ' AND tagmap.type_alias = ' . $db->quote('com_standard.itinerary')
            );
        }

        // Add the list ordering clause.
        // set order temp 
        $listOrdering = $this->getState('list.ordering', 'i.ordering');
        $listDirn = $db->escape($this->getState('list.direction', 'ASC'));
        if (true):
            $query->order('it.lft ' . $listDirn . ', i.itinerarytype_id ' . $listDirn . ', i.ordering ' . $listDirn);
        else:
            // $query->order($db->escape($listOrdering) . ' ' . $listDirn);
            // root order
            $query->order($this->getState('list.ordering', 'i.ordering') . ' ' . $this->getState('list.direction', 'ASC'));
        endif;

        //echo nl2br(str_replace('#__', 'dpjvy_', $query));
        //exit;

        return $query;
    }

    /**
     * Method to get a list of itineraries.
     *
     * Overriden to inject convert the attribs field into a JParameter object.
     *
     * @return  mixed  An array of objects on success, false on failure.
     *
     * @since   1.6
     */
    public function getItems() {
        $items = parent::getItems();
        $user = JFactory::getUser();
        $userId = $user->get('id');
        $guest = $user->get('guest');
        $groups = $user->getAuthorisedViewLevels();
        $input = JFactory::getApplication()->input;

        // Get the global params
        $globalParams = JComponentHelper::getParams('com_standard', true);

        // Convert the parameter fields into objects.
        foreach ($items as &$item) {
            $itineraryParams = new Registry($item->attribs);

            // Unpack readmore and layout params
            $item->alternative_readmore = $itineraryParams->get('alternative_readmore');
            $item->layout = $itineraryParams->get('layout');

            $item->params = clone $this->getState('params');

            /**
             * For blogs, itinerary params override menu item params only if menu param = 'use_itinerary'
             * Otherwise, menu item params control the layout
             * If menu item is 'use_itinerary' and there is no itinerary param, use global
             */
            if (($input->getString('layout') === 'blog') || ($input->getString('view') === 'featured') || ($this->getState('params')->get('layout_type') === 'blog')) {
                // Create an array of just the params set to 'use_itinerary'
                $menuParamsArray = $this->getState('params')->toArray();
                $itineraryArray = array();

                foreach ($menuParamsArray as $key => $value) {
                    if ($value === 'use_itinerary') {
                        // If the itinerary has a value, use it
                        if ($itineraryParams->get($key) != '') {
                            // Get the value from the itinerary
                            $itineraryArray[$key] = $itineraryParams->get($key);
                        } else {
                            // Otherwise, use the global value
                            $itineraryArray[$key] = $globalParams->get($key);
                        }
                    }
                }

                // Merge the selected itinerary params
                if (count($itineraryArray) > 0) {
                    $itineraryParams = new Registry($itineraryArray);
                    $item->params->merge($itineraryParams);
                }
            } else {
                // For non-blog layouts, merge all of the itinerary params
                $item->params->merge($itineraryParams);
            }

            // Get display date
            switch ($item->params->get('list_show_date')) {
                case 'modified':
                    $item->displayDate = $item->modified;
                    break;

                case 'published':
                    $item->displayDate = ($item->publish_up == 0) ? $item->created : $item->publish_up;
                    break;

                default:
                case 'created':
                    $item->displayDate = $item->created;
                    break;
            }

            /**
             * Compute the asset access permissions.
             * Technically guest could edit an itinerary, but lets not check that to improve performance a little.
             */
            if (!$guest) {
                $asset = 'com_standard.itinerary.' . $item->id;

                // Check general edit permission first.
                if ($user->authorise('core.edit', $asset)) {
                    $item->params->set('access-edit', true);
                }

                // Now check if edit.own is available.
                elseif (!empty($userId) && $user->authorise('core.edit.own', $asset)) {
                    // Check for a valid user and that they are the owner.
                    if ($userId == $item->created_by) {
                        $item->params->set('access-edit', true);
                    }
                }
            }

            $access = $this->getState('filter.access');

            if ($access) {
                // If the access filter has been set, we already have only the itineraries this user can view.
                $item->params->set('access-view', true);
            } else {
                // If no access filter is set, the layout takes some responsibility for display of limited information.
                if ($item->itinerarytype_id == 0 || $item->itinerarytype_access === null) {
                    $item->params->set('access-view', in_array($item->access, $groups));
                } else {
                    $item->params->set('access-view', in_array($item->access, $groups) && in_array($item->itinerarytype_access, $groups));
                }
            }

            // Some contexts may not use tags data at all, so we allow callers to disable loading tag data
            if ($this->getState('load_tags', $item->params->get('show_tags', '1'))) {
                $item->tags = new JHelperTags;
                $item->tags->getItemTags('com_standard.itinerary', $item->id);
            }

            if ($item->params->get('show_associations')) {
                $item->associations = StandardHelperAssociation::displayAssociations($item->id);
            }
        }
        
        return $items;
    }

    /**
     * Method to get the starting number of items for the data set.
     *
     * @return  integer  The starting number of items available in the data set.
     *
     * @since   3.0.1
     */
    public function getStart() {
        return $this->getState('list.start');
    }

    /**
     * Count Items by Month
     *
     * @return  mixed  An array of objects on success, false on failure.
     *
     * @since   3.9.0
     */
    public function countItemsByMonth() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query
                ->select('DATE(' .
                        $query->concatenate(
                                array(
                                    $query->year($query->quoteName('publish_up')),
                                    $query->quote('-'),
                                    $query->month($query->quoteName('publish_up')),
                                    $query->quote('-01')
                                )
                        ) . ') as d'
                )
                ->select('COUNT(*) as c')
                ->from('(' . $this->getListQuery() . ') as b')
                ->group($query->quoteName('d'))
                ->order($query->quoteName('d') . ' desc');

        return $db->setQuery($query)->loadObjectList();
    }

}
