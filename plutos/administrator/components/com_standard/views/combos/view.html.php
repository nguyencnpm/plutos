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
    JLoader::register('CalculationHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/calculation.php');
}

if (!class_exists('CurrencyHelper')) {
    JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
}

/**
 * View class for a list of combos.
 *
 * @since  1.6
 */
// [name component]<View>[name view]
class StandardViewCombos extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $calculator;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null) {
        if ($this->getLayout() !== 'modal') {
            StandardHelper::addSubmenu('combos'); //PATH: [name component]-> Helper->file[[name component].php] :: <class>[name component]<Helper>
        }
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

        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal') {
            $this->addToolbar();
            $this->sidebar = JHtmlSidebar::render();
        } else {
            // In combo associations modal we need to remove language filter if forcing a language.
            // We also need to change the category filter to show show categories with All or the forced language.
            if ($forcedLanguage = JFactory::getApplication()->input->get('forcedLanguage', '', 'CMD')) {
                // If the language is forced we can't allow to select the language, so transform the language selector filter into an hidden field.
                $languageXml = new SimpleXMLElement('<field name="language" type="hidden" default="' . $forcedLanguage . '" />');
                $this->filterForm->setField($languageXml, 'filter', true);

                // Also, unset the active language filter so the search tools is not open by default with this filter.
                unset($this->activeFilters['language']);

                // One last changes needed is to change the category filter to just show categories with All language or with the forced language.
                $this->filterForm->setFieldAttribute('category_id', 'language', '*,' . $forcedLanguage, 'filter');
            }
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
        $canDo = StandardHelper::getActions('com_standard', 'category', $this->state->get('filter.category_id'));
        $user = JFactory::getUser();

        // Get the toolbar object instance
        $bar = JToolbar::getInstance('toolbar');

        JToolbarHelper::title(JText::_('COM_STANDARD_COMBOS_TITLE'), 'stack article');

        if ($canDo->get('core.create') || count($user->getAuthorisedCategories('com_standard', 'core.create')) > 0) {
            JToolbarHelper::addNew('combo.add');
        }

        if ($canDo->get('core.edit') || $canDo->get('core.edit.own')) {
            JToolbarHelper::editList('combo.edit');
        }

        if ($canDo->get('core.edit.state')) {
            JToolbarHelper::publish('combos.publish', 'JTOOLBAR_PUBLISH', true);
            JToolbarHelper::unpublish('combos.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            JToolbarHelper::custom('combos.featured', 'featured.png', 'featured_f2.png', 'JFEATURE', true);
            JToolbarHelper::custom('combos.unfeatured', 'unfeatured.png', 'featured_f2.png', 'JUNFEATURE', true);
            JToolbarHelper::archiveList('combos.archive');
            JToolbarHelper::checkin('combos.checkin');
        }

        // Add a batch button
        if ($user->authorise('core.create', 'com_standard') && $user->authorise('core.edit', 'com_standard') && $user->authorise('core.edit.state', 'com_standard')) {
            $title = JText::_('JTOOLBAR_BATCH');

            // Instantiate a new JLayoutFile instance and render the batch button
            $layout = new JLayoutFile('joomla.toolbar.batch');

            $dhtml = $layout->render(array('title' => $title));
            $bar->appendButton('Custom', $dhtml, 'batch');
        }

        if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
            JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'combos.delete', 'JTOOLBAR_EMPTY_TRASH');
        } elseif ($canDo->get('core.edit.state')) {
            JToolbarHelper::trash('combos.trash');
        }

        if ($user->authorise('core.admin', 'com_standard') || $user->authorise('core.options', 'com_standard')) {
            JToolbarHelper::preferences('com_standard');
        }

        //JToolbarHelper::help('JHELP_STANDARD_COMBO_MANAGER');
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
            'cb.ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'cb.state' => JText::_('JSTATUS'),
            'cb.title' => JText::_('JGLOBAL_TITLE'),
            'category_title' => JText::_('JCATEGORY'),
            'access_level' => JText::_('JGRID_HEADING_ACCESS'),
            'cb.created_by' => JText::_('JAUTHOR'),
            'language' => JText::_('JGRID_HEADING_LANGUAGE'),
            'cb.created' => JText::_('JDATE'),
            'cb.id' => JText::_('JGRID_HEADING_ID'),
            'cb.featured' => JText::_('JFEATURED')
        );
    }

}
