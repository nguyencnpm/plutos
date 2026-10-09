<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

JLoader::register('StandardHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/standard.php');

/**
 * Item Model for an Extra.
 *
 * @since  1.6
 */
class StandardModelExtra extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STANDARD_EXTRA';

    /**
     * The type alias for this standard type (for example, 'com_standard.extra').
     *
     * @var      string
     * @since    3.2
     */
    public $typeAlias = 'com_standard.extra';

    /**
     * Method to test whether a record can be deleted.
     *
     * @param   object  $record  A record object.
     *
     * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
     *
     * @since   1.6
     */
    protected function canDelete($record) {
        if (!empty($record->id)) {
            if ($record->state != -2) {
                return false;
            }

            $user = JFactory::getUser();

            return $user->authorise('core.delete', 'com_standard.extra.' . (int) $record->id);
        }

        return false;
    }

    /**
     * Method to test whether a record can have its state edited.
     *
     * @param   object  $record  A record object.
     *
     * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
     *
     * @since   1.6
     */
    protected function canEditState($record) {
        $user = JFactory::getUser();

        // Check for existing extra.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standard.extra.' . (int) $record->id);
        }
        // Default to component settings if neither extra nor category known.
        else {
            return parent::canEditState('com_standard');
        }
    }

    /**
     * Prepare and sanitise the table data prior to saving.
     *
     * @param   JTable  $table  A JTable object.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function prepareTable($table) {
        // Set the publish date to now
        $db = $this->getDbo();

        if ($table->state == 1 && (int) $table->publish_up == 0) {
            $table->publish_up = JFactory::getDate()->toSql();
        }

        if ($table->state == 1 && intval($table->publish_down) == 0) {
            $table->publish_down = $db->getNullDate();
        }

        // Increment the standard version number.
        $table->version++;

        // Reorder the coupons types within the category so the new extra is first
        if (empty($table->id)) {
            $table->reorder('state >= 0');
        }
    }

    /**
     * Returns a Table object, always creating it.
     *
     * @param   string  $type    The table type to instantiate
     * @param   string  $prefix  A prefix for the table class name. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  JTable    A database object
     */
    public function getTable($type = 'Extra', $prefix = 'StandardTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get a single record.
     *
     * @param   integer  $pk  The id of the primary key.
     *
     * @return  mixed  Object on success, false on failure.
     */
    public function getItem($pk = null) {
        if ($item = parent::getItem($pk)) {
            $item->catid = $this->getCatIds($item->id);
            //$item->manufacturer_id = $this->getManufacturerIds($item->id);
            //$item->prefix = strtoupper($item->prefix);
            $item->extratext = trim($item->fulltext) != '' ? $item->introtext . "<hr id=\"system-readmore\" />" . $item->fulltext : $item->introtext;
        }
        return $item;
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  mixed  A JForm object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = $this->loadForm('com_standard.extra', 'extra', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }

        $jinput = JFactory::getApplication()->input;

        // The front end calls this model and uses p_id to avoid id clashes so we need to check for that first.
        if ($jinput->get('p_id')) {
            $id = $jinput->get('p_id', 0);
        }
        // The back end uses id so we use that the rest of the time and set it to 0 by default.
        else {
            $id = $jinput->get('id', 0);
        }

        // Determine correct permissions to check.
        if ($this->getState('extra.id')) {
            $id = $this->getState('extra.id');
        }

        $user = JFactory::getUser();

        // Check for existing extra.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standard.extra.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standard'))) {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an extra you can edit.
            $form->setFieldAttribute('ordering', 'filter', 'unset');
            $form->setFieldAttribute('publish_up', 'filter', 'unset');
            $form->setFieldAttribute('publish_down', 'filter', 'unset');
            $form->setFieldAttribute('state', 'filter', 'unset');
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  The data for the form.
     *
     * @since   1.6
     */
    protected function loadFormData() {
        // Check the session for previously entered form data.
        $app = JFactory::getApplication();
        $data = $app->getUserState('com_standard.edit.Extra.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Extra Manager: Currencies
            if ($this->getState('Extra.id') == 0) {
                $filters = (array) $app->getUserState('com_standard.Extras.filter');
                $data->set(
                        'state', $app->input->getInt(
                                'state', ((isset($filters['published']) && $filters['published'] !== '') ? $filters['published'] : null)
                        )
                );
                $data->set('language', $app->input->getString('language', (!empty($filters['language']) ? $filters['language'] : null)));
                $data->set('access', $app->input->getInt('access', (!empty($filters['access']) ? $filters['access'] : JFactory::getConfig()->get('access')))
                );
            }
        }

        // If there are params fieldsets in the form it will fail with a registry object
        if (isset($data->params) && $data->params instanceof Registry) {
            $data->params = $data->params->toArray();
        }

        $this->preprocessData('com_standard.Extra', $data);

        return $data;
    }

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   1.6
     */
    public function save($data) {
        $input = JFactory::getApplication()->input;
        $filter = JFilterInput::getInstance();

        if (isset($data['created_by_alias'])) {
            $data['created_by_alias'] = $filter->clean($data['created_by_alias'], 'TRIM');
        }

        if (isset($data['urls']) && is_array($data['urls'])) {
            $check = $input->post->get('jform', array(), 'array');

            foreach ($data['urls'] as $i => $url) {
                if ($url != false && ($i == 'urla' || $i == 'urlb' || $i == 'urlc')) {
                    if (preg_match('~^#[a-zA-Z]{1}[a-zA-Z0-9-_:.]*$~', $check['urls'][$i]) == 1) {
                        $data['urls'][$i] = $check['urls'][$i];
                    } else {
                        $data['urls'][$i] = JStringPunycode::urlToPunycode($url);
                    }
                }
            }

            unset($check);

            $registry = new Registry;
            $registry->loadArray($data['urls']);

            $data['urls'] = (string) $registry;
        }

        // Automatic handling of alias for empty fields
        if (in_array($input->get('task'), array('apply', 'save', 'save2new'))) {
            if ($data['alias'] == null) {
                if (JFactory::getConfig()->get('unicodeslugs') == 1) {
                    $data['alias'] = JFilterOutput::stringURLUnicodeSlug($data['title']);
                } else {
                    $data['alias'] = JFilterOutput::stringURLSafe($data['title']);
                }
                if (isset($msg)) {
                    JFactory::getApplication()->enqueueMessage($msg, 'warning');
                }
            }
            //$data['prefix'] = JFilterOutput::stringURLSafe($data['prefix']);
        }

        if (parent::save($data)) {

            if (isset($data['catid'])) {
                if ($data['id'] > 0) {
                    $action = 'set'; // edit
                } else {
                    $action = 'add';
                }
            } else {
                $action = 'del';
            }
            $this->mappingData($this->getState($this->getName() . '.id'), "extra_id", $data['catid'], "catid", "#__standard_extra_categories_map", $action);
            /*
              if (isset($data['manufacturer_id'])) {
              if ($data['id'] > 0) {
              $action = 'set'; // edit
              } else {
              $action = 'add';
              }
              } else {
              $action = 'del';
              }
              $this->mappingData($this->getState($this->getName() . '.id'), "couponstype_id", $data['manufacturer_id'], "manufacturer_id", "#__standard_couponstype_manufacturer_map", $action);
             */
            return true;
        }

        return false;
    }

    protected function mappingData($id, $name_id, $map_ids, $name_mapid, $map_tb, $action) {
        $db = $this->getDbo();
        $map_ids = (array) $map_ids;
        JArrayHelper::toInteger($map_ids);
        switch ($action) {
            // Sets products to a selected product
            case 'set':
                $doDelete = 'all';
                $doAssign = true;
                break;

            // Remove products from a selected product
            case 'del':
                $doDelete = 'product';
                break;

            // Add products to a selected product
            case 'add':
            default:
                $doAssign = true;
                break;
        }
        // Remove the products from the map_table if requested.
        if (isset($doDelete)) {
            $this->deleteMapping("{$name_id}", $id, array(0 => "{$map_tb}"));
        }

        // Remove the products from the product if requested.
        if (isset($doAssign)) {
            $query = $db->getQuery(true);
            // First, we need to check if the product is already assigned to a map id
            $query->select($db->quoteName("{$name_mapid}"))
                    ->from($db->quoteName("{$map_tb}"))
                    ->where($db->quoteName("{$name_id}") . ' = ' . (int) $id);
            $db->setQuery($query);
            $aMapIdAlreadyAssigned = $db->loadColumn();

            // Build the values clause for the assignment query.
            $query->clear();
            $products = false;

            foreach ($map_ids as $map_id) {
                if (!in_array($map_id, $aMapIdAlreadyAssigned)) {
                    $query->values($map_id . ',' . $id);
                    $products = true;
                }
            }

            $query->insert($db->quoteName("{$map_tb}"))
                    ->columns(array($db->quoteName("{$name_mapid}"), $db->quoteName("{$name_id}")));
            $db->setQuery($query);

            try {
                $db->execute();
            } catch (RuntimeException $e) {
                $this->setError($e->getMessage());

                return false;
            }
        }

        $this->cleanCache();
        return true;
    }

    public function deleteMapping($nameID, $pks, $tbs) {
        // Sanitize the ids.
        $pks = (array) $pks;
        JArrayHelper::toInteger($pks);
        $tbs = (array) $tbs;
        JArrayHelper::toString($tbs);

        $db = $this->getDbo();
        foreach ($tbs as $k => $val) {
            $query = $db->getQuery(true);
            // Adjust the mapping table.
            // Clear the existing features settings.
            $query->delete($db->quoteName($val))
                    ->where($db->quoteName($nameID) . ' IN (' . implode(',', $pks) . ')');
            $db->setQuery($query);
            try {
                $db->execute();
            } catch (Exception $ex) {
                $this->setError($ex->getMessage());

                return false;
            }
        }
        $this->cleanCache();
        return true;
    }

    /**
     * Build a list of Room Type ids
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    public function getManufacturerIds($pk) {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('manufacturer_id')
                ->from('#__standard_couponstype_manufacturer_map')
                ->where($db->quoteName('couponstype_id') . ' = ' . (int) $pk);

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadColumn();
    }

    /**
     * Build a list of Room Type ids
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    public function getCatIds($pk) {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('catid')
                ->from('#__standard_extra_categories_map')
                ->where($db->quoteName('extra_id') . ' = ' . (int) $pk);

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadColumn();
    }

    public function getRouteIds($pk) {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('route_id')
                ->from('#__standard_couponstype_routes_map')
                ->where($db->quoteName('couponstype_id') . ' = ' . (int) $pk);

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadColumn();
    }

    protected function generateNewPrefix($id, $prefix) {
        // Alter code
        $table = $this->getTable();
        while ($table->load(array('prefix' => $prefix, 'id' => $id))) {
            $prefix = JString::increment($prefix, 'dash');
        }

        return array($prefix);
    }

    /**
     * Custom clean the cache of com_standard and content modules
     *
     * @param   string   $group      The cache group
     * @param   integer  $client_id  The ID of the client
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function cleanCache($group = null, $client_id = 0) {
        parent::cleanCache('com_standard');
        parent::cleanCache('mod_products_archive');
        parent::cleanCache('mod_products_categories');
        parent::cleanCache('mod_products_category');
        parent::cleanCache('mod_products_latest');
        parent::cleanCache('mod_products_news');
        parent::cleanCache('mod_products_popular');
        parent::cleanCache('mod_marquee');
        parent::cleanCache('mod_carousel');
        parent::cleanCache('mod_video');
        parent::cleanCache('mod_utilities');
    }

}
