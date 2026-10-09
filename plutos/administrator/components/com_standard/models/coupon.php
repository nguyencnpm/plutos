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
 * Item Model for an Coupon.
 *
 * @since  1.6
 */
class StandardModelCoupon extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STANDARD_COUPON';

    /**
     * The type alias for this standard type (for example, 'com_standard.coupon').
     *
     * @var      string
     * @since    3.2
     */
    public $typeAlias = 'com_standard.coupon';

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

            return $user->authorise('core.delete', 'com_standard.coupon.' . (int) $record->id);
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

        // Check for existing coupon.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standard.coupon.' . (int) $record->id);
        }
        // Default to component settings if neither coupon nor category known.
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

        // Reorder the coupons within the category so the new coupon is first
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
    public function getTable($type = 'Coupon', $prefix = 'StandardTable', $config = array()) {
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
        $form = $this->loadForm('com_standard.coupon', 'coupon', array('control' => 'jform', 'load_data' => $loadData));
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
        if ($this->getState('coupon.id')) {
            $id = $this->getState('coupon.id');
        }

        $user = JFactory::getUser();

        // Check for existing coupon.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standard.coupon.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standard'))) {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an coupon you can edit.
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
        $data = $app->getUserState('com_standard.edit.coupon.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Coupon Manager: Currencies
            if ($this->getState('coupon.id') == 0) {
                $filters = (array) $app->getUserState('com_standard.coupons.filter');
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

        $this->preprocessData('com_standard.coupon', $data);

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
        //$data = array_merge($data, $input->post->get('jform', array(), 'array'));

        if (isset($data['created_by_alias'])) {
            $data['created_by_alias'] = $filter->clean($data['created_by_alias'], 'TRIM');
        }
        // ---- create code coupon ----
        $origTable = clone $this->getTable('CouponsType', 'StandardTable');
        $origTable->load($data['coupontype_id']);
        $prefix = $origTable->prefix;

        if (empty($data['code'])): // add new
            if (isset($data['quantity']) && $data['quantity'] > 1):
                for ($q = 0; $q < $data['quantity']; $q++) {
                    $data['code'] = utf8_strtolower(trim($this->getUniqid($prefix)));
                    parent::save($data);
                }
                $this->cleanCache();
                return true;
            else:
                $data['code'] = utf8_strtolower(trim($this->getUniqid($prefix)));
            endif;

        elseif (strpos(utf8_strtolower(trim($data['code'])), utf8_strtolower(trim($origTable->prefix))) === false) : // change coupon Type
            $data['code'] = utf8_strtolower(trim($this->getUniqid($prefix)));
        else:
            $data['code'] = utf8_strtolower(trim($data['code']));
        endif;
        // ---- /.create code coupon ----

        if (parent::save($data)) {
            $this->cleanCache();
            return true;
        }

        return false;
    }

    // create ID
    public function getUniqid($prefix = "") {
        return trim($prefix . uniqid());
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
