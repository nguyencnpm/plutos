<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Featured Table class.
 *
 * @since  1.6
 */
class StandardTableProductitinerary extends JTable {

    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  Database connector object
     *
     * @since   1.6
     */
    public function __construct(JDatabaseDriver $db) {// __construct(&$db) {
        parent::__construct('#__standard_itineraries', 'product_id', $db);

        //JTableObserverTags::createObserver($this, array('typeAlias' => 'com_standard.itinerary'));
        //JTableObserverContenthistory::createObserver($this, array('typeAlias' => 'com_standard.itinerary'));
        // Set the alias since the column is called state
        $this->setColumnAlias('published', 'state');
    }

}
