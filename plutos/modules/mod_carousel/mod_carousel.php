<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_carousel
 */
defined('_JEXEC') or die;
// Include the news functions only once
JLoader::register('ModCarouselHelper', __DIR__ . '/helper.php');
if (!class_exists('MobileDetect')) {
    jimport('informationtechnology.mobiledetect.mobile_detect');
}
//Parameters
$uniqid = $module->id;
$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');
$autoplay = (int) $params->get('autoplay', 0);
$show_arrows = (int) $params->get('show_arrows', 0);
$show_introtext = (int) $params->get('show_introtext', 0);
$show_custom_nav = (int) $params->get('show_custom_nav', 0);
$introtext_limit = $params->get('introtext_limit', 100);
// get instance.
$list = ModCarouselHelper::getList($params);

require JModuleHelper::getLayoutPath('mod_carousel', $params->get('layout', 'default'));
