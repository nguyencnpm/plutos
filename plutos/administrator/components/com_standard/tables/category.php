<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_categories
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

/**
 * Category table
 *
 * @since  1.6
 */
class StandardTableCategory extends JTableNested {

    /**
     * Constructor
     *
     * @param   \JDatabaseDriver  $db  Database driver object.
     *
     * @since   1.5
     */
    public function __construct(\JDatabaseDriver $db) {
        parent::__construct('#__standard_categories', 'id', $db);
        /*
          Tags::createObserver($this, array('typeAlias' => '{extension}.category'));
          ContentHistory::createObserver($this, array('typeAlias' => '{extension}.category'));

          $this->access = (int) \JFactory::getConfig()->get('access');
         */
    }

    /**
     * Method to compute the default name of the asset.
     * The default name is in the form table_name.id
     * where id is the value of the primary key of the table.
     *
     * @return  string
     *
     * @since   1.6
     */
    protected function _getAssetName() {
        $k = $this->_tbl_key;

        return $this->extension . '.category.' . (int) $this->$k;
    }

    /**
     * Method to return the title to use for the asset table.
     *
     * @return  string
     *
     * @since   1.6
     */
    protected function _getAssetTitle() {
        return $this->title;
    }

    /**
     * Get the parent asset id for the record
     *
     * @param   Table    $table  A JTable object for the asset parent.
     * @param   integer  $id     The id for the asset
     *
     * @return  integer  The id of the asset's parent
     *
     * @since   1.6
     */
    protected function _getAssetParentId($table = null, $id = null) {// _getAssetParentId(Table $table = null, $id = null)
        $assetId = null;

        // This is a category under a category.
        if ($this->parent_id > 1) {
            // Build the query to get the asset id for the parent category.
            $query = $this->_db->getQuery(true)
                    ->select($this->_db->quoteName('asset_id'))
                    ->from($this->_db->quoteName('#__standard_categories'))
                    ->where($this->_db->quoteName('id') . ' = ' . $this->parent_id);

            // Get the asset id from the database.
            $this->_db->setQuery($query);

            if ($result = $this->_db->loadResult()) {
                $assetId = (int) $result;
            }
        }
        // This is a category that needs to parent with the extension.
        elseif ($assetId === null) {
            // Build the query to get the asset id for the parent category.
            $query = $this->_db->getQuery(true)
                    ->select($this->_db->quoteName('id'))
                    ->from($this->_db->quoteName('#__assets'))
                    ->where($this->_db->quoteName('name') . ' = ' . $this->_db->quote($this->extension));

            // Get the asset id from the database.
            $this->_db->setQuery($query);

            if ($result = $this->_db->loadResult()) {
                $assetId = (int) $result;
            }
        }

        // Return the asset id.
        if ($assetId) {
            return $assetId;
        } else {
            return parent::_getAssetParentId($table, $id);
        }
    }

    /**
     * Override check function
     *
     * @return  boolean
     *
     * @see     Table::check()
     * @since   1.5
     */
    public function check() {
        // Check for a title.
        if (trim($this->title) == '') {
            $this->setError(\JText::_('JLIB_DATABASE_ERROR_MUSTCONTAIN_A_TITLE_CATEGORY'));

            return false;
        }

        $this->alias = trim($this->alias);

        if (empty($this->alias)) {
            $this->alias = $this->title;
        }

        // $this->alias = ApplicationHelper::stringURLSafe($this->alias, $this->language);
        $this->alias = JApplicationHelper::stringURLSafe($this->alias, $this->language);

        if (trim(str_replace('-', '', $this->alias)) == '') {
            $this->alias = \JFactory::getDate()->format('Y-m-d-H-i-s');
        }

        return true;
    }

    /**
     * Overloaded bind function.
     *
     * @param   array   $array   named array
     * @param   string  $ignore  An optional array or space separated list of properties
     *                           to ignore while binding.
     *
     * @return  mixed   Null if operation was satisfactory, otherwise returns an error
     *
     * @see     Table::bind()
     * @since   1.6
     */
    public function bind($array, $ignore = '') {
        if (isset($array['params']) && is_array($array['params'])) {
            $registry = new Registry($array['params']);
            $array['params'] = (string) $registry;
        }

        if (isset($array['metadata']) && is_array($array['metadata'])) {
            $registry = new Registry($array['metadata']);
            $array['metadata'] = (string) $registry;
        }

        // Bind the rules.
        if (isset($array['rules']) && is_array($array['rules'])) {
            $rules = new Rules($array['rules']);
            $this->setRules($rules);
        }

        return parent::bind($array, $ignore);
    }

    /**
     * Overridden Table::store to set created/modified and user id.
     *
     * @param   boolean  $updateNulls  True to update fields even if they are null.
     *
     * @return  boolean  True on success.
     *
     * @since   1.6
     */
    public function store($updateNulls = false) {
        $date = \JFactory::getDate();
        $user = \JFactory::getUser();

        $this->modified_time = $date->toSql();

        if ($this->id) {
            // Existing category
            $this->modified_user_id = $user->get('id');
        } else {
            // New category. A category created_time and created_user_id field can be set by the user,
            // so we don't touch either of these if they are set.
            if (!(int) $this->created_time) {
                $this->created_time = $date->toSql();
            }

            if (empty($this->created_user_id)) {
                $this->created_user_id = $user->get('id');
            }
        }

        // Verify that the alias is unique
        $table = JTable::getInstance('Category', 'StandardTable', array('dbo' => $this->getDbo()));

        if ($table->load(array('alias' => $this->alias, 'parent_id' => (int) $this->parent_id, 'extension' => $this->extension)) && ($table->id != $this->id || $this->id == 0)) {
            $this->setError(\JText::_('JLIB_DATABASE_ERROR_CATEGORY_UNIQUE_ALIAS'));

            return false;
        }

        return parent::store($updateNulls);
    }

