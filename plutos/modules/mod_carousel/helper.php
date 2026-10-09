<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_carousel
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

if (!class_exists('StandardHelperRoute')) {
    JLoader::register('StandardHelperRoute', JPATH_SITE . '/components/com_standard/helpers/route.php');
}
JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_standard/models', 'StandardModel');

/**
 * Helper for mod_carousel
 *
 * @since  1.6
 */
abstract class ModCarouselHelper {

    /**
     * Get a list of the latest products or articles from the product - article model
     *
     * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
     *
     * @return  mixed
     *
     * @since 1.6
     */
    public static function getList(&$params) {
        $items = array();
        $source = $params->get('using_mode', 'article');
        switch ($source) {
            case '*':

                break;

            case 'product':
                $items = self::_getProduct($params);
                break;

            case 'article':
                $items = self::_getArticle($params);
                break;

            case 'text':
            default:
                break;
        }

        return $items;
    }
    
    protected static function _getProduct($params) {

        // Get an instance of the generic products model
        $model = JModelLegacy::getInstance('Products', 'StandardModel', array('ignore_request' => true));

        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);

        // Set the filters based on the module params
        $model->setState('list.start', 0);
        $model->setState('list.limit', (int) $params->get('count', 5));
        $model->setState('filter.published', 1);

        // This module does not use tags data
        $model->setState('load_tags', false);

        // Access filter
        $access = !JComponentHelper::getParams('com_standard')->get('show_noauth');
        $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
        $model->setState('filter.access', $access);

        // Type filter
        $model->setState('filter.category_id', $params->get('catid', array()));

        // Filter by language
        $model->setState('filter.language', $app->getLanguageFilter());

        // Filer by tag
        $model->setState('filter.tag', $params->get('tag'), array());

        // Filer Banner
        if ($params->get('layout') == '_:default'):
            $model->setState('filter.banner_status', 1);
            $model->setState('filter.banner_home', $params->get('banner_home'));
        endif;

        //  Featured switch
        switch ($params->get('show_featured')) {
            case '1' :
                $model->setState('filter.featured', 'only');
                break;
            case '0' :
                $model->setState('filter.featured', 'hide');
                break;
            default :
                $model->setState('filter.featured', 'show');
                break;
        }

        // Set ordering
        $ordering = 'p.' . $params->get('ordering', 'publish_up');
        $model->setState('list.ordering', $ordering);

        if (trim($ordering) === 'rand()') {
            $model->setState('list.ordering', JFactory::getDbo()->getQuery(true)->Rand());
        } else {
            $direction = $params->get('direction', 1) ? 'DESC' : 'ASC';
            $model->setState('list.direction', $direction);
            $model->setState('list.ordering', $ordering);
        }

        // Check if we should trigger additional plugin events
        $triggerEvents = $params->get('triggerevents', 1);

        // Retrieve Standard
        $items = $model->getItems();

        foreach ($items as &$item) {
            $item->readmore = strlen(trim($item->fulltext));
            $item->slug = $item->id . ':' . $item->alias;

            /** @deprecated Catslug is deprecated, use catid instead. 4.0 * */
            $item->catslug = $item->catid . ':' . $item->category_alias;
            $sUrlsLink = self::_getLink($item);
            if (empty($sUrlsLink)):
                if ($access || in_array($item->access, $authorised)) {
                    // We know that user has the privilege to view the product
                    $item->link = JRoute::_(StandardHelperRoute::getProductRoute($item->slug, $item->catid, $item->language));
                    $item->linkText = JText::_('MOD_CAROUSEL_READMORE');
                } else {
                    $item->link = new JUri(JRoute::_('index.php?option=com_users&view=login', false));
                    $item->link->setVar('return', base64_encode(StandardHelperRoute::getProductRoute($item->slug, $item->catid, $item->language)));
                    $item->linkText = JText::_('MOD_CAROUSEL_READMORE_REGISTER');
                }
            else:
                $item->link = $sUrlsLink;
                $item->linkText = JText::_('MOD_CAROUSEL_READMORE');
            endif;
            $item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_carousel.product');

            if (!$params->get('image')) {
                $item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
            }

            if ($triggerEvents) {
                $item->text = '';
                $app->triggerEvent('onContentPrepare', array('com_standard.product', &$item, &$params, 0));

                $results = $app->triggerEvent('onContentAfterTitle', array('com_standard.product', &$item, &$params, 0));
                $item->afterDisplayTitle = trim(implode("\n", $results));

                $results = $app->triggerEvent('onContentBeforeDisplay', array('com_standard.product', &$item, &$params, 0));
                $item->beforeDisplayContent = trim(implode("\n", $results));

                $results = $app->triggerEvent('onContentAfterDisplay', array('com_standard.product', &$item, &$params, 0));
                $item->afterDisplayContent = trim(implode("\n", $results));
            } else {
                $item->afterDisplayTitle = '';
                $item->beforeDisplayContent = '';
                $item->afterDisplayContent = '';
            }
        }

