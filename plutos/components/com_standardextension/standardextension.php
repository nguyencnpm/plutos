<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standardextension
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('StandardextensionHelperRoute', JPATH_SITE . '/components/com_standardextension/helpers/route.php');
JLoader::register('StandardextensionHelperQuery', JPATH_SITE . '/components/com_standardextension/helpers/query.php');
JLoader::register('StandardextensionHelperAssociation', JPATH_SITE . '/components/com_standardextension/helpers/association.php');

$input = JFactory::getApplication()->input;
$user = JFactory::getUser();

$checkCreateEdit = ($input->get('view') === 'articles' && $input->get('layout') === 'modal') || ($input->get('view') === 'article' && $input->get('layout') === 'pagebreak');

if ($checkCreateEdit) {
    // Can create in any category (component permission) or at least in one category
    $canCreateRecords = $user->authorise('core.create', 'com_standardextension') || count($user->getAuthorisedCategories('com_standardextension', 'core.create')) > 0;

    // Instead of checking edit on all records, we can use **same** check as the form editing view
    $values = (array) JFactory::getApplication()->getUserState('com_standardextension.edit.article.id');
    $isEditingRecords = count($values);

    $hasAccess = $canCreateRecords || $isEditingRecords;

    if (!$hasAccess) {
        JFactory::getApplication()->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');

        return;
    }
}

$controller = JControllerLegacy::getInstance('Standardextension');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
