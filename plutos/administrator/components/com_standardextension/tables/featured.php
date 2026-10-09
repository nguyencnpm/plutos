<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standardextension
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Featured Table class.
 *
 * @since  1.6
 */
class StandardextensionTableFeatured extends JTable {

    /**
     * Constructor
     *
     * @param   JDatabaseDriver  $db  Database connector object
     *
     * @since   1.6
     */
    public function __construct(&$db) {
        parent::__construct('#__standardextension_content_frontpage', 'content_id', $db);
    }

}
