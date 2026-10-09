<?php

/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_standard_footer
 */
defined('_JEXEC') or die;
$app = JFactory::getApplication();
// Include the menu functions only once
JLoader::register('ModStandardfooterHelper', __DIR__ . '/helper.php');

// $list = ModStandardfooterHelper::getList($params);

$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');

// get Template Params 
$templateTemp = $app->getTemplate(true);
$templateParams = $templateTemp->params;
$sitenameFooter = $app->get('sitename', '');

// ---- render modules in mod view ---
$isLogoFooter = false;
$isContentFooter = false;
// ---
$cLogoFooter = "col-12 col-lg-3";
// --- 
$cContentFooter = "col-12 col-lg-9";

$cContentMenuFooter = "col-12";

$cContentFooterOne = "col-12 col-lg-6";
$cContentFooterTwo = "col-12 col-lg-6";

$cContentShareFooter = "col-12 col-lg-6 mb-3";
$cContentFakeShareAndPartner = "col-0 col-lg-1";
$cContentPartnerFooter = "col-12 col-lg-5 mb-3";

// --- ---
$renderLogo = "";
if (!empty($templateParams->get('logofooter', ''))):
    $renderLogo = JUri::root() . $templateParams->get('logofooter', '');
    $isLogoFooter = true;
endif;
// ====== =====
$isRenderModuleMenuFooterEnabled = false;
$moduleMenuFooter = JModuleHelper::getModules('menufooter');
if (count($moduleMenuFooter)):
    $isRenderModuleMenuFooterEnabled = true;
    $isContentFooter = true;
endif;

$isRenderModuleFooterOneEnabled = false;
$moduleFooterOne = JModuleHelper::getModules('footer-1');
if (count($moduleFooterOne)):
    $isRenderModuleFooterOneEnabled = true;
    $isContentFooter = true;
endif;

$isRenderModuleFooterTwoEnabled = false;
$moduleFooterTwo = JModuleHelper::getModules('footer-2');
if (count($moduleFooterTwo)):
    $isRenderModuleFooterTwoEnabled = true;
    $isContentFooter = true;
endif;
// ====== update class - Footer One and Footer Two =====
if ($isRenderModuleFooterOneEnabled == true && $isRenderModuleFooterTwoEnabled == false):
    $cContentFooterOne = "col-12";
    $cContentFooterTwo = "col-0";
elseif ($isRenderModuleFooterOneEnabled == false && $isRenderModuleFooterTwoEnabled == true) :
    $cContentFooterOne = "col-0";
    $cContentFooterTwo = "col-12";
endif;
// ====== /.update class - Logo Footer and Content Footer =====

$isRenderModuleShareFooterEnabled = false;
$moduleShareFooter = JModuleHelper::getModules('sharefooter');
if (count($moduleShareFooter)):
    $isRenderModuleShareFooterEnabled = true;
    $isContentFooter = true;
endif;

$isRenderModulePartnerFooterEnabled = false;
$modulePartnerFooter = JModuleHelper::getModules('partnerfooter');
if (count($modulePartnerFooter)):
    $isRenderModulePartnerFooterEnabled = true;
    $isContentFooter = true;
endif;
// ====== update class - Share Footer and Partner Footer =====
if ($isRenderModuleShareFooterEnabled == true && $isRenderModulePartnerFooterEnabled == false):
    $cContentShareFooter = "col-12 mb-3";
    $cContentFakeShareAndPartner = "col-0";
    $cContentPartnerFooter = "col-0";
elseif ($isRenderModuleShareFooterEnabled == false && $isRenderModulePartnerFooterEnabled == true) :
    $cContentShareFooter = "col-0";
    $cContentFakeShareAndPartner = "col-0";
    $cContentPartnerFooter = "col-12 mb-3";
endif;
// ====== /. update class - Share Footer and Partner Footer =====
// ====== update class - Logo Footer and Content Footer =====
if ($isLogoFooter == true && $isContentFooter == false):
    $cLogoFooter = "col-12";
    $cContentFooter = "col-0";
elseif ($isLogoFooter == false && $isContentFooter == true) :
    $cLogoFooter = "col-0";
    $cContentFooter = "col-12";
endif;
// ====== /.update class - Logo Footer and Content Footer =====
// ---- /.render modules in mod view ---

// fix temp
$cContentFooterBlog = "";
$isRenderModuleFooterBlogEnabled = false;
$moduleFooterBlog = JModuleHelper::getModules('footerblog');
if (count($moduleFooterBlog)):
    $isRenderModuleFooterBlogEnabled = true;
    $isContentFooter = true;
endif;

require JModuleHelper::getLayoutPath('mod_standard_footer', $params->get('layout', 'default'));
