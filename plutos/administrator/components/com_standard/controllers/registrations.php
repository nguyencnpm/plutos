<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

/**
 * Registrations list controller class.
 *
 * @since  1.6
 */
class StandardControllerRegistrations extends JControllerAdmin {

    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'COM_STANDARD_REGISTRATIONS';

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);

        $this->registerTask('publish', 'status');
        $this->registerTask('unpublish', 'status');
        $this->registerTask('unarchive', 'status');
        $this->registerTask('untrash', 'status');
    }

    public function status() {
        // Check for request forgeries
        \JSession::checkToken() or die(\JText::_('JINVALID_TOKEN'));

        // Get items to publish from the request.
        $cid = $this->input->get('cid', array(), 'array');
        $data = array('publish' => 1, 'unpublish' => 0, 'archive' => 2, 'trash' => -2, 'report' => -3);
        $task = $this->getTask();
        $value = ArrayHelper::getValue($data, $task, 0, 'int');

        if (empty($cid)) {
            \JLog::add(\JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), \JLog::WARNING, 'jerror');
        } else {
            // Get the model.
            $model = $this->getModel();

            // Make sure the item ids are integers
            $cid = ArrayHelper::toInteger($cid);

            // Publish the items.
            try {
                $model->status($cid, $value);
                $errors = $model->getErrors();
                $ntext = null;

                if ($value === 1) {
                    if ($errors) {
                        \JFactory::getApplication()->enqueueMessage(\JText::plural($this->text_prefix . '_N_ITEMS_FAILED_PUBLISHING', count($cid)), 'error');
                    } else {
                        $ntext = $this->text_prefix . '_N_ITEMS_PUBLISHED';
                    }
                } elseif ($value === 0) {
                    $ntext = $this->text_prefix . '_N_ITEMS_UNPUBLISHED';
                } elseif ($value === 2) {
                    $ntext = $this->text_prefix . '_N_ITEMS_ARCHIVED';
                } else {
                    $ntext = $this->text_prefix . '_N_ITEMS_TRASHED';
                }

                if ($ntext !== null) {
                    $this->setMessage(\JText::plural($ntext, count($cid)));
                }
            } catch (\Exception $e) {
                $this->setMessage($e->getMessage(), 'error');
            }
        }

        $extension = $this->input->get('extension');
        $extensionURL = $extension ? '&extension=' . $extension : '';
        $this->setRedirect(\JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list . $extensionURL, false));
    }

    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  The array of possible config values. Optional.
     *
     * @return  JModel
     *
     * @since   1.6
     */
    public function getModel($name = 'Registration', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }

    /**
     * Override delete method to add the image processing
     */
    public function delete() {
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        $input = JFactory::getApplication()->input;
        $pks = $input->post->get('cid');
        // Get the model.
        $model = $this->getModel();
        /*
        // delete previous files
        if (!$model->deleteImage($pks)) {
            JError::raiseWarning(500, $model->getError());
        }
        */
        // standard joomla delete
        parent::delete();
    }

    /**
     * Function that allows child controller access to model data
     * after the item has been deleted.
     *
     * @param   JModelLegacy  $model  The data model object.
     * @param   integer       $ids    The array of ids for items being deleted.
     *
     * @return  void
     *
     * @since   12.2
     */
    protected function postDeleteHook(JModelLegacy $model, $ids = null) {
        if (!empty($ids)) {
            
        }
    }

}
