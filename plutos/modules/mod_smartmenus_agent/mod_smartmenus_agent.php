<?php
/**
 * @author      Binh Nguyen! Project
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_smartmenus_agent
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
// Include the helper functions only once
JLoader::register('ModSmartmenusAgentHelper', __DIR__ . '/helper.php');
// $list = ModSmartmenusAgentHelper::getList($params);

$uniqid = $module->id;

$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_smartmenus_agent', $params->get('layout', 'default'));
