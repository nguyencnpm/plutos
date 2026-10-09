<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
if (!class_exists('Convert')) {
    jimport('informationtechnology.convert');
}

use Joomla\Archive\Archive;

/**
 * Methods supporting a list of request records.
 *
 * @since  1.6
 */
// [name component]<Model>[name Model]
class StandardModelSubscribedemails extends JModelList {

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @since   1.6
     * @see     JController
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'se.id',
                'subscribe_email', 'se.subscribe_email',
                'created', 'se.created',
                'ip_address', 'se.ip_address',
                'device', 'se.device',
                'browser', 'se.browser'
            );

            if (JLanguageAssociations::isEnabled()) {
                $config['filter_fields'][] = 'association';
            }
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function populateState($ordering = 'se.id', $direction = 'desc') {
        /*
          $app = JFactory::getApplication();

          $forcedLanguage = $app->input->get('forcedLanguage', '', 'cmd');

          // Adjust the context to support modal layouts.
          if ($layout = $app->input->get('layout')) {
          $this->context .= '.' . $layout;
          }

          // Adjust the context to support forced languages.
          if ($forcedLanguage) {
          $this->context .= '.' . $forcedLanguage;
          }
         */

        $this->context = 'com_standard.subscribedemails';

        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $ticketDate = $this->getUserStateFromRequest($this->context . '.filter.ticketDate', 'filter_ticketDate', '');
        $this->setState('filter.ticketDate', $ticketDate);
        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string  $id  A prefix for the store id.
     *
     * @return  string  A store id.
     *
     * @since   1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.ticketDate');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $user = JFactory::getUser();

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'se.*'
                )
        );
        $query->from('#__standard_subscribe AS se');

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('se.access IN (' . $groups . ')');
        }

        // Filter by booking-date Date Range 
        $delimiter = " - ";
        $sTicketDate = trim($this->getState('filter.ticketDate'));
        if (!empty($sTicketDate)):
            $aTicketDateTemp = explode($delimiter, trim($sTicketDate));
            if (count($aTicketDateTemp) > 1):
                $startTicketdate = $db->quote(Convert::getConvertDate(trim($aTicketDateTemp[0]), 'Y-m-d'));
                $endTicketdate = $db->quote(Convert::getConvertDate(trim($aTicketDateTemp[1]), 'Y-m-d'));
                $query->where("(DATE(se.created) BETWEEN {$startTicketdate} AND {$endTicketdate})");
            endif;
        endif;

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('se.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(se.subscribe_email LIKE ' . $search . ' OR se.ip_address LIKE ' . $search . ' OR se.device LIKE ' . $search . ' OR se.browser LIKE ' . $search . ' )');
            }
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'se.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        $query->order($db->escape($orderCol . ' ' . $orderDirn));
        /*
          echo nl2br(str_replace('#__', 'brle6_', $query));
          exit;
         */
        return $query;
    }

    /**
     * Method to get a list of products.
     * Overridden to add a check for access levels.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   1.6.1
     */
    public function getItems() {
        $items = parent::getItems(); // call function class parent "extends JModelList" in [libraries/legacy/model/list.php]
        return $items;
    }

    // === Export Data ===
    /**
     * Get file name
     *
     * @return  string  The file name
     *
     * @since   1.6
     */
    public function getBaseName() {
        if (!isset($this->basename)):
            $sViewName = empty($this->get('name')) ? "" : " " . $this->get('name');
            $basename = str_replace('- FileName -', JFactory::getApplication()->get('sitename') . $sViewName, $this->getState('basename'));
            $this->basename = $basename;
        endif;

        return $this->basename;
    }

    /**
     * Get the file type.
     *
     * @return  string  The file type
     *
     * @since   1.6
     */
    public function getFileType() {
        return $this->getState('compressed') ? 'zip' : 'csv';
    }

    /**
     * Get the mime type.
     *
     * @return  string  The mime type.
     *
     * @since   1.6
     */
    public function getMimeType() {
        return $this->getState('compressed') ? 'application/zip' : 'text/csv';
    }

    /**
     * Get the content
     *
     * @return  string  The content.
     *
     * @since   1.6
     */
    public function getContent() {
        $configParams = JComponentHelper::getParams('com_standard');

        $app = JFactory::getApplication();
        if (!isset($this->content)) {
            $this->content = '"'
                    . str_replace('"', '""', JText::_('HEADING_SUBSCRIBED_EMAILS_GUEST')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_SUBSCRIBED_EMAILS_DATE'))
                    . '"' . "\n";

            foreach ($this->getItems() as $item) :
                $sTicketDate = JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC5'));

                $this->content .= '"'
                        . str_replace('"', '""', $item->subscribe_email) . '","'
                        . str_replace('"', '""', $sTicketDate)
                        . '"' . "\n";
            endforeach;

            if ($this->getState('compressed')) {
                $app = JFactory::getApplication('administrator');

                $files = array(
                    'track' => array(
                        'name' => $this->getBasename() . '.csv',
                        'data' => $this->content,
                        'time' => time()
                    )
                );
                $ziproot = $app->get('tmp_path') . '/' . uniqid('seaplanes_subscribedemails_') . '.zip';

                // Run the packager
                jimport('joomla.filesystem.folder');
                jimport('joomla.filesystem.file');
                $delete = JFolder::files($app->get('tmp_path') . '/', uniqid('seaplanes_subscribedemails_'), false, true);

                if (!empty($delete)) {
                    if (!JFile::delete($delete)) {
                        // JFile::delete throws an error
                        $this->setError(JText::_('COM_STANDARD_ERR_ZIP_DELETE_FAILURE'));

                        return false;
                    }
                }

                $archive = new Archive;

                if (!$packager = $archive->getAdapter('zip')) {
                    $this->setError(JText::_('COM_STANDARD_ERR_ZIP_ADAPTER_FAILURE'));

                    return false;
                } elseif (!$packager->create($ziproot, $files)) {
                    $this->setError(JText::_('COM_STANDARD_ERR_ZIP_CREATE_FAILURE'));

                    return false;
                }

                $this->content = file_get_contents($ziproot);
            }
        }

        return $this->content;
    }

    // === /.Export Data ===
}
