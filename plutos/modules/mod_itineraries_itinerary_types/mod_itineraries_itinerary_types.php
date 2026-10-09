<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_itineraries_itinerary_types
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the helper functions only once
JLoader::register('ModItinerariesItineraryTypesHelper', __DIR__ . '/helper.php');

if (!class_exists('StandardHelperRoute')) {
    JLoader::register('StandardHelperRoute', JPATH_SITE . '/components/com_standard/helpers/route.php');
}

$cacheid = md5($module->id);

$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class = 'ModItinerariesItineraryTypesHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = $cacheid;

$list = JModuleHelper::moduleCache($module, $params, $cacheparams);

if (!empty($list)) {
    $class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');
    $startLevel = reset($list)->getParent()->level;

    $subheading_medialayoutelement = htmlspecialchars($params->get('subheading_medialayoutelement'), ENT_COMPAT, 'UTF-8');
    $cSubheadingLayoutElement = empty($subheading_medialayoutelement) ? "" : $subheading_medialayoutelement . " mx-auto " . htmlspecialchars($params->get('class_subheading'), ENT_COMPAT, 'UTF-8');

    $oLink = $params->get('links');
    $sLinkType = ModItinerariesItineraryTypesHelper::getLink($oLink);
  
    $sUrlText = htmlspecialchars($params->get('url_text'), ENT_COMPAT, 'UTF-8');

    $leading_medialayoutelement = htmlspecialchars($params->get('leading_medialayoutelement'), ENT_COMPAT, 'UTF-8');
    $intro_medialayoutelement = htmlspecialchars($params->get('intro_medialayoutelement'), ENT_COMPAT, 'UTF-8');
    $cLeadingLayoutElement = empty($leading_medialayoutelement) ? "" : $leading_medialayoutelement . " mx-auto ";
    $cIntroLayoutElement = empty($intro_medialayoutelement) ? "" : $intro_medialayoutelement . " mx-auto ";

    $numLeading = $params->def('num_leading', 2);
    $numIntro = $params->def('num_intro', 1);
    $numLinks = $params->def('num_links', 0);

    $columnLeading = max(1, $params->def('num_columns_leading', 1));
    $columnIntro = max(1, $params->def('num_columns_intro', 1));
    $order = $params->def('multi_column_order', 1);
    
    /*
    // Show the Intro/Full image field of the product
    if ($params->get('img_intro_full') !== 'none') {
        
    }
    */
    require JModuleHelper::getLayoutPath('mod_itineraries_itinerary_types', $params->get('layout', 'default'));
}
