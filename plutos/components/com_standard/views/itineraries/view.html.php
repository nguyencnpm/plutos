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
 * Frontpage View class
 *
 * @since  1.5
 */
class StandardViewItineraries extends JViewLegacy {

    protected $state = null;
    protected $item = null;
    protected $items = null;
    protected $pagination = null;
    protected $lead_items = array();
    protected $intro_items = array();
    protected $end_items = array();
    protected $link_items = array();

    /** @deprecated  4.0 */
    protected $columns = 1;

    /**
     * An instance of JDatabaseDriver.
     *
     * @var    JDatabaseDriver
     * @since  3.6.3
     */
    protected $db;

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise an Error object.
     */
    public function display($tpl = null) {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();

        $state = $this->get('State');
        $items = $this->get('Items');
        $pagination = $this->get('Pagination');

        // Flag indicates to not add limitstart=0 to URL
        $pagination->hideEmptyLimitstart = true;

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
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseWarning(500, implode("\n", $errors));

            return false;
        }

//        echo '<pre>';
//        print_r($items);
//        exit;
        $params = &$state->params;

        // PREPARE THE DATA
        // Get the metrics for the structural page layout.
        $numLeading = (int) $params->def('num_leading_itineraries', 1);
        $numIntro = (int) $params->def('num_intro_itineraries', 4);
        $numEnd = (int) $params->def('num_columns_end', 1);
        $numLinks = (int) $params->def('num_links', 4);

        JPluginHelper::importPlugin('content');

        // Compute the itinerary slugs and prepare introtext (runs content plugins).
        foreach ($items as &$item) {
            /*
            // is payment type id
            $type = 'Product';
            $prefix = 'StandardTable';
            $config = array();
            $tableProduct = JTable::getInstance($type, $prefix, $config);
            $tableProduct->load($item->product_id);
            $item->paymenttype_id = $tableProduct->paymenttype_id;
            // ---
            */
            
            $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;
            $item->catslug = $item->itinerarytype_alias ? ($item->itinerarytype_id . ':' . $item->itinerarytype_alias) : $item->itinerarytype_id;
            $item->parent_slug = $item->parent_alias ? ($item->parent_id . ':' . $item->parent_alias) : $item->parent_id;

            // No link for ROOT itinerarytype
            if ($item->parent_alias === 'root') {
                $item->parent_slug = null;
            }

            $item->event = new stdClass;
            $dispatcher = JEventDispatcher::getInstance();

            // Old plugins: Ensure that text property is available
            if (!isset($item->text)) {
                $item->text = $item->introtext;
            }

            $dispatcher->trigger('onContentPrepare', array('com_standard.featured', &$item, &$item->params, 0));

            // Old plugins: Use processed text as introtext
            $item->introtext = $item->text;

            $results = $dispatcher->trigger('onContentAfterTitle', array('com_standard.featured', &$item, &$item->params, 0));
            $item->event->afterDisplayTitle = trim(implode("\n", $results));

            $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_standard.featured', &$item, &$item->params, 0));
            $item->event->beforeDisplayContent = trim(implode("\n", $results));

            $results = $dispatcher->trigger('onContentAfterDisplay', array('com_standard.featured', &$item, &$item->params, 0));
            $item->event->afterDisplayContent = trim(implode("\n", $results));
        }
        // Preprocess the breakdown of leading, intro and linked itineraries.
        // This makes it much easier for the designer to just interogate the arrays.
        $max = count($items);

        // The first group is the leading itineraries.
        $limit = $numLeading;

        for ($i = 0; $i < $limit && $i < $max; $i++) {
            $this->lead_items[$i] = &$items[$i];
        }

        // The second group is the intro itineraries.
        $limitLeadingIntro = $numLeading + $numIntro;

        // Order itineraries across, then down (or single column mode)
        for ($i = $numLeading; $i < $limitLeadingIntro && $i < $max; $i++) {
            $this->intro_items[$i] = &$items[$i];
        }

        $limitEnd = $limitLeadingIntro + $numEnd;
        for ($i = $limitLeadingIntro; $i < $limitEnd && $i < $max; $i++) {
            $this->end_items[$i] = &$items[$i];
        }

        $this->lead_columns = max(1, $params->def('num_columns_leading', 1));
        $this->intro_columns = max(1, $params->def('num_columns_intro', 1));
        $this->end_columns = max(1, $params->def('num_columns_end', 1));

        /*
          $this->columns = max(1, $params->def('num_columns', 1));
          $order = $params->def('multi_column_order', 1);

          if ($order == 0 && $this->columns > 1) {
          // Call order down helper
          //$this->intro_items = StandardHelperQuery::orderDownColumns($this->intro_items, $this->columns);
          }
         */
        // The remainder are the links.
        
        for ($i = $numLeading + $numIntro + $numEnd; $i < ($numLeading + $numIntro + $numEnd + $numLinks) && i < $max; $i++) {
            $this->link_items[$i] = &$items[$i];
        }

        // Escape strings for HTML output
        $this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

        $this->leading_medialayoutelement = htmlspecialchars($params->get('leading_medialayoutelement'));
        $this->intro_medialayoutelement = htmlspecialchars($params->get('intro_medialayoutelement'));
        $this->end_medialayoutelement = htmlspecialchars($params->get('end_medialayoutelement'));


        $this->params = &$params;
        $this->items = &$items;
        $this->pagination = &$pagination;
        $this->user = &$user;
        $this->db = JFactory::getDbo();

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
        $title = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();

        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('JGLOBAL_ITINERARIES'));
        }

        $title = $this->params->get('page_title', '');

        if (empty($title)) {
            $title = $app->get('sitename');
        } elseif ($app->get('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        } elseif ($app->get('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }

        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }

        // Add feed links
        if ($this->params->get('show_feed_link', 1)) {
            $link = '&format=feed&limitstart=';
            $attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
            $this->document->addHeadLink(JRoute::_($link . '&type=rss'), 'alternate', 'rel', $attribs);
            $attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
            $this->document->addHeadLink(JRoute::_($link . '&type=atom'), 'alternate', 'rel', $attribs);
        }
    }

}
