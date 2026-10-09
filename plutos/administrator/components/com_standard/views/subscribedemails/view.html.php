<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * View class for a list of subscribedemails.
 *
 * @since  1.6
 */
// [name component]<View>[name view]
class StandardViewSubscribedemails extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * The context for persistent state.
     *
     * @var    string
     * @since  1.6
     */
    protected $context = 'com_standard.subscribedemails';

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
            StandardHelper::addSubmenu('subscribedemails'); //PATH: [name component]-> Helper->file[[name component].php] :: <class>[name component]<Helper>
        }
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->authors = $this->get('Authors');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal') {
            $this->addToolbar();
            $this->sidebar = JHtmlSidebar::render();
        } else {
            // In request associations modal we need to remove language filter if forcing a language.
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
        $user = JFactory::getUser();

        // Get the toolbar object instance
        $bar = JToolbar::getInstance('toolbar');

        JToolbarHelper::title(JText::_('COM_STANDARD_SUBSCRIBED_EMAILS_TITLE'), 'stack article');

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
            'language' => JText::_('JGRID_HEADING_LANGUAGE'),
            'se.created' => JText::_('JDATE'),
            'se.id' => JText::_('JGRID_HEADING_ID')
        );
    }

}
