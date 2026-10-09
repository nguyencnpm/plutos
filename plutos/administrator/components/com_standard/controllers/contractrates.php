<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Contractrates list controller class.
 *
 * @since  1.6
 */
class StandardControllerContractrates extends JControllerAdmin {

    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'COM_STANDARD_CONTRACT_RATES';

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  The array of possible config values. Optional.
     *
     * @return  JModel
     *
     * @since   1.6
     */
    public function getModel($name = 'Contractrate', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }

    /**
     * Function that allows child controller access to model data
     * after the item has been deleted.
     *
     * @param   JModelLegacy  $model  The data model object.
     * @param   integer       $ids    The array of ids for items being deleted.
     *
     * @return  void
     *
     * @since   12.2
     */
    protected function postDeleteHook(JModelLegacy $model, $ids = null) {
        if (!empty($ids)) {
            $model->deleteMapping("contractrate_id", $ids, array(0 => "#__standard_contractrate_details", 1 => "#__standard_routecontractrate_map", 2 => "#__standard_productcontractrate_map"));
        }
    }

}
