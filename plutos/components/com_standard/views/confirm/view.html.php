<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * HTML Confirm View class for the Standard component
 *
 * @since  1.5
 */
class StandardViewConfirm extends JViewLegacy {

    protected $state;
    protected $item;
    protected $params;

    public function __construct($config = array()) {

        parent::__construct($config);
    }

    public function display($tpl = null) {
        $app = JFactory::getApplication();
        //$user = JFactory::getUser();
        //$dispatcher = JEventDispatcher::getInstance();

        $this->state = $this->get('State');
        $this->params = $this->state->get('params');
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseWarning(500, implode("\n", $errors));

            return false;
        }

        $this->item = $app->getUserState("com_standard.result.data", NULL);
        $this->display = $this->item['layout'];
        $app->setUserState("com_standard.result.data", null);

        $this->setLayout($this->display);
        
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
    }

}
