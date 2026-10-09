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
class StandardTableAgent extends JTable {

    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  Database connector object
     *
     * @since   1.6
     */
    public function __construct(JDatabaseDriver $db) {// __construct(&$db) {
        parent::__construct('#__standard_agents', 'id', $db);

        // Set the alias since the column is called state
        $this->setColumnAlias('published', 'state');
    }

    /**
     * Overloaded bind function
     *
     * @param   array  $array   Named array
     * @param   mixed  $ignore  An optional array or space separated list of properties
     *                          to ignore while binding.
     *
     * @return  mixed  Null if operation was satisfactory, otherwise returns an error string
     *
     * @see     JTable::bind()
     * @since   11.1
     */
    public function bind($array, $ignore = '') {
        // Search for the {readmore} tag and split the text up accordingly.
        if (isset($array['agenttext'])) {
            $pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
            $tagPos = preg_match($pattern, $array['agenttext']);

            if ($tagPos == 0) {
                $this->introtext = $array['agenttext'];
                $this->fulltext = '';
            } else {
                list ($this->introtext, $this->fulltext) = preg_split($pattern, $array['agenttext'], 2);
            }
        }

        return parent::bind($array, $ignore);
    }

    /**
     * Overloaded check function
     *
     * @return  boolean  True on success, false on failure
     *
     * @see     JTable::check()
     * @since   11.1
     */
    public function check() {
        /*
        if (trim($this->user_id) == '0') {
            $this->setError(JText::_('COM_HOTELSRESORTS_WARNING_PROVIDE_VALID_USER'));

            return false;
        }
        */
        if (trim($this->title) == '') {
            $this->setError(JText::_('COM_HOTELSRESORTS_WARNING_PROVIDE_VALID_NAME'));

            return false;
        }

        if (trim($this->alias) == '') {
            $this->alias = $this->title;
        }

        $this->alias = JApplicationHelper::stringURLSafe($this->alias, $this->language);

        if (trim(str_replace('-', '', $this->alias)) == '') {
            $this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
        }
        
        if (trim(str_replace('&nbsp;', '', $this->fulltext)) == '') {
            $this->fulltext = '';
        }

        /**
         * Ensure any new items have compulsory fields set. This is needed for things like
         * frontend editing where we don't show all the fields or using some kind of API
         */
        if (!$this->id) {
            // Images can be an empty json string
            if (!isset($this->images)) {
                $this->images = '{}';
            }
        }

        // Check the publish down date is not earlier than publish up.
        if ($this->publish_down > $this->_db->getNullDate() && $this->publish_down < $this->publish_up) {
            // Swap the dates.
            $temp = $this->publish_up;
            $this->publish_up = $this->publish_down;
            $this->publish_down = $temp;
        }

        return true;
    }

    /**
     * Overrides JTable::store to set modified data and user id.
     *
     * @param   boolean  $updateNulls  True to update fields even if they are null.
     *
     * @return  boolean  True on success.
     *
     * @since   11.1
     */
    public function store($updateNulls = false) {
        $date = JFactory::getDate();
        $user = JFactory::getUser();

        $this->modified = $date->toSql();

        if ($this->id) {
            // Existing item
            $this->modified_by = $user->get('id');
        } else {
            // New article. An article created and created_by field can be set by the user,
            // so we don't touch either of these if they are set.
            if (!(int) $this->created) {
                $this->created = $date->toSql();
            }

            if (empty($this->created_by)) {
                $this->created_by = $user->get('id');
            }
        }

        // Verify that the alias is unique
        $table = JTable::getInstance('Agent', 'StandardTable', array('dbo' => $this->getDbo()));

        if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0)) {
            $this->setError(JText::_('JLIB_DATABASE_ERROR_TRAVEL_AGENT_UNIQUE_ALIAS'));

            return false;
        }

        return parent::store($updateNulls);
    }

}
