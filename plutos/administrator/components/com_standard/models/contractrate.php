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
 * Item Model for an Contractrate.
 *
 * @since  1.6
 */
class StandardModelContractrate extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STANDARD_RATE';

    /**
     * The contractrate alias for this standard contractrate (for example, 'com_standard.contractrate').
     *
     * @var      string
     * @since    3.2
     */
    public $contractrateAlias = 'com_standard.contractrate';

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

            return $user->authorise('core.delete', 'com_standard.contractrate.' . (int) $record->id);
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

        // Check for existing contractrate.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standard.contractrate.' . (int) $record->id);
        }
        // Default to component settings if neither contractrate nor category known.
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

        // Reorder the contractrates within the category so the new contractrate is first
        if (empty($table->id)) {
            $table->reorder('state >= 0');
        }
    }

    /**
     * Returns a Table object, always creating it.
     *
     * @param   string  $contractrate    The table contractrate to instantiate
     * @param   string  $prefix  A prefix for the table class name. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  JTable    A database object
     */
    public function getTable($type = 'Contractrate', $prefix = 'StandardTable', $config = array()) {
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
            $item->inforates = $this->getListInfoContractrates($item->id);
            // Convert the metadata field to an array.
            $registry = new Registry;
            $registry->loadString($item->metadata);
            $item->metadata = $registry->toArray();

            $item->route_ids = $this->getRouteIds($item->id);
            $item->product_ids = $this->getProductIds($item->id);

            $item->contractratetext = trim($item->fulltext) != '' ? $item->introtext . "<hr id=\"system-readmore\" />" . $item->fulltext : $item->introtext;
        } else {
            $app = JFactory::getApplication();
            $today = JFactory::getDate()->toSql();
            $date = $app->getUserState('com_standard.params.date', $today);
            $item->start_date = $date;
            $item->expiry_date = $date;
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
        $form = $this->loadForm('com_standard.contractrate', 'contractrate', array('control' => 'jform', 'load_data' => $loadData));
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
        if ($this->getState('contractrate.id')) {
            $id = $this->getState('contractrate.id');
        }

        $user = JFactory::getUser();

        // Check for existing contractrate.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standard.contractrate.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standard'))) {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an contractrate you can edit.
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
        $data = $app->getUserState('com_standard.edit.contractrate.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Contractrate Manager: Currencies
            if ($this->getState('contractrate.id') == 0) {
                $filters = (array) $app->getUserState('com_standard.contractrates.filter');
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

        $this->preprocessData('com_standard.contractrate', $data);

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
        $data = array_merge($data, $input->post->get('jform', array(), 'array'));

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
            $data['id'] = 0; // xem lai cho nay clone $data['id'] = id old

            if ($data['title'] == $origTable->title) {
                list($title, $alias) = $this->generateNewTitleContractRate($data['contractgroup_id'], $data['catid'], $data['alias'], $data['title']);
                $data['title'] = $title;
                $data['alias'] = $alias;
            } else {
                if ($data['alias'] == $origTable->alias) {
                    $data['alias'] = '';
                }
            }

            if (utf8_strtolower(trim($data['code'])) == utf8_strtolower(trim($origTable->code))) {
                list($code) = $this->genecontractrateNewCode($origTable->id, utf8_strtolower(trim($data['code'])));
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
            $data['code'] = JFilterOutput::stringURLUnicodeSlug($data['code']);
        }

        if (empty($data['route_id']) OR ! array_key_exists('route_id', $data)) {
            $this->setError(JText::_('COM_STANDARD_WARNING_PROVIDE_VALID_ROUTETYPE'));

            return false;
        }

        if (empty($data['product_id']) OR ! array_key_exists('product_id', $data)) {
            $this->setError(JText::_('COM_STANDARD_WARNING_PROVIDE_VALID_PRODUCTTYPE'));

            return false;
        }

        // --- Verify that the value is unique --
        $isExisted = $this->isExists(array('alias' => $data['alias'], 'catid' => $data['catid'], 'contractgroup_id' => $data['contractgroup_id'], 'route_id' => $data['route_id'], 'product_id' => $data['product_id'], 'id' => $data['id']));
        if ($isExisted) {
            $this->setError(JText::_('COM_STANDARD_RATE_UNIQUE_ALIAS'));

            return false;
        }

        if (parent::save($data)) {
            if ($data['id'] > 0) {
                $action = 'set'; // edit
            } else {
                $action = 'add';
            }

            $this->contractRateDetails($this->getState($this->getName() . '.id'), $data);
            $this->contractRateRouteMap($this->getState($this->getName() . '.id'), $data['route_id'], $action);
            $this->contractRateProductMap($this->getState($this->getName() . '.id'), $data['product_id'], $action);
            $this->cleanCache();
            return true;
        }

        return false;
    }

    protected function isExists($keys = null) {
        // Need to find the Expiry Date max or Unlimited.
        $result = null;
        $isexisted = 0;
        if (isset($keys) && is_array($keys)) {
            $db = $this->getDbo();
            $query = $db->getQuery(true);
            // --- start data current
            $catid = $keys['catid'];
            $contractgroup_id = (int) $keys['contractgroup_id'];

            $aRouteId = $keys['route_id'];
            $aProductId = $keys['product_id'];
            JArrayHelper::toInteger($aRouteId);
            JArrayHelper::toInteger($aProductId);

            $id = $keys['id'];

            //$alias = array_key_exists('alias', $keys) ? $keys['alias'] : "";

            $alias = array_key_exists('alias', $keys) ? $keys['alias'] : "";
            /*
              $where = " 1 = 0 ";
              if (!empty($alias)) :
              $where = " alias = '{$alias}' AND catid = {$catid}";
              else:
              $where = " catid = {$catid}";
              endif;
             */
            $where = " catid = {$catid} AND contractgroup_id = {$contractgroup_id} ";
            // Construct the query
            $query->select('id') // , start_date, expiry_date
                    ->from('#__standard_contractrates as ct')
                    ->join('LEFT', $db->qn('#__standard_routecontractrate_map', 'map') . ' ON (ct.id = map.contractrate_id)')
                    ->join('LEFT', $db->qn('#__standard_productcontractrate_map', 'promap') . ' ON (ct.id = promap.contractrate_id)')
                    ->where($db->quoteName('map.route_id') . ' IN (' . implode(',', $aRouteId) . ')')
                    ->where($db->quoteName('promap.product_id') . ' IN (' . implode(',', $aProductId) . ')')
                    ->where($where)
                    ->group("id");
            // Setup the query
            $db->setQuery($query);

            // echo nl2br(str_replace('#__', 'dpjvy_', $query));
            // exit;
            // Return the result
            $result = $db->loadAssocList();
            if (count($result) > 0) {
                if (count($result) == 1) {
                    if ($result[0]['id'] != $id || $id == 0) {
                        $isexisted = 1;
                    } else {
                        $isexisted = 0; // Edit
                    }
                } else {
                    // -- check case edit $result > 1
                    $isexisted = 0; // Edit
                    foreach ($result as $idDB) {
                        if ($idDB['id'] != $id || $id == 0) {
                            $isexisted = 1;
                            break;
                        }
                    }
                }
            } else {
                $isexisted = 0;
            }
        }
        return $isexisted;
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
    protected function generateNewTitleContractRate($contractgroup_id, $catid, $alias, $title) {
        // Alter the title & alias
        $table = $this->getTable();
        while ($table->load(array('alias' => $alias, 'contractgroup_id' => $contractgroup_id, 'catid' => $catid))) {
            $title = JString::increment($title);
            $alias = JString::increment($alias, 'dash');
        }

        return array($title, $alias);
    }

    protected function genecontractrateNewTitle($id, $alias, $title) {
        // Alter the title & alias
        $table = $this->getTable();
        while ($table->load(array('alias' => $alias, 'id' => $id))) {
            $title = JString::increment($title);
            $alias = JString::increment($alias, 'dash');
        }

        return array($title, $alias);
    }

    protected function genecontractrateNewCode($id, $code) {
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

    /**
     * Build a list of Route Type ids
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    public function getRouteIds($pk) {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('route_id')
                ->from('#__standard_routecontractrate_map')
                ->where($db->quoteName('contractrate_id') . ' = ' . (int) $pk);

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadColumn();
    }

    /**
     * Build a list of Product Type ids
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    public function getProductIds($pk) {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('product_id')
                ->from('#__standard_productcontractrate_map')
                ->where($db->quoteName('contractrate_id') . ' = ' . (int) $pk);

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadColumn();
    }

    protected function contractRateDetails($contractrate_id, $data) {
        // --- Get the time offset. ---
        $offset = JFactory::getApplication()->get('offset');
        // --- /. ---
        $tableContractratedetails = $this->getTable('Contractratedetails');
        $dispatcher = JEventDispatcher::getInstance();
        $context = 'contractrateDetails';

        $delimiter = " - ";
        $updateNullsTamp = array();

        foreach ($data['inforate'] as $key_inforate => $value_inforate) {
            if (isset($value_inforate['price'])):
                if ($value_inforate['price'] <= 0 || empty($value_inforate['price'])) :
                    if (isset($value_inforate['id'])):
                        $this->deleteMapping("id", $value_inforate['id'], array(0 => "#__standard_contractrate_details"));
                    endif;
                    continue;
                endif;
            else:
                if (isset($value_inforate['id'])):
                    $this->deleteMapping("id", $value_inforate['id'], array(0 => "#__standard_contractrate_details"));
                endif;
                continue;
            endif;

            // Contractrate id
            $updateNullsTamp['contractrate_id'] = $contractrate_id;
            // Amount
            $updateNullsTamp['price'] = $value_inforate['price'];
            // info contractrate status
            $updateNullsTamp['inforate_status'] = $value_inforate['inforate_status'];
            // Contractrate period is valid
            $arrayTemp = explode($delimiter, trim($value_inforate['ratedate']));

            $updateNullsTamp['start_date'] = JFactory::getDate(trim($arrayTemp[0]), $offset)->toSql(); //trim($arrayTemp[0]);
            $updateNullsTamp['expiry_date'] = JFactory::getDate(trim($arrayTemp[1]), $offset)->toSql(); //trim($arrayTemp[1]);

            $key = isset($value_inforate['id']) ? $value_inforate['id'] : 0;
            if ($key > 0) {// case: edit  
                $updateNullsTamp['id'] = $key;
                $tableContractratedetails->load($key); // $pk = $key
                $isNew = false;
            } else {
                $isNew = true;
                $updateNullsTamp['id'] = 0; //case: add
            }

            // Bind the data.
            if (!$tableContractratedetails->bind($updateNullsTamp)) {
                $this->setError($tableContractratedetails->getError());

                return false;
            }
            // Trigger the before save event.
            $result = $dispatcher->trigger($this->event_before_save, array($context, &$tableContractratedetails, $isNew, $data));

            if (in_array(false, $result, true)) {
                $this->setError($tableContractratedetails->getError());

                return false;
            }

            // Store the data.
            if (!$tableContractratedetails->store()) {
                $this->setError($tableContractratedetails->getError());

                return false;
            }
        }
        return TRUE;
    }

    public function contractRateRouteMap($contractrate_id, $route_ids, $action) {
        $db = $this->getDbo();
        $route_ids = (array) $route_ids;
        JArrayHelper::toInteger($route_ids);

        switch ($action) {
            // Sets products to a selected contractrate
            case 'set':
                $doDelete = 'all';
                $doAssign = true;
                break;

            // Remove products from a selected contractrate
            case 'del':
                $doDelete = 'contractrate';
                break;

            // Add products to a selected contractrate
            case 'add':
            default:
                $doAssign = true;
                break;
        }

        // Remove the products from the contractrate if requested.
        if (isset($doDelete)) {
            $this->deleteMapping("contractrate_id", $contractrate_id, array(0 => "#__standard_routecontractrate_map"));
        }
        if ($this->checkDataContractrateDetails($contractrate_id)) {// check data contractrate detail isset
            // Remove the products from the contractrate if requested.
            if (isset($doAssign)) {
                $query = $db->getQuery(true);
                // First, we need to check if the contractrate is already assigned to a room type
                $query->select($db->quoteName('route_id'))
                        ->from($db->quoteName('#__standard_routecontractrate_map'))
                        ->where($db->quoteName('contractrate_id') . ' = ' . (int) $contractrate_id);
                $db->setQuery($query);
                $routes = $db->loadColumn();

                // Build the values clause for the assignment query.
                $query->clear();
                $contractrates = false;

                foreach ($route_ids as $id) {
                    if (!in_array($id, $routes)) {
                        $query->values($id . ',' . $contractrate_id);
                        $contractrates = true;
                    }
                }

                $query->insert($db->quoteName('#__standard_routecontractrate_map'))
                        ->columns(array($db->quoteName('route_id'), $db->quoteName('contractrate_id')));
                $db->setQuery($query);

                try {
                    $db->execute();
                } catch (RuntimeException $e) {
                    $this->setError($e->getMessage());

                    return false;
                }
            }
        }
        return true;
    }

    public function contractRateProductMap($contractrate_id, $product_ids, $action) {
        $db = $this->getDbo();
        $product_ids = (array) $product_ids;
        JArrayHelper::toInteger($product_ids);

        switch ($action) {
            // Sets products to a selected rate
            case 'set':
                $doDelete = 'all';
                $doAssign = true;
                break;

            // Remove products from a selected rate
            case 'del':
                $doDelete = 'rate';
                break;

            // Add products to a selected rate
            case 'add':
            default:
                $doAssign = true;
                break;
        }

        // Remove the products from the rate if requested.
        if (isset($doDelete)) {
            $this->deleteMapping("contractrate_id", $contractrate_id, array(0 => "#__standard_productcontractrate_map"));
        }
        if ($this->checkDataContractrateDetails($contractrate_id)) {// check data rate detail isset
            // Remove the products from the rate if requested.
            if (isset($doAssign)) {
                $query = $db->getQuery(true);
                // First, we need to check if the rate is already assigned to a room type
                $query->select($db->quoteName('product_id'))
                        ->from($db->quoteName('#__standard_productcontractrate_map'))
                        ->where($db->quoteName('contractrate_id') . ' = ' . (int) $contractrate_id);
                $db->setQuery($query);
                $products = $db->loadColumn();

                // Build the values clause for the assignment query.
                $query->clear();
                $rates = false;

                foreach ($product_ids as $id) {
                    if (!in_array($id, $products)) {
                        $query->values($id . ',' . $contractrate_id);
                        $rates = true;
                    }
                }

                $query->insert($db->quoteName('#__standard_productcontractrate_map'))
                        ->columns(array($db->quoteName('product_id'), $db->quoteName('contractrate_id')));
                $db->setQuery($query);

                try {
                    $db->execute();
                } catch (RuntimeException $e) {
                    $this->setError($e->getMessage());

                    return false;
                }
            }
        }
        return true;
    }

    public function checkDataContractrateDetails($contractrate_id = 0) {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName('id'))
                ->from($db->quoteName('#__standard_contractrate_details'))
                ->where($db->quoteName('contractrate_id') . ' = ' . (int) $contractrate_id);
        $db->setQuery($query);
        return $db->loadResult();
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
     * Build a Object List of Contractrate Details
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    public function getListInfoContractrates($pk) {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('*')
                ->from('#__standard_contractrate_details')
                ->where($db->quoteName('contractrate_id') . ' = ' . (int) $pk);

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
    }

}
