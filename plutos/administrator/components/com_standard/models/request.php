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

/**
 * Item Model for an Request.
 *
 * @since  1.6
 */
class StandardModelRequest extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STANDARD_REQUEST';

    /**
     * The type alias for this standard type (for example, 'com_standard.request').
     *
     * @var      string
     * @since    3.2
     */
    public $typeAlias = 'com_standard.request';

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

            return $user->authorise('core.delete', 'com_standard.request.' . (int) $record->id);
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

        // Check for existing request.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standard.request.' . (int) $record->id);
        }
        // Default to component settings if neither request nor category known.
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
        $db = $this->getDbo();
        // Reorder the orders within the category so the new order is first
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
    public function getTable($type = 'Request', $prefix = 'StandardTable', $config = array()) {
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

        }
//        echo '<pre>';
//        print_r($item);
//        exit;
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
        $form = $this->loadForm('com_standard.request', 'request', array('control' => 'jform', 'load_data' => $loadData));
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
        if ($this->getState('request.id')) {
            $id = $this->getState('request.id');
        }

        $user = JFactory::getUser();

        // Check for existing request.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standard.request.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standard'))) {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an order you can edit.
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
        $data = $app->getUserState('com_standard.edit.request.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Request Manager: Currencies
            if ($this->getState('request.id') == 0) {
                $filters = (array) $app->getUserState('com_standard.requests.filter');
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

        $this->preprocessData('com_standard.request', $data);

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
        }

        if (parent::save($data)) {
            return true;
        }

        return false;
    }

    public function status($pks, $value = 0) {
        try {
            $date = JFactory::getDate();
            $user = JFactory::getUser();
            $db = $this->getDbo();
            $query = $db->getQuery(true)
                    ->update($db->quoteName('#__standard_request'))
                    ->set('state = ' . (int) $value)
                    ->set("modified = '" . $date->toSql() . "'")
                    ->set('modified_by = ' . $user->get('id'))
                    ->where('id IN (' . implode(',', $pks) . ')');
            $db->setQuery($query);
            /*
              echo nl2br(str_replace('#__', 'brle6_', $query));
              exit;
             */
            $db->execute();
        } catch (Exception $e) {
            $this->setError($e->getMessage());

            return false;
        }
        $this->cleanCache();
        return true;
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
    }

}
