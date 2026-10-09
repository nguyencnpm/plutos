<?php

defined('_JEXEC') or die;

// Include the search functions only once
JLoader::register('ModSubscribeHelper', __DIR__ . '/helper.php');
$form = ModSubscribeHelper::getForm();
$keyform = "subscribe-" . $module->id;
$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_subscribe', $params->get('layout', 'default'));
