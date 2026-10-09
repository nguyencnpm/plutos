<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('StandardHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/standard.php');

use Joomla\Utilities\ArrayHelper;

/**
 * Standard HTML helper
 *
 * @since  3.0
 */
abstract class JHtmlStandardAdministrator {

    /**
     * Render the list of associated items
     *
     * @param   int  $productid  The product item id
     *
     * @return  string  The language HTML
     */
    public static function association($productid) {
        // Defaults
        $html = '';

        // Get the associations
        if ($associations = JLanguageAssociations::getAssociations('com_standard', '#__standard_products', 'com_standard.item', $productid)) {
            foreach ($associations as $tag => $associated) {
                $associations[$tag] = (int) $associated->id;
            }

            // Get the associated menu items
            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                    ->select('p.*')
                    ->select('l.sef as lang_sef')
                    ->from('#__standard_products as p')
                    ->select('cat.title as category_title')
                    ->join('LEFT', '#__standard_categories as cat ON cat.id=p.catid')
                    ->where('p.id IN (' . implode(',', array_values($associations)) . ')')
                    ->join('LEFT', '#__languages as l ON p.language=l.lang_code')
                    ->select('l.image')
                    ->select('l.title as language_title');
            $db->setQuery($query);

            try {
                $items = $db->loadObjectList('id');
            } catch (RuntimeException $e) {
                throw new Exception($e->getMessage(), 500);
            }

            if ($items) {
                foreach ($items as &$item) {
                    $text = strtoupper($item->lang_sef);
                    $url = JRoute::_('index.php?option=com_standard&task=product.edit&id=' . (int) $item->id);
                    $tooltipParts = array(
                        JHtml::_('image', 'mod_languages/' . $item->image . '.gif', $item->language_title, array('title' => $item->language_title), true
                        ),
                        $item->title,
                        '(' . $item->category_title . ')'
                    );

                    $item->link = JHtml::_(
                                    'tooltip', implode(' ', $tooltipParts), null, null, $text, $url, null, 'hasTooltip label label-association label-' . $item->lang_sef
                    );
                }
            }

            $html = JLayoutHelper::render('standard.content.associations', $items);
        }

        return $html;
    }

    /**
     * Show the feature/unfeature links
     *
     * @param   int      $value      The state value
     * @param   int      $i          Row number
     * @param   boolean  $canChange  Is user allowed to change?
     *
     * @return  string       HTML code
     */
    public static function featured($value = 0, $i, $canChange = true) {
        JHtml::_('bootstrap.tooltip');

        // Array of image, task, title, action
        $states = array(
            0 => array('unfeatured', 'products.featured', 'COM_STANDARD_UNFEATURED', 'JGLOBAL_TOGGLE_FEATURED'),
            1 => array('featured', 'products.unfeatured', 'COM_STANDARD_FEATURED', 'JGLOBAL_TOGGLE_FEATURED'),
        );
        $state = JArrayHelper::getValue($states, (int) $value, $states[1]);
        $icon = $state[0];

        if ($canChange) {
            $html = '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[1] . '\')" class="btn btn-micro hasTooltip'
                    . ($value == 1 ? ' active' : '') . '" title="' . JHtml::tooltipText($state[3]) . '"><span class="icon-' . $icon . '"></span></a>';
        } else {
            $html = '<a class="btn btn-micro hasTooltip disabled' . ($value == 1 ? ' active' : '') . '" title="'
                    . JHtml::tooltipText($state[2]) . '"><span class="icon-' . $icon . '"></span></a>';
        }

        return $html;
    }

    /**
     * Show the status/unstatus links
     *
     * @param   integer  $value      The state value
     * @param   integer  $i          Row number
     * @param   boolean  $canChange  Is user allowed to change?
     *
     * @return  string       HTML code
     */
    public static function status($value = 0, $i, $canChange = true, $task = "orders") {
        JHtml::_('bootstrap.tooltip');

        // Array of image, task, title, action
        $states = array(
            0 => array('unpublish', "{$task}.publish", 'COM_STANDARD_UNPUBLISHED', 'COM_STANDARD_TOGGLE_UNPUBLISHED'),
            1 => array('publish', "{$task}.unpublish", 'COM_STANDARD_PUBLISHED', 'COM_STANDARD_TOGGLE_PUBLISHED'),
            2 => array('archive', "{$task}.unarchive", 'COM_STANDARD_PUBLISHED', 'COM_STANDARD_TOGGLE_ARCHIVE'),
            -2 => array('trash', "{$task}.untrash", 'COM_STANDARD_PUBLISHED', 'COM_STANDARD_TOGGLE_TRASH')
        );
        $state = ArrayHelper::getValue($states, (int) $value, $states[1]);
        $icon = $state[0];

        if ($canChange) {
            $html = '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[1] . '\')" class="btn btn-micro hasTooltip'
                    . ($value == 1 ? ' active' : '') . '" title="' . JHtml::_('tooltipText', $state[3])
                    . '"><span class="icon-' . $icon . '" aria-hidden="true"></span>' . JText::_($state[3]) . '</a>';
        } else {
            $html = '<a class="btn btn-micro hasTooltip disabled' . ($value == 1 ? ' active' : '') . '" title="'
                    . JHtml::_('tooltipText', $state[2]) . '"><span class="icon-' . $icon . '" aria-hidden="true"></span>' . JText::_($state[3]) . '</a>';
        }

        return $html;
    }

}
