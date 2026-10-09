<?php

defined('_JEXEC') or die;
JHtml::_('behavior.tabstate');

if (!JFactory::getUser()->authorise('core.manage', 'com_standard')) {
    throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

JLoader::register('StandardHelper', __DIR__ . '/helpers/standard.php');
//JLoader::register('CurrencyHelper', __DIR__ . '/helpers/currency.php');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'components/com_standard/assets/css/style.min.css');

$controller = JControllerLegacy::getInstance('Standard'); //<Name component>
$controller->execute(JFactory::getApplication()->input->get('task')); //<execute: get('task') if exists, if does not exist get('task') then execute <[Name component]Controller>>
$controller->redirect();
