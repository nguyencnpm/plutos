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
 * Item Model for an Combo.
 *
 * @since  1.6
 */
class StandardModelCombo extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STANDARD';

    /**
     * The type alias for this standard type (for example, 'com_standard.combo').
     *
     * @var      string
     * @since    3.2
     */
    public $typeAlias = 'com_standard.combo';

    /**
     * The context used for the associations table
     *
     * @var      string
     * @since    3.4.4
     */
    protected $associationsContext = 'com_standard.item';

    /**
     * Batch copy items to a new category or current.
     *
     * @param   integer  $value     The new category.
     * @param   array    $pks       An array of row IDs.
     * @param   array    $contexts  An array of item contexts.
     *
     * @return  mixed  An array of new IDs on success, boolean false on failure.
     *
     * @since   11.1
     */
    protected function batchCopy($value, $pks, $contexts) {

        $categoryId = (int) $value;

        $newIds = array();

        if (!parent::checkCategoryId($categoryId)) {
            return false;
        }

        // Parent exists so we let's proceed
        while (!empty($pks)) {
            // Pop the first ID off the stack
            $pk = array_shift($pks);

            $this->table->reset();

            // Check that the row actually exists
            if (!$this->table->load($pk)) {
                if ($error = $this->table->getError()) {
                    // Fatal error
                    $this->setError($error);

                    return false;
                } else {
                    // Not fatal error
                    $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
                    continue;
                }
            }

            // Alter the title & alias
            $data = $this->generateNewTitle($categoryId, $this->table->alias, $this->table->title);
            $this->table->title = $data['0'];
            $this->table->alias = $data['1'];

            // Reset the ID because we are making a copy
            $this->table->id = 0;

            // Reset hits because we are making a copy
            $this->table->hits = 0;

            // Unpublish because we are making a copy
            $this->table->state = 0;

            // New category ID
            $this->table->catid = $categoryId;

            // TODO: Deal with ordering?
            // $table->ordering	= 1;
            // Get the featured state
            $featured = $this->table->featured;

            // Check the row.
            if (!$this->table->check()) {
                $this->setError($this->table->getError());

                return false;
            }

            parent::createTagsHelper($this->tagsObserver, $this->type, $pk, $this->typeAlias, $this->table);

            // Store the row.
            if (!$this->table->store()) {
                $this->setError($this->table->getError());

                return false;
            }

            // Get the new item ID
            $newId = $this->table->get('id');

            // Add the new ID to the array
            $newIds[$pk] = $newId;

            // Check if the combo was featured and update the #__standard_combos_frontpage table
            if ($featured == 1) {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                        ->insert($db->quoteName('#__standard_combos_frontpage'))
                        ->values($newId . ', 0');
                $db->setQuery($query);
                $db->execute();
            }
        }

        // Clean the cache
        $this->cleanCache();

        return $newIds;
    }

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

            return $user->authorise('core.delete', 'com_standard.combo.' . (int) $record->id);
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

        // Check for existing combo.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standard.combo.' . (int) $record->id);
        }
        // New combo, so check against the category.
        elseif (!empty($record->catid)) {
            return $user->authorise('core.edit.state', 'com_standard.category.' . (int) $record->catid);
        }
        // Default to component settings if neither combo nor category known.
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

        // Reorder the combos within the category so the new combo is first
        if (empty($table->id)) {
            $table->reorder('catid = ' . (int) $table->catid . ' AND state >= 0');
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
    public function getTable($type = 'Combo', $prefix = 'StandardTable', $config = array()) {
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
            // Convert the params field to an array.
            $registry = new Registry;
            $registry->loadString($item->attribs);
            $item->attribs = $registry->toArray();

            // Convert the metadata field to an array.
            $registry = new Registry;
            $registry->loadString($item->metadata);
            $item->metadata = $registry->toArray();

            // Convert the descriptions field to an array.
            $registry = new Registry;
            $registry->loadString($item->descriptions);
            $item->descriptions = $registry->toArray();

            // Convert the images field to an array.
            $registry = new Registry;
            $registry->loadString($item->images);
            $item->images = $registry->toArray();

            // Convert the child images field to an array.
            $registry = new Registry;
            $registry->loadString($item->childimages);
            $item->childimages = $registry->toArray();

            // Convert the banners field to an array.
            $registry = new Registry;
            $registry->loadString($item->banners);
            $item->banners = $registry->toArray();

            $registry = new Registry;
            $registry->loadString($item->banners_tablet);
            $item->banners_tablet = $registry->toArray();

            $registry = new Registry;
            $registry->loadString($item->banners_phone);
            $item->banners_phone = $registry->toArray();

            // Convert the galleries field to an array.
            $registry = new Registry($item->galleries);
            $item->galleries = $registry->toArray();

            // Convert the videos field to an array.
            $registry = new Registry($item->videos);
            $item->videos = $registry->toArray();

            // Convert the images plans field to an array.
            $registry = new Registry($item->plans_image);
            $item->plans_image = $registry->toArray();

            // Convert the plans field to an array.
            $registry = new Registry($item->plans);
            $item->plans = $registry->toArray();

//            echo '<pre>';
//            print_r($item->images);
//            exit;
            // Convert the links field to an array.
            $registry = new Registry($item->links);
            $item->links = $registry->toArray();

            // Convert the urls field to an array.
            $registry = new Registry;
            $registry->loadString($item->urls);
            $item->urls = $registry->toArray();

            $item->combotext = trim($item->fulltext) != '' ? $item->introtext . "<hr id=\"system-readmore\" />" . $item->fulltext : $item->introtext;

            // $item->manufacturer_id = $this->getManufacturerIds($item->id);

            // Convert the block combo date field to an array.
            $registry = new Registry($item->period_block);
            $item->period_block = $registry->toArray();
            if (!empty($item->period_block) && sizeof($item->period_block) > 0):
                $delimiter = " - ";
                foreach ($item->period_block as $pKey => $pValue):
                    $adateTemp = explode($delimiter, trim($pValue));
                    $start = JHtml::_('date', trim($adateTemp[0]), 'Y-m-d');
                    $expiry = JHtml::_('date', trim($adateTemp[1]), 'Y-m-d');
                    $item->period_block[$pKey] = $start . " - " . $expiry;
                endforeach;
            endif;

            if (!empty($item->id)) {
                $item->tags = new JHelperTags;
                $item->tags->getTagIds($item->id, 'com_standard.combo');
            }
        }

        // Load associated standard items
        $app = JFactory::getApplication();
        $assoc = JLanguageAssociations::isEnabled();

        if ($assoc) {
            $item->associations = array();

            if ($item->id != null) {
                $associations = JLanguageAssociations::getAssociations('com_standard', '#__standard_combos', 'com_standard.item', $item->id);

                foreach ($associations as $tag => $association) {
                    $item->associations[$tag] = $association->id;
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
        $form = $this->loadForm('com_standard.combo', 'combo', array('control' => 'jform', 'load_data' => $loadData));

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
        if ($this->getState('combo.id')) {
            $id = $this->getState('combo.id');

            // Existing record. Can only edit in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.edit');

            // Existing record. Can only edit own combos in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.edit.own');
        } else {
            // New record. Can only create in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.create');
        }

        $user = JFactory::getUser();

        // Check for existing combo.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standard.combo.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standard'))) {
            // Disable fields for display.
            $form->setFieldAttribute('featured', 'disabled', 'true');
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an combo you can edit.
            $form->setFieldAttribute('featured', 'filter', 'unset');
            $form->setFieldAttribute('ordering', 'filter', 'unset');
            $form->setFieldAttribute('publish_up', 'filter', 'unset');
            $form->setFieldAttribute('publish_down', 'filter', 'unset');
            $form->setFieldAttribute('state', 'filter', 'unset');
        }

        // Prevent messing with combo language and category when editing existing combo with associations
        $app = JFactory::getApplication();
        $assoc = JLanguageAssociations::isEnabled();

        // Check if combo is associated
        if ($this->getState('combo.id') && $app->isSite() && $assoc) {
            $associations = JLanguageAssociations::getAssociations('com_standard', '#__standard_combos', 'com_standard.item', $id);

            // Make fields read only
            if (!empty($associations)) {
                $form->setFieldAttribute('language', 'readonly', 'true');
                $form->setFieldAttribute('catid', 'readonly', 'true');
                $form->setFieldAttribute('language', 'filter', 'unset');
                $form->setFieldAttribute('catid', 'filter', 'unset');
            }
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
        $data = $app->getUserState('com_standard.edit.combo.data', array());

        if (empty($data)) {
            $data = $this->getItem();

            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Combo Manager: Combos
            if ($this->getState('combo.id') == 0) {
                $filters = (array) $app->getUserState('com_standard.combos.filter');
                $data->set(
                        'state', $app->input->getInt(
                                'state', ((isset($filters['published']) && $filters['published'] !== '') ? $filters['published'] : null)
                        )
                );
                $data->set('catid', $app->input->getInt('catid', (!empty($filters['category_id']) ? $filters['category_id'] : null)));
                $data->set('language', $app->input->getString('language', (!empty($filters['language']) ? $filters['language'] : null)));
                $data->set('access', $app->input->getInt('access', (!empty($filters['access']) ? $filters['access'] : JFactory::getConfig()->get('access')))
                );
            }
        }

        // If there are params fieldsets in the form it will fail with a registry object
        if (isset($data->params) && $data->params instanceof Registry) {
            $data->params = $data->params->toArray();
        }

        $this->preprocessData('com_standard.combo', $data);

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
        /*
          $array1 = array('blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4);
          $array2 = array('green' => 2, 'yellow' => 2, 'cyan' => 4);
          $array3 = array('blue' => 4, 'yellow' => 2, 'mauve' => 1);
          echo '<pre>';
          print_r(array_diff_key($array1, $array2, $array3));
          exit;
         */
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

        if ($data['id'] > 0) :
            $item = parent::getItem($data['id']);
        else:
            $item = new stdClass();
        endif;

        // --- descriptions ---
        $data['descriptions'] = '{}';
        $aDescriptions = isset($input->post->get('jform', array(), 'array')['descriptions']) ? $input->post->get('jform', array(), 'array')['descriptions'] : array();
        $aDescriptionsTemp = $aDescriptions;

        if (isset($aDescriptions) && is_array($aDescriptions) && !empty($aDescriptions)) :
            $sSuffix = "descriptions";
            $folder = "descriptions";
            $isMulti = 1;

            $aDescriptionImageFiles = $input->files->get('descriptions');
            $aDescriptionImageSizes = array('full', 'big', 'screen', 'medium', 'small');
            $aResult = null;
            // --- Delete img in description case: Item of description empty in Items of description ---
            if ($data['id'] > 0) : // Edit
                $dataDelete = empty($item->descriptions) ? array() : array_diff_key(json_decode($item->descriptions, true), $aDescriptions);
                if (!empty($dataDelete)):
                    $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrentDelete($dataDelete);
                    if (!empty($MultiArrayDesImagesPathsCurrent)):
                        foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                            $imageHelper->deleteImage($aDesImagesPathsCurrent);
                        endforeach;
                    endif;
                endif;
            endif;
            // --- /.Delete img in description case: Item of description empty in Items of description ---

            foreach ($aDescriptions as $key => $aValue) {
                if (isset($aValue['descriptionimages_delete'])):
                    $isDelete = $aValue['descriptionimages_delete'];
                else:
                    $isDelete = 0;
                endif;

                $aItemFile = $aDescriptionImageFiles[$key];
                $iKeyFile = $key;
                $aResult = $this->executeMedia($data, $aItemFile, $iKeyFile, $aDescriptionImageSizes, $sSuffix, $folder, $isDelete, $isMulti);
                // add images
                $aDescriptionsTemp[$key]['images'] = $aResult[$sSuffix];
                /*
                  if (empty($aValue['title']) && empty($aValue['description'])):
                  $this->removeItem($aDescriptionsTemp, $key);
                  endif;
                 */
            }
            if (sizeof($aDescriptionsTemp) > 0):
                $registry = new Registry;
                $registry->loadArray(array_values($aDescriptionsTemp));
                $data['descriptions'] = (string) $registry;
            endif;
        else: // descriptions "{}" empty ->  description of images empty
            if ($data['id'] > 0) :
                $sSuffix = "descriptions";
                $isMulti = 1;
                $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrent($data, $sSuffix, $isMulti);

                if (!empty($MultiArrayDesImagesPathsCurrent)):
                    foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                        $imageHelper->deleteImage($aDesImagesPathsCurrent);
                    endforeach;
                endif;
            endif;
        endif;
        // --- /.descriptions ---
        // --- start save or delete image ---
        $file = $input->files->get('image');
        $folder = "combos";
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
            // Convert the images field to an array.
            $registry = new Registry;
            $registry->loadString($item->images);
            $images = $registry->toArray();
            foreach ($image_paths_current as $key => $value) {
                $image_paths_current[$key] = $images[$key];
            }
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
            $folder = "combos/childimages";
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
        // --- save or delete banner ---
        $fileBanner = $input->files->get('banner');
        $folderBanner = "banners/combos";

        $aBannerPathsCurrent = array();
        $aBannerPathsEmpty = array();
        $aBannerSizes = array('full', 'big', 'screen', 'medium', 'small', 'tiny');
        foreach ($imageHelper->sizes() as $value) {
            $aBannerPathsCurrent["image_$value"] = "";
            $aBannerPathsEmpty["image_$value"] = "";
        }

        if ($data['id'] > 0) {
            // Convert the banners field to an array.
            $registry = new Registry;
            $registry->loadString($item->banners);
            $banners = $registry->toArray();
            foreach ($aBannerPathsCurrent as $key => $value) {
                $aBannerPathsCurrent[$key] = $banners[$key];
            }
        }

        if ($fileBanner['size']) {
            $banner_paths_upload = $imageHelper->uploadImage($fileBanner, $aBannerPathsCurrent, $folderBanner, $aBannerSizes, $message, $keep_original);
            if (is_array($banner_paths_upload)) {
                $data['banners'] = array_merge($data['banners'], $banner_paths_upload);
            } else {// case edit and add new " error: edit banner or upload banner new "
                $data['banners'] = array_merge($data['banners'], $aBannerPathsCurrent);
            }
        } else {
            if ($input->get('banner_delete')) {
                $imageHelper->deleteImage($aBannerPathsCurrent);
                // update banners path => ""
                $data['banners'] = array_merge($data['banners'], $aBannerPathsEmpty);
            } else {// case edit and add new " no edit banner (upload banner new)"
                $data['banners'] = array_merge($data['banners'], $aBannerPathsCurrent);
            }
        }

        if (isset($data['banners']) && is_array($data['banners'])) {
            $registry = new Registry;
            $registry->loadArray($data['banners']);

            $data['banners'] = (string) $registry;
        }

        // --- save or delete banner tablet ---
        $fileBannerTablet = $input->files->get('banner_tablet');
        $folderBannerTablet = "banners/combos/tablets";

        $aBannerTabletPathsCurrent = array();
        $aBannerTabletPathsEmpty = array();
        $aBannerTabletSizes = array('full', 'big', 'screen', 'medium', 'small', 'tiny');
        foreach ($imageHelper->sizes() as $value) {
            $aBannerTabletPathsCurrent["image_$value"] = "";
            $aBannerTabletPathsEmpty["image_$value"] = "";
        }

        if ($data['id'] > 0) {
            if (!empty($item->banners_tablet)) {
                // Convert the tablet banners field to an array.
                $registry = new Registry;
                $registry->loadString($item->banners_tablet);
                $banners_tablet = $registry->toArray();
                foreach ($aBannerTabletPathsCurrent as $key => $value) {
                    $aBannerTabletPathsCurrent[$key] = $banners_tablet[$key];
                }
            }
        }

        if ($fileBannerTablet['size']) {
            $banner_paths_upload = $imageHelper->uploadImage($fileBannerTablet, $aBannerTabletPathsCurrent, $folderBannerTablet, $aBannerTabletSizes, $message, $keep_original);
            if (is_array($banner_paths_upload)) {
                $data['banners_tablet'] = $banner_paths_upload;
            } else {// case edit and add new " error: edit banner or upload banner new "
                $data['banners_tablet'] = $aBannerTabletPathsCurrent;
            }
        } else {
            if ($input->get('banner_tablet_delete')) {
                $imageHelper->deleteImage($aBannerTabletPathsCurrent);
                // update banners_tablet path => ""
                $data['banners_tablet'] = $aBannerTabletPathsEmpty;
            } else {// case edit and add new " no edit banner (upload banner new)"
                $data['banners_tablet'] = $aBannerTabletPathsCurrent;
            }
        }

        if (isset($data['banners_tablet']) && is_array($data['banners_tablet'])) {
            $registry = new Registry;
            $registry->loadArray($data['banners_tablet']);

            $data['banners_tablet'] = (string) $registry;
        }

        // --- save or delete banner phone ---
        $fileBannerPhone = $input->files->get('banner_phone');
        $folderBannerPhone = "banners/combos/phones";

        $aBannerPhonePathsCurrent = array();
        $aBannerPhonePathsEmpty = array();
        $aBannerPhoneSizes = array('full', 'big', 'screen', 'medium', 'small', 'tiny');
        foreach ($imageHelper->sizes() as $value) {
            $aBannerPhonePathsCurrent["image_$value"] = "";
            $aBannerPhonePathsEmpty["image_$value"] = "";
        }

        if ($data['id'] > 0) {
            if (!empty($item->banners_phone)) {
                // Convert the banners_phone field to an array.
                $registry = new Registry;
                $registry->loadString($item->banners_phone);
                $banners_phone = $registry->toArray();
                foreach ($aBannerPhonePathsCurrent as $key => $value) {
                    $aBannerPhonePathsCurrent[$key] = $banners_phone[$key];
                }
            }
        }

        if ($fileBannerPhone['size']) {
            $banner_paths_upload = $imageHelper->uploadImage($fileBannerPhone, $aBannerPhonePathsCurrent, $folderBannerPhone, $aBannerPhoneSizes, $message, $keep_original);
            if (is_array($banner_paths_upload)) {
                $data['banners_phone'] = $banner_paths_upload;
            } else {// case edit and add new " error: edit banner or upload banner new "
                $data['banners_phone'] = $aBannerPhonePathsCurrent;
            }
        } else {
            if ($input->get('banner_phone_delete')) {
                $imageHelper->deleteImage($aBannerPhonePathsCurrent);
                // update banners_phone path => ""
                $data['banners_phone'] = $aBannerPhonePathsEmpty;
            } else {// case edit and add new " no edit banner (upload banner new)"
                $data['banners_phone'] = $aBannerPhonePathsCurrent;
            }
        }

        if (isset($data['banners_phone']) && is_array($data['banners_phone'])) {
            $registry = new Registry;
            $registry->loadArray($data['banners_phone']);

            $data['banners_phone'] = (string) $registry;
        }
        // --- /. save or delete banner --- 
        // --- gallery --- galleries 
        $data['galleries'] = '{}';
        $aGalleries = $input->post->get('jform', array(), 'array')['galleries'];
        $aGalleriesTemp = $aGalleries;
        if (isset($aGalleries) && is_array($aGalleries)) :
            $sSuffix = "galleries";
            $folder = "combos/galleries";
            $isMulti = 1;

            $aFiles = $input->files->get('gallery');
            $aGallerySizes = array('full', 'big', 'screen', 'medium', 'small', 'tiny');
            $aResult = null;

            // --- Delete img in galleries case: Item of galleries empty in Items of galleries ---
            if ($data['id'] > 0) : // Edit
                $dataDelete = empty($item->galleries) ? array() : array_diff_key(json_decode($item->galleries, true), $aGalleries);
                if (!empty($dataDelete)):
                    $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrentDelete($dataDelete);
                    if (!empty($MultiArrayDesImagesPathsCurrent)):
                        foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                            $imageHelper->deleteImage($aDesImagesPathsCurrent);
                        endforeach;
                    endif;
                endif;
            endif;
            // --- /.Delete img in galleries case: Item of galleries empty in Items of galleries ---

            foreach ($aGalleries as $kGallery => $vGallery) {
                if (isset($vGallery['gallery_delete'])):
                    $isDelete = $vGallery['gallery_delete'];
                else:
                    $isDelete = 0;
                endif;

                $aItemFile = $aFiles[$kGallery];
                $iKeyFile = $kGallery;
                $aResult = $this->executeMedia($data, $aItemFile, $iKeyFile, $aGallerySizes, $sSuffix, $folder, $isDelete, $isMulti);
                // add images
                $aGalleriesTemp[$kGallery]['images'] = $aResult[$sSuffix];

                if ($isDelete || empty($aGalleriesTemp[$kGallery]['images']['image_medium'])):
                    $this->removeItem($aGalleriesTemp, $kGallery);
                endif;
            }
            if (sizeof($aGalleriesTemp) > 0):
                $registry = new Registry(array_values($aGalleriesTemp));
                $data['galleries'] = (string) $registry; // json
            endif;
        else: // galleries "{}" empty ->  galleries empty
            if ($data['id'] > 0) :
                $sSuffix = "galleries";
                $isMulti = 1;
                $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrent($data, $sSuffix, $isMulti);

                if (!empty($MultiArrayDesImagesPathsCurrent)):
                    foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                        $imageHelper->deleteImage($aDesImagesPathsCurrent);
                    endforeach;
                endif;
            endif;
        endif;
        // --- /.gallery ---
        // --- videos ---
        $data['videos'] = '{}';
        $aVideos = $input->post->get('jform', array(), 'array')['videos'];
        $aVideosTemp = $aVideos;
        if (isset($aVideos) && is_array($aVideos)) :
            $sSuffix = "videos";
            $folder = "combos/video_thumbnails";
            $isMulti = 1;
            $aFiles = $input->files->get('video');
            $aVideoSizes = array('full', 'big', 'screen', 'medium', 'small');
            $aResult = null;

            // --- Delete img in video thumbnails case: Item of video thumbnails empty in Items of video thumbnails ---
            if ($data['id'] > 0) : // Edit
                $dataDelete = empty($item->videos) ? array() : array_diff_key(json_decode($item->videos, true), $aVideos);
                if (!empty($dataDelete)):
                    $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrentDelete($dataDelete);
                    if (!empty($MultiArrayDesImagesPathsCurrent)):
                        foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                            $imageHelper->deleteImage($aDesImagesPathsCurrent);
                        endforeach;
                    endif;
                endif;
            endif;
            // --- /.Delete img in video thumbnails case: Item of video thumbnails empty in Items of video thumbnails ---

            foreach ($aVideos as $kVideo => $vVideo) {
                if (isset($vVideo['video_delete'])):
                    $isDelete = $vVideo['video_delete'];
                else:
                    $isDelete = 0;
                endif;
                $aItemFile = $aFiles[$kVideo];
                $iKeyFile = $kVideo;

                $aResult = $this->executeMedia($data, $aItemFile, $iKeyFile, $aVideoSizes, $sSuffix, $folder, $isDelete, $isMulti);
                // add thumbnail
                $aVideosTemp[$kVideo]['images'] = $aResult[$sSuffix];
                /*
                  if ($isDelete || empty($aVideosTemp[$kVideo]['images']['image_medium'])):
                  $this->removeItem($aVideosTemp, $kVideo);
                  endif;
                 */
            }
            if (sizeof($aVideosTemp) > 0):
                $registry = new Registry(array_values($aVideosTemp));
                $data['videos'] = (string) $registry; // json
            endif;
        else: // descriptions "{}" empty ->  description of images empty
            if ($data['id'] > 0) :
                $sSuffix = "videos";
                $isMulti = 1;
                $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrent($data, $sSuffix, $isMulti);

                if (!empty($MultiArrayDesImagesPathsCurrent)):
                    foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                        $imageHelper->deleteImage($aDesImagesPathsCurrent);
                    endforeach;
                endif;
            endif;
        endif;
        // --- /.videos ---
        // --- image plans --- 
        $data['plans_image'] = '{}';
        $aPlansImage = $input->post->get('jform', array(), 'array')['plans_image'];
        $aPlansImageTemp = $aPlansImage;
        if (isset($aPlansImage) && is_array($aPlansImage)) :
            $sSuffix = "plans_image";
            $folder = "combos/plans_image";
            $isMulti = 1;

            $aFiles = $input->files->get('plans_image');
            $aPlansImageSizes = array('full', 'big', 'screen', 'medium', 'small', 'tiny');
            $aResult = null;

            // --- Delete img in plans_image case: Item of plans_image empty in Items of plans_image ---
            if ($data['id'] > 0) : // Edit
                $dataDelete = empty($item->plans_image) ? array() : array_diff_key(json_decode($item->plans_image, true), $aPlansImage);
                if (!empty($dataDelete)):
                    $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrentDelete($dataDelete);
                    if (!empty($MultiArrayDesImagesPathsCurrent)):
                        foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                            $imageHelper->deleteImage($aDesImagesPathsCurrent);
                        endforeach;
                    endif;
                endif;
            endif;
            // --- /.Delete img in plans_image case: Item of plans_image empty in Items of plans_image ---

            foreach ($aPlansImage as $kPlansImage => $vPlansImage) {
                if (isset($vPlansImage['plans_image_delete'])):
                    $isDelete = $vPlansImage['plans_image_delete'];
                else:
                    $isDelete = 0;
                endif;

                $aItemFile = $aFiles[$kPlansImage];
                $iKeyFile = $kPlansImage;
                $aResult = $this->executeMedia($data, $aItemFile, $iKeyFile, $aPlansImageSizes, $sSuffix, $folder, $isDelete, $isMulti);
                // add images
                $aPlansImageTemp[$kPlansImage]['images'] = $aResult[$sSuffix];

                if ($isDelete || empty($aPlansImageTemp[$kPlansImage]['images']['image_medium'])):
                    $this->removeItem($aPlansImageTemp, $kPlansImage);
                endif;
            }
            if (sizeof($aPlansImageTemp) > 0):
                $registry = new Registry(array_values($aPlansImageTemp));
                $data['plans_image'] = (string) $registry; // json
            endif;
        else: // plans_image "{}" empty ->  plans_image empty
            if ($data['id'] > 0) :
                $sSuffix = "plans_image";
                $isMulti = 1;
                $MultiArrayDesImagesPathsCurrent = $this->getItemsArrayPathsCurrent($data, $sSuffix, $isMulti);

                if (!empty($MultiArrayDesImagesPathsCurrent)):
                    foreach ($MultiArrayDesImagesPathsCurrent as $aDesImagesPathsCurrent):
                        $imageHelper->deleteImage($aDesImagesPathsCurrent);
                    endforeach;
                endif;
            endif;
        endif;
        // --- /. image plans ---
        // --- plans ---
        $data['plans'] = '{}';
        $aPlans = isset($input->post->get('jform', array(), 'array')['plans']) ? $input->post->get('jform', array(), 'array')['plans'] : array();
        if (isset($aPlans) && is_array($aPlans) && !empty($aPlans)) :
            $registry = new Registry;
            $registry->loadArray(array_values($aPlans));
            $data['plans'] = (string) $registry;
        endif;
        // --- /.plans ---
        // JLoader::register('CategoriesHelper', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/categories.php');
        // Cast catid to integer for comparison
        $catid = (int) $data['catid'];

        // Check if New Category exists
        if ($catid > 0) {
            // $catid = CategoriesHelper::validateCategoryId($data['catid'], 'com_standard');
            $catid = StandardHelper::validateCategoryId($data['catid'], 'com_standard');
        }

        // Save New Categoryg
        if ($catid == 0 && $this->canCreateCategory()) {
            $table = array();
            $table['title'] = $data['catid'];
            $table['parent_id'] = 1;
            $table['extension'] = 'com_standard';
            $table['language'] = $data['language'];
            $table['published'] = 1;

            // Create new category and get catid back
            // $data['catid'] = CategoriesHelper::createCategory($table);
            $data['catid'] = StandardHelper::createCategory($table);
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

        // === Chu y: Time Zone of SQL --- fixed case then ===
        if (isset($input->post->get('jform', array(), 'array')['period_block']) && is_array($input->post->get('jform', array(), 'array')['period_block'])) {
            $period_block = $input->post->get('jform', array(), 'array')['period_block'];
            foreach ($period_block as $keyBR => $v_block_room) {
                if (empty(trim($v_block_room))) {
                    unset($period_block[$keyBR]);
                }
            }
            if (is_array($period_block) && count($period_block) > 0) {
                // --- Date period is valid ---
                $aperiodTemp = array_values($period_block);
                $delimiter = " - ";
                // --- Get the time offset. ---
                $offset = JFactory::getApplication()->get('offset');
                foreach ($aperiodTemp as $pKey => $pValue):
                    $adateTemp = explode($delimiter, trim($pValue));
                    $sStart = JFactory::getDate(trim($adateTemp[0]), $offset)->toSql(); // false: Time Zone of SQL (user_utc), default false
                    $sExpiry = JFactory::getDate(trim($adateTemp[1]), $offset)->toSql();
                    $aperiodTemp[$pKey] = $sStart . " - " . $sExpiry;
                endforeach;
                // --- /.Get the time offset. ---
                $registry = new Registry(array_values($aperiodTemp));
                $data['period_block'] = (string) $registry; // json
                $data['block_in_date'] = 1;
            }else {
                $data['period_block'] = '{}'; // json
                $data['block_in_date'] = 0;
            }
        } else {
            $data['period_block'] = '{}'; // json
            $data['block_in_date'] = 0;
        }
        // === /.Chu y: Time Zone of SQL --- fixed case then ===
        // Alter the title for save as copy
        if ($input->get('task') == 'save2copy') {
            $origTable = clone $this->getTable();
            $origTable->load($input->getInt('id'));

            if ($data['title'] == $origTable->title) {
                list($title, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['title']);
                $data['title'] = $title;
                $data['alias'] = $alias;
            } else {
                if ($data['alias'] == $origTable->alias) {
                    $data['alias'] = '';
                }
            }

            if (utf8_strtolower(trim($data['code'])) == utf8_strtolower(trim($origTable->code))) {
                list($code) = $this->generateNewCode($data['catid'], utf8_strtolower(trim($data['code'])));
                $data['code'] = $code;
            } else {
                if ($data['code'] == $origTable->code) {
                    $data['code'] = '';
                }
            }

            $data['state'] = 0;
        }

        // Automatic handling of alias for empty fields
        if (in_array($input->get('task'), array('apply', 'save', 'save2new')) && (!isset($data['id']) || (int) $data['id'] == 0)) {
            if ($data['alias'] == null) {
                if (JFactory::getConfig()->get('unicodeslugs') == 1) {
                    $data['alias'] = JFilterOutput::stringURLUnicodeSlug($data['title']);
                } else {
                    $data['alias'] = JFilterOutput::stringURLSafe($data['title']);
                }

                //$table = JTable::getInstance('Standard', 'JTable');
                $table = JTable::getInstance('Combo', 'StandardTable'); // C1: Binh Nguyen
                //$table = $this->getTable();// C2: Binh Nguyen
                if ($table->load(array('alias' => $data['alias'], 'catid' => $data['catid']))) {
                    $msg = JText::_('COM_STANDARD_SAVE_WARNING');
                }

                list($title, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['title']);
                $data['alias'] = $alias;

                if (isset($msg)) {
                    JFactory::getApplication()->enqueueMessage($msg, 'warning');
                }
            }
        }

        $data['code'] = JFilterOutput::stringURLUnicodeSlug($data['code']);
        if (parent::save($data)) {

            if (isset($data['featured'])) {
                $this->featured($this->getState($this->getName() . '.id'), $data['featured']);
            }

            if (isset($data['manufacturer_id'])) {
                if ($data['id'] > 0) {
                    $action = 'set'; // edit
                } else {
                    $action = 'add';
                }
            } else {
                $action = 'del';
            }
            // $this->comboManufacturerMapping($this->getState($this->getName() . '.id'), $data['manufacturer_id'], $action);

            return true;
        }

        return false;
    }

    /**
     * Method to toggle the featured setting of combos.
     *
     * @param   array    $pks    The ids of the items to toggle.
     * @param   integer  $value  The value to toggle to.
     *
     * @return  boolean  True on success.
     */
    public function featured($pks, $value = 0) {
        // Sanitize the ids.
        $pks = (array) $pks;
        JArrayHelper::toInteger($pks);

        if (empty($pks)) {
            $this->setError(JText::_('COM_STANDARD_NO_ITEM_SELECTED'));

            return false;
        }

        $table = $this->getTable('Featured', 'StandardTable');

        try {
            $db = $this->getDbo();
            $query = $db->getQuery(true)
                    ->update($db->quoteName('#__standard_combos'))
                    ->set('featured = ' . (int) $value)
                    ->where('id IN (' . implode(',', $pks) . ')');
            $db->setQuery($query);
            $db->execute();

            if ((int) $value == 0) {
                // Adjust the mapping table.
                // Clear the existing features settings.
                $this->deleteComboMapping($pks, array(0 => "#__standard_combos_frontpage"));
            } else {
                // First, we find out which of our new featured combos are already featured.
                $query = $db->getQuery(true)
                        ->select('f.combo_id')
                        ->from('#__standard_combos_frontpage AS f')
                        ->where('combo_id IN (' . implode(',', $pks) . ')');
                $db->setQuery($query);

                $old_featured = $db->loadColumn();

                // We diff the arrays to get a list of the combos that are newly featured
                $new_featured = array_diff($pks, $old_featured);

                // Featuring.
                $tuples = array();

                foreach ($new_featured as $pk) {
                    $tuples[] = $pk . ', 0';
                }

                if (count($tuples)) {
                    $db = $this->getDbo();
                    $columns = array('combo_id', 'ordering');
                    $query = $db->getQuery(true)
                            ->insert($db->quoteName('#__standard_combos_frontpage'))
                            ->columns($db->quoteName($columns))
                            ->values($tuples);
                    $db->setQuery($query);
                    $db->execute();
                }
            }
        } catch (Exception $e) {
            $this->setError($e->getMessage());

            return false;
        }

        $table->reorder();

        $this->cleanCache();

        return true;
    }

    public function comboManufacturerMapping($combo_id, $manufacturer_ids, $action) {
        $db = $this->getDbo();
        $manufacturer_ids = (array) $manufacturer_ids;
        JArrayHelper::toInteger($manufacturer_ids);

        switch ($action) {
            // Sets combos to a selected combo
            case 'set':
                $doDelete = 'all';
                $doAssign = true;
                break;

            // Remove combos from a selected combo
            case 'del':
                $doDelete = 'combo';
                break;

            // Add combos to a selected combo
            case 'add':
            default:
                $doAssign = true;
                break;
        }

        // Remove the combos from the combo if requested.
        if (isset($doDelete)) {
            $this->deleteComboMapping($combo_id, array(0 => "#__standard_combo_manufacturer_map"));
        }
        // Remove the combos from the combo if requested.
        if (isset($doAssign)) {
            $query = $db->getQuery(true);
            // First, we need to check if the combo is already assigned to a room type
            $query->select($db->quoteName('manufacturer_id'))
                    ->from($db->quoteName('#__standard_combo_manufacturer_map'))
                    ->where($db->quoteName('combo_id') . ' = ' . (int) $combo_id);
            $db->setQuery($query);
            $manufacturers = $db->loadColumn();

            // Build the values clause for the assignment query.
            $query->clear();
            $combos = false;

            foreach ($manufacturer_ids as $id) {
                if (!in_array($id, $manufacturers)) {
                    $query->values($id . ',' . $combo_id);
                    $combos = true;
                }
            }

            $query->insert($db->quoteName('#__standard_combo_manufacturer_map'))
                    ->columns(array($db->quoteName('manufacturer_id'), $db->quoteName('combo_id')));
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
                ->from('#__standard_combo_manufacturer_map')
                ->where($db->quoteName('combo_id') . ' = ' . (int) $pk);

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadColumn();
    }

    public function deleteComboMapping($pks, $tbs = NULL) {
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
                    ->where($db->quoteName('combo_id') . ' IN (' . implode(',', $pks) . ')');
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

    protected function getItemArrayPathsCurrent($data, $iKeyFile, $sSuffix, $isMulti = 0) {
        if (!class_exists('ImageHelper')) {
            JLoader::register('ImageHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/image.php');
        }
        $aPathsCurrent = array();
        $imageHelper = new ImageHelper(JComponentHelper::getParams('com_standard'));
        foreach ($imageHelper->sizes() as $value) {
            $aPathsCurrent["image_$value"] = "";
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
        return $aPathsCurrent;
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
     * A protected method to get a set of ordering conditions.
     *
     * @param   object  $table  A record object.
     *
     * @return  array  An array of conditions to add to add to ordering queries.
     *
     * @since   1.6
     */
    protected function getReorderConditions($table) {
        $condition = array();
        $condition[] = 'catid = ' . (int) $table->catid;

        return $condition;
    }

    /**
     * Allows preprocessing of the JForm object.
     *
     * @param   JForm   $form   The form object
     * @param   array   $data   The data to be merged into the form object
     * @param   string  $group  The plugin group to be executed
     *
     * @return  void
     *
     * @since    3.0
     */
    protected function preprocessForm(JForm $form, $data, $group = 'content') {
        if ($this->canCreateCategory()) {
            $form->setFieldAttribute('catid', 'allowAdd', 'true');
        }

        // Association content items
        $assoc = JLanguageAssociations::isEnabled();

        if ($assoc) {
            $languages = JLanguageHelper::getLanguages('lang_code');
            $addform = new SimpleXMLElement('<form />');
            $fields = $addform->addChild('fields');
            $fields->addAttribute('name', 'associations');
            $fieldset = $fields->addChild('fieldset');
            $fieldset->addAttribute('name', 'item_associations');
            $fieldset->addAttribute('description', 'COM_STANDARD_ITEM_ASSOCIATIONS_FIELDSET_DESC');
            $add = false;

            foreach ($languages as $tag => $language) {
                if (empty($data->language) || $tag != $data->language) {
                    $add = true;
                    $field = $fieldset->addChild('field');
                    $field->addAttribute('name', $tag);
                    $field->addAttribute('type', 'modal_combo');
                    $field->addAttribute('language', $tag);
                    $field->addAttribute('label', $language->title);
                    $field->addAttribute('translate_label', 'false');
                    $field->addAttribute('edit', 'true');
                    $field->addAttribute('clear', 'true');
                }
            }

            if ($add) {
                $form->load($addform, false);
            }
        }

        parent::preprocessForm($form, $data, $group);
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
        parent::cleanCache('mod_combos_archive');
        parent::cleanCache('mod_combos_categories');
        parent::cleanCache('mod_combos_category');
        parent::cleanCache('mod_combos_latest');
        parent::cleanCache('mod_combos_news');
        parent::cleanCache('mod_combos_popular');
        parent::cleanCache('mod_marquee');
        parent::cleanCache('mod_carousel');
        parent::cleanCache('mod_video');
        parent::cleanCache('mod_utilities');
    }

    /**
     * Void hit function for pagebreak when editing content from frontend
     *
     * @return  void
     *
     * @since   3.6.0
     */
    public function hit() {
        return;
    }

    /**
     * Is the user allowed to create an on the fly category?
     *
     * @return  boolean
     *
     * @since   3.6.1
     */
    private function canCreateCategory() {
        return JFactory::getUser()->authorise('core.create', 'com_standard');
    }

    protected function generateNewCode($catid, $code) {
        // Alter code
        $table = $this->getTable();
        while ($table->load(array('code' => $code, 'catid' => $catid))) {
            $code = JString::increment($code, 'dash');
        }

        return array($code);
    }

}
