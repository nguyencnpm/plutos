<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2018 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class StandardViewContact extends JViewLegacy {

    protected $item;
    protected $params;
    protected $print;
    protected $state;
    protected $user;
    protected $context = 'com_standard.contact';

    /**
     * Should we show a captcha form for the submission of the contact request?
     *
     * @var   bool
     * @since 3.6.3
     */
    protected $captchaEnabled = false;
    protected $isRenderModuleEnabled = false;

    public function display($tpl = null) {
        $app = JFactory::getApplication();
        $this->datainput = $app->input->getArray();
        $this->form = $this->get('Form');
        $this->state = $this->get('State');
        $this->params = $this->state->get('params');
        $this->modulesinfo = JModuleHelper::getModules('contact-info');
        $this->cContactForm = "post col-12";
        $this->cRenderModule = "";
        if (count($this->modulesinfo)):
            $this->cContactForm = "post d-flex col-12 col-md-6";
            $this->cRenderModule = "post d-flex col-12 col-md-6";
            $this->isRenderModuleEnabled = true;
        endif;

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseWarning(500, implode("\n", $errors));

            return false;
        }

        // 1 : MALE
        // 2 : FEMALE
        // 3 : OTHER
        $this->aGender = array(
            1 => JText::_('COM_STANDARD_MALE_SHORT'),
            2 => JText::_('COM_STANDARD_FEMALE_SHORT'),
            3 => JText::_('COM_STANDARD_OTHER_SHORT')
        );

        $captchaSet = $this->params->get('captcha', $app->get('captcha', '0'));

        foreach (JPluginHelper::getPlugin('captcha') as $plugin) {
            if ($captchaSet === $plugin->name) {
                $this->captchaEnabled = true;
                break;
            }
        }

        // Escape strings for HTML output
        $this->pageclass_sfx = htmlspecialchars($this->params->get('pageclass_sfx'));
        $this->_prepareDocument();

        parent::display($tpl);
    }

    /**
     * Prepares the document.
     *
     * @return  void.
     */
    protected function _prepareDocument() {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $pathway = $app->getPathway();
        $title = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();

        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('GLOBAL_CONTACT'));
        }

        $title = $this->params->get('page_title', '');

        //$id = (int) @$menu->query['id'];
        // If the menu item does not concern this contact
        if ($menu && ($menu->query['option'] !== 'com_standard' || $menu->query['view'] !== 'contact')) {//  || $id != $this->item->id
            // If a browser page title is defined, use that, then fall back to the contact title if set, then fall back to the page_title option
            $title = $this->item->params->get('contact_page_title', $this->item->title ?: $title);

            $path = array(array('title' => $this->item->title, 'link' => ''));
            foreach ($path as $item) {
                $pathway->addItem($item['title'], $item['link']);
            }
        }

        // Check for empty title and add site name if param is set
        if (empty($title)) {
            $title = $app->get('sitename');
        } elseif ($app->get('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        } elseif ($app->get('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }

        if (empty($title)) {
            $title = $this->item->title;
        }

        $this->document->setTitle($title);
        /*
          if ($this->item->metadesc) {
          $this->document->setDescription($this->item->metadesc);
          } elseif ($this->params->get('menu-meta_description')) {
          $this->document->setDescription($this->params->get('menu-meta_description'));
          }

          if ($this->item->metakey) {
          $this->document->setMetadata('keywords', $this->item->metakey);
          } elseif ($this->params->get('menu-meta_keywords')) {
          $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
          }
         */
        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
        /*
          $mdata = $this->item->metadata->toArray();

          foreach ($mdata as $k => $v) {
          if ($v) {
          $this->document->setMetadata($k, $v);
          }
          }
         */
        // If there is a pagebreak heading or title, add it to the page title
        if (!empty($this->item->page_title)) {
            $this->item->title = $this->item->title . ' - ' . $this->item->page_title;
            $this->document->setTitle(
                    $this->item->page_title . ' - ' . JText::sprintf('PLG_CONTENT_PAGEBREAK_PAGE_NUM', $this->state->get('list.offset') + 1)
            );
        }

        if ($this->print) {
            $this->document->setMetaData('robots', 'noindex, nofollow');
        }
    }

}
