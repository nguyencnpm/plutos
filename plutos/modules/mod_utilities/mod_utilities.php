<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_utilities
 */
defined('_JEXEC') or die;
// Include the login functions only once
JLoader::register('ModUtilitiesHelper', __DIR__ . '/helper.php');
$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');

$link = '';
if (!empty($params->get('cart'))):
    $link = ModUtilitiesHelper::getLink($params);
endif;
$show_popover = $params->get("show_popover");
require JModuleHelper::getLayoutPath('mod_utilities', $params->get('layout', 'default'));
?>
