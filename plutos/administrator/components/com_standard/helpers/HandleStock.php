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

class HandleStockHelper {

    static $_instance = null;

    public function __construct() {
        
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new HandleStockHelper();
        }
        return self::$_instance;
    }
    
    public static function updateStockInDB($product, $amount, $signInStock, $signOrderedStock) {
        $validFields = array('=', '+', '-');
        if (!in_array($signInStock, $validFields)) :
            return FALSE;
        endif;
        if (!in_array($signOrderedStock, $validFields)) :
            return FALSE;
        endif;
        //sanitize fields
        $pk = (int) $product->id; // product_id
        $update = array();

        if ($signInStock != '=' or $signOrderedStock != '='):
            if ($signOrderedStock != '=') {
                $update[] = '`ordered` = `ordered` ' . $signOrderedStock . ' ' . (int) $amount;
            }

            $db = JFactory::getDbo();
            $query = 'UPDATE `#__standard_products` SET ' . implode(", ", $update) . ' WHERE `id` = ' . (int) $pk;
            $db->setQuery($query);
            $db->execute(); // $db->query();
        endif;
    }

}
