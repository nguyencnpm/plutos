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
 * Item Model for an Promotion.
 *
 * @since  1.6
 */
class StandardModelPromotion extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STANDARD_PROMOTION';

    /**
     * The type alias for this standard type (for example, 'com_standard.promotion').
     *
     * @var      string
     * @since    3.2
     */
    public $typeAlias = 'com_standard.promotion';

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

            return $user->authorise('core.delete', 'com_standard.promotion.' . (int) $record->id);
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

        // Check for existing promotion.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standard.promotion.' . (int) $record->id);
        }
        // Default to component settings if neither promotion nor category known.
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

        if ($table->state == 1 && intval($table->start_date) == 0) {
            $table->start_date = JFactory::getDate()->toSql();
        }

        if ($table->state == 1 && (int) $table->publish_up == 0) {
            $table->publish_up = JFactory::getDate()->toSql();
        }

        if ($table->state == 1 && intval($table->publish_down) == 0) {
            $table->publish_down = $db->getNullDate();
        }

        // Increment the standard version number.
        $table->version++;

        // Reorder the promotions within the category so the new promotion is first
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
    public function getTable($type = 'Promotion', $prefix = 'StandardTable', $config = array()) {
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
            // Convert the metadata field to an array.
            $registry = new Registry;
            $registry->loadString($item->metadata);
            $item->metadata = $registry->toArray();

            // Convert the images field to an array.
            $registry = new Registry;
            $registry->loadString($item->images);
            $item->images = $registry->toArray();

            // Convert the child images field to an array.
            $registry = new Registry;
            $registry->loadString($item->childimages);
            $item->childimages = $registry->toArray();

            // Convert the urls field to an array.
            $registry = new Registry;
            $registry->loadString($item->urls);
            $item->urls = $registry->toArray();

            $item->promotiontext = trim($item->fulltext) != '' ? $item->introtext . "<hr id=\"system-readmore\" />" . $item->fulltext : $item->introtext;

            $item->manufacturer_id = $this->getManufacturerIds($item->id);
            $item->catid = $this->getCatIds($item->id);
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
        $form = $this->loadForm('com_standard.promotion', 'promotion', array('control' => 'jform', 'load_data' => $loadData));
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
        if ($this->getState('promotion.id')) {
            $id = $this->getState('promotion.id');
        }

        $user = JFactory::getUser();

        // Check for existing promotion.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standard.promotion.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standard'))) {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an promotion you can edit.
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
        $data = $app->getUserState('com_standard.edit.promotion.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Promotion Manager: Currencies
            if ($this->getState('promotion.id') == 0) {
                $filters = (array) $app->getUserState('com_standard.promotions.filter');
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

        $this->preprocessData('com_standard.promotion', $data);

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
        if (!class_exists('ImageHelper')) {
            JLoader::register('ImageHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/image.php');
        }
        $imageHelper = new ImageHelper(JComponentHelper::getParams('com_standard'));

        $input = JFactory::getApplication()->input;
        $filter = JFilterInput::getInstance();

        if (isset($data['metadata']) && isset($data['metadata']['author'])) {
            $data['metadata']['author'] = $filter->clean($data['metadata']['author'], 'TRIM');
        }

        if (isset($data['created_by_alias'])) {
            $data['created_by_alias'] = $filter->clean($data['created_by_alias'], 'TRIM');
        }
        /*
          if (isset($data['images']) && is_array($data['images'])) {
          $registry = new Registry;
          $registry->loadArray($data['images']);

          $data['images'] = (string) $registry;
          }
         */
        if ($data['id'] > 0) :
            $item = parent::getItem($data['id']);
        else:
            $item = new stdClass();
        endif;
        // --- start save or delete image ---
        $file = $input->files->get('image');
        $folder = "promotions";
        $message = true;
        $keep_original = FALSE;
        $image_paths_current = array();
        $image_paths_empty = array();
        $arr_sizes = array('full', 'big', 'screen', 'medium', 'small', 'tiny');

        foreach ($imageHelper->sizes() as $value) {
            $image_paths_current["image_$value"] = "";
            $image_paths_empty["image_$value"] = "";
        }

        if ($data['id'] > 0) {
            if (isset($item->images)):
                // Convert the images field to an array.
                $registry = new Registry;
                $registry->loadString($item->images);
                $images = $registry->toArray();
                foreach ($image_paths_current as $key => $value) {
                    $image_paths_current[$key] = $images[$key];
                }
            endif;
        }

        if ($file['size']) {
            $image_paths_upload = $imageHelper->uploadImage($file, $image_paths_current, $folder, $arr_sizes, $message, $keep_original);
            if (is_array($image_paths_upload)) {
                $data['images'] = array_merge($data['images'], $image_paths_upload);
            } else {// case edit and add new " error: edit image or upload image new "
                $data['images'] = array_merge($data['images'], $image_paths_current);
            }
        } else {
            if ($input->get('image_delete')) {
                $imageHelper->deleteImage($image_paths_current);
                // update images path => ""
                $data['images'] = array_merge($data['images'], $image_paths_empty);
            } else {// case edit and add new " no edit image (upload image new)"
                $data['images'] = array_merge($data['images'], $image_paths_current);
            }
        }

        if (isset($data['images']) && is_array($data['images'])) {
            $registry = new Registry;
            $registry->loadArray($data['images']);
            $data['images'] = (string) $registry;
        }
        // --- end save or delete image ---
        // --- save or delete child image ---
        $data['childimages'] = '{}';
        $aFiles = $input->files->get('childimages');
        if (isset($aFiles) && is_array($aFiles)) :
            $sSuffix = "childimages";
            $folder = "promotions/childimages";
            $isMulti = 1;
            $aChildImagesSizes = array('full', 'big', 'screen', 'medium', 'small', 'tiny');
            $aResult = null;

            // --- Delete img in childimage case: Item of childimage empty in Items of childimage ---
            if ($data['id'] > 0) : // Edit
                $dataDelete = empty($item->childimages) ? array() : array_diff_key(json_decode($item->childimages, true), $aFiles);
                if (!empty($dataDelete)):
                    $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrentDelete($dataDelete);
                    if (!empty($MultiArrayDesImagesPathsCurrent)):
                        foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                            $imageHelper->deleteImage($aDesImagesPathsCurrent);
                        endforeach;
                    endif;
                endif;
            endif;
            // --- /.Delete img in childimage case: Item of childimage empty in Items of childimage ---

            foreach ($aFiles as $kChildImages => $vChildImages) {
                $isDelete = 0;
                $aItemFile = $vChildImages; // $aFiles[$kChildImages];
                $iKeyFile = $kChildImages;
                $aResult = $this->executeMedia($data, $aItemFile, $iKeyFile, $aChildImagesSizes, $sSuffix, $folder, $isDelete, $isMulti);

                // add images
                $aFilesTemp[$kChildImages]['images'] = $aResult[$sSuffix];

                if ($isDelete):
                    $this->removeItem($aFilesTemp, $kChildImages);
                endif;
            }
            if (sizeof($aFilesTemp) > 0):
                $registry = new Registry(array_values($aFilesTemp));
                $data['childimages'] = (string) $registry; // json
            endif;

        else: // child images "{}" empty ->  child images of images empty
            if ($data['id'] > 0) :
                $imageHelper = new ImageHelper(JComponentHelper::getParams('com_standard'));
                $sSuffix = "childimages";
                $isMulti = 1;
                $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrent($data, $sSuffix, $isMulti);

                if (!empty($MultiArrayDesImagesPathsCurrent)):
                    foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                        $imageHelper->deleteImage($aDesImagesPathsCurrent);
                    endforeach;
                endif;
            endif;
        endif;
        // --- end save or delete child image ---
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
        }
//        echo '<pre>';
//        print_r($data);
//        exit;
        if (parent::save($data)) {
            if (isset($data['manufacturer_id'])) {
                if ($data['id'] > 0) {
                    $action = 'set'; // edit
                } else {
                    $action = 'add';
                }
            } else {
                $action = 'del';
            }
            if (isset($data['manufacturer_id'])):
                $this->promotionManufacturerMapping($this->getState($this->getName() . '.id'), $data['manufacturer_id'], $action);
            endif;
            if (isset($data['catid'])) {
                if ($data['id'] > 0) {
                    $action = 'set'; // edit
                } else {
                    $action = 'add';
                }
            } else {
                $action = 'del';
            }
            if (isset($data['catid'])):
                $this->promotionCategoriesMapping($this->getState($this->getName() . '.id'), $data['catid'], $action);
            endif;

            return true;
        }

        return false;
    }

    public function promotionManufacturerMapping($promotion_id, $manufacturer_ids, $action) {
        $db = $this->getDbo();
        $manufacturer_ids = (array) $manufacturer_ids;
        JArrayHelper::toInteger($manufacturer_ids);

        switch ($action) {
            // Sets promotions to a selected promotion
            case 'set':
                $doDelete = 'all';
                $doAssign = true;
                break;

            // Remove promotions from a selected promotion
            case 'del':
                $doDelete = 'promotion';
                break;

            // Add promotions to a selected promotion
            case 'add':
            default:
                $doAssign = true;
                break;
        }

        // Remove the promotions from the promotion if requested.
        if (isset($doDelete)) {
            $this->deleteMapping("promotion_id", $promotion_id, array(0 => "#__standard_promotion_manufacturer_map"));
        }
        // Remove the promotions from the promotion if requested.
        if (isset($doAssign)) {
            $query = $db->getQuery(true);
            // First, we need to check if the promotion is already assigned to a room type
            $query->select($db->quoteName('manufacturer_id'))
                    ->from($db->quoteName('#__standard_promotion_manufacturer_map'))
                    ->where($db->quoteName('promotion_id') . ' = ' . (int) $promotion_id);
            $db->setQuery($query);
            $manufacturers = $db->loadColumn();

            // Build the values clause for the assignment query.
            $query->clear();
            $promotions = false;

            foreach ($manufacturer_ids as $id) {
                if (!in_array($id, $manufacturers)) {
                    $query->values($id . ',' . $promotion_id);
                    $promotions = true;
                }
            }

            $query->insert($db->quoteName('#__standard_promotion_manufacturer_map'))
                    ->columns(array($db->quoteName('manufacturer_id'), $db->quoteName('promotion_id')));
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

    public function promotionCategoriesMapping($promotion_id, $catids, $action) {
        $db = $this->getDbo();
        $catids = (array) $catids;
        JArrayHelper::toInteger($catids);

        switch ($action) {
            // Sets promotions to a selected promotion
            case 'set':
                $doDelete = 'all';
                $doAssign = true;
                break;

            // Remove promotions from a selected promotion
            case 'del':
                $doDelete = 'promotion';
                break;

            // Add promotions to a selected promotion
            case 'add':
            default:
                $doAssign = true;
                break;
        }

        // Remove the promotions from the promotion if requested.
        if (isset($doDelete)) {
            $this->deleteMapping("promotion_id", $promotion_id, array(0 => "#__standard_promotion_categories_map"));
        }
        // Remove the promotions from the promotion if requested.
        if (isset($doAssign)) {
            $query = $db->getQuery(true);
            // First, we need to check if the promotion is already assigned to a room type
            $query->select($db->quoteName('catid'))
                    ->from($db->quoteName('#__standard_promotion_categories_map'))
                    ->where($db->quoteName('promotion_id') . ' = ' . (int) $promotion_id);
            $db->setQuery($query);
            $manufacturers = $db->loadColumn();

            // Build the values clause for the assignment query.
            $query->clear();
            $promotions = false;

            foreach ($catids as $id) {
                if (!in_array($id, $manufacturers)) {
                    $query->values($id . ',' . $promotion_id);
                    $promotions = true;
                }
            }

            $query->insert($db->quoteName('#__standard_promotion_categories_map'))
                    ->columns(array($db->quoteName('catid'), $db->quoteName('promotion_id')));
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
                ->from('#__standard_promotion_manufacturer_map')
                ->where($db->quoteName('promotion_id') . ' = ' . (int) $pk);

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
                ->from('#__standard_promotion_categories_map')
                ->where($db->quoteName('promotion_id') . ' = ' . (int) $pk);

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadColumn();
    }

    // ---- ----
    protected function getItemsArrayPathsCurrent($data, $sSuffix, $isMulti = 0) {

        $MultiArrayPathsCurrent = array();
        if ($data['id'] > 0) {
            $item = parent::getItem($data['id']);
            // Convert the $sSuffix field to an array.
            $registry = new Registry;
            $aTemp = array();
            if ($isMulti):
                $registry->loadString($item->$sSuffix);
                $aMultiSuffix = $registry->toArray();
                foreach ($aMultiSuffix as $key => $aVal):
                    if (isset($aVal['images'])):
                        $registry = new Registry;
                        $registry->loadArray($aVal['images']);
                        $aTemp = $registry->toArray();
                    endif;
                    if (!empty($aTemp)):
                        $MultiArrayPathsCurrent[$key] = $aTemp;
                    endif;
                endforeach;
            else:
                $registry->loadString($item->$sSuffix);
                $aTemp = $registry->toArray();
                if (!empty($aTemp)):
                    $MultiArrayPathsCurrent[$key] = $aTemp;
                endif;
            endif;
        }
        return $MultiArrayPathsCurrent;
    }

    protected function getItemsArrayPathsCurrentDelete($dataDelete) {

        if (is_array($dataDelete)) {
            $MultiArrayPathsCurrent = array();
            $aTemp = array();
            foreach ($dataDelete as $key => $aVal):
                if (isset($aVal['images'])):
                    $registry = new Registry;
                    $registry->loadArray($aVal['images']);
                    $aTemp = $registry->toArray();
                endif;
                if (!empty($aTemp)):
                    $MultiArrayPathsCurrent[$key] = $aTemp;
                endif;
            endforeach;
            return $MultiArrayPathsCurrent;
        }
    }

    protected function executeMedia($data, $aFile, $iKeyFile, $aSizes, $sSuffix, $folder, $isDelete, $isMulti) {
        if (!class_exists('ImageHelper')) {
            JLoader::register('ImageHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/image.php');
        }
        $imageHelper = new ImageHelper(JComponentHelper::getParams('com_standard'));
        $message = true;
        $keep_original = FALSE;

        $aData = array();

        // --- save or delete image ---
        $aPathsCurrent = array();
        $aPathsEmpty = array();
        foreach ($imageHelper->sizes() as $value) {
            $aPathsCurrent["image_$value"] = "";
            $aPathsEmpty["image_$value"] = "";
        }

        if ($data['id'] > 0) {
            $item = parent::getItem($data['id']);
            // Convert the $sSuffix field to an array.
            $registry = new Registry;
            $aTemp = array();
            if ($isMulti):
                $registry->loadString($item->$sSuffix);
                $aMultiSuffix = $registry->toArray();
                if (isset($aMultiSuffix[$iKeyFile]['images'])):
                    $registry = new Registry;
                    $registry->loadArray($aMultiSuffix[$iKeyFile]['images']);
                    $aTemp = $registry->toArray();
                endif;

            else:
                $registry->loadString($item->$sSuffix);
                $aTemp = $registry->toArray();
            endif;

            if (!empty($aTemp)):
                foreach ($aPathsCurrent as $key => $value) {
                    $aPathsCurrent[$key] = $aTemp[$key];
                }
            endif;
        }

        if ($aFile['size']) {
            $map_paths_upload = $imageHelper->uploadImage($aFile, $aPathsCurrent, $folder, $aSizes, $message, $keep_original);
            if (is_array($map_paths_upload)) {
                $aData[$sSuffix] = $isMulti == 1 ? $map_paths_upload : array_merge($data[$sSuffix], $map_paths_upload);
            } else {// case edit and add new " error: edit map or upload map new "
                $aData[$sSuffix] = $isMulti == 1 ? $aPathsCurrent : array_merge($data[$sSuffix], $aPathsCurrent);
            }
        } else {
            if ($isDelete) {
                $imageHelper->deleteImage($aPathsCurrent);
                // update $sSuffix path => ""
                $aData[$sSuffix] = $isMulti == 1 ? $aPathsEmpty : array_merge($data[$sSuffix], $aPathsEmpty);
            } else {// case edit and add new " no edit map (upload map new)"
                $aData[$sSuffix] = $isMulti == 1 ? $aPathsCurrent : array_merge($data[$sSuffix], $aPathsCurrent);
            }
        }
        // --- /. save or delete image --- 
        return $aData;
    }

    public function deleteImage($pks, $aColumn = null) {
        // Sanitize the ids.
        $pks = (array) $pks;
        JArrayHelper::toInteger($pks);
        $aColumn = (array) $aColumn;
        JArrayHelper::toString($aColumn);

        if (!class_exists('ImageHelper')) {
            JLoader::register('ImageHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/image.php');
        }
        $imageHelper = new ImageHelper(JComponentHelper::getParams('com_standard'));
        $image_paths = array();
        foreach ($pks as $id) {
            $item = parent::getItem($id);
            foreach ($aColumn as $k => $val) {
                // Convert the images field to an array.
                $registry = new Registry;
                $registry->loadString($item->$val); //$item->images or $item->banners, ...
                $aMedia = $registry->toArray();
                foreach ($imageHelper->sizes() as $value) {// filter image paths
                    $image_paths["image_$value"] = $aMedia["image_$value"];
                }
                $imageHelper->deleteImage($image_paths);
            }
        }
        return true;
    }

    public function removeItem(&$aByKey, $id = 0) {
        unset($aByKey[(int) $id]);
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
        parent::cleanCache('mod_promotions_archive');
    }

}
