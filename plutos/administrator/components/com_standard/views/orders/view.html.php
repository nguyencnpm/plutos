<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
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
 * View class for a list of orders.
 *
 * @since  1.6
 */
// [name component]<View>[name view]
class StandardViewOrders extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $calculator;

    /**
     * The context for persistent state.
     *
     * @var    string
     * @since  1.6
     */
    protected $context = 'com_standard.orders';

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null) {
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        $document->addScript('components/com_standard/assets/js/ready-daterangepicker.min.js');
        $document->addScript('components/com_standard/assets/js/daterangepicker/moment.min.js');
        $document->addScript('components/com_standard/assets/js/daterangepicker/daterangepicker.min.js');

        if ($this->getLayout() !== 'modal') {
            StandardHelper::addSubmenu('orders'); //PATH: [name component]-> Helper->file[[name component].php] :: <class>[name component]<Helper>
        }
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->authors = $this->get('Authors');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');
        $this->calculator = CalculationHelper::getInstance();

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

        $this->iCurrencyDisplay = $app->getUserState($this->context . '.list.currency_id');
        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal') {
            $this->addToolbar();
            $this->sidebar = JHtmlSidebar::render();
        } else {
            // In order associations modal we need to remove language filter if forcing a language.
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

        JToolbarHelper::title(JText::_('COM_STANDARD_ORDERS_TITLE'), 'stack article');
        /*
          if ($canDo->get('core.create') || count($user->getAuthorisedCategories('com_standard', 'core.create')) > 0) {
          JToolbarHelper::addNew('order.add');
          }
         */
        if ($canDo->get('core.edit') || $canDo->get('core.edit.own')) {
            JToolbarHelper::editList('order.edit');
        }

        if ($canDo->get('core.edit.state')) {
            JToolbarHelper::publish('orders.publish', 'COM_STANDARD_TOGGLE_PUBLISHED', true);
            JToolbarHelper::unpublish('orders.unpublish', 'COM_STANDARD_TOGGLE_UNPUBLISHED', true);
            JToolbarHelper::archiveList('orders.archive', 'COM_STANDARD_TOGGLE_ARCHIVE');
            JToolbarHelper::checkin('orders.checkin');
        }
        /*
          // Add a batch button
          if ($user->authorise('core.create', 'com_standard') && $user->authorise('core.edit', 'com_standard') && $user->authorise('core.edit.state', 'com_standard')) {
          $title = JText::_('JTOOLBAR_BATCH');

          // Instantiate a new JLayoutFile instance and render the batch button
          $layout = new JLayoutFile('joomla.toolbar.batch');

          $dhtml = $layout->render(array('title' => $title));
          $bar->appendButton('Custom', $dhtml, 'batch');
          }
         */
        if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
            JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'orders.delete', 'JTOOLBAR_EMPTY_TRASH');
        } elseif ($canDo->get('core.edit.state')) {
            JToolbarHelper::trash('orders.trash', 'COM_STANDARD_TOGGLE_TRASH');
        }

        // ---- Instantiate a new JLayoutFile instance and render the export button ----
        $layout = new JLayoutFile('joomla.toolbar.modal');

        $dhtml = $layout->render(
                array(
                    'selector' => 'downloadModal',
                    'icon' => 'download',
                    'class' => 'btn btn-small button-download',
                    'text' => JText::_('JTOOLBAR_EXPORT')
                )
        );
        $bar->appendButton('Custom', $dhtml, 'download');

        // ---- /.Instantiate a new JLayoutFile instance and render the export button ----

        if ($user->authorise('core.admin', 'com_standard') || $user->authorise('core.options', 'com_standard')) {
            JToolbarHelper::preferences('com_standard');
        }

        //JToolbarHelper::help('JHELP_STANDARD_ORDER_MANAGER');
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
            'o.ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'o.state' => JText::_('JSTATUS'),
            'o.title' => JText::_('JGLOBAL_TITLE'),
            'category_title' => JText::_('JCATEGORY'),
            'access_level' => JText::_('JGRID_HEADING_ACCESS'),
            'o.created_by' => JText::_('JAUTHOR'),
            'language' => JText::_('JGRID_HEADING_LANGUAGE'),
            'o.created' => JText::_('JDATE'),
            'o.id' => JText::_('JGRID_HEADING_ID'),
            'o.featured' => JText::_('JFEATURED')
        );
    }

}
