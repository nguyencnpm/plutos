<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;

jimport('informationtechnology.convert');

/**
 * This models supports retrieving lists of products.
 *
 * @since  1.6
 */
class StandardModelSelectProducts extends JModelList {

    protected $_sStartDate = '';
    protected $_sExpiryDate = '';

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
                'id', 'cr.id',
                'title', 'cr.title',
                'alias', 'cr.alias',
                'checked_out', 'cr.checked_out',
                'checked_out_time', 'cr.checked_out_time',
                'catid', 'cr.catid', 'category_title',
                'state', 'cr.state',
                'access', 'cr.access', 'access_level',
                'created', 'cr.created',
                'created_by', 'cr.created_by',
                'ordering', 'cr.ordering',
                'featured', 'cr.featured',
                'language', 'cr.language',
                'hits', 'cr.hits',
                'publish_up', 'cr.publish_up',
                'publish_down', 'cr.publish_down',
                'images', 'cr.images',
                'urls', 'cr.urls',
                'filter_tag'
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
     * @since   12.2
     */
    protected function populateState($ordering = 'ordering', $direction = 'ASC') {
        $app = JFactory::getApplication();

        $params = $app->getParams();
        $this->setState('params', $params);
        $user = JFactory::getUser();
        // List state information "Form Post"
        $aFormPost = $app->input->post->get('jform', array(), 'array');

        if (isset($aFormPost['route_id'])):
            $this->setState('filter.route_id', $aFormPost['route_id']);
            $app->setUserState('com_standard.search.filter.route_id', $aFormPost['route_id']);
        else:
            $iDefaultRouteId = $params->get('route_id');
            $this->setState('filter.route_id', $app->getUserState('com_standard.search.filter.route_id', $iDefaultRouteId));
            $app->setUserState('com_standard.search.filter.route_id', $app->getUserState('com_standard.search.filter.route_id', $iDefaultRouteId));
        endif;

        if (isset($aFormPost['departure_day_start'])):// $aFormPost['departure_day']
            $sDepartureDay = $aFormPost['departure_day_start'];
            $sDepartureDay .= isset($aFormPost['departure_day_end']) ? " - " . $aFormPost['departure_day_end'] : " - " . $aFormPost['departure_day_start'];
            $this->setState('filter.departure_day', $sDepartureDay);
            $app->setUserState('com_standard.search.filter.departure_day', $sDepartureDay);
        else:
            $calendarStart = $params->get('calendar_start');
            $sCalendarStart = JHtml::_('date', $calendarStart, JText::_('DATE_FORMAT_SYSTEM'));
            $nowDate = JFactory::getDate()->toSql();
            $sNowDate = JHtml::_('date', $nowDate, JText::_('DATE_FORMAT_SYSTEM'));
            if (strtotime($sCalendarStart) < strtotime($sNowDate)):
                $calendarStart = $nowDate;
            endif;

            $oEndDateRangYear = new JDate($calendarStart . ' +1 year');
            $sToday = JHtml::_('date', $calendarStart, JText::_('DATE_RANGE_PICKER_FORMAT_SYSTEM'));
            $sEndDateRangYear = JHtml::_('date', $oEndDateRangYear, JText::_('DATE_RANGE_PICKER_FORMAT_SYSTEM'));
            // --- set Default Departure Day ---
            $sDefaultDepartureDay = $sToday . " - " . $sEndDateRangYear;
            $routeId = $app->getUserState('com_standard.search.filter.route_id');
            $this->getDefaultDepartureDay($routeId, $calendarStart, $sDefaultDepartureDay);

            $this->setState('filter.departure_day', $app->getUserState('com_standard.search.filter.departure_day', $sDefaultDepartureDay));
            $app->setUserState('com_standard.search.filter.departure_day', $app->getUserState('com_standard.search.filter.departure_day', $sDefaultDepartureDay));
        endif;

        // List state information
        $value = $params->get('num_leading_products') + $params->get('num_intro_products') + $params->get('num_links');
        // $value = $app->input->get('limit', $app->get('list_limit', 0), 'uint');
        $this->setState('list.limit', $value);
        $this->setState('list.links', $params->get('num_links'));

        $value = $app->input->get('limitstart', 0, 'uint');
        $this->setState('list.start', $value);

        $value = $app->input->get('filter_tag', 0, 'uint');
        $this->setState('filter.tag', $value);

        $orderCol = $app->input->get('filter_order', 'cr.ordering');

        if (!in_array($orderCol, $this->filter_fields)) {
            $orderCol = 'cr.ordering';
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
        $id .= $this->getState('filter.selectproducts');

        return parent::getStoreId($id);
    }

    /**
     * Get the master query for retrieving a list of products subject to the model state.
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    protected function getListQuery() {
        // --- Get the time offset. ---
        $offset = JFactory::getApplication()->get('offset');
        $timezone = new DateTimeZone($offset);
        $setTimeZone = $timezone->getOffset(new DateTime) / 3600;
        // Get the current user for authorisation checks
        $user = JFactory::getUser();

        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'cr.id, cr.catid, cr.contractgroup_id, cr.currency_id'
                        . ', cr.title, cr.alias, cr.code, cr.introtext, cr.fulltext'
                        . ', cr.checked_out, cr.checked_out_time'
                        . ', cr.created, cr.created_by'
                        // Published/archived product in archive category is treats as archive product
                        // If category is not published then force 0
                        . ', CASE WHEN c.published = 2 AND cr.state > 0 THEN 2 WHEN c.published != 1 THEN 0 ELSE cr.state END as state'
                        // Use created if modified is 0
                        . ', CASE WHEN cr.modified = ' . $db->quote($db->getNullDate()) . ' THEN cr.created ELSE cr.modified END as modified'
                        . ', cr.modified_by, uam.name as modified_by_name'
                        // Use created if publish_up is 0
                        . ', CASE WHEN cr.publish_up = ' . $db->quote($db->getNullDate()) . ' THEN cr.created ELSE cr.publish_up END as publish_up'
                        . ', cr.publish_down, cr.metadata, cr.metakey, cr.metadesc, cr.access'
                        . ', cr.hits, cr.language, ' . ' ' . $query->length('cr.fulltext') . ' AS readmore'
                )
        );

        $query->from('#__standard_contractrates AS cr');

        $params = $this->getState('params');
        $limit_products = (int) $params->get('limit_products', 0);
        $orderby_sec = $params->get('orderby_sec');

        // Join over the contractrate details
        $query->select('crd.id AS crd_id'
                        . ', crd.start_date'
                        . ', crd.expiry_date'
                        . ', crd.price'
                        . ', crd.inforate_status'
                )
                ->join('RIGHT', $db->quoteName('#__standard_contractrate_details') . ' AS crd ON crd.contractrate_id = cr.id')
                ->join('LEFT', '#__standard_contractgroup_usergroup_map AS cgug ON cgug.contractgroup_id = cr.contractgroup_id')
                ->where('cgug.usergroup_id IN (' . implode(',', $user->groups) . ')');

        // Join over the contract group
        $query->select('cg.title AS contractgroup_title')
                ->join('LEFT', $db->quoteName('#__standard_contractgroups') . ' AS cg ON cg.id = cr.contractgroup_id');

        // Join over the categories.
        $query->select('c.title AS category_title, c.path AS category_route, c.access AS category_access, c.alias AS category_alias')
                ->select('c.published, c.published AS parents_published')
                ->join('LEFT', '#__standard_categories AS c ON c.id = cr.catid');

        // Join over the users for the author and modified_by names.
        $query->select("ua.name AS author")
                ->select('ua.email AS author_email')
                ->join('LEFT', '#__users AS ua ON ua.id = cr.created_by')
                ->join('LEFT', '#__users AS uam ON uam.id = cr.modified_by');

        // Join over the categories to get parent category titles
        $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
                ->join('LEFT', '#__standard_categories as parent ON parent.id = c.parent_id');

        // Join over the route contract rate map
        $query->select('r.id AS route_id, r.code AS route_code'
                        . ', r.title AS route_title, r.subtitle AS route_subtitle, r.departure_day AS route_departure_day'
                        . ', r.number_days AS route_number_days, r.departure_time AS route_departure_time, r.arrival_time AS route_arrival_time'
                )
                ->join('LEFT', $db->quoteName('#__standard_routecontractrate_map') . ' AS rcr_map ON rcr_map.contractrate_id = cr.id')
                ->join('LEFT', $db->quoteName('#__standard_routes') . ' AS r ON (r.id = rcr_map.route_id and c.id = r.catid)');

        // Join over the product contract rate map
        $query->select(' p.id AS product_id'
                        . ', p.title AS product_title, p.alias AS product_alias, p.subtitle AS product_subtitle'
                        . ', p.introtext AS product_introtext, p.fulltext AS product_fulltext'
                        . ', p.in_stock AS product_in_stock, p.ordered AS product_ordered'
                        . ', p.max_occupancy as product_max_occupancy, p.max_adult as product_max_adult, p.max_children as product_max_children'
                        . ', p.adult as product_adult, p.children as product_children'
                        . ', p.period_block AS product_period_block, p.block_in_date AS product_block_in_date'
                        . ', p.images AS product_images, p.attribs as product_attribs'
                )
                ->join('LEFT', $db->quoteName('#__standard_productcontractrate_map') . ' AS pcr_map ON pcr_map.contractrate_id = cr.id')
                ->join('LEFT', $db->quoteName('#__standard_products') . ' AS p ON (p.id = pcr_map.product_id and c.id = p.catid)');

        // Join over the product contract rate map
        $query->select(' a.id AS allotment_id'
                        . ', a.date AS allotment_date, a.allotment, a.booking'
                        . ', if((CAST(allotment AS SIGNED) - CAST(booking AS SIGNED))>CAST(p.in_stock AS SIGNED), CAST(p.in_stock AS SIGNED), (CAST(allotment AS SIGNED) - CAST(booking AS SIGNED))) as max_quantity'
                        // . ', CAST(allotment AS SIGNED) - CAST(booking AS SIGNED) as max_quantity'
                        // . ', if((CAST(allotment AS SIGNED) - CAST(booking AS SIGNED))>(CAST(p.in_stock AS SIGNED) - CAST(booking AS SIGNED)), (CAST(p.in_stock AS SIGNED) - CAST(booking AS SIGNED)), (CAST(allotment AS SIGNED) - CAST(booking AS SIGNED))) as max_quantity'
                )
                ->join('LEFT', $db->quoteName('#__standard_allotment') . ' AS a ON (a.product_id = p.id AND (DATE(a.date)>=DATE(crd.start_date) and DATE(a.date)<=DATE(crd.expiry_date)))');
        $query->where('(CAST(allotment AS SIGNED) - CAST(booking AS SIGNED)) > 0');
        // $query->where('(CAST(p.in_stock AS SIGNED) - CAST(booking AS SIGNED)) > 0');
        // --- Take the days of departure ---
        $query->where("DATE_FORMAT(CONVERT_TZ(a.date, '+00:00','+{$setTimeZone}:00'), '%w') = r.departure_day");

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published) && $published == 2) {
            // If category is archived then product has to be published or archived.
            // If categogy is published then product has to be archived.
            $query->where('(c.published = 2 AND cr.state > 0 AND p.state > 0 AND a.state > 0) OR (c.published = 1 AND cr.state = 2 AND p.state = 2 AND a.state = 2)');
        } elseif (is_numeric($published)) {
            // Category has to be published
            $query->where('c.published = 1 AND cr.state = ' . (int) $published . ' AND p.state = ' . (int) $published . ' AND a.state = ' . (int) $published);
        } elseif (is_array($published)) {
            $published = ArrayHelper::toInteger($published);
            $published = implode(',', $published);

            // Category has to be published
            $query->where('c.published = 1 AND cr.state IN (' . $published . 'AND p.state IN (' . $published . 'AND a.state IN (' . $published . ')');
        }

        // Filter by route
        $routeId = $this->getState('filter.route_id');
        if (is_numeric($routeId)):
            $query->where('r.id = ' . (int) $routeId);
        endif;

        // Filter by date range picker
        $departureDayDateRange = $this->getState('filter.departure_day');
        if (!empty(trim($departureDayDateRange))):
            // --- Get the time offset. ---
            // --- /. ---
            // Contractrate period is valid
            // --- Convert Date ---
            $delimiter = " - ";
            $aTemp = explode($delimiter, trim($departureDayDateRange));
            $sStartDate = JFactory::getDate(Convert::getConvertDate(trim($aTemp[0]), JText::_('DATE_FORMAT_SYSTEM')), $offset)->toSql(); //trim($aTemp[0]);
            $sExpiryDate = JFactory::getDate(Convert::getConvertDate(trim($aTemp[1]), JText::_('DATE_FORMAT_SYSTEM')), $offset)->toSql(); //trim($aTemp[1]);
            // --- Format Date ---
            $OStartDate = new JDate($sStartDate);
            $this->_sStartDate = $OStartDate->format(JText::_('DATE_FORMAT_SYSTEM'));
            $OExpiryDate = new JDate($sExpiryDate);
            $this->_sExpiryDate = $OExpiryDate->format(JText::_('DATE_FORMAT_SYSTEM'));

            // --- Use Where Date ---
            $query->where("(DATE(crd.expiry_date) >= '{$this->_sStartDate}' OR DATE(crd.expiry_date) >= '{$this->_sExpiryDate}')");

            $query->where("(DATE(a.date) BETWEEN '{$this->_sStartDate}' AND '{$this->_sExpiryDate}')");
        endif;

        // Add the list ordering clause.
        // $query->order($this->getState('list.ordering', 'cr.ordering') . ' ' . $this->getState('list.direction', 'ASC'));
        $query->order("a.date ASC, crd.start_date ASC,  crd.price ASC");

//        echo nl2br(str_replace('#__', 'dpjvy_', $query));
//        exit;

        return $query;
    }

    /**
     * Method to get a list of products.
     *
     * Overriden to inject convert the attribs field into a JParameter object.
     *
     * @return  mixed  An array of objects on success, false on failure.
     *
     * @since   1.6
     */
    public function getItems() {
        if (!class_exists('Cart')) {
            JLoader::register('Cart', JPATH_SITE . '/components/com_standard/helpers/cart.php');
        }
        // -- ex Cart -- 
        $this->cart = Cart::getCart();
        // $this->cart->prepareCartData(false);
        // -- /.ex Cart --

        $items = parent::getItems();
        $user = JFactory::getUser();
        $userId = $user->get('id');
        $guest = $user->get('guest');
        $groups = $user->getAuthorisedViewLevels();
        $input = JFactory::getApplication()->input;

        // Get the global params
        $globalParams = JComponentHelper::getParams('com_standard', true);

        foreach ($items as $key => &$item) :
            // --- unset product in In period block ---
            if (StandardHelperQuery::checkBlock($item, $item->allotment_date, $item->allotment_date)):
                // --- In period block --- 
                unset($items[$key]);
                continue;
            endif;
            // --- /.unset product in In period block ---
            // 
            // --- unset items Request max quantity ---
            if (isset($this->cart->cartProductsData) && sizeof($this->cart->cartProductsData) > 0):
                foreach ($this->cart->cartProductsData as $cartProduct) {
                    if ((int) $cartProduct['product_id'] === (int) $item->product_id):
                        if ((int) $cartProduct['quantity'] >= (int) $item->max_quantity):
                            unset($items[$key]);
                        endif;
                    endif;
                }
            endif;
            // --- /.unset items Request max quantity ---
            // 
            // --- Convert the parameter fields into objects. ---
            $productParams = new Registry($item->product_attribs);
            // Unpack readmore and layout params
            $item->alternative_readmore = $productParams->get('alternative_readmore');
            $item->layout = $productParams->get('layout');

            $item->params = clone $this->getState('params');

            $item->slug = $item->product_alias ? ($item->product_id . ':' . $item->product_alias) : $item->product_id;
            $item->catslug = $item->category_alias ? ($item->catid . ':' . $item->category_alias) : $item->catid;
            $item->parent_slug = $item->parent_alias ? ($item->parent_id . ':' . $item->parent_alias) : $item->parent_id;
            // No link for ROOT category
            if ($item->parent_alias === 'root') {
                $item->parent_slug = null;
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
            // --- /.Convert the parameter fields into objects. ---

        endforeach;

        return array_values($items);
    }

    public function getDefaultDepartureDay($routeId, $calendarStart, &$sDefaultDepartureDay = '') {

        $db = JFactory::getDbo();
        // Construct the query
        $query = $db->getQuery(true)
                ->select('departure_day')
                ->from('#__standard_routes')
                ->where('state IN (1)')
                ->where('id=' . (int) $routeId);
        // Setup the query
        $db->setQuery($query);
        $iResult = $db->loadResult();

        $startDate = $calendarStart;
        $endDate = $calendarStart;

        // Check of the day of the week 
        $dayweek = new JDate(JHtml::_('date', $calendarStart, JText::_('DATE_FORMAT_SYSTEM')));
        $day = $dayweek->format('w');

        if ((int) $day != (int) $iResult && isset($iResult)):
            $i = 1;
            $flag = true;
            do {
                $sIsStartDate = new JDate($calendarStart . "+" . $i . " days");
                $i++;

                $isDayweek = new JDate(JHtml::_('date', $sIsStartDate, JText::_('DATE_FORMAT_SYSTEM')));
                $isDay = $isDayweek->format('w');
                if ((int) $isDay == (int) $iResult) {
                    $startDate = $sIsStartDate;
                    $endDate = $sIsStartDate;
                    $flag = false;
                }
            } while ($flag && $i <= 7);
        endif;

        $sToday = JHtml::_('date', $startDate, JText::_('DATE_RANGE_PICKER_FORMAT_SYSTEM'));
        $sEndDateRangYear = JHtml::_('date', $endDate, JText::_('DATE_RANGE_PICKER_FORMAT_SYSTEM'));

        $sDefaultDepartureDay = $sToday . " - " . $sEndDateRangYear;
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

}
