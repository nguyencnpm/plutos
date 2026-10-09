<?php

/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;
$params = $displayData['item']->params;

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$templateParams = $template->params;
$templateParams->get('tooltip_viewport');

$tooltip = "hover percent polaroid " . $templateParams->get('tooltip_viewport');
$isShowTooltipImage = false;

//$mobile = new MobileDetect();
// Desktop - default
$nameImageSize = "image_medium";
/*
  // Phone
  if ($mobile->isMobile()) {
  $nameImageSize = "image_medium";
  }
  // Tablet
  if ($mobile->isTablet()) {
  $nameImageSize = "image_medium";
  }
 */

echo $this->sublayout($displayData['sublayout'], $displayData['item']);
?>

