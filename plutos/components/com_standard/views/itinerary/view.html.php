<?php

/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * HTML Itinerary View class for the Standard component
 *
 * @since  1.5
 */
class StandardViewItinerary extends JViewLegacy {

    protected $item;
    protected $params;
    protected $print;
    protected $state;
    protected $user;
    protected $captchaEnabled = false;
    protected $isRenderModuleEnabled = false;

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise an Error object.
     */
    public function display($tpl = null) {
        global $showModuleTitle;
        global $aInfoCurrent;
        global $list;
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        $dispatcher = JEventDispatcher::getInstance();

        $this->item = $this->get('Item');
        $this->print = $app->input->getBool('print');

        $this->form = $this->get('Form');
        $this->state = $this->get('State');

        // --- load page location (section scrolling form) ----
        $post_tourId = $app->getUserState('com_standard.filter.tour_id', 0);
        $this->isLoadPageLocation = false;
       
        if ($post_tourId):
            $this->isLoadPageLocation = true;
            $app->setUserState('com_standard.filter.tour_id', 0);
        endif;
        
        // --- /.load page location (section scrolling form) ----
        
        $this->user = $user;

        $overview = json_decode($this->item->overview, true);

        $this->isLinkRedirect = false;
        $this->aLinkRedirect = new stdClass();
        $this->aLinkARedirect = new stdClass();
        if (!empty($overview)):
            $model = $this->getModel();
            if (isset($overview['linktype']) && !empty($overview['linktype'])):
                $this->isLinkRedirect = true;

                $this->aLinkRedirect->linktype = $overview['linktype'];
                $this->aLinkRedirect->linkmenu = $overview['linkmenu'];
                $this->aLinkRedirect->linkurl = $overview['linkurl'];
                $this->aLinkRedirect->linkarticle = $overview['linkarticle'];
                $this->aLinkRedirect->url_type = $overview['url_type'];
                $this->aLinkRedirect->url_class_sfx = $overview['url_class_sfx'];
                $this->aLinkRedirect->urltext = $overview['urltext'];

                $this->aLinkRedirect->linktarget = $overview['linktarget'];
                $this->aLinkRedirect->url = $model->getLink($this->aLinkRedirect);
            endif;
            if (isset($overview['linkatype']) && !empty($overview['linkatype'])):
                $this->isLinkRedirect = true;

                $this->aLinkARedirect->linktype = $overview['linkatype'];
                $this->aLinkARedirect->linkmenu = $overview['linkamenu'];
                $this->aLinkARedirect->linkurl = $overview['linkaurl'];
                $this->aLinkARedirect->linkarticle = $overview['linkaarticle'];
                $this->aLinkARedirect->url_type = $overview['urla_type'];
                $this->aLinkARedirect->url_class_sfx = $overview['urla_class_sfx'];
                $this->aLinkARedirect->urltext = $overview['urlatext'];

                $this->aLinkARedirect->linktarget = $overview['linkatarget'];
                $this->aLinkARedirect->url = $model->getLink($this->aLinkARedirect);
            endif;
        endif;

        // get Template Params 
        $template = $app->getTemplate(true);
        $this->templateParams = $template->params;
        // Display Type
        $this->aDisplayType = array(
            '0' => 'global',
            '1' => 'article',
            '2' => 'treeview',
            '3' => 'gridworks',
            '4' => 'masonry'
        );

        // is payment type id
        /*
          $type = 'Product';
          $prefix = 'StandardTable';
          $config = array();
          $tableProduct = JTable::getInstance($type, $prefix, $config);
          $tableProduct->load($this->item->product_id);
          $this->item->paymenttype_id = $tableProduct->paymenttype_id;
         */
        switch ((int) $this->item->paymenttype_id) {
            case 11:
                $this->isForm = 0;
                break;
            default:
                $this->isForm = 1;
                break;
        }
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseWarning(500, implode("\n", $errors));

            return false;
        }

        // Create a shortcut for $item.
        $item = $this->item;
        $item->tagLayout = new JLayoutFile('joomla.content.tags');

        // Add router helpers.
        $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;
        $item->catslug = $item->itinerarytype_alias ? ($item->itinerarytype_id . ':' . $item->itinerarytype_alias) : $item->itinerarytype_id;
        $item->parent_slug = $item->parent_alias ? ($item->parent_id . ':' . $item->parent_alias) : $item->parent_id;

        // No link for ROOT itinerarytype
        if ($item->parent_alias === 'root') {
            $item->parent_slug = null;
        }

        // TODO: Change based on shownoauth
        $item->readmore_link = JRoute::_(StandardHelperRoute::getItineraryRoute($item->slug, $item->itinerarytype_id, $item->language));

        // Merge article params. If this is single-article view, menu params override article params
        // Otherwise, article params override menu item params
        $this->params = $this->state->get('params');
        $active = $app->getMenu()->getActive();
        $temp = clone $this->params;

