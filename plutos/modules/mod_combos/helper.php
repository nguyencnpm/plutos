<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_combos
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

if (!class_exists('StandardHelperRoute')) {
    JLoader::register('StandardHelperRoute', JPATH_SITE . '/components/com_standard/helpers/route.php');
}

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_standard/models', 'StandardModel');

/**
 * Helper for mod_combos
 *
 * @since  1.6
 */
abstract class ModCombosHelper {

    /**
     * Get a list of the latest combos from the product model
     *
     * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
     *
     * @return  mixed
     *
     * @since 1.6
     */
    public static function getList(&$params, $aInfoCurrent) {
        // Get an instance of the generic combos model
        $model = JModelLegacy::getInstance('Combos', 'StandardModel', array('ignore_request' => true));

        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);

        $model->setState('list.start', 0);
        $model->setState('filter.published', 1);

        // Set the filters based on the module params
        $model->setState('list.limit', (int) $params->get('count', 5));

        // This module does not use tags data
        $model->setState('load_tags', false);

        // Access filter
        $access = !JComponentHelper::getParams('com_standard')->get('show_noauth');
        $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
        $model->setState('filter.access', $access);

        // Category filter
        //$model->setState('filter.category_id', $params->get('catid', array()));
        //$model->setState('filter.category_id', isset($aInfoCurrent['current_catid'])? $aInfoCurrent['current_catid']: 0);
        $model->setState('filter.combo_apply_product_id', isset($aInfoCurrent['current_item_id']) ? $aInfoCurrent['current_item_id'] : -1);

        $model->setState('filter.combo_apply_itinerary_id', isset($aInfoCurrent['current_itinerary_id']) ? $aInfoCurrent['current_itinerary_id'] : -1);

        // Filter by language
        $model->setState('filter.language', $app->getLanguageFilter());

        // Filer by tag
        $model->setState('filter.tag', $params->get('tag', array()));

        // Featured switch
        $featured = $params->get('show_featured', '');

        if ($featured === '') {
            $model->setState('filter.featured', 'show');
        } elseif ($featured) {
            $model->setState('filter.featured', 'only');
        } else {
            $model->setState('filter.featured', 'hide');
        }

        // Set ordering
        $ordering = $params->get('ordering', 'cb.ordering');
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

        // Retrieve Content
        $items = $model->getItems();
        if (!empty($items)):
            foreach ($items as &$item) {
                $item->readmore = strlen(trim($item->fulltext));
                $item->slug = $item->id . ':' . $item->alias;

                /** @deprecated Catslug is deprecated, use catid instead. 4.0 */
                $item->catslug = $item->catid . ':' . $item->category_alias;

                if ($access || in_array($item->access, $authorised)) {
                    // We know that user has the privilege to view the product
                    $item->link = JRoute::_(StandardHelperRoute::getProductRoute($item->slug, $item->catid, $item->language));
                    $item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE');
                } else {
                    $item->link = new JUri(JRoute::_('index.php?option=com_users&view=login', false));
                    $item->link->setVar('return', base64_encode(StandardHelperRoute::getProductRoute($item->slug, $item->catid, $item->language)));
                    $item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE_REGISTER');
                }

                $item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_combos.content');

                // Remove any images belongs to the text
                if (!$params->get('image')) {
                    $item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
                }

                // Show the Intro/Full image field of the product
                if ($params->get('img_intro_full') !== 'none') {
                    $images = json_decode($item->images);
                    $item->imageSrc = '';
                    $item->imageAlt = '';
                    $item->imageCaption = '';

                    if ($params->get('img_intro_full') === 'intro' && !empty($images->image_medium)) {
                        $item->imageSrc = htmlspecialchars($images->image_medium, ENT_COMPAT, 'UTF-8');
                        $item->imageAlt = htmlspecialchars($images->image_intro_alt, ENT_COMPAT, 'UTF-8');

                        if ($images->image_intro_caption) {
                            $item->imageCaption = htmlspecialchars($images->image_intro_caption, ENT_COMPAT, 'UTF-8');
                        }
                    } elseif ($params->get('img_intro_full') === 'full' && !empty($images->image_full)) {
                        $item->imageSrc = htmlspecialchars($images->image_full, ENT_COMPAT, 'UTF-8');
                        $item->imageAlt = htmlspecialchars($images->image_fulltext_alt, ENT_COMPAT, 'UTF-8');

                        if ($images->image_intro_caption) {
                            $item->imageCaption = htmlspecialchars($images->image_fulltext_caption, ENT_COMPAT, 'UTF-8');
                        }
                    }
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
        endif;

        return $items;
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
    
    public static function getImageLink($item) {
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

    public static function getbannerLinkA($item) {
        $link = '';
        $app = JFactory::getApplication();

        if (isset($item)):
            // Convert the links field to an array.
            $registry = new Registry($item);
            $aLinks = $registry->toArray();

            if (!empty($aLinks) && sizeof($aLinks) > 0 && isset($aLinks['linkatype'])):

                switch ($aLinks['linkatype']) {

                    case 'menu':

                        if ($menuid = $aLinks['linkamenu']) {

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

                        if ($itemurl = $aLinks['linkaurl']) {
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
