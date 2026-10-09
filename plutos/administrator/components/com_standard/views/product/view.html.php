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
 * View to edit an product.
 *
 * @since  1.6
 */
class StandardViewProduct extends JViewLegacy {

    protected $form;
    protected $item;
    protected $state;

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
        // --- sortable ---
        // $document->addScript('components/com_standard/assets/js/jquery/jquery-ui.min.js');
        // --- /.sortable ---
        $document->addScript('components/com_standard/assets/js/daterangepicker/moment.min.js');
        $document->addScript('components/com_standard/assets/js/daterangepicker/daterangepicker.min.js');
        $document->addScript('components/com_standard/assets/js/bootstrap-year-calendar.min.js');

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

        $this->canDo = JHelperContent::getActions('com_standard', 'product', $this->item->id);
        // --- description image ---
        $this->focus_view_descriptionimage = JURI::root(FALSE) . 'images/focus/banners/focus-banner.png';
        $this->focus_view_descriptionimage_alt = JText::_("Focus");
        $this->aFloatFullText = array(
            "" => JText::_('JGLOBAL_USE_GLOBAL'),
            "right" => JText::_('COM_STANDARD_RIGHT'),
            "left" => JText::_('COM_STANDARD_LEFT'),
            "none" => JText::_('COM_STANDARD_NONE')
        );

        $this->aEffect = array(
            "" => JText::_('COM_STANDARD_EFFECT_GLOBAL'),
            "parallax-scrolling fixed" => JText::_('COM_STANDARD_EFFECT_SCROLLING'),
            "parallax-scrolling scroll" => JText::_('COM_STANDARD_EFFECT_BACKGROUND')
        );

        $this->aTargeta = array(
            "" => JText::_('Use Global (Open in parent window)'),
            "0" => JText::_('Open in parent window'),
            "1" => JText::_('Open in new window'),
            "2" => JText::_('Open in popup'),
            "3" => JText::_('Modal')
        );
        // --- /. description image ---
        $this->focus_view_image = JURI::root(FALSE) . 'images/focus/products/focus-product.png';
        if (empty($this->item->images['image_medium'])):
            $this->item->view_image = JURI::root(FALSE) . 'images/focus/products/focus-product.png';
            $this->item->view_image_alt = JText::_("Focus");
        else :
            $this->item->view_image = JURI::root(FALSE) . $this->item->images['image_medium'];
            $this->item->view_image_alt = empty($this->item->images['image_intro_alt']) ? $this->item->title : $this->item->images['image_intro_alt'];
        endif;


        //  --- banners ---
        if (empty($this->item->banners['image_medium'])):
            $this->item->view_banner = JURI::root(FALSE) . 'images/focus/banners/focus-banner.png';
            $this->item->view_banner_alt = JText::_("Focus");
        else :
            $this->item->view_banner = JURI::root(FALSE) . $this->item->banners['image_medium'];
            $this->item->view_banner_alt = empty($this->item->banners['banner_alt']) ? $this->item->title : $this->item->banners['banner_alt'];
        endif;

        if (empty($this->item->banners_tablet['image_medium'])):
            $this->item->view_banner_tablet = JURI::root(FALSE) . 'images/focus/banners/focus-banner.png';
            $this->item->view_banner_alt = JText::_("Focus");
        else :
            $this->item->view_banner_tablet = JURI::root(FALSE) . $this->item->banners_tablet['image_medium'];
            $this->item->view_banner_alt = empty($this->item->banners['banner_alt']) ? $this->item->title : $this->item->banners['banner_alt'];
        endif;

        if (empty($this->item->banners_phone['image_medium'])):
            $this->item->view_banner_phone = JURI::root(FALSE) . 'images/focus/banners/focus-banner.png';
            $this->item->view_banner_alt = JText::_("Focus");
        else :
            $this->item->view_banner_phone = JURI::root(FALSE) . $this->item->banners_phone['image_medium'];
            $this->item->view_banner_alt = empty($this->item->banners['banner_alt']) ? $this->item->title : $this->item->banners['banner_alt'];
        endif;
        //  --- /.banners ---

        $this->focus_view_gallery = JURI::root(FALSE) . 'images/focus/small-thumbnail-gallery.png';
        $this->focus_view_gallery_alt = JText::_("Focus");

        $this->focus_view_video = JURI::root(FALSE) . 'images/focus/small-thumbnail-video.png';
        $this->focus_view_video_alt = JText::_("Focus");

        $this->focus_view_plansimage = JURI::root(FALSE) . 'images/focus/small-thumbnail-gallery.png';
        $this->focus_view_plansimage_alt = JText::_("Focus");

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        if ($this->getLayout() == 'modal') {
            $this->form->setFieldAttribute('language', 'readonly', 'true');
            $this->form->setFieldAttribute('catid', 'readonly', 'true');
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
                JText::_('COM_STANDARD_PAGE_' . ($checkedOut ? 'VIEW_PRODUCT' : ($isNew ? 'ADD_PRODUCT' : 'EDIT_PRODUCT'))), 'pencil-2 article-add'
        );

        // For new records, check the create permission.
        if ($isNew && (count($user->getAuthorisedCategories('com_standard', 'core.create')) > 0)) {
            JToolbarHelper::apply('product.apply');
            JToolbarHelper::save('product.save');
            JToolbarHelper::save2new('product.save2new');
            JToolbarHelper::cancel('product.cancel');
        } else {
            // Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
            $itemEditable = $canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId);

            // Can't save the record if it's checked out and editable
            if (!$checkedOut && $itemEditable) {
                JToolbarHelper::apply('product.apply');
                JToolbarHelper::save('product.save');

                // We can save this record, but check the create permission to see if we can return to make a new one.
                if ($canDo->get('core.create')) {
                    JToolbarHelper::save2new('product.save2new');
                }
            }

            // If checked out, we can still save
            if ($canDo->get('core.create')) {
                JToolbarHelper::save2copy('product.save2copy');
            }

            if ($this->state->params->get('save_history', 0) && $itemEditable) {
                JToolbarHelper::versions('com_standard.product', $this->item->id);
            }

            JToolbarHelper::cancel('product.cancel', 'JTOOLBAR_CLOSE');
        }

        //JToolbarHelper::divider();
        //JToolbarHelper::help('JHELP_STANDARD_PRODUCT_MANAGER_EDIT');
    }

}
