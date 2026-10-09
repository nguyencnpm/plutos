<?php

defined('_JEXEC') or die;

/**
 * Standard component helper.
 */
class StandardHelper extends JHelperContent {

    public static $extension = 'com_standard';

    /**
     * Configure the Linkbar.
     *
     * @param   string  $vName  The name of the active view.
     *
     * @return  void
     */
    public static function addSubmenu($vName) {
        JHtmlSidebar::addEntry(
                JText::_('COM_STANDARD_PRODUCTS'), 'index.php?option=com_standard&view=products', $vName == 'products'
        );
        JHtmlSidebar::addEntry(
                JText::_('COM_STANDARD_SUBMENU_CATEGORIES'), 'index.php?option=com_standard&view=categories', $vName == 'categories'
        );
        /*
          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_SUBMENU_CATEGORIES'), 'index.php?option=com_categories&extension=com_standard', $vName == 'categories'
          );

          if (JComponentHelper::isEnabled('com_fields') && JComponentHelper::getParams('com_standard')->get('custom_fields_enable', '1')) {
          JHtmlSidebar::addEntry(
          JText::_('JGLOBAL_FIELDS'), 'index.php?option=com_fields&context=com_standard.product', $vName == 'fields.fields'
          );
          JHtmlSidebar::addEntry(
          JText::_('JGLOBAL_FIELD_GROUPS'), 'index.php?option=com_fields&view=groups&context=com_standard.product', $vName == 'fields.groups'
          );
          }

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_SUBMENU_FEATURED'), 'index.php?option=com_standard&view=featured', $vName == 'featured'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_PRODUCT_BLOCKS'), 'index.php?option=com_standard&view=productblocks', $vName == 'productblocks'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_INVENTORY'), 'index.php?option=com_standard&view=inventory', $vName == 'inventory'
          );


          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_ITINERARIES'), 'index.php?option=com_standard&view=itineraries', $vName == 'itineraries'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_ITINERARY_TYPES'), 'index.php?option=com_standard&view=itineraryTypes', $vName == 'itineraryTypes'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_COMBOS'), 'index.php?option=com_standard&view=combos', $vName == 'combos'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_ALLOTMENTS'), 'index.php?option=com_standard&view=allotments', $vName == 'allotments'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_ROUTES'), 'index.php?option=com_standard&view=routes', $vName == 'routes'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_RATES'), 'index.php?option=com_standard&view=rates', $vName == 'rates'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_CONTRACT_RATES'), 'index.php?option=com_standard&view=contractrates', $vName == 'contractrates'
          );
          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_CONTRACT_GROUPS'), 'index.php?option=com_standard&view=contractgroups', $vName == 'contractgroups'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_TAXES_CALCULATION_RULES'), 'index.php?option=com_standard&view=calculations', $vName == 'calculations'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_MANUFACTURERS'), 'index.php?option=com_standard&view=manufacturers', $vName == 'manufacturers'
          );
          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_SHIPMENT_METHODS'), 'index.php?option=com_standard&view=shipmentMethods', $vName == 'shipmentMethods'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_EXTRAS'), 'index.php?option=com_standard&view=extras', $vName == 'extras'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_PAYMENT_METHODS'), 'index.php?option=com_standard&view=paymentMethods', $vName == 'paymentMethods'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_PROMOTIONS'), 'index.php?option=com_standard&view=promotions', $vName == 'promotions'
          );


          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_COUPONS_TYPES'), 'index.php?option=com_standard&view=couponsTypes', $vName == 'couponsTypes'
          );
          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_COUPONS'), 'index.php?option=com_standard&view=coupons', $vName == 'coupons'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_CURRENCIES'), 'index.php?option=com_standard&view=currencies', $vName == 'currencies'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_USERS'), 'index.php?option=com_standard&view=users', $vName == 'users'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_AGENT'), 'index.php?option=com_standard&view=agents', $vName == 'agents'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_USER_GROUPS'), 'index.php?option=com_standard&view=usergroups', $vName == 'usergroups'
          );


          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_ORDERS'), 'index.php?option=com_standard&view=orders', $vName == 'orders'
          );

          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_SUBSCRIBED_EMAILS'), 'index.php?option=com_standard&view=subscribedemails', $vName == 'subscribedemails'
          );
          JHtmlSidebar::addEntry(
          JText::_('COM_STANDARD_CONTACT_REQUESTS'), 'index.php?option=com_standard&view=requests', $vName == 'requests'
          );
         */
        JHtmlSidebar::addEntry(
                JText::_('COM_STANDARD_REGISTRATIONS'), 'index.php?option=com_standard&view=registrations', $vName == 'registrations'
        );
    }

