<?php
/**
 * @author      Binh Nguyen! Project
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_smartmenus
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the menu functions only once
JLoader::register('ModSmartmenusHelper', __DIR__ . '/helper.php');

$list = ModSmartmenusHelper::getList($params);
$base = ModSmartmenusHelper::getBase($params);
$active = ModSmartmenusHelper::getActive($params);

$start = (int) $params->get('startLevel', 1);
$end = (int) $params->get('endLevel', 0);

$default = ModSmartmenusHelper::getDefault();
$active_id = $active->id;
$default_id = $default->id;
$path = $base->tree;
$showAll = $params->get('showAllChildren', 1);
$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');
$justify_content = htmlspecialchars($params->get('justify_content'), ENT_COMPAT, 'UTF-8');
$direction = htmlspecialchars($params->get('direction'), ENT_COMPAT, 'UTF-8');

if (count($list)) {
    require JModuleHelper::getLayoutPath('mod_smartmenus', $params->get('layout', 'default'));
}
