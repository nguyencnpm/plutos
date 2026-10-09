<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * View to edit an rate.
 *
 * @since  1.6
 */
class StandardViewRate extends JViewLegacy {

    protected $form;
    protected $item;
    protected $state;
    protected $start_date;
    protected $expiry_date;

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise an Error object.
     *
     * @since   1.6
     */
    public function display($tpl = null) {

        $document = JFactory::getDocument();
        $document->addScript('components/com_standard/assets/js/ready.min.js');
        $document->addScript('components/com_standard/assets/js/ready-route.min.js');
        $document->addScript('components/com_standard/assets/js/ready-productcategory.min.js');
        $document->addScript('components/com_standard/assets/js/daterangepicker/moment.min.js');
        $document->addScript('components/com_standard/assets/js/daterangepicker/daterangepicker.min.js');

        $document->addScript('components/com_standard/assets/js/treeselectmenu.jquery.min.js');
        
        if ($this->getLayout() == 'pagebreak') {
            // TODO: This is really dogy - should change this one day.
            $input = JFactory::getApplication()->input;
            $eName = $input->getCmd('e_name');
            $eName = preg_replace('#[^A-Z0-9\-\_\[\]]#i', '', $eName);
            $document = JFactory::getDocument();
            $document->setTitle(JText::_('COM_STANDARD_PAGEBREAK_DOC_TITLE'));
            $this->eName = &$eName;
            parent::display($tpl);

            return;
        }

        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->state = $this->get('State');
        $this->canDo = JHelperContent::getActions('com_standard', 'rate', $this->item->id);

        $OjbNowDate = new JDate();
        $this->start_date = $OjbNowDate->format('Y-m-d');
        $OjbExpiry_date = new JDate($OjbNowDate . ' +1 month');
        $this->expiry_date = $OjbExpiry_date->format('Y-m-d');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        if ($this->getLayout() == 'modal') {
            $this->form->setFieldAttribute('language', 'readonly', 'true');
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
        $user = JFactory::getUser();
        $userId = $user->get('id');
        $isNew = ($this->item->id == 0);
        $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);

        // Built the actions for new and existing records.
        $canDo = $this->canDo;

        JToolbarHelper::title(
                JText::_('COM_STANDARD_PAGE_' . ($checkedOut ? 'VIEW_RATE' : ($isNew ? 'ADD_RATE' : 'EDIT_RATE'))), 'pencil-2 article-add'
        );

        // For new records, check the create permission.
        if ($isNew && (count($user->getAuthorisedCategories('com_standard', 'core.create')) > 0)) {
            JToolbarHelper::apply('rate.apply');
            JToolbarHelper::save('rate.save');
            JToolbarHelper::save2new('rate.save2new');
            JToolbarHelper::cancel('rate.cancel');
        } else {
            // Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
            $itemEditable = $canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId);

            // Can't save the record if it's checked out and editable
            if (!$checkedOut && $itemEditable) {
                JToolbarHelper::apply('rate.apply');
                JToolbarHelper::save('rate.save');

                // We can save this record, but check the create permission to see if we can return to make a new one.
                if ($canDo->get('core.create')) {
                    JToolbarHelper::save2new('rate.save2new');
                }
            }

            // If checked out, we can still save
            if ($canDo->get('core.create')) {
                JToolbarHelper::save2copy('rate.save2copy');
            }

            if ($this->state->params->get('save_history', 0) && $itemEditable) {
                JToolbarHelper::versions('com_standard.rate', $this->item->id);
            }

            JToolbarHelper::cancel('rate.cancel', 'JTOOLBAR_CLOSE');
        }

        //JToolbarHelper::divider();
        //JToolbarHelper::help('JHELP_STANDARD_RATE_MANAGER_EDIT');
    }

}