        return $items;
    }

    protected static function _getArticle($params) {

        // Get an instance of the generic articles model
        $model = JModelLegacy::getInstance('Articles', 'StandardModel', array('ignore_request' => true));

        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);

        // Set the filters based on the module params
        $model->setState('list.start', 0);
        $model->setState('list.limit', (int) $params->get('count', 5));
        $model->setState('filter.published', 1);

        // This module does not use tags data
        $model->setState('load_tags', false);

        // Access filter
        $access = !JComponentHelper::getParams('com_standard')->get('show_noauth');
        $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
        $model->setState('filter.access', $access);

        // Category filter
        $model->setState('filter.category_id', $params->get('catid', array()));

        // Filter by language
        $model->setState('filter.language', $app->getLanguageFilter());

        // Filer by tag
        $model->setState('filter.tag', $params->get('tag'), array());

        // Filer Banner
        if ($params->get('layout') == '_:default'):
            $model->setState('filter.banner_status', 1);
            $model->setState('filter.banner_home', $params->get('banner_home'));
        endif;

        //  Featured switch
        switch ($params->get('show_featured')) {
            case '1' :
                $model->setState('filter.featured', 'only');
                break;
            case '0' :
                $model->setState('filter.featured', 'hide');
                break;
            default :
                $model->setState('filter.featured', 'show');
                break;
        }

        // Set ordering
        $ordering = 'p.' . $params->get('ordering', 'publish_up');
        $model->setState('list.ordering', $ordering);

        if (trim($ordering) === 'rand()') {
            $model->setState('list.ordering', JFactory::getDbo()->getQuery(true)->Rand());
        } else {
            $direction = $params->get('direction', 1) ? 'DESC' : 'ASC';
            $model->setState('list.direction', $direction);
            $model->setState('list.ordering', $ordering);
        }

        // Check if we should trigger additional plugin events
        $triggerEvents = $params->get('triggerevents', 1);

        // Retrieve Standard
        $items = $model->getItems();

        foreach ($items as &$item) {
            $item->readmore = strlen(trim($item->fulltext));
            $item->slug = $item->id . ':' . $item->alias;

            /** @deprecated Catslug is deprecated, use catid instead. 4.0 * */
            $item->catslug = $item->catid . ':' . $item->category_alias;
            $sUrlsLink = self::_getLink($item);
            if (empty($sUrlsLink)):
                if ($access || in_array($item->access, $authorised)) {
                    // We know that user has the privilege to view the article
                    $item->link = JRoute::_(StandardHelperRoute::getArticledetailRoute($item->slug, $item->catid, $item->language));
                    $item->linkText = JText::_('MOD_CAROUSEL_READMORE');
                } else {
                    $item->link = new JUri(JRoute::_('index.php?option=com_users&view=login', false));
                    $item->link->setVar('return', base64_encode(StandardHelperRoute::getArticledetailRoute($item->slug, $item->catid, $item->language)));
                    $item->linkText = JText::_('MOD_CAROUSEL_READMORE_REGISTER');
                }
            else:
                $item->link = $sUrlsLink;
                $item->linkText = JText::_('MOD_CAROUSEL_READMORE');
            endif;

            $item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_carousel.article');

            if (!$params->get('image')) {
                $item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
            }

            if ($triggerEvents) {
                $item->text = '';
                $app->triggerEvent('onContentPrepare', array('com_standard.article', &$item, &$params, 0));

                $results = $app->triggerEvent('onContentAfterTitle', array('com_standard.article', &$item, &$params, 0));
                $item->afterDisplayTitle = trim(implode("\n", $results));

                $results = $app->triggerEvent('onContentBeforeDisplay', array('com_standard.article', &$item, &$params, 0));
                $item->beforeDisplayContent = trim(implode("\n", $results));

                $results = $app->triggerEvent('onContentAfterDisplay', array('com_standard.article', &$item, &$params, 0));
                $item->afterDisplayContent = trim(implode("\n", $results));
            } else {
                $item->afterDisplayTitle = '';
                $item->beforeDisplayContent = '';
                $item->afterDisplayContent = '';
            }
        }

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
