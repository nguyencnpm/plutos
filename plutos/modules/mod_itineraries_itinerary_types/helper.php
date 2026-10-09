<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_itineraries_itinerary_types
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Helper for mod_itineraries_itinerary_types
 *
 * @since  1.5
 */
abstract class ModItinerariesItineraryTypesHelper {

    /**
     * Get list of itineraries
     *
     * @param   \Joomla\Registry\Registry  &$params  module parameters
     *
     * @return  array
     *
     * @since   1.5
     */
    public static function getList(&$params) {
        $options = array();
        $options['countItems'] = $params->get('numitems', 0);
        if (!class_exists('StandardItineraryTypes')) {
            JLoader::register('StandardItineraryTypes', JPATH_SITE . '/components/com_standard/helpers/ItineraryType.php');
        }
        $ItineraryTypes = StandardItineraryTypes::getInstance('Standard', $options);
        // $this->_parent = $ItineraryTypes->get($this->getState('filter.parentId', 'root'));
        if ($params->get('show_all_itinerarytype') === 'root'):
            $ItineraryType = $ItineraryTypes->get($params->get('show_all_itinerarytype'));
        else:
            $ItineraryType = $ItineraryTypes->get($params->get('parent', 'root'));
        endif;


//        echo '<pre>';
//        print_r($ItineraryType);
//        exit;
        if ($ItineraryType !== null) {
            $items = $ItineraryType->getChildren();

            $count = $params->get('count', 0);

            if ($count > 0 && count($items) > $count) {
                $items = array_slice($items, 0, $count);
            }

            return $items;
        }
    }

    public static function getLink($item) {
        $link = '';
        $app = JFactory::getApplication();

        if (isset($item)):
            // Convert the links field to an array.
            $registry = new Registry($item);
            $aLinks = $registry->toArray();
            if (!empty($aLinks) && sizeof($aLinks) > 0):
                switch ($aLinks['link_type']) {
                    case 'menu':

                        if ($menuid = $aLinks['link_menu']) {

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

                    case 'url':

                        if ($itemurl = $aLinks['link_url']) {
                            $link = JRoute::_($itemurl);
                        }
                        break;

                    case 'article':

                        break;
                }
            endif;
        endif;

        return $link;
    }

    public static function getbannerLink($item) {
        $link = '';
        $app = JFactory::getApplication();

        if (isset($item)):
            // Convert the links field to an array.
            $registry = new Registry($item);
            $aLinks = $registry->toArray();

            if (!empty($aLinks) && sizeof($aLinks) > 0 && isset($aLinks['linktype'])):

                switch ($aLinks['linktype']) {

                    case 'bannermenu':

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

                    case 'bannerurl':

                        if ($itemurl = $aLinks['linkurl']) {
                            $link = JRoute::_($itemurl);
                        }
                        break;

                    case 'article':

                        break;
                }

            endif;
        endif;

        return $link;
    }

}
