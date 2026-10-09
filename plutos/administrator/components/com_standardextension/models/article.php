<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standardextension
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

JLoader::register('StandardextensionHelper', JPATH_ADMINISTRATOR . '/components/com_standardextension/helpers/standardextension.php');

/**
 * Item Model for an Article.
 *
 * @since  1.6
 */
class StandardextensionModelArticle extends JModelAdmin {

    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'COM_STANDARDEXTENSION';

    /**
     * The type alias for this content type (for example, 'com_standardextension.article').
     *
     * @var    string
     * @since  3.2
     */
    public $typeAlias = 'com_standardextension.article';

    /**
     * The context used for the associations table
     *
     * @var    string
     * @since  3.4.4
     */
    protected $associationsContext = 'com_standardextension.item';

    /**
     * Function that can be overriden to do any data cleanup after batch copying data
     *
     * @param   \JTableInterface  $table  The table object containing the newly created item
     * @param   integer           $newId  The id of the new item
     * @param   integer           $oldId  The original item id
     *
     * @return  void
     *
     * @since  3.8.12
     */
    protected function cleanupPostBatchCopy(\JTableInterface $table, $newId, $oldId) {
        // Check if the article was featured and update the #__standardextension_content_frontpage table
        if ($table->featured == 1) {
            $db = $this->getDbo();
            $query = $db->getQuery(true)
                    ->insert($db->quoteName('#__standardextension_content_frontpage'))
                    ->values($newId . ', 0');
            $db->setQuery($query);
            $db->execute();
        }

        // Register FieldsHelper
        JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');

        $oldItem = $this->getTable();
        $oldItem->load($oldId);
        $fields = FieldsHelper::getFields('com_standardextension.article', $oldItem, true);

        $fieldsData = array();

        if (!empty($fields)) {
            $fieldsData['com_fields'] = array();

            foreach ($fields as $field) {
                $fieldsData['com_fields'][$field->name] = $field->rawvalue;
            }
        }

        JEventDispatcher::getInstance()->trigger('onContentAfterSave', array('com_standardextension.article', &$this->table, true, $fieldsData));
    }

    /**
     * Batch move categories to a new category.
     *
     * @param   integer  $value     The new category ID.
     * @param   array    $pks       An array of row IDs.
     * @param   array    $contexts  An array of item contexts.
     *
     * @return  boolean  True on success.
     *
     * @since   3.8.6
     */
    protected function batchMove($value, $pks, $contexts) {
        if (empty($this->batchSet)) {
            // Set some needed variables.
            $this->user = JFactory::getUser();
            $this->table = $this->getTable();
            $this->tableClassName = get_class($this->table);
            $this->contentType = new JUcmType;
            $this->type = $this->contentType->getTypeByTable($this->tableClassName);
        }

        $categoryId = (int) $value;

        if (!$this->checkCategoryId($categoryId)) {
            return false;
        }

        JPluginHelper::importPlugin('system');
        $dispatcher = JEventDispatcher::getInstance();

        // Register FieldsHelper
        JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');

        // Parent exists so we proceed
        foreach ($pks as $pk) {
            if (!$this->user->authorise('core.edit', $contexts[$pk])) {
                $this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));

                return false;
            }

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

            $fields = FieldsHelper::getFields('com_standardextension.article', $this->table, true);
            $fieldsData = array();

            if (!empty($fields)) {
                $fieldsData['com_fields'] = array();

                foreach ($fields as $field) {
                    $fieldsData['com_fields'][$field->name] = $field->rawvalue;
                }
            }

            // Set the new category ID
            $this->table->catid = $categoryId;

            // Check the row.
            if (!$this->table->check()) {
                $this->setError($this->table->getError());

                return false;
            }

            if (!empty($this->type)) {
                $this->createTagsHelper($this->tagsObserver, $this->type, $pk, $this->typeAlias, $this->table);
            }

            // Store the row.
            if (!$this->table->store()) {
                $this->setError($this->table->getError());

                return false;
            }

