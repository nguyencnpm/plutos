<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('StandardModelProduct', __DIR__ . '/product.php');

/**
 * Standard Component Productdetail Model
 *
 * @since  1.5
 */
class StandardModelProductdetail extends StandardModelProduct {

    /**
     * Model context string.
     *
     * @var        string
     */
    protected $_context = 'com_standard.productdetail';
    protected $_products = null;

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since   1.6
     *
     * @return void
     */
    protected function populateState() {
        $app = JFactory::getApplication('site');

        // Load state from the request.
        $pk = $app->input->getInt('id');
        $this->setState('product.id', $pk);

        $offset = $app->input->getUInt('limitstart');
        $this->setState('list.offset', $offset);

        // Load the parameters.
        $params = $app->getParams();
        $this->setState('params', $params);

        // TODO: Tune these values based on other permissions.
        $user = JFactory::getUser();

        if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
            $this->setState('filter.published', 1);
            $this->setState('filter.archived', 2);
        }

        $this->setState('filter.language', JLanguageMultilang::isEnabled());
    }

    /**
     * Method to get product data.
     *
     * @param   integer  $pk  The id of the product.
     *
     * @return  object|boolean|JException  Menu item data object on success, boolean false or JException instance on error
     */
    public function getItem($pk = null) { 
        return parent::getItem();
    }

}
