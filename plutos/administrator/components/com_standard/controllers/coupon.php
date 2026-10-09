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
 * The coupon controller
 *
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 * @since       1.6
 */
class StandardControllerCoupon extends JControllerForm {

    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'COM_STANDARD_COUPON';
    /**
     * Class constructor.
     *
     * @param   array  $config  A named array of configuration variables.
     *
     * @since   1.6
     */
    public function __construct($config = array()) {

        parent::__construct($config);
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
        if ($user->authorise('core.edit', 'com_standard.coupon.' . $recordId)) {
            return true;
        }

        // Check edit own on the record asset (explicit or inherited)
        if ($user->authorise('core.edit.own', 'com_standard.coupon.' . $recordId)) {
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