            // Run event for moved article
            $dispatcher->trigger('onContentAfterSave', array('com_standardextension.article', &$this->table, false, $fieldsData));
        }

        // Clean the cache
        $this->cleanCache();

        return true;
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
        if (empty($record->id) || $record->state != -2) {
            return false;
        }

        return JFactory::getUser()->authorise('core.delete', 'com_standardextension.article.' . (int) $record->id);
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

        // Check for existing article.
        if (!empty($record->id)) {
            return $user->authorise('core.edit.state', 'com_standardextension.article.' . (int) $record->id);
        }

        // New article, so check against the category.
        if (!empty($record->catid)) {
            return $user->authorise('core.edit.state', 'com_standardextension.category.' . (int) $record->catid);
        }

        // Default to component settings if neither article nor category known.
        return parent::canEditState($record);
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
        if ($table->state == 1 && (int) $table->publish_up == 0) {
            $table->publish_up = JFactory::getDate()->toSql();
        }

        if ($table->state == 1 && intval($table->publish_down) == 0) {
            $table->publish_down = $this->getDbo()->getNullDate();
        }

        // Increment the content version number.
        $table->version++;

        // Reorder the articles within the category so the new article is first
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
    public function getTable($type = 'Content', $prefix = 'StandardextensionTable', $config = array()) {
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
            // Convert the params field to an array.
            $registry = new Registry($item->attribs);
            $item->attribs = $registry->toArray();

            // Convert the metadata field to an array.
            $registry = new Registry($item->metadata);
            $item->metadata = $registry->toArray();
            /*
            // Convert the images field to an array.
            $registry = new Registry($item->images);
            $item->images = $registry->toArray();
            */
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

            // Convert the links field to an array.
            $registry = new Registry($item->links);
            $item->links = $registry->toArray();
            
            // Convert the videos field to an array.
            $registry = new Registry($item->videos);
            $item->videos = $registry->toArray();
            
            // Convert the urls field to an array.
            $registry = new Registry($item->urls);
            $item->urls = $registry->toArray();

            $item->articletext = trim($item->fulltext) != '' ? $item->introtext . "<hr id=\"system-readmore\" />" . $item->fulltext : $item->introtext;

            if (!empty($item->id)) {
                $item->tags = new JHelperTags;
                $item->tags->getTagIds($item->id, 'com_standardextension.article');
            }
        }

        // Load associated content items
        $assoc = JLanguageAssociations::isEnabled();

        if ($assoc) {
            $item->associations = array();

            if ($item->id != null) {
                $associations = JLanguageAssociations::getAssociations('com_standardextension', '#__standardextension_content', 'com_standardextension.item', $item->id);

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
     * @return  JForm|boolean  A JForm object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true) {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();

        // Get the form.
        $form = $this->loadForm('com_standardextension.article', 'article', array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form)) {
            return false;
        }

        $jinput = JFactory::getApplication()->input;

        /*
         * The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.
         * The back end uses id so we use that the rest of the time and set it to 0 by default.
         */
        $id = $jinput->get('a_id', $jinput->get('id', 0));

        // Determine correct permissions to check.
        if ($this->getState('article.id')) {
            $id = $this->getState('article.id');

            // Existing record. Can only edit in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.edit');

            // Existing record. Can only edit own articles in selected categories.
            if ($app->isClient('administrator')) {
                $form->setFieldAttribute('catid', 'action', 'core.edit.own');
            } else {
                // Existing record. We can't edit the category in frontend if not edit.state.
                if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standardextension.article.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standardextension'))) {
                    $form->setFieldAttribute('catid', 'readonly', 'true');
                    $form->setFieldAttribute('catid', 'filter', 'unset');
                }
            }
        } else {
            // New record. Can only create in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.create');
        }

        // Check for existing article.
        // Modify the form based on Edit State access controls.
        if ($id != 0 && (!$user->authorise('core.edit.state', 'com_standardextension.article.' . (int) $id)) || ($id == 0 && !$user->authorise('core.edit.state', 'com_standardextension'))) {
            // Disable fields for display.
            $form->setFieldAttribute('featured', 'disabled', 'true');
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is an article you can edit.
            $form->setFieldAttribute('featured', 'filter', 'unset');
            $form->setFieldAttribute('ordering', 'filter', 'unset');
            $form->setFieldAttribute('publish_up', 'filter', 'unset');
            $form->setFieldAttribute('publish_down', 'filter', 'unset');
            $form->setFieldAttribute('state', 'filter', 'unset');
        }

        // Prevent messing with article language and category when editing existing article with associations
        $assoc = JLanguageAssociations::isEnabled();

        // Check if article is associated
        if ($this->getState('article.id') && $app->isClient('site') && $assoc) {
            $associations = JLanguageAssociations::getAssociations('com_standardextension', '#__standardextension_content', 'com_standardextension.item', $id);

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
        $data = $app->getUserState('com_standardextension.edit.article.data', array());

        if (empty($data)) {
            $data = $this->getItem();

            // Pre-select some filters (Status, Category, Language, Access) in edit form if those have been selected in Article Manager: Articles
            if ($this->getState('article.id') == 0) {
                $filters = (array) $app->getUserState('com_standardextension.articles.filter');
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

        $this->preprocessData('com_standardextension.article', $data);

        return $data;
    }

    /**
     * Method to validate the form data.
     *
     * @param   JForm   $form   The form to validate against.
     * @param   array   $data   The data to validate.
     * @param   string  $group  The name of the field group to validate.
     *
     * @return  array|boolean  Array of filtered data if valid, false otherwise.
     *
     * @see     JFormRule
     * @see     JFilterInput
     * @since   3.7.0
     */
    public function validate($form, $data, $group = null) {
        // Don't allow to change the users if not allowed to access com_users.
        if (JFactory::getApplication()->isClient('administrator') && !JFactory::getUser()->authorise('core.manage', 'com_users')) {
            if (isset($data['created_by'])) {
                unset($data['created_by']);
            }

            if (isset($data['modified_by'])) {
                unset($data['modified_by']);
            }
        }

        return parent::validate($form, $data, $group);
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
          $registry = new Registry($data['images']);

          $data['images'] = (string) $registry;
          }
         */
        // ====== =====
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
            $folder = "articles/descriptions";
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
        $folder = "articles";
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
            $folder = "articles/childimages";
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
        $folderBanner = "articles/banners";

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
        $folderBannerTablet = "articles/banners/tablets";

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
        $folderBannerPhone = "articles/banners/phones";

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
        // --- videos ---
        $data['videos'] = '{}';
        $aVideos = $input->post->get('jform', array(), 'array')['videos'];
        $aVideosTemp = $aVideos;
        if (isset($aVideos) && is_array($aVideos)) :
            $sSuffix = "videos";
            $folder = "articles/video_thumbnails";
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
        // ====== ====

        JLoader::register('CategoriesHelper', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/categories.php');

        // Cast catid to integer for comparison
        $catid = (int) $data['catid'];

        // Check if New Category exists
        if ($catid > 0) {
            $catid = CategoriesHelper::validateCategoryId($data['catid'], 'com_standardextension');
        }

        // Save New Category
        if ($catid == 0 && $this->canCreateCategory()) {
            $table = array();
            $table['title'] = $data['catid'];
            $table['parent_id'] = 1;
            $table['extension'] = 'com_standardextension';
            $table['language'] = $data['language'];
            $table['published'] = 1;

            // Create new category and get catid back
            $data['catid'] = CategoriesHelper::createCategory($table);
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

            $registry = new Registry($data['urls']);

            $data['urls'] = (string) $registry;
        }

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

                $table = JTable::getInstance('Content', 'JTable');

                if ($table->load(array('alias' => $data['alias'], 'catid' => $data['catid']))) {
                    $msg = JText::_('COM_STANDARDEXTENSION_SAVE_WARNING');
                }

                list($title, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['title']);
                $data['alias'] = $alias;

                if (isset($msg)) {
                    JFactory::getApplication()->enqueueMessage($msg, 'warning');
                }
            }
        }

        if (parent::save($data)) {
            if (isset($data['featured'])) {
                $this->featured($this->getState($this->getName() . '.id'), $data['featured']);
            }

            return true;
        }

        return false;
    }

    /**
     * Method to toggle the featured setting of articles.
     *
     * @param   array    $pks    The ids of the items to toggle.
     * @param   integer  $value  The value to toggle to.
     *
     * @return  boolean  True on success.
     */
    public function featured($pks, $value = 0) {
        // Sanitize the ids.
        $pks = (array) $pks;
        $pks = ArrayHelper::toInteger($pks);

        if (empty($pks)) {
            $this->setError(JText::_('COM_STANDARDEXTENSION_NO_ITEM_SELECTED'));

            return false;
        }

        $table = $this->getTable('Featured', 'StandardextensionTable');

        try {
            $db = $this->getDbo();
            $query = $db->getQuery(true)
                    ->update($db->quoteName('#__standardextension_content'))
                    ->set('featured = ' . (int) $value)
                    ->where('id IN (' . implode(',', $pks) . ')');
            $db->setQuery($query);
            $db->execute();

            if ((int) $value == 0) {
                // Adjust the mapping table.
                // Clear the existing features settings.
                $query = $db->getQuery(true)
                        ->delete($db->quoteName('#__standardextension_content_frontpage'))
                        ->where('content_id IN (' . implode(',', $pks) . ')');
                $db->setQuery($query);
                $db->execute();
            } else {
                // First, we find out which of our new featured articles are already featured.
                $query = $db->getQuery(true)
                        ->select('f.content_id')
                        ->from('#__standardextension_content_frontpage AS f')
                        ->where('content_id IN (' . implode(',', $pks) . ')');
                $db->setQuery($query);

                $oldFeatured = $db->loadColumn();

                // We diff the arrays to get a list of the articles that are newly featured
                $newFeatured = array_diff($pks, $oldFeatured);

                // Featuring.
                $tuples = array();

                foreach ($newFeatured as $pk) {
                    $tuples[] = $pk . ', 0';
                }

                if (count($tuples)) {
                    $columns = array('content_id', 'ordering');
                    $query = $db->getQuery(true)
                            ->insert($db->quoteName('#__standardextension_content_frontpage'))
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
        return array('catid = ' . (int) $table->catid);
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
     * @since   3.0
     */
    protected function preprocessForm(JForm $form, $data, $group = 'content') {
        if ($this->canCreateCategory()) {
            $form->setFieldAttribute('catid', 'allowAdd', 'true');
        }

        // Association content items
        if (JLanguageAssociations::isEnabled()) {
            $languages = JLanguageHelper::getContentLanguages(false, true, null, 'ordering', 'asc');

            if (count($languages) > 1) {
                $addform = new SimpleXMLElement('<form />');
                $fields = $addform->addChild('fields');
                $fields->addAttribute('name', 'associations');
                $fieldset = $fields->addChild('fieldset');
                $fieldset->addAttribute('name', 'item_associations');

                foreach ($languages as $language) {
                    $field = $fieldset->addChild('field');
                    $field->addAttribute('name', $language->lang_code);
                    $field->addAttribute('type', 'modal_article');
                    $field->addAttribute('language', $language->lang_code);
                    $field->addAttribute('label', $language->title);
                    $field->addAttribute('translate_label', 'false');
                    $field->addAttribute('select', 'true');
                    $field->addAttribute('new', 'true');
                    $field->addAttribute('edit', 'true');
                    $field->addAttribute('clear', 'true');
                    $field->addAttribute('propagate', 'true');
                }

                $form->load($addform, false);
            }
        }

        parent::preprocessForm($form, $data, $group);
    }

    /**
     * Custom clean the cache of com_standardextension and content modules
     *
     * @param   string   $group      The cache group
     * @param   integer  $client_id  The ID of the client
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function cleanCache($group = null, $client_id = 0) {
        parent::cleanCache('com_standardextension');
        parent::cleanCache('mod_articles_archive');
        parent::cleanCache('mod_articles_categories');
        parent::cleanCache('mod_articles_category');
        parent::cleanCache('mod_articles_latest');
        parent::cleanCache('mod_articles_news');
        parent::cleanCache('mod_articles_popular');
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
        return JFactory::getUser()->authorise('core.create', 'com_standardextension');
    }

    /**
     * Delete #__standardextension_content_frontpage items if the deleted articles was featured
     *
     * @param   object  $pks  The primary key related to the contents that was deleted.
     *
     * @return  boolean
     *
     * @since   3.7.0
     */
    public function delete(&$pks) {
        $return = parent::delete($pks);

        if ($return) {
            // Now check to see if this articles was featured if so delete it from the #__standardextension_content_frontpage table
            $db = $this->getDbo();
            $query = $db->getQuery(true)
                    ->delete($db->quoteName('#__standardextension_content_frontpage'))
                    ->where('content_id IN (' . implode(',', $pks) . ')');
            $db->setQuery($query);
            $db->execute();
        }

        return $return;
    }

    public function deleteArticleMapping($pks, $tbs = NULL) {
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
                    ->where($db->quoteName('product_id') . ' IN (' . implode(',', $pks) . ')');
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

}
