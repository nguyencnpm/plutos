<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

JLoader::register('StandardHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/standard.php');

/**
 * Item Model for an Allotment.
 *
 * @since  1.6
 */
class StandardModelAllotment extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STANDARD_ALLOTMENT';

    /**
     * The type alias for this standard type (for example, 'com_standard.allotment').
     *
     * @var      string
     * @since    3.2
     */
    public $typeAlias = 'com_standard.allotment';

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

            return $user->authorise('core.delete', 'com_standard.allotment.' . (int) $record->id);
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

        // Check for existing allotment.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standard.allotment.' . (int) $record->id);
        }
        // Default to component settings if neither allotment nor category known.
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

        if ($table->state == 1 && (int) $table->publish_up == 0) {
            $table->publish_up = JFactory::getDate()->toSql();
        }

        if ($table->state == 1 && intval($table->publish_down) == 0) {
            $table->publish_down = $db->getNullDate();
        }
        // Increment the roomrate version number.
        $table->version++;
        // Reorder the allotments within the category so the new allotment is first
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
    public function getTable($type = 'Allotment', $prefix = 'StandardTable', $config = array()) {
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
            /*
              $item->start_date = $item->date;
              $item->expiry_date = $item->date;
             */

            //$offset = JFactory::getApplication()->get('offset');
            //$sdate = JFactory::getDate($item->date, $offset)->toSql();
            $date = JHtml::_('date', $item->date, 'Y-m-d');
            $item->periodDate = $date . " - " . $date;

            if (!empty($date) && intval($date) != 0) {
                $dayweek = new JDate($date);
                $day = $dayweek->format('w');
                $days = $dayweek->dayToString($day);
                switch ($days) {
                    case "Sunday":
                        $item->allotment_sunday = $item->allotment;
                        $item->sunsat = 1;
                        break;
                    case "Saturday":
                        $item->allotment_saturday = $item->allotment;
                        $item->sunsat = 1;
                        break;
                    default:
                        break;
                }
            }
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
        $form = $this->loadForm('com_standard.allotment', 'allotment', array('control' => 'jform', 'load_data' => $loadData));
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
        if ($this->getState('allotment.id')) {
            $id = $this->getState('allotment.id');
        }

        $user = JFactory::getUser();

        // Check for existing allotment.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standard.allotment.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standard'))) {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an allotment you can edit.
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
        $data = $app->getUserState('com_standard.edit.allotment.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Allotment Manager: Currencies
            if ($this->getState('allotment.id') == 0) {
                $filters = (array) $app->getUserState('com_standard.allotments.filter');
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

        $this->preprocessData('com_standard.allotment', $data);

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
        if (empty($data['sunday'])) {
            $data['sunday'] = 0;
        }
        if (empty($data['monday'])) {
            $data['monday'] = 0;
        }
        if (empty($data['tuesday'])) {
            $data['tuesday'] = 0;
        }
        if (empty($data['wednesday'])) {
            $data['wednesday'] = 0;
        }
        if (empty($data['thursday'])) {
            $data['thursday'] = 0;
        }
        if (empty($data['friday'])) {
            $data['friday'] = 0;
        }
        if (empty($data['saturday'])) {
            $data['saturday'] = 0;
        }

        $table = JTable::getInstance('Allotment', 'StandardTable');

        // --- check Invalid field --- 
        $start = "";
        $expiry = "";

        //$sToday = JFactory::getDate()->format('Y-m-d');
        // --- Get the time offset. ---
        $offset = JFactory::getApplication()->get('offset');
        $toSqlToday = JFactory::getDate(); // format Y-m-d H:i:s
        // --- fix get Today format Y-m-d ---
        $offsetToday = JHtml::_('date', $toSqlToday, 'Y-m-d');
        $sTodayTemp = JFactory::getDate($offsetToday, $offset)->toSql();
        $oToday = new JDate($sTodayTemp);
        $sToday = $oToday->format('Y-m-d');
        // --- /.fix get Today format Y-m-d ---

        if (isset($data['periodDate']) && !empty($data['periodDate'])):
            // --- Date period is valid ---
            $delimiter = " - ";
            $arrayTemp = explode($delimiter, trim($data['periodDate']));
            $temp_startDate = trim($arrayTemp[0]);
            $temp_expiryDate = trim($arrayTemp[1]);
            // --- Get the time offset. ---
            $sStart = JFactory::getDate($temp_startDate, $offset)->toSql(); // false: Time Zone of SQL (user_utc), default false 
            $sExpiry = JFactory::getDate($temp_expiryDate, $offset)->toSql();

            $oStart = new JDate($sStart);
            $start = $oStart->format('Y-m-d');

            $oExpiry = new JDate($sExpiry);
            $expiry = $oExpiry->format('Y-m-d');
        // $start = JHtml::_('date', $sStart, 'Y-m-d');
        // $expiry = JHtml::_('date', $sExpiry, 'Y-m-d');
        // --- /.Get the time offset. ---
        // --- /.Date period is valid ---
        endif;
        /*
          if (!empty($data['start_date']) && intval($data['start_date']) != 0) {
          $start_date = new JDate($data['start_date']);
          $start = $start_date->format('Y-m-d');
          }
          if (!empty($data['expiry_date']) && intval($data['expiry_date']) != 0) {
          $expiry_date = new JDate($data['expiry_date']);
          $expiry = $expiry_date->format('Y-m-d');
          }
         */
        if (intval($start) == 0 || intval($expiry) == 0 || empty($start) || empty($expiry) || (strtotime($start) > strtotime($expiry)) || (strtotime($start) < strtotime($sToday))) {
            $this->setError(JText::_('JLIB_DATABASE_ERROR_INVALID_PERIOD'));

            return false;
        }

        // --- end Invalid field ---
        // Bind the data.
        if (!$table->bind($data)) {
            $this->setError($table->getError());

            return false;
        }
        // Store the data.
        if (!$table->store($data)) {
            $this->setError($table->getError());

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
        parent::cleanCache('mod_allotments_archive');
    }

}
