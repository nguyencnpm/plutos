<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standardextension
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * View to edit an article.
 *
 * @since  1.6
 */
class StandardextensionViewArticle extends JViewLegacy {

    /**
     * The JForm object
     *
     * @var  JForm
     */
    protected $form;

    /**
     * The active item
     *
     * @var  object
     */
    protected $item;

    /**
     * The model state
     *
     * @var  object
     */
    protected $state;

    /**
     * The actions the user is authorised to perform
     *
     * @var  JObject
     */
    protected $canDo;

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
        if ($this->getLayout() == 'pagebreak') {
            return parent::display($tpl);
        }

        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->state = $this->get('State');
        $this->canDo = StandardextensionHelper::getActions('com_standardextension', 'article', $this->item->id);
        // --- description image ---
        $this->focus_view_descriptionimage = JURI::root(FALSE) . 'images/focus/banners/focus-banner.png';
        $this->focus_view_descriptionimage_alt = JText::_("Focus");
        $this->aFloatFullText = array(
            "" => JText::_('JGLOBAL_USE_GLOBAL'),
            "right" => JText::_('COM_STANDARDEXTENSION_RIGHT'),
            "left" => JText::_('COM_STANDARDEXTENSION_LEFT'),
            "none" => JText::_('COM_STANDARDEXTENSION_NONE')
        );

        $this->aEffect = array(
            "" => JText::_('COM_STANDARDEXTENSION_EFFECT_GLOBAL'),
            "parallax-scrolling fixed" => JText::_('COM_STANDARDEXTENSION_EFFECT_SCROLLING'),
            "parallax-scrolling scroll" => JText::_('COM_STANDARDEXTENSION_EFFECT_BACKGROUND')
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
        $this->focus_view_video = JURI::root(FALSE) . 'images/focus/small-thumbnail-video.png';
        $this->focus_view_video_alt = JText::_("Focus");
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        // If we are forcing a language in modal (used for associations).
        if ($this->getLayout() === 'modal' && $forcedLanguage = JFactory::getApplication()->input->get('forcedLanguage', '', 'cmd')) {
            // Set the language field to the forcedLanguage and disable changing it.
            $this->form->setValue('language', null, $forcedLanguage);
            $this->form->setFieldAttribute('language', 'readonly', 'true');

            // Only allow to select categories with All language or with the forced language.
            $this->form->setFieldAttribute('catid', 'language', '*,' . $forcedLanguage);

            // Only allow to select tags with All language or with the forced language.
            $this->form->setFieldAttribute('tags', 'language', '*,' . $forcedLanguage);
        }

        $this->addToolbar();

        return parent::display($tpl);
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
        $userId = $user->id;
        $isNew = ($this->item->id == 0);
        $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);

        // Built the actions for new and existing records.
        $canDo = $this->canDo;

        JToolbarHelper::title(
                JText::_('COM_STANDARDEXTENSION_PAGE_' . ($checkedOut ? 'VIEW_ARTICLE' : ($isNew ? 'ADD_ARTICLE' : 'EDIT_ARTICLE'))), 'pencil-2 article-add'
        );

        // For new records, check the create permission.
        if ($isNew && (count($user->getAuthorisedCategories('com_standardextension', 'core.create')) > 0)) {
            JToolbarHelper::apply('article.apply');
            JToolbarHelper::save('article.save');
            JToolbarHelper::save2new('article.save2new');
            JToolbarHelper::cancel('article.cancel');
        } else {
            // Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
            $itemEditable = $canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId);

            // Can't save the record if it's checked out and editable
            if (!$checkedOut && $itemEditable) {
                JToolbarHelper::apply('article.apply');
                JToolbarHelper::save('article.save');

                // We can save this record, but check the create permission to see if we can return to make a new one.
                if ($canDo->get('core.create')) {
                    JToolbarHelper::save2new('article.save2new');
                }
            }

            // If checked out, we can still save
            if ($canDo->get('core.create')) {
                JToolbarHelper::save2copy('article.save2copy');
            }

            if (JComponentHelper::isEnabled('com_standardextensionhistory') && $this->state->params->get('save_history', 0) && $itemEditable) {
                JToolbarHelper::versions('com_standardextension.article', $this->item->id);
            }

            if (JLanguageAssociations::isEnabled() && JComponentHelper::isEnabled('com_associations')) {
                JToolbarHelper::custom('article.editAssociations', 'contract', 'contract', 'JTOOLBAR_ASSOCIATIONS', false, false);
            }

            JToolbarHelper::cancel('article.cancel', 'JTOOLBAR_CLOSE');
        }

        //JToolbarHelper::divider();
        //JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER_EDIT');
    }

}
