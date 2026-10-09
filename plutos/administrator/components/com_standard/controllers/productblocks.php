<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('StandardControllerProducts', __DIR__ . '/products.php');

/**
 * Productblocks product controller class.
 *
 * @since  1.6
 */
class StandardControllerProductblocks extends StandardControllerProducts {

    /**
     * Method to publish a list of products.
     *
     * @return  void
     *
     * @since   1.0
     */
    public function publish() {
        parent::publish();

        $this->setRedirect('index.php?option=com_standard&view=productblocks');
    }

    /**
     * Method to get a model object, loading it if required.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     *
     * @since   1.6
     */
    public function getModel($name = 'Productblock', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }

}
