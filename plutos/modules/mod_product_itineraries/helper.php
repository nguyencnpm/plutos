<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_product_itineraries
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

if (!class_exists('StandardHelperRoute')) {
    JLoader::register('StandardHelperRoute', JPATH_SITE . '/components/com_standard/helpers/route.php');
}

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_standard/models', 'StandardModel');

/**
 * Helper for mod_products
 *
 * @since  1.6
 */
abstract class ModProductitinerariesHelper {

    /**
     * Get a list of the latest products from the product model
     *
     * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
     *
     * @return  mixed
     *
     * @since 1.6
     */
    public static function getList(&$params, $aInfoCurrent) {
        // Get an instance of the generic products model
        $model = JModelLegacy::getInstance('Itineraries', 'StandardModel', array('ignore_request' => true));

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
        // $model->setState('filter.category_id', $params->get('catid', array()));
        // $model->setState('filter.category_id', isset($aInfoCurrent['current_catid'])? $aInfoCurrent['current_catid']: 0);
        $model->setState('filter.product_id', isset($aInfoCurrent['current_item_id'])?$aInfoCurrent['current_item_id']: 0);

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
        $ordering = $params->get('ordering', 'p.ordering');
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

//        echo '<pre>';
//        print_r($items);
//        exit;
        foreach ($items as &$item) {
            $item->readmore = strlen(trim($item->fulltext));
            $item->slug = $item->id . ':' . $item->alias;

            /** @deprecated Catslug is deprecated, use itinerarytype_id instead. 4.0 */
            $item->catslug = $item->itinerarytype_id . ':' . $item->itinerarytype_alias;

            if ($access || in_array($item->access, $authorised)) {
                // We know that user has the privilege to view the product
                $item->link = JRoute::_(StandardHelperRoute::getItineraryRoute($item->slug, $item->itinerarytype_id, $item->language));
                $item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE');
            } else {
                $item->link = new JUri(JRoute::_('index.php?option=com_users&view=login', false));
                $item->link->setVar('return', base64_encode(StandardHelperRoute::getItineraryRoute($item->slug, $item->itinerarytype_id, $item->language)));
                $item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE_REGISTER');
            }

            $item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_products.content');

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

        return $items;
    }

}
