<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

if (!class_exists('CalculationHelper')) {
    JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
}

/**
 * View class for a list of extras.
 *
 * @since  1.6
 */
// [name component]<View>[name view]
class StandardViewExtras extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $currency;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null) {
        if ($this->getLayout() !== 'modal') {
            StandardHelper::addSubmenu('extras'); //PATH: [name component]-> Helper->file[[name component].php] :: <class>[name component]<Helper>
        }

        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->authors = $this->get('Authors');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');
        $this->currency = CurrencyHelper::getInstance();

        $this->aTax = array(
            '-1' => JText::_('COM_STANDARD_TAX_NONE'),
            '0' => JText::_('COM_STANDARD_TAX_NO_SPECIAL')
        );

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal') {
            $this->addToolbar();
            $this->sidebar = JHtmlSidebar::render();
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
        $canDo = StandardHelper::getActions('com_standard', 'extra', $this->state->get('filter.id'));
        $user = JFactory::getUser();

        // Get the toolbar object instance
        $bar = JToolbar::getInstance('toolbar');

        JToolbarHelper::title(JText::_('COM_STANDARD_EXTRAS_TITLE'), 'stack article');

        if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_standard', 'core.create'))) > 0) {
            JToolbarHelper::addNew('extra.add');
        }

        if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own'))) {
            JToolbarHelper::editList('extra.edit');
        }

        if ($canDo->get('core.edit.state')) {
            JToolbarHelper::publish('extras.publish', 'JTOOLBAR_PUBLISH', true);
            JToolbarHelper::unpublish('extras.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            JToolbarHelper::archiveList('extras.archive');
            JToolbarHelper::checkin('extras.checkin');
        }

        if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
            JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'extras.delete', 'JTOOLBAR_EMPTY_TRASH');
        } elseif ($canDo->get('core.edit.state')) {
            JToolbarHelper::trash('extras.trash');
        }

        if ($user->authorise('core.admin', 'com_standard') || $user->authorise('core.options', 'com_standard')) {
            JToolbarHelper::preferences('com_standard');
        }

        //JToolbarHelper::help('JHELP_STANDARD_EXTRA_MANAGER');
    }

}
