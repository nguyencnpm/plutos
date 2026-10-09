<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standardextension
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
JHtml::_('behavior.tabstate');

if (!JFactory::getUser()->authorise('core.manage', 'com_standardextension')) {
    throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

JLoader::register('StandardextensionHelper', __DIR__ . '/helpers/standardextension.php');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'components/com_standard/assets/css/style.min.css');

$controller = JControllerLegacy::getInstance('Standardextension');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
