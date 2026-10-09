<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * View class for a list of allotments.
 *
 * @since  1.6
 */
// [name component]<View>[name view]
class StandardViewAllotments extends JViewLegacy {

    /**
     * An array of items
     *
     * @var  array
     */
    protected $items;

    /**
     * The pagination object
     *
     * @var  JPagination
     */
    protected $pagination;

    /**
     * The model state
     *
     * @var  object
     */
    protected $state;

    /**
     * Flag if an association exists
     *
     * @var  boolean
     */
    protected $assoc;

    /**
     * Form object for search filters
     *
     * @var  JForm
     */
    public $filterForm;

    /**
     * The active search filters
     *
     * @var  array
     */
    public $activeFilters;

    /**
     * The sidebar markup
     *
     * @var  string
     */
    protected $string;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */

    /**
     * An array of items
     *
     * @var  array
     */
    protected $itemsJson;
    protected $itemstamp;

    public function display($tpl = null) {
        $document = JFactory::getDocument();
        $document->addScript('components/com_standard/assets/js/underscore/underscore.min.js');

        if ($this->getLayout() !== 'modal') {
            StandardHelper::addSubmenu('allotments'); //PATH: [name component]-> Helper->file[[name component].php] :: <class>[name component]<Helper>
        }
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->authors = $this->get('Authors');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');
        $today = JFactory::getDate()->format('Y-m-d');
        /*
        $offset = JFactory::getApplication()->get('offset');
        $sToday = JFactory::getDate('now', $offset)->toSql();
        $today = JHtml::_('date', $sToday, 'Y-m-d');
        */
        $today1day = new JDate($today . ' +1 day');
        $today1day = $today1day->format('Y-m-d');
        // Get the model.
        $model = $this->getModel();
        foreach ($this->items as $key => $value) {
            $this->items_json[$key] = new stdClass();
            $this->items_json[$key]->id = $value->id;
            $this->items_json[$key]->title = $value->title;
            $this->items_json[$key]->catid = $value->catid;
            $this->items_json[$key]->category_title = $value->category_title;
            $this->items_json[$key]->checked_out = $value->checked_out;
            $this->items_json[$key]->checked_out_time = $value->checked_out_time;
            $this->items_json[$key]->editor = $value->editor;
            $this->items_json[$key]->created_by = $value->created_by;

            $this->itemstamp = $model->getAllotment($value->id, $value->catid);

            foreach ($this->itemstamp as $ktamp => $valtamp) {
                //$oDatemillisecond = new JDate($this->itemstamp[$ktamp]['date']);
                //$datemillisecond = $oDatemillisecond->format('Y-m-d');

                // $sDatemillisecond = JFactory::getDate($this->itemstamp[$ktamp]['date'], $offset)->toSql();
                $datemillisecond = JHtml::_('date', $this->itemstamp[$ktamp]['date'], 'Y-m-d');

                if ((strtotime($today1day) >= strtotime($datemillisecond)) && (strtotime($datemillisecond) >= strtotime($today))) {
                    $class = "badge badge-warning";
                } elseif (strtotime($today) > strtotime($datemillisecond)) {
                    $class = "badge badge-inverse";
                } else {
                    $class = "badge badge-info";
                }
                if ((int) $this->itemstamp[$ktamp]['available'] == 0):
                    $class = "badge badge-important";
                endif;

                $this->itemstamp[$ktamp]['class'] = $class;
                $this->itemstamp[$ktamp]['start'] = strtotime($datemillisecond) * 1000; // strtotime($datemillisecond).'1000'
                $this->itemstamp[$ktamp]['end'] = strtotime($datemillisecond) * 1000;
            }
            $this->items_json[$key]->allotment = $this->itemstamp;
            //$this->items_json[$key]->allotment_json = json_encode($this->items_json[$key]->allotment);
        }

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));

            return false;
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
        $canDo = StandardHelper::getActions('com_standard', 'allotment', $this->state->get('filter.id'));
        $user = JFactory::getUser();

        // Get the toolbar object instance
        $bar = JToolbar::getInstance('toolbar');

        JToolbarHelper::title(JText::_('COM_STANDARD_ALLOTMENTS_TITLE'), 'stack article');
        /*
          if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_standard', 'core.create'))) > 0) {
          JToolbarHelper::addNew('allotment.add');
          }
         */
        if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own'))) {
            JToolbarHelper::editList('allotmentproduct.edit');
        }

        if ($canDo->get('core.edit.state')) {
            //JToolbarHelper::publish('allotments.publish', 'JTOOLBAR_PUBLISH', true);
            //JToolbarHelper::unpublish('allotments.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            //JToolbarHelper::archiveList('allotments.archive');
            JToolbarHelper::checkin('allotmentproduct.checkin');
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

          if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
          JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'allotments.delete', 'JTOOLBAR_EMPTY_TRASH');
          } elseif ($canDo->get('core.edit.state')) {
          JToolbarHelper::trash('allotments.trash');
          }
         */
        if ($user->authorise('core.admin', 'com_standard') || $user->authorise('core.options', 'com_standard')) {
            JToolbarHelper::preferences('com_standard');
        }

        //JToolbarHelper::help('JHELP_STANDARD_ROOMRATE_MANAGER');
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
            'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'a.state' => JText::_('JSTATUS'),
            'a.title' => JText::_('JGLOBAL_TITLE'),
            'access_level' => JText::_('JGRID_HEADING_ACCESS'),
            'a.created_by' => JText::_('JAUTHOR'),
            'language' => JText::_('JGRID_HEADING_LANGUAGE'),
            'a.created' => JText::_('JDATE'),
            'a.id' => JText::_('JGRID_HEADING_ID')
        );
    }

}
