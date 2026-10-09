<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Combos list controller class.
 *
 * @since  1.6
 */
class StandardControllerCombos extends JControllerAdmin {
    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'COM_STANDARD_COMBOS';
    
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

        // Combos default form can come from the combos or featured view.
        // Adjust the redirect view on the value of 'view' in the request.
        if ($this->input->get('view') == 'featured') {
            $this->view_list = 'featured';
        }

        $this->registerTask('unfeatured', 'featured');
        
        // Combos default form can come from the combotypes or combo block view.
        // Adjust the redirect view on the value of 'view' in the request.
        if ($this->input->get('view') == 'combolocks') {
            $this->view_list = 'combolocks';
        }
    }

    /**
     * Method to toggle the featured setting of a list of combos.
     *
     * @return  void
     *
     * @since   1.6
     */
    public function featured() {
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $user = JFactory::getUser();
        $ids = $this->input->get('cid', array(), 'array');
        $values = array('featured' => 1, 'unfeatured' => 0);
        $task = $this->getTask();
        $value = JArrayHelper::getValue($values, $task, 0, 'int');

        // Access checks.
        foreach ($ids as $i => $id) {
            if (!$user->authorise('core.edit.state', 'com_standard.combo.' . (int) $id)) {
                // Prune items that you can't change.
                unset($ids[$i]);
                JError::raiseNotice(403, JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
            }
        }

        if (empty($ids)) {
            JError::raiseWarning(500, JText::_('JERROR_NO_ITEMS_SELECTED'));
        } else {
            // Get the model.
            $model = $this->getModel();

            // Publish the items.
            if (!$model->featured($ids, $value)) {
                JError::raiseWarning(500, $model->getError());
            }

            if ($value == 1) {
                $message = JText::plural('COM_STANDARD_N_ITEMS_FEATURED', count($ids));
            } else {
                $message = JText::plural('COM_STANDARD_N_ITEMS_UNFEATURED', count($ids));
            }
        }

        $view = $this->input->get('view', '');

        if ($view == 'featured') :
            $this->setRedirect(JRoute::_('index.php?option=com_standard&view=featured', false), $message);
        elseif ($view == 'comboblocks') :
            $this->setRedirect(JRoute::_('index.php?option=com_standard&view=comboblocks', false), $message);
        else:
            $this->setRedirect(JRoute::_('index.php?option=com_standard&view=combos', false), $message);
        endif;
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
    public function getModel($name = 'Combo', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
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
        $aColumn = array(0 => "images", 1 => "banners");
        // Get the model.
        $model = $this->getModel();
        // delete previous files
        if (!$model->deleteImage($pks, $aColumn)) {
            JError::raiseWarning(500, $model->getError());
        }
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
            $model->deleteComboMapping($ids, array(0 => "#__standard_combos_frontpage", 1 => "#__standard_combo_manufacturer_map"));
        }
    }

}
