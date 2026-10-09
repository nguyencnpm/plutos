<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_utilities
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Helper for mod_utilities
 *
 * @since  1.6
 */
abstract class ModUtilitiesHelper {

    public static function getLink($params) {
        $app = JFactory::getApplication();
        $link = '';
        $menuid = $params->get('cart');
        $menu = $app->getMenu();
        $menuitem = $menu->getItem($menuid);
        if ($menuitem):
            switch ($menuitem->type) {
                case 'component':
                    $link = JRoute::_($menuitem->link . '&Itemid=' . $menuid);
                    break;
                case 'url':
                case 'alias':
                    $link = JRoute::_($menuitem->link);
                    break;
            }
        endif;
        return $link;
    }

    public static function getList(&$params) {
        $items = new stdClass();
        foreach ($items as &$item):
//        $sUrlsLink = self::_getLink($item);
//        if (empty($sUrlsLink)):
//            $item->link = "";
//        else :
//            $item->link = $sUrlsLink;
//        endif;

        endforeach;

        return $items;
    }

    protected static function _getLink($item) {
        $link = '';
        $app = JFactory::getApplication();

        if (isset($item->links)):
            // Convert the links field to an array.
            $registry = new Registry($item->links);
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

}

?>