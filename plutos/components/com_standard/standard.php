<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');
*/
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
JLoader::register('StandardHelperRoute', JPATH_SITE . '/components/com_standard/helpers/route.php');
JLoader::register('StandardHelperQuery', JPATH_SITE . '/components/com_standard/helpers/query.php');
JLoader::register('StandardHelperAssociation', JPATH_SITE . '/components/com_standard/helpers/association.php');
// -- xem lai --
/*
if (!class_exists('CalculationHelper')) {
    JLoader::register('CalculationHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/calculation.php');
}

if (!class_exists('CurrencyHelper')) {
    JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
}
*/
// -- /.xem lai --
if (!class_exists('MobileDetect')) {
    jimport('informationtechnology.mobiledetect.mobile_detect');
}
$input = JFactory::getApplication()->input;
$user = JFactory::getUser();

if ($input->get('view') === 'product' && $input->get('layout') === 'pagebreak') {
    if (!$user->authorise('core.create', 'com_standard')) {
        JFactory::getApplication()->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');

        return;
    }
} elseif ($input->get('view') === 'products' && $input->get('layout') === 'modal') {
    if (!$user->authorise('core.create', 'com_standard')) {
        JFactory::getApplication()->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');

        return;
    }
}

$controller = JControllerLegacy::getInstance('Standard');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