    /**
     * Applies the standard tag filters to arbitrary text as per settings for current user group
     *
     * @param   text  $text  The string to filter
     *
     * @return  string  The filtered string
     *
     * @deprecated  4.0  Use JComponentHelper::filterText() instead.
     */
    public static function filterText($text) {
        JLog::add('StandardHelper::filterText() is deprecated. Use JComponentHelper::filterText() instead.', JLog::WARNING, 'deprecated');

        return JComponentHelper::filterText($text);
    }

    /**
     * Adds Count Items for Category Manager.
     *
     * @param   stdClass[]  &$items  The banner category objects
     *
     * @return  stdClass[]
     *
     * @since   3.5
     */
    public static function countItems(&$items) {

        $config = (object) array(
                    'related_tbl' => 'standard_products',
                    'state_col' => 'state',
                    'group_col' => 'catid',
                    'relation_type' => 'category_or_group',
        );
        return parent::countRelations($items, $config);
        /*
          $db = JFactory::getDbo();

          foreach ($items as $item) {
          $item->count_trashed = 0;
          $item->count_archived = 0;
          $item->count_unpublished = 0;
          $item->count_published = 0;
          $query = $db->getQuery(true);
          $query->select('state, count(*) AS count')
          ->from($db->qn('#__standard_products'))
          ->where('catid = ' . (int) $item->id)
          ->group('state');
          $db->setQuery($query);
          $products = $db->loadObjectList();

          foreach ($products as $product) {
          if ($product->state == 1) {
          $item->count_published = $product->count;
          }

          if ($product->state == 0) {
          $item->count_unpublished = $product->count;
          }

          if ($product->state == 2) {
          $item->count_archived = $product->count;
          }

          if ($product->state == -2) {
          $item->count_trashed = $product->count;
          }
          }
          }

          return $items
         */
    }

    /**
     * Adds Count Items for itinerary Type Manager.
     *
     * @param   stdClass[]  &$items  The banner itinerary Type objects
     *
     * @return  stdClass[]
     *
     * @since   3.5
     */
    public static function countItineraryItems(&$items) {

        $config = (object) array(
                    'related_tbl' => 'standard_itineraries',
                    'state_col' => 'state',
                    'group_col' => 'itinerarytype_id',
                    'relation_type' => 'category_or_group',
        );
        return parent::countRelations($items, $config);
        /*
          $db = JFactory::getDbo();

          foreach ($items as $item) {
          $item->count_trashed = 0;
          $item->count_archived = 0;
          $item->count_unpublished = 0;
          $item->count_published = 0;
          $query = $db->getQuery(true);
          $query->select('state, count(*) AS count')
          ->from($db->qn('#__standard_itineraries'))
          ->where('itinerarytype_id = ' . (int) $item->id)
          ->group('state');
          $db->setQuery($query);
          $products = $db->loadObjectList();

          foreach ($products as $product) {
          if ($product->state == 1) {
          $item->count_published = $product->count;
          }

          if ($product->state == 0) {
          $item->count_unpublished = $product->count;
          }

          if ($product->state == 2) {
          $item->count_archived = $product->count;
          }

          if ($product->state == -2) {
          $item->count_trashed = $product->count;
          }
          }
          }

          return $items;
         */
    }

    /**
     * Check if Category ID exists otherwise assign to ROOT category.
     *
     * @param   mixed   $catid      Name or ID of category.
     * @param   string  $extension  Extension that triggers this function
     *
     * @return  integer  $catid  Category ID.
     */
    public static function validateCategoryId($catid, $extension) {
        // JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_categories/tables');
        // $categoryTable = JTable::getInstance('Category');

        $categoryTable = JTable::getInstance('Category', 'StandardTable');

        $data = array();
        $data['id'] = $catid;
        $data['extension'] = $extension;

        if (!$categoryTable->load($data)) {
            $catid = 0;
        }

        return (int) $catid;
    }

    /**
     * Create new Category from within item view.
     *
     * @param   array  $data  Array of data for new category.
     *
     * @return  integer
     */
    public static function createCategory($data) {
        // JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_categories/models');
        // JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_categories/tables');
        // $categoryModel = JModelLegacy::getInstance('Category', 'CategoriesModel', array('ignore_request' => true));
        $categoryModel = JModelLegacy::getInstance('Category', 'StandardModel', array('ignore_request' => true));

        $categoryModel->save($data);

        $catid = $categoryModel->getState('category.id');

        return $catid;
    }

}
