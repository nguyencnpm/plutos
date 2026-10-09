<?php
/**
 * @author      Binh Nguyen
 * @package     Giaiphapcongnghethongtin.Settings
 * @subpackage  com_hotelsresorts
 *
 * @copyright   Copyright (C) 2017 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_PLATFORM') or die;

define('SOURCE_CODE', 'VIC');
define('SOURCE_GROUP', 'WEB');

class SmileConfiguration{
    static public function getConfiguration($service_function=''){
        $arrConfiguration = array(array());
        // --- CreateBooking ---

        // --- CancelBooking ---

        
        return $arrConfiguration[$service_function];
    }
}