        // Check to see which parameters should take priority
        if ($active) {
            $currentLink = $active->link;

            // If the current view is the active item and an article view for this article, then the menu item params take priority
            if (strpos($currentLink, 'view=article') && strpos($currentLink, '&id=' . (string) $item->id)) {
                // Load layout from active query (in case it is an alternative menu item)
                if (isset($active->query['layout'])) {
                    $this->setLayout($active->query['layout']);
                }
                // Check for alternative layout of article
                elseif ($layout = $item->params->get('article_layout')) {
                    $this->setLayout($layout);
                }

                // $item->params are the article params, $temp are the menu item params
                // Merge so that the menu item params take priority
                $item->params->merge($temp);
            } else {
                // Current view is not a single article, so the article params take priority here
                // Merge the menu item params with the article params so that the article params take priority
                $temp->merge($item->params);
                $item->params = $temp;

                // Check for alternative layouts (since we are not in a single-article menu item)
                // Single-article menu item layout takes priority over alt layout for an article
                if ($layout = $item->params->get('article_layout')) {
                    $this->setLayout($layout);
                }
            }
        } else {
            // Merge so that article params take priority
            $temp->merge($item->params);
            $item->params = $temp;

            // Check for alternative layouts (since we are not in a single-article menu item)
            // Single-article menu item layout takes priority over alt layout for an article
            if ($layout = $item->params->get('article_layout')) {
                $this->setLayout($layout);
            }
        }

        $offset = $this->state->get('list.offset');

        // Check the view access to the article (the model has already computed the values).
        if ($item->params->get('access-view') == false && ($item->params->get('show_noauth', '0') == '0')) {
            $app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');
            $app->setHeader('status', 403, true);

            return;
        }

        /**
         * Check for no 'access-view' and empty fulltext,
         * - Redirect guest users to login
         * - Deny access to logged users with 403 code
         * NOTE: we do not recheck for no access-view + show_noauth disabled ... since it was checked above
         */
        if ($item->params->get('access-view') == false && !strlen($item->fulltext)) {
            if ($this->user->get('guest')) {
                $return = base64_encode(JUri::getInstance());
                $login_url_with_return = JRoute::_('index.php?option=com_users&view=login&return=' . $return);
                $app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'notice');
                $app->redirect($login_url_with_return, 403);
            } else {
                $app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');
                $app->setHeader('status', 403, true);

                return;
            }
        }

        /**
         * NOTE: The following code (usually) sets the text to contain the fulltext, but it is the
         * responsibility of the layout to check 'access-view' and only use "introtext" for guests
         */
        if ($item->params->get('show_intro', '1') == '1') {
            $item->text = $item->introtext . ' ' . $item->fulltext;
        } elseif ($item->fulltext) {
            $item->text = $item->fulltext;
        } else {
            $item->text = $item->introtext;
        }

        $item->tags = new JHelperTags;
        $item->tags->getItemTags('com_content.article', $this->item->id);

        if ($item->params->get('show_associations')) {
            $item->associations = StandardHelperAssociation::displayAssociations($item->id);
        }

        // Process the content plugins.
        JPluginHelper::importPlugin('content');
        $dispatcher->trigger('onContentPrepare', array('com_content.article', &$item, &$item->params, $offset));

        $item->event = new stdClass;
        $results = $dispatcher->trigger('onContentAfterTitle', array('com_content.article', &$item, &$item->params, $offset));
        $item->event->afterDisplayTitle = trim(implode("\n", $results));

        $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.article', &$item, &$item->params, $offset));
        $item->event->beforeDisplayContent = trim(implode("\n", $results));

        $results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.article', &$item, &$item->params, $offset));
        $item->event->afterDisplayContent = trim(implode("\n", $results));

        // --- Contact ---
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
        // --- /.Contact ---
        // ============ Set global =============
        $showModuleTitle = true;
        // --- set Info Current (ex: related) ---
        $aInfoCurrent = array(
            "current_itinerarytype_id" => $this->item->itinerarytype_id,
            "current_itinerary_id" => $this->item->id
        );
        // --- /.set Info Current (ex: related) ---

        $item->link = isset($item->readmore_link) ? $item->readmore_link : "";
        $list['banner'] = clone $this->item;
        // ============ /.Set global =============
        // 
        // Escape strings for HTML output
        $this->pageclass_sfx = htmlspecialchars($this->item->params->get('pageclass_sfx'));

        $this->_prepareDocument();

        parent::display($tpl);
    }

    /**
     * Prepares the document.
     *
     * @return  void
     */
    protected function _prepareDocument() {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $pathway = $app->getPathway();
        $title = null;

        /**
         * Because the application sets a default page title,
         * we need to get it from the menu item itself
         */
        $menu = $menus->getActive();

        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('JGLOBAL_ARTICLES'));
        }

        $title = $this->params->get('page_title', '');

        $id = (int) @$menu->query['id'];

        // If the menu item does not concern this article
        if ($menu && (!isset($menu->query['option']) || $menu->query['option'] !== 'com_content' || $menu->query['view'] !== 'article' || $id != $this->item->id)) {
            // If a browser page title is defined, use that, then fall back to the article title if set, then fall back to the page_title option
            $title = $this->item->params->get('article_page_title', $this->item->title ?: $title);

            $path = array(array('title' => $this->item->title, 'link' => ''));
            $itinerarytype = JCategories::getInstance('Content')->get($this->item->itinerarytype_id);

            while ($itinerarytype && (!isset($menu->query['option']) || $menu->query['option'] !== 'com_content' || $menu->query['view'] === 'article' || $id != $itinerarytype->id) && $itinerarytype->id > 1) {
                $path[] = array('title' => $itinerarytype->title, 'link' => ContentHelperRoute::getCategoryRoute($itinerarytype->id));
                $itinerarytype = $itinerarytype->getParent();
            }

            $path = array_reverse($path);

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

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }

        if ($app->get('MetaAuthor') == '1') {
            $author = $this->item->created_by_alias ?: $this->item->author;
            $this->document->setMetaData('author', $author);
        }

        $mdata = $this->item->metadata->toArray();

        foreach ($mdata as $k => $v) {
            if ($v) {
                $this->document->setMetadata($k, $v);
            }
        }

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
