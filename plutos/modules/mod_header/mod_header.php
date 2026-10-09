<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_header
 */
defined('_JEXEC') or die;
// Include the menu functions only once
JLoader::register('ModHeaderHelper', __DIR__ . '/helper.php');

// $list = ModHeaderHelper::getList($params);

$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');

$cMarquee = "";
$cShare = "";
$cCart = "";
$cLanguage = "";

// ---- render modules in mod view ---
$isRenderModuleMarqueeEnabled = false;
$moduleMarquee = JModuleHelper::getModules('marquee');
if (count($moduleMarquee)):
    $isRenderModuleMarqueeEnabled = true;
endif;

$isRenderModuleShareEnabled = false;
$moduleShare = JModuleHelper::getModules('share');
if (count($moduleShare)):
    $isRenderModuleShareEnabled = true;
endif;

$isRenderModuleCartEnabled = false;
$moduleCart = JModuleHelper::getModules('cart');
if (count($moduleCart)):
    $isRenderModuleCartEnabled = true;
endif;

$isRenderModuleLanguageEnabled = false;
$moduleLanguage = JModuleHelper::getModules('language');
if (count($moduleLanguage)):
    $isRenderModuleLanguageEnabled = true;
endif;
// ---- /.render modules in mod view ---

require JModuleHelper::getLayoutPath('mod_header', $params->get('layout', 'default'));
