<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Featured Table class.
 *
 * @since  1.6
 */
class StandardTableRatedetails extends JTable {

    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  Database connector object
     *
     * @since   1.6
     */
    public function __construct(JDatabaseDriver $db) {
        parent::__construct('#__standard_rate_details', 'id', $db);
    }

}
