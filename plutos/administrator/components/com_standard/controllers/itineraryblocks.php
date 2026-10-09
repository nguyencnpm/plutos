<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('StandardControllerItineraries', __DIR__ . '/itineraries.php');

/**
 * Itineraryblocks itinerary controller class.
 *
 * @since  1.6
 */
class StandardControllerItineraryblocks extends StandardControllerItineraries {

    /**
     * Method to publish a list of itineraries.
     *
     * @return  void
     *
     * @since   1.0
     */
    public function publish() {
        parent::publish();

        $this->setRedirect('index.php?option=com_standard&view=itineraryblocks');
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
    public function getModel($name = 'Itineraryblock', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }

}
