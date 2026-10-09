<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_products
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
// Include the news functions only once
JLoader::register('ModProductsHelper', __DIR__ . '/helper.php');

$list = ModProductsHelper::getList($params);
if (!empty($list)):
    $uniqid = $module->id;
    $class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');

    $subheading_medialayoutelement = htmlspecialchars($params->get('subheading_medialayoutelement'), ENT_COMPAT, 'UTF-8');
    $cSubheadingLayoutElement = empty($subheading_medialayoutelement) ? "" : $subheading_medialayoutelement . " mx-auto " . htmlspecialchars($params->get('class_subheading'), ENT_COMPAT, 'UTF-8');

    $sLinkType = htmlspecialchars($params->get('link_type'), ENT_COMPAT, 'UTF-8');
    $sUrlText = htmlspecialchars($params->get('url_text'), ENT_COMPAT, 'UTF-8');

    $leading_medialayoutelement = htmlspecialchars($params->get('leading_medialayoutelement'), ENT_COMPAT, 'UTF-8');
    $intro_medialayoutelement = htmlspecialchars($params->get('intro_medialayoutelement'), ENT_COMPAT, 'UTF-8');
    $cLeadingLayoutElement = empty($leading_medialayoutelement) ? "" : $leading_medialayoutelement . " mx-auto ";
    $cIntroLayoutElement = empty($intro_medialayoutelement) ? "" : $intro_medialayoutelement . " mx-auto ";

    $numLeading = $params->def('num_leading', 3);
    $numIntro = $params->def('num_intro', 1);
    $numLinks = $params->def('num_links', 0);

    $columnLeading = max(1, $params->def('num_columns_leading', 1));
    $columnIntro = max(1, $params->def('num_columns_intro', 1));
    $order = $params->def('multi_column_order', 1);

    require JModuleHelper::getLayoutPath('mod_products', $params->get('layout', 'default'));
endif;