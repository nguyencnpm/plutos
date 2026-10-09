<?php

// no direct access
defined('_JEXEC') or die;
// Include the weblinks functions only once
require_once dirname(__FILE__) . '/helper.php';
//Parameters
$uniqid = $module->id;

$list = modVideoHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$title = htmlspecialchars($params->get('title'));
$link = htmlspecialchars($params->get('url'));
$thumbnail = htmlspecialchars($params->get('thumbnail'));

require JModuleHelper::getLayoutPath('mod_video', $params->get('layout', 'default'));
