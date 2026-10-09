<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

JLoader::register('StandardHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/standard.php');

/**
 * Item Model for an Route.
 *
 * @since  1.6
 */
class StandardModelRoute extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STANDARD_ROUTE';

    /**
     * The route alias for this standard route (for example, 'com_standard.route').
     *
     * @var      string
     * @since    3.2
     */
    public $routeAlias = 'com_standard.route';

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

            return $user->authorise('core.delete', 'com_standard.route.' . (int) $record->id);
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

        // Check for existing route.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standard.route.' . (int) $record->id);
        }
        // Default to component settings if neither route nor category known.
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

        // Increment the standard version number.
        $table->version++;

        // Reorder the routes within the category so the new route is first
        if (empty($table->id)) {
            $table->reorder('state >= 0');
        }
    }

    /**
     * Returns a Table object, always creating it.
     *
     * @param   string  $route    The table route to instantiate
     * @param   string  $prefix  A prefix for the table class name. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  JTable    A database object
     */
    public function getTable($type = 'Route', $prefix = 'StandardTable', $config = array()) {
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
            $item->code = strtoupper($item->code);
            
            if (intval($item->departure_time) != 0):
                $item->departure_time = date(JText::_('COM_STANDARD_TIME_FORMAT'), strtotime($item->departure_time));
            endif;
            if (intval($item->departure_time) != 0):
                $item->arrival_time = date(JText::_('COM_STANDARD_TIME_FORMAT'), strtotime($item->arrival_time));
            endif;
            
            // Convert the metadata field to an array.
            $registry = new Registry;
            $registry->loadString($item->metadata);
            $item->metadata = $registry->toArray();

            $item->routetext = trim($item->fulltext) != '' ? $item->introtext . "<hr id=\"system-readmore\" />" . $item->fulltext : $item->introtext;
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
        $form = $this->loadForm('com_standard.route', 'route', array('control' => 'jform', 'load_data' => $loadData));
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
        if ($this->getState('route.id')) {
            $id = $this->getState('route.id');
        }

        $user = JFactory::getUser();

        // Check for existing route.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standard.route.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standard'))) {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an route you can edit.
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
        $data = $app->getUserState('com_standard.edit.route.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Route Manager: Currencies
            if ($this->getState('route.id') == 0) {
                $filters = (array) $app->getUserState('com_standard.routes.filter');
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

        $this->preprocessData('com_standard.route', $data);

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

        if (isset($data['metadata']) && isset($data['metadata']['author'])) {
            $data['metadata']['author'] = $filter->clean($data['metadata']['author'], 'TRIM');
        }

        if (isset($data['created_by_alias'])) {
            $data['created_by_alias'] = $filter->clean($data['created_by_alias'], 'TRIM');
        }

        // Alter the title for save as copy
        if ($input->get('task') == 'save2copy') {
            $origTable = clone $this->getTable();
            $origTable->load($input->getInt('id'));


            if ($data['title'] == $origTable->title) {
                list($title, $alias) = $this->generateNewTitle($origTable->id, $data['alias'], $data['title']);
                $data['title'] = $title;
                $data['alias'] = $alias;
            } else {
                if ($data['alias'] == $origTable->alias) {
                    $data['alias'] = '';
                }
            }


            if (utf8_strtolower(trim($data['alias'])) == utf8_strtolower(trim($origTable->alias))) {
                list($alias) = $this->generateNewAlias($origTable->id, utf8_strtolower(trim($data['alias'])));
                $data['alias'] = $alias;
            } else {
                if ($data['alias'] == $origTable->alias) {
                    $data['alias'] = '';
                }
            }

            if (utf8_strtolower(trim($data['code'])) == utf8_strtolower(trim($origTable->code))) {
                list($code) = $this->generateNewCode($origTable->id, utf8_strtolower(trim($data['code'])));
                $data['code'] = $code;
            } else {
                if ($data['code'] == $origTable->code) {
                    $data['code'] = '';
                }
            }

            $data['state'] = 0;
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

            if ($data['alias'] != null) {
                $data['alias'] = JFilterOutput::stringURLUnicodeSlug($data['alias']);
            }
            $data['code'] = JFilterOutput::stringURLUnicodeSlug($data['code']);
        }

        if (parent::save($data)) {
            return true;
        }

        return false;
    }

    /**
     * Method to change the title & alias.
     *
     * @param   integer  $id  The id of the parent.
     * @param   string   $alias      The alias.
     * @param   string   $title      The title.
     *
     * @return  array    Contains the modified title and alias.
     *
     * @since   1.7
     */
    protected function generateNewTitle($id, $alias, $title) {
        // Alter the title & alias
        $table = $this->getTable();
        while ($table->load(array('alias' => $alias, 'id' => $id))) {
            $title = JString::increment($title);
            $alias = JString::increment($alias, 'dash');
        }

        return array($title, $alias);
    }

    protected function generateNewAlias($alias) {
        // Alter code
        $table = $this->getTable();
        while ($table->load(array('alias' => $alias, 'id' => $id))) {
            $code = JString::increment($alias, 'dash');
        }

        return array($code);
    }

    protected function generateNewCode($id, $code) {
        // Alter code
        $table = $this->getTable();
        while ($table->load(array('code' => $code, 'id' => $id))) {
            $code = JString::increment($code, 'dash');
        }

        return array($code);
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
        parent::cleanCache('mod_carousel_slider');
        parent::cleanCache('mod_findit');
        parent::cleanCache('mod_getglobal');
        parent::cleanCache('mod_lookingfor');
        parent::cleanCache('mod_marquee');
        parent::cleanCache('mod_products_news');
        parent::cleanCache('mod_moreinfomations');
        parent::cleanCache('mod_sidewidget');
        parent::cleanCache('mod_tripadvisor');
        parent::cleanCache('mod_video');
        parent::cleanCache('mod_video_gallery');
    }

}
