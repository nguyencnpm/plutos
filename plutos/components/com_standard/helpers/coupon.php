<?php

/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

abstract class CouponHelper {

    /**
     * Returns a Table object, always creating it.
     *
     * @param   string  $type    The table type to instantiate
     * @param   string  $prefix  A prefix for the table class name. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  JTable    A database object
     */
    static public function getTable($type = 'Coupon', $prefix = 'StandardTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Check if the given coupon code exists, is (still) valid and valid for the total order amount
     * @param string $_code Coupon code
     * @param float $_billTotal Total amount for the order
     * @author Binh Nguyen
     * @return string Empty when the code is valid, otherwise the error message
     */
    static public function ValidateCouponCode($_code, $_billTotal) {

        if (empty($_code) or $_code == JText::_('COM_STANDARD_COUPON_CODE_ENTER') or $_code == JText::_('COM_STANDARD_COUPON_CODE_CHANGE')) :
            return '';
        endif;
        $couponData = 0;

        if (empty($couponData)) :
            // Create a new query object.
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            // Construct the query
            $query->select('IFNULL(NOW() >= ct.start_date OR ct.start_date="0000-00-00 00:00:00" , 1) AS started'
                            . ', ct.start_date'
                            . ', IFNULL(ct.expiry_date!="0000-00-00 00:00:00" and NOW() > ct.expiry_date, 0) AS `ended`'
                            . ', ct.expiry_date'
                            . ', ct.value_mathop'
                            . ', ct.currency_id'
                            . ', ct.value'
                            . ', ct.value_valid'
                            . ', ct.limit'
                            . ', c.used'
                    )
                    ->from('#__standard_couponstypes AS ct')
                    ->join('LEFT', '#__standard_coupons AS c ON c.coupontype_id = ct.id')
                    ->where("c.code ='{$db->escape($_code)}'");

            // Setup the query
            $db->setQuery($query);

            // result
            $couponData = $db->loadObject();
        endif;

        if (!$couponData) :
            return JText::_('COM_STANDARD_COUPON_CODE_INVALID');
        endif;

        if ($couponData->used) :
            /*
              $session = JFactory::getSession();
              $session_id = $session->getId();
              if ($couponData->used != $session_id) :
              return JText::_('COM_STANDARD_COUPON_CODE_INVALID');
              endif;
             */
            if ($couponData->used >= $couponData->limit) :
                return JText::_('COM_STANDARD_COUPON_CODE_HAS_BEEN_USED');
            endif;
        endif;

        if (!$couponData->started) :
            return JText::_('COM_STANDARD_COUPON_CODE_NOTYET') . $couponData->start_date;
        endif;

        if ($couponData->ended) :
            //self::RemoveCoupon($_code, true);
            return JText::_('COM_STANDARD_COUPON_CODE_EXPIRED');
        endif;

        /*
          if ($_billTotal < $couponData->value_valid) :

          $currency = CurrencyHelper::getInstance();
          $value_valid = $currency->priceDisplay($couponData->value_valid);
          return JText::_('COM_STANDARD_COUPON_CODE_TOOLOW') . " " . $value_valid;
          endif;
         */
        return '';
    }

    /**
     * Get the details for a given coupon
     * @param string $_code Coupon code
     * @author Binh Nguyen
     * @return object Coupon details
     */
    static public function getCouponDetails($_code) {
        // Create a new query object.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Construct the query
        $query->select('ct.value_mathop'
                        . ', ct.currency_id'
                        . ', ct.value'
                        . ', ct.value_valid'
                        . ', ct.limit'
                        . ', c.used'
                )
                ->from('#__standard_couponstypes AS ct')
                ->join('LEFT', '#__standard_coupons AS c ON c.coupontype_id = ct.id')
                ->where("c.code ='{$db->escape($_code)}'");

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadObject();
    }

    /** 
     * UPDATE a coupon_used from the database
     * @author Binh Nguyen
     * @return boolean True on success
     */
    static public function setInUseCoupon($code, $in_use = true, $coupon_used = null) {
        // --- get data in database of table #__standard_coupons and update used
        if (is_numeric($coupon_used)) :
            $tableCoupon = self::getTable('Couponcode');
            $tableCoupon->load($code);

            $tableCoupon->used = (int) $tableCoupon->used + (int) $coupon_used;
            return $tableCoupon->store();
        endif;
        return false;
    }

}