    /**
     * Method to delete a node and, optionally, its child nodes from the table.
     *
     * @param   integer  $pk        The primary key of the node to delete.
     * @param   boolean  $children  True to delete child nodes, false to move them up a level.
     *
     * @return  boolean  True on success.
     *
     * @since   2.5
     */
    /*
      public function delete($pk = null, $children = false) {
      return parent::delete($pk, $children);
      }
     */

    /**
     * Method to delete a node and, optionally, its child nodes from the table.
     *
     * @param   integer  $pk        The primary key of the node to delete.
     * @param   boolean  $children  True to delete child nodes, false to move them up a level.
     *
     * @return  boolean  True on success.
     *
     * @since   1.7.0
     */
    public function delete($pk = null, $children = false) {//  $children = true
        $k = $this->_tbl_key;
        $pk = (is_null($pk)) ? $this->$k : $pk;

        // Implement \JObservableInterface: Pre-processing by observers
        $this->_observers->update('onBeforeDelete', array($pk));

        // Lock the table for writing.
        if (!$this->_lock()) {
            // Error message set in lock method.
            return false;
        }
        /*
          // === Can nghien cuu them o cho nay ===
          // If tracking assets, remove the asset first.
          if ($this->_trackAssets) {
          $name = $this->_getAssetName();
         * // --- Binh Nguyen modify ---
          // $asset = Table::getInstance('Asset', 'JTable', array('dbo' => $this->getDbo()));
          $asset = JTable::getInstance('Asset', 'JTable', array('dbo' => $this->getDbo()));
          // --- /.Binh Nguyen modify ---
          // Lock the table for writing.
          if (!$asset->_lock()) {
          // Error message set in lock method.
          return false;
          }

          if ($asset->loadByName($name)) {
          // Delete the node in assets table.
          if (!$asset->delete(null, $children)) {
          $this->setError($asset->getError());
          $asset->_unlock();

          return false;
          }

          $asset->_unlock();
          } else {
          $this->setError($asset->getError());
          $asset->_unlock();

          return false;
          }

          }
          // === /. Can nghien cuu them o cho nay ===
         */
        // Get the node by id.
        $node = $this->_getNode($pk);

        if (empty($node)) {
            // Error message set in getNode method.
            $this->_unlock();

            return false;
        }

        $query = $this->_db->getQuery(true);

        // Should we delete all children along with the node?
        if ($children) {
            // Delete the node and all of its children.
            $query->clear()
                    ->delete($this->_tbl)
                    ->where('lft BETWEEN ' . (int) $node->lft . ' AND ' . (int) $node->rgt);
            $this->_runQuery($query, 'JLIB_DATABASE_ERROR_DELETE_FAILED');

            // Compress the left values.
            $query->clear()
                    ->update($this->_tbl)
                    ->set('lft = lft - ' . (int) $node->width)
                    ->where('lft > ' . (int) $node->rgt);
            $this->_runQuery($query, 'JLIB_DATABASE_ERROR_DELETE_FAILED');

            // Compress the right values.
            $query->clear()
                    ->update($this->_tbl)
                    ->set('rgt = rgt - ' . (int) $node->width)
                    ->where('rgt > ' . (int) $node->rgt);
            $this->_runQuery($query, 'JLIB_DATABASE_ERROR_DELETE_FAILED');
        }
        // Leave the children and move them up a level.
        else {
            // Delete the node.
            $query->clear()
                    ->delete($this->_tbl)
                    ->where('lft = ' . (int) $node->lft);
            $this->_runQuery($query, 'JLIB_DATABASE_ERROR_DELETE_FAILED');

            // Shift all node's children up a level.
            $query->clear()
                    ->update($this->_tbl)
                    ->set('lft = lft - 1')
                    ->set('rgt = rgt - 1')
                    ->set('level = level - 1')
                    ->where('lft BETWEEN ' . (int) $node->lft . ' AND ' . (int) $node->rgt);
            $this->_runQuery($query, 'JLIB_DATABASE_ERROR_DELETE_FAILED');

            // Adjust all the parent values for direct children of the deleted node.
            $query->clear()
                    ->update($this->_tbl)
                    ->set('parent_id = ' . (int) $node->parent_id)
                    ->where('parent_id = ' . (int) $node->$k);
            $this->_runQuery($query, 'JLIB_DATABASE_ERROR_DELETE_FAILED');

            // Shift all of the left values that are right of the node.
            $query->clear()
                    ->update($this->_tbl)
                    ->set('lft = lft - 2')
                    ->where('lft > ' . (int) $node->rgt);
            $this->_runQuery($query, 'JLIB_DATABASE_ERROR_DELETE_FAILED');

            // Shift all of the right values that are right of the node.
            $query->clear()
                    ->update($this->_tbl)
                    ->set('rgt = rgt - 2')
                    ->where('rgt > ' . (int) $node->rgt);
            $this->_runQuery($query, 'JLIB_DATABASE_ERROR_DELETE_FAILED');
        }

        // Unlock the table for writing.
        $this->_unlock();

        // Implement \JObservableInterface: Post-processing by observers
        $this->_observers->update('onAfterDelete', array($pk));

        return true;
    }

}
