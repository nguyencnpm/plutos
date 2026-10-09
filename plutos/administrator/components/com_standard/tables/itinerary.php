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
class StandardTableItinerary extends JTable {

    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  Database connector object
     *
     * @since   1.6
     */
    public function __construct(JDatabaseDriver $db) {// __construct(&$db) {
        parent::__construct('#__standard_itineraries', 'id', $db);

        //JTableObserverTags::createObserver($this, array('typeAlias' => 'com_standard.itinerary'));
        //JTableObserverContenthistory::createObserver($this, array('typeAlias' => 'com_standard.itinerary'));
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
        if (isset($array['itinerarytext'])) {
            $pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
            $tagPos = preg_match($pattern, $array['itinerarytext']);

            if ($tagPos == 0) {
                $this->introtext = $array['itinerarytext'];
                $this->fulltext = '';
            } else {
                list ($this->introtext, $this->fulltext) = preg_split($pattern, $array['itinerarytext'], 2);
            }
        }

        if (isset($array['attribs']) && is_array($array['attribs'])) {
            $registry = new Registry;
            $registry->loadArray($array['attribs']);
            $array['attribs'] = (string) $registry;
        }

        if (isset($array['links']) && is_array($array['links'])) {
            $registry = new Registry;
            $registry->loadArray($array['links']);
            $array['links'] = (string) $registry;
        }

        if (isset($array['metadata']) && is_array($array['metadata'])) {
            $registry = new Registry;
            $registry->loadArray($array['metadata']);
            $array['metadata'] = (string) $registry;
        }

        // Bind the rules.
        if (isset($array['rules']) && is_array($array['rules'])) {
            $rules = new JAccessRules($array['rules']);
            $this->setRules($rules);
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
        if (trim($this->title) == '') {
            $this->setError(JText::_('COM_STANDARD_WARNING_PROVIDE_VALID_NAME'));

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
            /*
              if (!isset($this->images)) {
              $this->images = '{}';
              }
             */

            // Links can be an empty json string
            if (!isset($this->links)) {
                $this->links = '{}';
            }
            // URLs can be an empty json string
            if (!isset($this->urls)) {
                $this->urls = '{}';
            }

            // Attributes (article params) can be an empty json string
            if (!isset($this->attribs)) {
                $this->attribs = '{}';
            }

            // Metadata can be an empty json string
            if (!isset($this->metadata)) {
                $this->metadata = '{}';
            }

            // If we don't have any access rules set at this point just use an empty JAccessRules class
            if (!$this->getRules()) {
                $rules = $this->getDefaultAssetValues('com_standard');
                $this->setRules($rules);
            }
        }

        // Check the publish down date is not earlier than publish up.
        if ($this->publish_down > $this->_db->getNullDate() && $this->publish_down < $this->publish_up) {
            // Swap the dates.
            $temp = $this->publish_up;
            $this->publish_up = $this->publish_down;
            $this->publish_down = $temp;
        }

        // Clean up keywords -- eliminate extra spaces between phrases
        // and cr (\r) and lf (\n) characters from string
        if (!empty($this->metakey)) {
            // Only process if not empty
            // Array of characters to remove
            $bad_characters = array("\n", "\r", "\"", "<", ">");

            // Remove bad characters
            $after_clean = JString::str_ireplace($bad_characters, "", $this->metakey);

            // Create array using commas as delimiter
            $keys = explode(',', $after_clean);

            $clean_keys = array();

            foreach ($keys as $key) {
                if (trim($key)) {
                    // Ignore blank keywords
                    $clean_keys[] = trim($key);
                }
            }
            // Put array back together delimited by ", "
            $this->metakey = implode(", ", $clean_keys);
        }

        return true;
    }

    /**
     * Gets the default asset values for a component.
     *
     * @param   $string  $component  The component asset name to search for
     *
     * @return  JAccessRules  The JAccessRules object for the asset
     */
    protected function getDefaultAssetValues($component) {
        // Need to find the asset id by the name of the component.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select($db->quoteName('id'))
                ->from($db->quoteName('#__assets'))
                ->where($db->quoteName('name') . ' = ' . $db->quote($component));
        $db->setQuery($query);
        $assetId = (int) $db->loadResult();

        return JAccess::getAssetRules($assetId);
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
        $table = JTable::getInstance('Itinerary', 'StandardTable', array('dbo' => $this->getDbo()));

        if ($table->load(array('alias' => $this->alias, 'itinerarytype_id' => $this->itinerarytype_id)) && ($table->id != $this->id || $this->id == 0)) {
            $this->setError(JText::_('JLIB_DATABASE_ERROR_ARTICLE_UNIQUE_ALIAS'));

            return false;
        }
        
        return parent::store($updateNulls);
    }

}
