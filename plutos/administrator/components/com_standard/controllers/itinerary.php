<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * The itinerary controller
 *
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 * @since       1.6
 */
class StandardControllerItinerary extends JControllerForm {

    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'COM_STANDARD_ITINERARY';
    
    /**
     * Class constructor.
     *
     * @param   array  $config  A named array of configuration variables.
     *
     * @since   1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
        // An itinerary edit form can come from the itineraries or featured view.
        // Adjust the redirect view on the value of 'return' in the request.
        if ($this->input->get('return') == 'featured') {
            $this->view_list = 'featured';
            $this->view_item = 'itinerary&return=featured';
        }
        
        // An itinerary edit form can come from the itineraries or featured or itineraryblock view.
        // Adjust the redirect view on the value of 'view' in the request.
        if ($this->input->get('return') == 'itineraryblocks') {
            $this->view_list = 'itineraryblocks';
            $this->view_item = 'itinerary&return=itineraryblocks';
        }
    }

    /**
     * Method override to check if you can add a new record.
     *
     * @param   array  $data  An array of input data.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowAdd($data = array()) {
        $user = JFactory::getUser();
        $itinerarytypeId = JArrayHelper::getValue($data, 'itinerarytype_id', $this->input->getInt('filter_itinerarytype_id'), 'int');
        $allow = null;

        if ($itinerarytypeId) {
            // If the itinerarytype has been passed in the data or URL check it.
            $allow = $user->authorise('core.create', 'com_standard.itinerarytype.' . $itinerarytypeId);
        }

        if ($allow === null) {
            // In the absense of better information, revert to the component permissions.
            return parent::allowAdd();
        } else {
            return $allow;
        }
    }

    /**
     * Method override to check if you can edit an existing record.
     *
     * @param   array   $data  An array of input data.
     * @param   string  $key   The name of the key for the primary key.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowEdit($data = array(), $key = 'id') {

        $recordId = (int) isset($data[$key]) ? $data[$key] : 0;
        $user = JFactory::getUser();

        // Zero record (id:0), return component edit permission by calling parent controller method
        if (!$recordId) {
            return parent::allowEdit($data, $key);
        }

        // Check edit on the record asset (explicit or inherited)
        if ($user->authorise('core.edit', 'com_standard.itinerary.' . $recordId)) {
            return true;
        }

        // Check edit own on the record asset (explicit or inherited)
        if ($user->authorise('core.edit.own', 'com_standard.itinerary.' . $recordId)) {
            // Existing record already has an owner, get it
            $record = $this->getModel()->getItem($recordId);

            if (empty($record)) {
                return false;
            }

            // Grant if current user is owner of the record
            return $user->get('id') == $record->created_by;
        }

        return false;
    }

    /**
     * Method to run batch operations.
     *
     * @param   object  $model  The model.
     *
     * @return  boolean   True if successful, false otherwise and internal error is set.
     *
     * @since   1.6
     */
    public function batch($model = null) {

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Set the model
        $model = $this->getModel('Itinerary', '', array());

        // Preset the redirect
        $this->setRedirect(JRoute::_('index.php?option=com_standard&view=itineraries' . $this->getRedirectToListAppend(), false));

        return parent::batch($model);
    }

    /**
     * Function that allows child controller access to model data after the data has been saved.
     *
     * @param   JModelLegacy  $model      The data model object.
     * @param   array         $validData  The validated data.
     *
     * @return	void
     *
     * @since	3.1
     */
    protected function postSaveHook(JModelLegacy $model, $validData = array()) {

        return;
    }

}
