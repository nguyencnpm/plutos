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
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;

/**
 * Frontpage Component Model
 *
 * @since  1.5
 */
class StandardModelPromotions extends JModelList {

    /**
     * Model context string.
     *
     * @var		string
     */
    public $_context = 'com_standard.promotions';

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
                'id', 'prm.id',
                'title', 'prm.title',
                'alias', 'prm.alias',
                'code', 'prm.code',
                'checked_out', 'prm.checked_out',
                'checked_out_time', 'prm.checked_out_time',
                'catid', 'prm.catid', 'category_title',
                'state', 'prm.state',
                'access', 'prm.access', 'access_level',
                'created', 'prm.created',
                'created_by', 'prm.created_by',
                'ordering', 'prm.ordering',
                'featured', 'prm.featured',
                'language', 'prm.language',
                'hits', 'prm.hits',
                'publish_up', 'prm.publish_up',
                'publish_down', 'prm.publish_down',
                'images', 'prm.images',
                'urls', 'prm.urls',
                'filter_tag'
            );
        }

        parent::__construct($config);
    }

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

        $params = $app->getParams();
        $this->setState('params', $params);
        $user = JFactory::getUser();
        // List state information
        $value = $params->get('num_leading_products') + $params->get('num_intro_products') + $params->get('num_links');
        // $value = $app->input->get('limit', $app->get('list_limit', 0), 'uint');
        $this->setState('list.limit', $value);
        $this->setState('list.links', $params->get('num_links'));

        $value = $app->input->get('limitstart', 0, 'uint');
        $this->setState('list.start', $value);

        $value = $app->input->get('filter_tag', 0, 'uint');
        $this->setState('filter.tag', $value);

        $orderCol = $app->input->get('filter_order', 'prm.ordering');

        if (!in_array($orderCol, $this->filter_fields)) {
            $orderCol = 'p.ordering';
        }

        $this->setState('list.ordering', $orderCol);

        $listOrder = $app->input->get('filter_order_Dir', 'ASC');

        if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', ''))) {
            $listOrder = 'ASC';
        }

        $this->setState('list.direction', $listOrder);



        if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
            // Filter on published for those who do not have edit or edit.state rights.
            $this->setState('filter.published', 1);
        }

        $this->setState('filter.language', JLanguageMultilang::isEnabled());

        // Process show_noauth parameter
        if (!$params->get('show_noauth')) {
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
        $id .= ':' . $this->getState('filter.promotions');
        $id .= ':' . serialize($this->getState('filter.product_id'));
        $id .= ':' . $this->getState('filter.product_id.include');
        $id .= ':' . serialize($this->getState('filter.category_id'));
        $id .= ':' . $this->getState('filter.category_id.include');
        $id .= ':' . serialize($this->getState('filter.author_id'));
        $id .= ':' . $this->getState('filter.author_id.include');
        $id .= ':' . serialize($this->getState('filter.author_alias'));
        $id .= ':' . $this->getState('filter.author_alias.include');
        $id .= ':' . $this->getState('filter.date_filtering');
        $id .= ':' . $this->getState('filter.date_field');
        $id .= ':' . $this->getState('filter.start_date_range');
        $id .= ':' . $this->getState('filter.end_date_range');
        $id .= ':' . $this->getState('filter.relative_date');

        return parent::getStoreId($id);
    }

    /**
     * Get the master query for retrieving a list of promotions subject to the model state.
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
                        'list.select', 'prm.id, prm.title, prm.alias, prm.introtext, prm.fulltext'
                        . ', prm.value_mathop, prm.value as price, prm.currency_id'
                        . ', prm.start_date, prm.expiry_date'
                        . ', prm.checked_out, prm.checked_out_time'
                        // . ', prm.catid'
                        . ', prm.created, prm.created_by, prm.created_by_alias'
                        // Published/archived product in archive category is treats as archive product
                        // If category is not published then force 0
                        // . ', CASE WHEN c.published = 2 AND prm.state > 0 THEN 2 WHEN c.published != 1 THEN 0 ELSE prm.state END as state'
                        . ', prm.state'
                        // Use created if modified is 0
                        . ', CASE WHEN prm.modified = ' . $db->quote($db->getNullDate()) . ' THEN prm.created ELSE prm.modified END as modified'
                        . ', prm.modified_by, uam.name as modified_by_name'
                        // Use created if publish_up is 0
                        . ', CASE WHEN prm.publish_up = ' . $db->quote($db->getNullDate()) . ' THEN prm.created ELSE prm.publish_up END as publish_up'
                        . ', prm.publish_down'
                        . ', prm.images, prm.childimages'
                        // . ', prm.banners, prm.banners_tablet, prm.banners_phone, prm.banner_status'
                        . ', prm.urls'
                        // . ', prm.attribs'
                        . ', prm.metadata, prm.metakey, prm.metadesc, prm.access'
                        // . ', prm.hits, prm.xreference, prm.featured'
                        . ', prm.language, ' . ' ' . $query->length('prm.fulltext') . ' AS readmore'
                )
        );

        $query->from('#__standard_promotions AS prm');

        $params = $this->getState('params');
        $orderby_sec = $params->get('orderby_sec');

        // Join over the frontpage promotions if required.
        if ($this->getState('filter.frontpage')) {
            if ($orderby_sec === 'front') {
                $query->join('INNER', '#__standard_promotions_frontpage AS fp ON fp.content_id = prm.id');
            } else {
                $query->where('prm.featured = 1');
            }
        } elseif ($orderby_sec === 'front' || $this->getState('list.ordering') === 'fp.ordering') {
            $query->join('LEFT', '#__standard_promotions_frontpage AS fp ON fp.content_id = prm.id');
        }
        /*
          // Join over the categories.
          $query->select('c.title AS category_title, c.path AS category_route, c.access AS category_access, c.alias AS category_alias')
          ->select('c.published, c.published AS parents_published')
          ->join('LEFT', '#__standard_categories AS c ON c.id = prm.catid');
         */
        // Join over the manufacturer.
        $query->select('GROUP_CONCAT(m.id SEPARATOR ", ") as manufacturer_ids, GROUP_CONCAT(m.title SEPARATOR ", ") as manufacturer_title')
                ->join('LEFT', '#__standard_product_manufacturer_map AS map ON map.product_id = prm.id')
                ->join('LEFT', '#__standard_manufacturers AS m ON m.id = map.manufacturer_id and m.state in(1)')
                ->group('prm.id');

        // Join over the users for the author and modified_by names.
        $query->select("CASE WHEN prm.created_by_alias > ' ' THEN prm.created_by_alias ELSE ua.name END AS author")
                ->select('ua.email AS author_email')
                ->join('LEFT', '#__users AS ua ON ua.id = prm.created_by')
                ->join('LEFT', '#__users AS uam ON uam.id = prm.modified_by');
        /*
          // Join over the categories to get parent category titles
          $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
          ->join('LEFT', '#__standard_categories as parent ON parent.id = c.parent_id');
         */
        if (JPluginHelper::isEnabled('content', 'vote')) {
            // Join on voting table
            $query->select('COALESCE(NULLIF(ROUND(v.rating_sum  / v.rating_count, 0), 0), 0) AS rating, 
							COALESCE(NULLIF(v.rating_count, 0), 0) as rating_count')
                    ->join('LEFT', '#__content_rating AS v ON prm.id = v.content_id');
        }
        /*
          // Filter by access level.
          if ($access = $this->getState('filter.access')) {
          $groups = implode(',', $user->getAuthorisedViewLevels());
          $query->where('prm.access IN (' . $groups . ')')
          ->where('c.access IN (' . $groups . ')');
          }
         */

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published) && $published == 2) {
            // If category is archived then product has to be published or archived.
            // If categogy is published then product has to be archived.
            $query->where('(prm.state > 0) OR (prm.state = 2)');
        } elseif (is_numeric($published)) {
            // Category has to be published
            $query->where('prm.state = ' . (int) $published);
        } elseif (is_array($published)) {
            $published = ArrayHelper::toInteger($published);
            $published = implode(',', $published);

            // Category has to be published
            $query->where('prm.state IN (' . $published . ')');
        }

        // Filter by featured state
        $featured = $this->getState('filter.featured');

        switch ($featured) {
            case 'hide':
                $query->where('prm.featured = 0');
                break;

            case 'only':
                $query->where('prm.featured = 1');
                break;

            case 'show':
            default:
                // Normally we do not discriminate
                // between featured/unfeatured items.
                break;
        }

        // Filter by a single or group of promotions.
        $productId = $this->getState('filter.product_id');

        if (is_numeric($productId)) {
            $type = $this->getState('filter.product_id.include', true) ? '= ' : '<> ';
            $query->where('prm.id ' . $type . (int) $productId);
        } elseif (is_array($productId)) {
            $productId = ArrayHelper::toInteger($productId);
            $productId = implode(',', $productId);
            $type = $this->getState('filter.product_id.include', true) ? 'IN' : 'NOT IN';
            $query->where('prm.id ' . $type . ' (' . $productId . ')');
        }

        // Filter by a single or group of categories
        $categoryId = $this->getState('filter.category_id');

        if (is_numeric($categoryId)) {
            $type = $this->getState('filter.category_id.include', true) ? '= ' : '<> ';

            // Add subcategory check
            $includeSubcategories = $this->getState('filter.subcategories', false);
            $categoryEquals = 'prm.catid ' . $type . (int) $categoryId;

            if ($includeSubcategories) {
                $levels = (int) $this->getState('filter.max_category_levels', '1');

                // Create a subquery for the subcategory list
                $subQuery = $db->getQuery(true)
                        ->select('sub.id')
                        ->from('#__standard_categories as sub')
                        ->join('INNER', '#__standard_categories as this ON sub.lft > this.lft AND sub.rgt < this.rgt')
                        ->where('this.id = ' . (int) $categoryId);

                if ($levels >= 0) {
                    $subQuery->where('sub.level <= this.level + ' . $levels);
                }

                // Add the subquery to the main query
                $query->where('(' . $categoryEquals . ' OR prm.catid IN (' . (string) $subQuery . '))');
            } else {
                $query->where($categoryEquals);
            }
        } elseif (is_array($categoryId) && (count($categoryId) > 0)) {
            $categoryId = ArrayHelper::toInteger($categoryId);
            $categoryId = implode(',', $categoryId);

            if (!empty($categoryId)) {
                $type = $this->getState('filter.category_id.include', true) ? 'IN' : 'NOT IN';
                $query->where('prm.catid ' . $type . ' (' . $categoryId . ')');
            }
        }

        // Filter by a single or group of combo: Apply Product Informations
        $comboApplyProductId = $this->getState('filter.combo_apply_product_id');
        // Filter by a single or group of combo: Apply Itinerary Informations
        $comboApplyItineraryId = $this->getState('filter.combo_apply_itinerary_id');
        if (is_numeric($comboApplyProductId) || is_numeric($comboApplyItineraryId)) {
            $query->where(''
                    . 'prm.product_id IN (' . (int) $comboApplyProductId . ')'
                    . ' OR prm.itinerary_id IN (' . (int) $comboApplyItineraryId . ')'
                    . '');
        }

        // Filer Banner
        $bannerStatus = $this->getState('filter.banner_status');
        if (is_numeric($bannerStatus)) {
            $query->where('prm.banner_status = ' . $bannerStatus);
        }

        $bannerHome = $this->getState('filter.banner_home');
        if (is_numeric($bannerHome)) {
            $query->where('prm.banner_home = ' . (int) $bannerHome);
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');
        $authorWhere = '';

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<> ';
            $authorWhere = 'prm.created_by ' . $type . (int) $authorId;
        } elseif (is_array($authorId)) {
            $authorId = ArrayHelper::toInteger($authorId);
            $authorId = implode(',', $authorId);

            if ($authorId) {
                $type = $this->getState('filter.author_id.include', true) ? 'IN' : 'NOT IN';
                $authorWhere = 'prm.created_by ' . $type . ' (' . $authorId . ')';
            }
        }

        // Filter by author alias
        $authorAlias = $this->getState('filter.author_alias');
        $authorAliasWhere = '';

        if (is_string($authorAlias)) {
            $type = $this->getState('filter.author_alias.include', true) ? '= ' : '<> ';
            $authorAliasWhere = 'prm.created_by_alias ' . $type . $db->quote($authorAlias);
        } elseif (is_array($authorAlias)) {
            $first = current($authorAlias);

            if (!empty($first)) {
                foreach ($authorAlias as $key => $alias) {
                    $authorAlias[$key] = $db->quote($alias);
                }

                $authorAlias = implode(',', $authorAlias);

                if ($authorAlias) {
                    $type = $this->getState('filter.author_alias.include', true) ? 'IN' : 'NOT IN';
                    $authorAliasWhere = 'prm.created_by_alias ' . $type . ' (' . $authorAlias .
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
            $query->where('(prm.publish_up = ' . $nullDate . ' OR prm.publish_up <= ' . $nowDate . ')')
                    ->where('(prm.publish_down = ' . $nullDate . ' OR prm.publish_down >= ' . $nowDate . ')');
        }

        // Filter by Date Range or Relative Date
        $dateFiltering = $this->getState('filter.date_filtering', 'off');
        $dateField = $this->getState('filter.date_field', 'prm.created');

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
                        $dateField . ' >= DATE_SUB(' . $nowDate . ', INTERVAL ' .
                        $relativeDate . ' DAY)'
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
            $hitsFilter = (int) $filter;
            $filter = $db->quote('%' . $db->escape($filter, true) . '%', false);

            switch ($params->get('filter_field')) {
                case 'author':
                    $query->where(
                            'LOWER( CASE WHEN prm.created_by_alias > ' . $db->quote(' ') .
                            ' THEN prm.created_by_alias ELSE ua.name END ) LIKE ' . $filter . ' '
                    );
                    break;

                case 'hits':
                    $query->where('prm.hits >= ' . $hitsFilter . ' ');
                    break;

                case 'title':
                default:
                    // Default to 'title' if parameter is not valid
                    $query->where('LOWER( prm.title ) LIKE ' . $filter);
                    break;
            }
        }

        // Filter by language
        if ($this->getState('filter.language')) {
            $query->where('prm.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
        }

        // Filter by a single tag.
        $tagId = $this->getState('filter.tag');

        if (!empty($tagId) && is_numeric($tagId)) {
            $query->where($db->quoteName('tagmap.tag_id') . ' = ' . (int) $tagId)
                    ->join(
                            'LEFT', $db->quoteName('#__standard_promotionsitem_tag_map', 'tagmap')
                            . ' ON ' . $db->quoteName('tagmap.content_item_id') . ' = ' . $db->quoteName('prm.id')
                            . ' AND ' . $db->quoteName('tagmap.type_alias') . ' = ' . $db->quote('com_standard.product')
            );
        }

        // Add the list ordering clause.
        $query->order($this->getState('list.ordering', 'prm.ordering') . ' ' . $this->getState('list.direction', 'ASC'));
        // echo nl2br(str_replace('#__', 'dpjvy_', $query));
        // exit;
        return $query;
    }

    /**
     * Method to get a list of promotions.
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
        $productParams = array();
        // Convert the parameter fields into objects.
//        echo '<pre>';
//        print_r($items);
//        exit;
        foreach ($items as &$item) {
            // $productParams = new Registry($item->attribs);

            // Unpack readmore and layout params
            // $item->alternative_readmore = $productParams->get('alternative_readmore');
            // $item->layout = $productParams->get('layout');

            $item->params = clone $this->getState('params');

            /* For blogs, product params override menu item params only if menu param = 'use_product'
              Otherwise, menu item params control the layout
              If menu item is 'use_product' and there is no product param, use global */
            if (($input->getString('layout') === 'blog') || ($input->getString('view') === 'featured') || ($this->getState('params')->get('layout_type') === 'blog')) {
                // Create an array of just the params set to 'use_product'
                $menuParamsArray = $this->getState('params')->toArray();
                $productArray = array();

                foreach ($menuParamsArray as $key => $value) {
                    if ($value === 'use_product') {
                        /*
                        // If the product has a value, use it
                        if ($productParams->get($key) != '') {
                            // Get the value from the product
                            $productArray[$key] = $productParams->get($key);
                        } else {
                            // Otherwise, use the global value
                            $productArray[$key] = $globalParams->get($key);
                        }
                        */
                    }
                }

                // Merge the selected product params
                if (count($productArray) > 0) {
                    $productParams = new Registry($productArray);
                    $item->params->merge($productParams);
                }
            } else {
                // For non-blog layouts, merge all of the product params
                $item->params->merge($productParams);
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

            // Compute the asset access permissions.
            // Technically guest could edit an product, but lets not check that to improve performance a little.
            if (!$guest) {
                $asset = 'com_standard.product.' . $item->id;

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
                // If the access filter has been set, we already have only the products this user can view.
                $item->params->set('access-view', true);
            } else {
                // If no access filter is set, the layout takes some responsibility for display of limited information.
                if ($item->catid == 0 || $item->category_access === null) {
                    $item->params->set('access-view', in_array($item->access, $groups));
                } else {
                    $item->params->set('access-view', in_array($item->access, $groups) && in_array($item->category_access, $groups));
                }
            }

            // Get the tags
            if ($item->params->get('show_tags')) {
                $item->tags = new JHelperTags;
                $item->tags->getItemTags('com_standard.product', $item->id);
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
     * @since   12.2
     */
    public function getStart() {
        return $this->getState('list.start');
    }
    
    public function getForm($data = array(), $loadData = true) {
        // Get an instance of the generic products model
        $model = JModelLegacy::getInstance('Contact', 'StandardModel', array('ignore_request' => true));
        // Retrieve Standard
        $form = $model->getForm(array(), true, 'contactPromotion');
        if (empty($form)) {
            return false;
        }
        return $form;
    }

}
