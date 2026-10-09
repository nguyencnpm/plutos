<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

if (!class_exists('CurrencyHelper')) {
    JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
}
/**
 * View class for a list of travel agent groups.
 *
 * @since  1.6
 */
class StandardViewUsergroups extends JViewLegacy {

    /**
     * The item data.
     *
     * @var   object
     * @since 1.6
     */
    protected $items;

    /**
     * The pagination object.
     *
     * @var   JPagination
     * @since 1.6
     */
    protected $pagination;

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
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');
        $this->currency = CurrencyHelper::getInstance();
        if ($this->getLayout() !== 'modal') {
            StandardHelper::addSubmenu('usergroups'); //PATH: [name component]-> Helper->file[[name component].php] :: <class>[name component]<Helper>
        }
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }
        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal') {
            $this->addToolbar();
            $this->sidebar = JHtmlSidebar::render();
        } else {
            // In roomtype associations modal we need to remove language filter if forcing a language.
            // We also need to change the hotel filter to show show hotels with All or the forced language.
            
        }

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
        $canDo = StandardHelper::getActions('com_standard');

        JToolbarHelper::title(JText::_('COM_STANDARD_VIEW_USER_GROUPS_TITLE'), 'users groups');

        if ($canDo->get('core.create')) {
            JToolbarHelper::addNew('usergroup.add');
        }

        if ($canDo->get('core.edit')) {
            JToolbarHelper::editList('usergroup.edit');
            JToolbarHelper::divider();
        }

        if ($canDo->get('core.delete')) {
            JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'usergroups.delete', 'JTOOLBAR_DELETE');
            JToolbarHelper::divider();
        }

        if ($canDo->get('core.admin') || $canDo->get('core.options')) {
            JToolbarHelper::preferences('com_users');
            JToolbarHelper::divider();
        }

        //JToolbarHelper::help('JHELP_HOTELSRESORTS_USER_GROUP');
    }

    /**
     * Returns an array of fields the table can be sorted by
     *
     * @return  array  Array containing the field name to sort by as the key and display text as value
     *
     * @since   3.0
     */
    protected function getSortFields() {
        return array(
            'tag.title' => JText::_('COM_STANDARD_HEADING_USER_GROUP_TITLE'),
            'tag.id' => JText::_('JGRID_HEADING_ID'),
        );
    }

}
