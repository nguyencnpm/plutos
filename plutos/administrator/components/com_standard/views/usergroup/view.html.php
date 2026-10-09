<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * View to edit a travel agent group.
 *
 * @since  1.6
 */
class StandardViewUsergroup extends JViewLegacy {

    protected $form;

    /**
     * The item data.
     *
     * @var   object
     * @since 1.6
     */
    protected $item;

    /**
     * The model state.
     *
     * @var   JObject
     * @since 1.6
     */
    protected $state;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);
        $canDo = JHelperContent::getActions('com_standard');

        JToolbarHelper::title(JText::_($isNew ? 'COM_STANDARD_VIEW_NEW_USER_GROUP_TITLE' : 'COM_STANDARD_VIEW_EDIT_USER_GROUP_TITLE'), 'users groups-add');

        if ($canDo->get('core.edit') || $canDo->get('core.create')) {
            JToolbarHelper::apply('usergroup.apply');
            JToolbarHelper::save('usergroup.save');
        }

        if ($canDo->get('core.create')) {
            JToolbarHelper::save2new('usergroup.save2new');
        }

        // If an existing item, can save to a copy.
        if (!$isNew && $canDo->get('core.create')) {
            JToolbarHelper::save2copy('usergroup.save2copy');
        }

        if (empty($this->item->id)) {
            JToolbarHelper::cancel('usergroup.cancel');
        } else {
            JToolbarHelper::cancel('usergroup.cancel', 'JTOOLBAR_CLOSE');
        }

        //JToolbarHelper::divider();
        //JToolbarHelper::help('JHELP_USERS_USERGROUPS_EDIT');
    }

}
