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
 * Methods supporting a list of order records.
 *
 * @since  1.6
 */
// [name component]<Model>[name Model]
class StandardModelOrders extends JModelList {

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
                'id', 'o.id',
                //'vendor',
                'number', 'o.number',
                //'paymentmethod', 'o.paymentmethod',
                //'shipmentmethod', 'o.shipmentmethod',
                'checked_out', 'o.checked_out',
                'checked_out_time', 'o.checked_out_time',
                'catid', 'o.catid', 'category_title',
                'state', 'o.state',
                'access', 'o.access', 'access_level',
                'total', 'o.total',
                'created', 'o.created',
                'modified', 'o.modified',
                'ip_address', 'o.ip_address',
                'device', 'o.device',
                'browser', 'o.browser',
                'created_by', 'o.created_by',
                'created_by_alias', 'o.created_by_alias',
                'ordering', 'o.ordering',
                'language', 'o.language',
                'publish_up', 'o.publish_up',
                'publish_down', 'o.publish_down',
                'published', 'o.published',
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
    protected function populateState($ordering = 'o.id', $direction = 'desc') {
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

        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $orderDate = $this->getUserStateFromRequest($this->context . '.filter.orderDate', 'filter_orderDate', '');
        $this->setState('filter.orderDate', $orderDate);

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
        $app = JFactory::getApplication();

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'o.*'
                )
        );
        $query->from('#__standard_orders AS o');

        // Join over the language
        $query->select('l.title AS language_title, l.image AS language_image')
                ->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = o.language');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor')
                ->join('LEFT', '#__users AS uc ON uc.id=o.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level')
                ->join('LEFT', '#__viewlevels AS ag ON ag.id = o.access');

        // Join over the categories.
        $query->select('v.title AS vendor_title')
                ->join('LEFT', '#__standard_vendors AS v ON v.id = o.vendor_id');

        // Join over the users for the author.
        $query->select('ua.name AS author_name')
                ->join('LEFT', '#__users AS ua ON ua.id = o.created_by');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('o.access = ' . (int) $access);
        }

        // Implement View Level Access
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('o.access IN (' . $groups . ')');
        }

        // Filter by booking-date Date Range 
        $delimiter = " - ";
        $sOrderDate = trim($this->getState('filter.orderDate'));
        if (!empty($sOrderDate)):
            $aOrderDateTemp = explode($delimiter, trim($sOrderDate));
            if (count($aOrderDateTemp) > 1):
                $startOrderdate = $db->quote(Convert::getConvertDate(trim($aOrderDateTemp[0]), 'Y-m-d'));
                $endOrderdate = $db->quote(Convert::getConvertDate(trim($aOrderDateTemp[1]), 'Y-m-d'));
                $query->where("(DATE(o.created) BETWEEN {$startOrderdate} AND {$endOrderdate})");
            endif;
        endif;

        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            $query->where('o.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(o.state = 0 OR o.state = 1)');
        }

        // Filter on the level.
        if ($level = $this->getState('filter.level')) {
            $query->where('c.level <= ' . ((int) $level + (int) $baselevel - 1));
        }

        // Filter by author
        $authorId = $this->getState('filter.author_id');

        if (is_numeric($authorId)) {
            $type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
            $query->where('o.created_by ' . $type . (int) $authorId);
        }

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('o.id = ' . (int) substr($search, 3));
            } elseif (stripos($search, 'author:') === 0) {
                $search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
                $query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(o.number LIKE ' . $search . ' OR o.ip_address LIKE ' . $search . ' OR o.device LIKE ' . $search . ' OR o.browser LIKE ' . $search . ' )');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('o.language = ' . $db->quote($language));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'o.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        if ($orderCol == 'o.ordering' || $orderCol == 'category_title') {
            $orderCol = 'c.title ' . $orderDirn . ', o.ordering';
        }

        // SQL server change
        if ($orderCol == 'language') {
            $orderCol = 'l.title';
        }

        if ($orderCol == 'access_level') {
            $orderCol = 'ag.title';
        }

        $query->order($db->escape($orderCol . ' ' . $orderDirn));

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
                ->join('INNER', '#__standard_products AS o ON o.created_by = u.id')
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
            $basename = str_replace('- FileName -', JFactory::getApplication()->get('sitename'), $this->getState('basename'));
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
        if (!class_exists('CurrencyHelper')) {
            JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
        }
        $this->iCurrencyDisplay = $this->getState('list.currency_id');
        $configParams = JComponentHelper::getParams('com_standard');

        $app = JFactory::getApplication();
        if (!isset($this->content)) {
            $this->content = '"'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_STATUS')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_GUEST_NAME')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_EMAIL')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_PHONE_NUMBER')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_CONTACT_TYPE')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_PRODUCT_NAME')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_PAYABLE_AMOUNT')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_CURRENCY_SYMBOL')) . '","'
                    . str_replace('"', '""', JText::_('HEADING_ORDERS_DATE'))
                    . '"' . "\n";

            $aStatus = $this->getStatusList();
            foreach ($this->getItems() as $item) :

//                echo '<pre>';
//                print_r($this->getItems());
//                exit;

                $sStatus = "";
                if (!empty($aStatus)):
                    $sStatus = $aStatus[$item->state];
                endif;
                // === ===
                $contactPhone = isset($item->contact_phone) ? $item->contact_phone : "";
                $sContactType = "";
                $sProductName = "";

                $display_amount = 0;
                $display_symbol = " - ";
                if ($item->total > 0):
                    if ($this->iCurrencyDisplay == ""):
                        $display_amount = $item->total;
                        $display_symbol = $item->payment_currency_symbol;
                    else:
                        $aCuruncyHostory = array();
                        foreach (json_decode($item->currency_history) as $item_curuncy):
                            $aCuruncyHostory[$item_curuncy->id] = $item_curuncy;
                        endforeach;

                        $oCurrA = new stdClass();
                        $oCurrA->id = $item->payment_currency_id;
                        $oCurrA->exchange_rate = $item->payment_currency_rate;

                        $oStyleCurrB = isset($aCuruncyHostory[$this->iCurrencyDisplay]) ? $aCuruncyHostory[$this->iCurrencyDisplay] : $aCuruncyHostory[$item->payment_currency_id];
                        $display_amount = CurrencyHelper::convert($item->total, $oCurrA, $oStyleCurrB);
                        $display_symbol = $oStyleCurrB->symbol;
                    endif;
                endif;
                
                $sOrderDate = JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC5'));

                $this->content .= '"'
                        . str_replace('"', '""', $sStatus) . '","'
                        . str_replace('"', '""', $item->contact_fullName) . '","'
                        . str_replace('"', '""', $item->contact_email) . '","'
                        . str_replace('"', '""', $contactPhone) . '","'
                        . str_replace('"', '""', $sContactType) . '","'
                        . str_replace('"', '""', $sProductName) . '","'
                        . str_replace('"', '""', $display_amount) . '","'
                        . str_replace('"', '""', $display_symbol) . '","'
                        . str_replace('"', '""', $sOrderDate)
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
                $ziproot = $app->get('tmp_path') . '/' . uniqid('seaplanes_orders_') . '.zip';

                // Run the packager
                jimport('joomla.filesystem.folder');
                jimport('joomla.filesystem.file');
                $delete = JFolder::files($app->get('tmp_path') . '/', uniqid('seaplanes_orders_'), false, true);

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
