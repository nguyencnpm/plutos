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

class HandleAllotmentHelper {

    static $_instance = null;

    public function __construct() {
        
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new HandleAllotmentHelper();
        }
        return self::$_instance;
    }

    public static function updateAllotmentInDB($product, $amount, $signInAllotment, $signOrderedAllotment) {
        $validFields = array('=', '+', '-');
        if (!in_array($signInAllotment, $validFields)) :
            return false;
        endif;
        if (!in_array($signOrderedAllotment, $validFields)) :
            return false;
        endif;
        //sanitize fields
        $pk = (int) $product->product_id;
        $catid = (int) $product->catid;
        $allotment_date = $product->allotment_date;
        $update = array();

        if ($signInAllotment != '=' or $signOrderedAllotment != '='):
            if ($signOrderedAllotment != '=') {
                $update[] = '`booking` = `booking` ' . $signOrderedAllotment . ' ' . (int) $amount;
            }

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->update($db->quoteName("#__standard_allotment"))
                    ->set(implode(", ", $update));
            // Build the WHERE clause for the primary keys.
            $query->where("{$db->quoteName('product_id')}= {$pk}"
                    . " AND {$db->quoteName('catid')} ={$catid}"
                    . " AND {$db->quoteName('date')} ='{$allotment_date}'"
            );

            /*
              $db = JFactory::getDbo();
              $query = 'UPDATE `#__standard_allotment` SET ' . implode(", ", $update)
              . ' WHERE `product_id` = ' . (int) $pk . ' AND `catid` =' . (int) $catid . " AND `date` ='{$allotment_date}'";
             */
            // Setup the query
            $db->setQuery($query);
            try {
                $db->execute(); // $db->query();
            } catch (RuntimeException $e) {
                // JError::raiseWarning(500, $e->getMessage());

                $app = JFactory::getApplication();
                $type = 'error';
                $app->enqueueMessage($e->getMessage(), $type);

                return false;
            }

            return true;
            
        endif;
        return false;
    }

    public static function changeOrderStatus($product) {
        $pk = (int) $product->cancelid;
        $orderid = (int) $product->orderid;

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->update($db->quoteName("#__standard_order_items"))
                ->set($db->quoteName('order_status') . ' = ' . -2);
        // Build the WHERE clause for the primary keys.
        $query->where("id={$pk}");
        // Setup the query
        $db->setQuery($query);
        $db->execute();

        // check and update status order
        $query->clear()
                ->select('COUNT(oi.id) As order_items_count')
                ->from('#__standard_order_items AS oi')
                ->where("oi.order_id={$orderid}")
                ->group('oi.order_id');
        $db->setQuery($query);
        $order_items_count = $db->loadResult();

        $query->clear()
                ->select('COUNT(oi.id) As order_items_count')
                ->from('#__standard_order_items AS oi')
                ->where("oi.order_id={$orderid}")
                ->where('oi.order_status = -2')
                ->group('oi.order_id');
        $db->setQuery($query);
        $order_items_canceled_count = $db->loadResult();

        if (($order_items_count == $order_items_canceled_count) and ! empty($order_items_count) and ! empty($order_items_canceled_count)):
            $query->clear()
                    ->update($db->quoteName("#__standard_orders"))
                    ->set($db->quoteName('state') . ' = ' . -2);
            // Build the WHERE clause for the primary keys.
            $query->where("id={$orderid}");
            // Setup the query
            $db->setQuery($query);
            $db->execute();
        endif;

        return true;
    }

}
