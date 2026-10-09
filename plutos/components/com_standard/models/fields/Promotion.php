<?php
/**
 * @package     giaiphapcongnghethongtin.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
namespace Joomla\CMS\Form\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('list');


class PromotionField extends \JFormFieldList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'Promotion';

    /**
     * Cached array of the category items.
     *
     * @var    array
     * @since  3.2
     */
    protected static $options = array();

    /**
     * Method to get the options to populate list
     *
     * @return  array  The field option objects.
     *
     * @since   3.2
     */
    protected function getOptions() {
        // Accepted modifiers
        $hash = md5($this->element);

        if (!isset(static::$options[$hash])) {
            static::$options[$hash] = parent::getOptions();

            $db = Factory::getDbo();
            // Construct the query
            $query = $db->getQuery(true)
                    ->select('id AS value, title AS text')
                    ->from('#__standard_promotions')
                    ->where('state IN (1)')
                    ->where('language in (' . $db->quote(Factory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')')
                    ->group($db->quoteName('id'))
                    ->order('title');

            // Setup the query
            $db->setQuery($query);
            //echo nl2br(str_replace('#__', 'brle6_', $query));
            //exit;
            // Return the result
            if ($options = $db->loadObjectList()) {
                static::$options[$hash] = array_merge(static::$options[$hash], $options);
            }
        }

        return static::$options[$hash];
    }

}