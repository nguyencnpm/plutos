<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Featured Table class.
 *
 * @since  1.6
 */
class StandardTableAllotment extends JTable {

    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  Database connector object
     *
     * @since   1.6
     */
    public function __construct(JDatabaseDriver $db) {
        parent::__construct('#__standard_allotment', 'id', $db);

        // Set the alias since the column is called state
        $this->setColumnAlias('published', 'state');
    }

    /**
     * Overloaded bind function
     *
     * @param   array  $array   Named array
     * @param   mixed  $ignore  An optional array or space separated list of properties
     *                          to ignore while binding.
     *
     * @return  mixed  Null if operation was satisfactory, otherwise returns an error string
     *
     * @see     JTable::bind()
     * @since   11.1
     */
    public function bind($array, $ignore = '') {
        // Bind the rules.
        if (isset($array['rules']) && is_array($array['rules'])) {
            $rules = new JAccessRules($array['rules']);
            $this->setRules($rules);
        }
        return parent::bind($array, $ignore);
    }

    public function checkData($ids = null) {
        $product_id = $ids['product_id'];
        $catid = $ids['catid'];
        $date = $ids['checkdate'];

        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName('id'))
                ->from($db->quoteName('#__standard_allotment'))
                ->where($db->quoteName('product_id') . ' = ' . (int) $product_id)
                ->where($db->quoteName('catid') . ' = ' . (int) $catid)
                ->where("date(" . $db->quoteName('date') . ") = '" . $date . "'");
        $db->setQuery($query);
        return $db->loadResult();
    }

    /**
     * Overrides JTable::store to set modified data and user id.
     *
     * @param   boolean  $updateNulls  True to update fields even if they are null.
     *
     * @return  boolean  True on success.
     *
     * @since   11.1
     */
    public function store($updateNulls = false) {
        $date = JFactory::getDate();
        $user = JFactory::getUser();

        // Check the publish down date is not earlier than publish up.
        if ($this->publish_down > $this->_db->getNullDate() && $this->publish_down < $this->publish_up) {
            // Swap the dates.
            $temp = $this->publish_up;
            $this->publish_up = $this->publish_down;
            $this->publish_down = $temp;
        }
        /*
          if (!empty($updateNulls['start_date']) && intval($updateNulls['start_date']) != 0) {
          $start_date = new JDate($updateNulls['start_date']);
          $start = $start_date->format('Y-m-d');
          }

          if (!empty($updateNulls['expiry_date']) && intval($updateNulls['expiry_date']) != 0) {
          $expiry_date = new JDate($updateNulls['expiry_date']);
          $expiry = $expiry_date->format('Y-m-d');
          }
         */

        if (isset($updateNulls['periodDate']) && !empty($updateNulls['periodDate'])):
            // --- Date period is valid ---
            $delimiter = " - ";
            $arrayTemp = explode($delimiter, trim($updateNulls['periodDate']));
            $temp_startDate = trim($arrayTemp[0]);
            $temp_expiryDate = trim($arrayTemp[1]);
            // --- Get the time offset. ---
            $offset = JFactory::getApplication()->get('offset');
            $sStart = JFactory::getDate($temp_startDate, $offset)->toSql(); // false: Time Zone of SQL (user_utc), default false 
            $sExpiry = JFactory::getDate($temp_expiryDate, $offset)->toSql();
            //$start = JHtml::_('date', $sStart, 'Y-m-d');
            //$expiry = JHtml::_('date', $sExpiry, 'Y-m-d');
        // --- /.Get the time offset. ---
        // --- /.Date period is valid ---
        endif;

        $i = 1;
        $dateALM = strtotime($sStart);
        $dateALMend = strtotime($sExpiry);
        for ($dateALM; $dateALM <= $dateALMend; $i++) {
            $ids['product_id'] = $updateNulls['product_id'];
            $ids['catid'] = $updateNulls['catid'];
            $ids['date'] = date('Y-m-d H:i:s', $dateALM);
            $ids['checkdate'] = date('Y-m-d', $dateALM);
            $key = $this->checkData($ids);
            // ---
            // phai de o day do case: continue;
            $dateALM = strtotime(new JDate($sStart . "+" . $i . " days"));
            //$dateALM = strtotime(date('d-m-Y', strtotime($start)) . "+" . $i . " days");
            // --- 
            // Insert or update the object based on presence of a key value.
            if ($key) {// edit
                $thisUpdateNulls = clone $this;
                $updateNullsTamp = $updateNulls;

                // Check of the day of the week 
                $dayweek = new JDate(JHtml::_('date', $ids['date'], 'Y-m-d'));
                $day = $dayweek->format('w');
                // $days = trim(JString::strtolower($dayweek->dayToString($day)));
                $days = $this->getDays($day);
                
                if (!$updateNullsTamp[$days]) {
                    continue;
                } else {
                    if ($updateNullsTamp['sunsat'] && ($days == 'sunday' || $days == 'saturday')) {
                        $updateNullsTamp['allotment'] = $updateNullsTamp['allotment_' . $days];
                        $thisUpdateNulls->allotment = $updateNullsTamp['allotment_' . $days];
                    }
                    // set value 0 fields of the day of the week no Checked"
                    for ($d = 0; $d <= 6; $d++) {
                        if ($day != $d) {
                            //$day_w = trim(JString::strtolower($dayweek->dayToString($d)));
                            $day_w = $this->getDays($d);
                            $updateNullsTamp[$day_w] = 0;
                            $thisUpdateNulls->$day_w = 0;
                        }
                    }
                }

                // check Invalid: allotment and booking               
                if (!$this->checkInvalid($updateNullsTamp['allotment'], $key)) {
                    $this->setError(JText::sprintf('JLIB_DATABASE_ERROR_INVALID_PERIOD_ALLOTMENT', $days . ': ' . JHtml::_('date', $ids['date'], 'Y-m-d')));
                    return false;
                }

                // Already have a table key, update the row.
                $thisUpdateNulls->id = $key;
                $thisUpdateNulls->date = $ids['date'];

                unset($thisUpdateNulls->booking);

                unset($thisUpdateNulls->created);
                unset($thisUpdateNulls->created_by);
                unset($thisUpdateNulls->created_by_alias);

                $thisUpdateNulls->modified = $date->toSql();
                $thisUpdateNulls->modified_by = $user->get('id');


                $updateNullsTamp['id'] = $key;
                $updateNullsTamp['date'] = $ids['date'];

                unset($updateNullsTamp['created']);
                unset($updateNullsTamp['created_by']);

                $updateNullsTamp['modified'] = $date->toSql();
                $updateNullsTamp['modified_by'] = $user->get('id');

                $this->_db->updateObject($thisUpdateNulls->_tbl, $thisUpdateNulls, $thisUpdateNulls->_tbl_key, $updateNullsTamp);
            } else {// add new
                $thisTamp = clone $this;
                $updateNullsTamp = $updateNulls;
                // Check of the day of the week 
                $dayweek = new JDate(JHtml::_('date', $ids['date'], 'Y-m-d'));
                $day = $dayweek->format('w');
                // $days = trim(JString::strtolower($dayweek->dayToString($day)));
                $days = $this->getDays($day);
               
                if (!$thisTamp->$days) {
                    continue;
                } else {
                    if ($updateNullsTamp['sunsat'] && ($days == 'sunday' || $days == 'saturday')) {
                        $thisTamp->allotment = $updateNullsTamp['allotment_' . $days];
                    }
                    // set value 0 fields of the day of the week no Checked"
                    for ($d = 0; $d <= 6; $d++) {
                        if ($day != $d) {
                            // $day_w = trim(JString::strtolower($dayweek->dayToString($d)));
                            $day_w = $this->getDays($d);
                            $thisTamp->$day_w = 0;
                        }
                    }
                }

                $thisTamp->id = null;
                $thisTamp->date = $ids['date'];

                $thisTamp->created = $date->toSql();
                $thisTamp->created_by = $user->get('id');

                unset($thisTamp->modified);
                unset($thisTamp->modified_by);
                //$thisTamp->modified = null;
                //$thisTamp->modified_by = null;
                $thisTamp->publish_up = $date->toSql();
                // Don't have a table key, insert the row.
                $this->_db->insertObject($thisTamp->_tbl, $thisTamp, $thisTamp->_tbl_key);
            }
        }

        return true;
    }

    public function checkInvalid($allotment, $pk) {
        // Verify that the ordered "Booking"
        $table = JTable::getInstance('Allotment', 'StandardTable', array('dbo' => $this->getDbo()));
        $table->load($pk);
        if ((int) $table->booking > 0 && (int) $table->booking > (int) $allotment) {
            return false; // $this->setError(JText::_('JLIB_DATABASE_ERROR_INVALID_PERIOD_ALLOTMENT'));
        }
        return true;
    }

    public function getDays($day) {
        // khong su dung " function dayToString" nay duoc trong truong hop da ngon ngu (VD: co them tieng viet se loi)
        // $days = trim(JString::strtolower($dayweek->dayToString($day))); 
        $days = "";
        switch ($day) {
            case '0':
                $days = "sunday";

                break;
            case '1':
                $days = "monday";

                break;
            case '2':
                $days = "tuesday";

                break;
            case '3':
                $days = "wednesday";

                break;
            case '4':
                $days = "thursday";

                break;

            case '5':
                $days = "friday";

                break;
            case '6':
                $days = "saturday";

                break;

            default:
                break;
        }
        return $days;
    }

}
