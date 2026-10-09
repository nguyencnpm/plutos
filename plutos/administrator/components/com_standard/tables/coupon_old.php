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
class StandardTableCoupon extends JTable {

    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  Database connector object
     *
     * @since   1.6
     */
    public function __construct(JDatabaseDriver $db) {
        parent::__construct('#__standard_coupons', 'id', $db);

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
        // Bind the rules.
        if (isset($array['rules']) && is_array($array['rules'])) {
            $rules = new JAccessRules($array['rules']);
            $this->setRules($rules);
        }

        return parent::bind($array, $ignore);
    }

    /**
     * Override check function
     *
     * @return  boolean
     *
     * @see     JTable::check()
     * @since   11.1
     */
    public function check() {
        // Check for a title.
        if (trim($this->title) == '') {
            $this->setError(JText::_('JLIB_DATABASE_ERROR_MUSTCONTAIN_A_TITLE_CATEGORY'));

            return false;
        }

        $this->alias = trim($this->alias);

        if (empty($this->alias)) {
            $this->alias = $this->title;
        }

        $this->alias = JApplicationHelper::stringURLSafe($this->alias, $this->language);

        if (trim(str_replace('-', '', $this->alias)) == '') {
            $this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
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
        $table = JTable::getInstance('Coupon', 'StandardTable', array('dbo' => $this->getDbo()));

        if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0)) {
            $this->setError(JText::_('JLIB_DATABASE_ERROR_ARTICLE_UNIQUE_ALIAS'));

            return false;
        }

        return parent::store($updateNulls);
    }

}
