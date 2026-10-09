<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

if (!class_exists('CalculationHelper')) {
    JLoader::register('CalculationHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/calculation.php');
}

if (!class_exists('CurrencyHelper')) {
    JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
}

/**
 * View class for a list of featured products.
 *
 * @since  1.6
 */
class StandardViewFeatured extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null) {
        StandardHelper::addSubmenu('featured');

        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->authors = $this->get('Authors');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        $this->calculator = CalculationHelper::getInstance();
        $this->currency = CurrencyHelper::getInstance();

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        // Levels filter.
        $options = array();
        $options[] = JHtml::_('select.option', '1', JText::_('J1'));
        $options[] = JHtml::_('select.option', '2', JText::_('J2'));
        $options[] = JHtml::_('select.option', '3', JText::_('J3'));
        $options[] = JHtml::_('select.option', '4', JText::_('J4'));
        $options[] = JHtml::_('select.option', '5', JText::_('J5'));
        $options[] = JHtml::_('select.option', '6', JText::_('J6'));
        $options[] = JHtml::_('select.option', '7', JText::_('J7'));
        $options[] = JHtml::_('select.option', '8', JText::_('J8'));
        $options[] = JHtml::_('select.option', '9', JText::_('J9'));
        $options[] = JHtml::_('select.option', '10', JText::_('J10'));

        $this->f_levels = $options;

        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();
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
        $state = $this->get('State');
        $canDo = JHelperContent::getActions('com_standard', 'category', $this->state->get('filter.category_id'));

        JToolbarHelper::title(JText::_('COM_STANDARD_FEATURED_TITLE'), 'star featured');

        if ($canDo->get('core.create')) {
            JToolbarHelper::addNew('product.add');
        }

        if ($canDo->get('core.edit')) {
            JToolbarHelper::editList('product.edit');
        }

        if ($canDo->get('core.edit.state')) {
            JToolbarHelper::publish('products.publish', 'JTOOLBAR_PUBLISH', true);
            JToolbarHelper::unpublish('products.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            JToolbarHelper::custom('products.unfeatured', 'unfeatured.png', 'featured_f2.png', 'JUNFEATURE', true);
            JToolbarHelper::archiveList('products.archive');
            JToolbarHelper::checkin('products.checkin');
        }

        if ($state->get('filter.published') == -2 && $canDo->get('core.delete')) {
            JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'products.delete', 'JTOOLBAR_EMPTY_TRASH');
        } elseif ($canDo->get('core.edit.state')) {
            JToolbarHelper::trash('products.trash');
        }

        if ($canDo->get('core.admin') || $canDo->get('core.options')) {
            JToolbarHelper::preferences('com_standard');
        }

        //JToolbarHelper::help('JHELP_STANDARD_FEATURED_ARTICLES');
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
            'fp.ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'p.state' => JText::_('JSTATUS'),
            'p.title' => JText::_('JGLOBAL_TITLE'),
            'category_title' => JText::_('JCATEGORY'),
            'access_level' => JText::_('JGRID_HEADING_ACCESS'),
            'p.created_by' => JText::_('JAUTHOR'),
            'language' => JText::_('JGRID_HEADING_LANGUAGE'),
            'p.created' => JText::_('JDATE'),
            'p.id' => JText::_('JGRID_HEADING_ID')
        );
    }

}
