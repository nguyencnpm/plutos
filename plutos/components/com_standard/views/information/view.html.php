<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
if (!class_exists('CurrencyHelper')) {
    JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
}

if (!class_exists('Cart')) {
    JLoader::register('Cart', JPATH_SITE . '/components/com_standard/helpers/cart.php');
}

/**
 * HTML Information View class for the Standard component
 *
 * @since  1.5
 */
class StandardViewInformation extends JViewLegacy {

    protected $form;
    protected $item;
    protected $params;
    protected $print;
    protected $state;
    protected $user;
    protected $calculation;
    protected $currency;
    protected $captchaEnabled = false;

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
        $dispatcher = JEventDispatcher::getInstance();
        $this->datainput = $app->input->getArray();
        $this->currency = CurrencyHelper::getInstance();
        
        $this->form = $this->get('Form');

        // -- ex Cart -- 
        $this->cart = Cart::getCart();
        $this->cart->prepareCartData(false);
        // -- /.ex Cart --

        $this->state = $this->get('State');
        $this->params = $this->state->get('params');

        $captchaSet = $this->params->get('captcha', $app->get('captcha', '0'));
        foreach (JPluginHelper::getPlugin('captcha') as $plugin) {
            if ($captchaSet === $plugin->name) {
                $this->captchaEnabled = true;
                break;
            }
        }
        
        //
        $this->coupon_text = $this->cart->couponCode ? JText::_('COM_STANDARD_COUPON_CODE_CHANGE') : JText::_('COM_STANDARD_COUPON_CODE_ENTER');

        // Escape strings for HTML output
        $this->pageclass_sfx = ""; //htmlspecialchars($this->item->params->get('pageclass_sfx'));

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
            $this->params->def('page_heading', JText::_('JGLOBAL_PRODUCTS'));
        }

        $title = $this->params->get('page_title', '');

        $id = (int) @$menu->query['id'];
        /*
          // If the menu item does not concern this product
          if ($menu && ($menu->query['option'] !== 'com_standard' || $menu->query['view'] !== 'product' || $id != $this->item->id)) {
          // If a browser page title is defined, use that, then fall back to the product title if set, then fall back to the page_title option
          $title = $this->item->params->get('product_page_title', $this->item->title ?: $title);

          $path = array(array('title' => $this->item->title, 'link' => ''));
          $category = JCategories::getInstance('Content')->get($this->item->catid);

          while ($category && ($menu->query['option'] !== 'com_standard' || $menu->query['view'] === 'product' || $id != $category->id) && $category->id > 1) {
          $path[] = array('title' => $category->title, 'link' => StandardHelperRoute::getCategoryRoute($category->id));
          $category = $category->getParent();
          }

          $path = array_reverse($path);

          foreach ($path as $item) {
          $pathway->addItem($item['title'], $item['link']);
          }
          }
         */
        // Check for empty title and add site name if param is set
        if (empty($title)) {
            $title = $app->get('sitename');
        } elseif ($app->get('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        } elseif ($app->get('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }
        /*
          if (empty($title)) {
          $title = $this->item->title;
          }
         */
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

          // If there is a pagebreak heading or title, add it to the page title
          if (!empty($this->item->page_title)) {
          $this->item->title = $this->item->title . ' - ' . $this->item->page_title;
          $this->document->setTitle(
          $this->item->page_title . ' - ' . JText::sprintf('PLG_CONTENT_PAGEBREAK_PAGE_NUM', $this->state->get('list.offset') + 1)
          );
          }
         */

        if ($this->print) {
            $this->document->setMetaData('robots', 'noindex, nofollow');
        }
    }

}
