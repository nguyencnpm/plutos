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
class StandardModelRequests extends JModelList {

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
                'id', 'r.id',
                //'vendor',
                'contact_fullName', 'r.contact_fullName',
                //'shipmentmethod', 'r.shipmentmethod',
                'checked_out', 'r.checked_out',
                'checked_out_time', 'r.checked_out_time',
                'catid', 'r.catid', 'category_title',
                'state', 'r.state',
                'access', 'r.access', 'access_level',
                'return_date', 'r.return_date',
                'created', 'r.created',
                'modified', 'r.modified',
                'ip_address', 'r.ip_address',
                'device', 'r.device',
                'browser', 'r.browser',
                'created_by', 'r.created_by',
                'created_by_alias', 'r.created_by_alias',
                'ordering', 'r.ordering',
                'language', 'r.language',
                'publish_up', 'r.publish_up',
                'publish_down', 'r.publish_down',
                'published', 'r.published',
                'author_id',
                'category_id',
                'level'
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
    protected function populateState($ordering = 'r.id', $direction = 'desc') {
        $app = JFactory::getApplication();
        /*
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

        $this->context = 'com_standard.requests';

        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $requestDate = $this->getUserStateFromRequest($this->context . '.filter.requestDate', 'filter_requestDate', '');
        //exit;
        $this->setState('filter.requestDate', $requestDate);

        $access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access');
        $this->setState('filter.access', $access);

        $authorId = $app->getUserStateFromRequest($this->context . '.filter.author_id', 'filter_author_id');
        $this->setState('filter.author_id', $authorId);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        $categoryId = $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id');
        $this->setState('filter.category_id', $categoryId);

        $level = $this->getUserStateFromRequest($this->context . '.filter.level', 'filter_level');
        $this->setState('filter.level', $level);

        $language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
        $this->setState('filter.language', $language);

        $tag = $this->getUserStateFromRequest($this->context . '.filter.tag', 'filter_tag', '');
        $this->setState('filter.tag', $tag);

        // List state information.
        parent::populateState($ordering, $direction);

        // Force a language
        if (!empty($forcedLanguage)) {
            $this->setState('filter.language', $forcedLanguage);
            $this->setState('filter.forcedLanguage', $forcedLanguage);
        }
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
        $id .= ':' . $this->getState('filter.requestDate');
        $id .= ':' . $this->getState('filter.access');
        $id .= ':' . $this->getState('filter.published');
        $id .= ':' . $this->getState('filter.category_id');
        $id .= ':' . $this->getState('filter.author_id');
        $id .= ':' . $this->getState('filter.language');

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
                        'list.select', 'r.*'
                )
        );
        $query->from('#__standard_request AS r');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = r.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=r.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = r.access');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = r.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('r.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('r.access IN (' . $groups . ')');
        }

        // Filter by booking-date Date Range 
        $delimiter = " - ";
        $sRequestDate = trim($this->getState('filter.requestDate'));
        if (!empty($sRequestDate)):
            $aRequestDateTemp = explode($delimiter, trim($sRequestDate));
            if (count($aRequestDateTemp) > 1):
                $startRequestdate = $db->quote(Convert::getConvertDate(trim($aRequestDateTemp[0]), 'Y-m-d'));
                $endRequestdate = $db->quote(Convert::getConvertDate(trim($aRequestDateTemp[1]), 'Y-m-d'));
                $query->where("(DATE(r.created) BETWEEN {$startRequestdate} AND {$endRequestdate})");
            endif;
        endif;

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('r.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(r.state = 0 OR r.state = 1)');
        }

        // Filter on the level.
        if ($level = $this->getState('filter.level')) {
            $query->where('c.level <= ' . ((int) $level + (int) $baselevel - 1));
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('r.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('r.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(r.contact_fullName LIKE ' . $search . ' OR r.ip_address LIKE ' . $search . ' OR r.device LIKE ' . $search . ' OR r.browser LIKE ' . $search . ' )');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('r.language = ' . $db->quote($language));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'r.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        // SQL server change
        if ($orderCol == 'language') {
            $orderCol = 'l.title';
        }

        if ($orderCol == 'access_level') {
            $orderCol = 'ag.title';
        }

        $query->order($db->escape($orderCol . ' ' . $orderDirn));
        /*
          echo nl2br(str_replace('#__', 'brle6_', $query));
          exit;
         */
        return $query;
    }

    /**
     * Build a list of authors
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    public function getAuthors() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('u.id AS value, u.name AS text')
                ->from('#__users AS u')
                ->join('INNER', '#__standard_request AS r ON r.created_by = u.id')
                ->group('u.id, u.name')
                ->order('u.name');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObjectList();
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
        /*
          if (JFactory::getApplication()->isSite()) {
          $user = JFactory::getUser();
          $groups = $user->getAuthorisedViewLevels();

          for ($x = 0, $count = count($items); $x < $count; $x++) {
          // Check the access level. Remove products the user shouldn't see
          if (!in_array($items[$x]->access, $groups)) {
          unset($items[$x]);
          }
          }
          }
         */
        return $items;
    }

    public function getStatusList() {
        $requestStatusList = array(
            0 => JText::_('COM_STANDARD_TOGGLE_UNPUBLISHED'),
            1 => JText::_('COM_STANDARD_TOGGLE_PUBLISHED'),
            2 => JText::_('COM_STANDARD_TOGGLE_ARCHIVE'),
            -2 => JText::_('COM_STANDARD_TOGGLE_TRASH')
        );
        return $requestStatusList;
    }

    public function getPaymentMethod() {
        $paymentMethodList = array(
            '1' => JText::_('COM_STANDARD_PAYMENT_METHOD_PAYMENT_ONLINE'),
            '2' => JText::_('COM_STANDARD_PAYMENT_METHOD_SEND_RESERVE'),
            '3' => JText::_('COM_STANDARD_PAYMENT_METHOD_SEND_BOOKING_PACKAGE'),
            '4' => JText::_('COM_STANDARD_PAYMENT_METHOD_SEND_REQUEST'),
            '5' => JText::_('COM_STANDARD_PAYMENT_METHOD_PAYMENT_OFFLINE'),
            '6' => JText::_('COM_STANDARD_PAYMENT_METHOD_SEND_CONTACT'),
            '7' => JText::_('COM_STANDARD_PAYMENT_METHOD_SEND_ENQUIRY'),
        );
        return $paymentMethodList;
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
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_STATUS')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_GUEST_NAME')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_EMAIL')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_PHONE_NUMBER')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_REQUEST_DATE'))
                    . '"' . "\n";

            $aStatus = $this->getStatusList();
            
            foreach ($this->getItems() as $item) :

                $sStatus = " - ";
                if (!empty($aStatus)):
                    $sStatus = $aStatus[$item->state];
                endif;
                // === ===
                $contactPhone = empty($item->contact_phone) ? $item->contact_mobile : $item->contact_phone;
                $sRequestDate = JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC5'));

                $this->content .= '"'
                        . str_replace('"', '""', $sStatus) . '","'
                        . str_replace('"', '""', $item->contact_fullName) . '","'
                        . str_replace('"', '""', $item->contact_email) . '","'
                        . str_replace('"', '""', $contactPhone) . '","'
                          . str_replace('"', '""', $sRequestDate)
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
                $ziproot = $app->get('tmp_path') . '/' . uniqid('seaplanes_requests_') . '.zip';

                // Run the packager
                jimport('joomla.filesystem.folder');
                jimport('joomla.filesystem.file');
                $delete = JFolder::files($app->get('tmp_path') . '/', uniqid('seaplanes_requests_'), false, true);

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
