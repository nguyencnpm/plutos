<?php

/**
 * @author      Binh Nguyen
 * @package     Giaiphapcongnghethongtin.Libraries
 * Binh Nguyen
 * 
 * @copyright   Copyright (C) 2017 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
class Convert {

    static $_instance = null;
    var $date = null;

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new Convert();
        }
        return self::$_instance;
    }

    //--------------------- Convert date ---------------------------------------
    public static function getConvertDate($date, $format = "d/m/Y") {
        $pattern = "#(/)#";
        $replacement = "-";
        return date($format, strtotime(preg_replace("#-+#", "-", preg_replace($pattern, $replacement, $date))));
    }

    public static function getConvertDateStrtotime($date) {
        $pattern = "#(/)#";
        $replacement = "-";
        return strtotime(preg_replace("#-+#", "-", preg_replace($pattern, $replacement, $date)));
    }

    public static function timestamp_to_iso8601($timestamp, $utc = true) {
        $datestr = date('Y-m-d\TH:i:sO', $timestamp);
        $pos = strrpos($datestr, "+");
        if ($pos === false) {
            $pos = strrpos($datestr, "-");
        }
        if ($pos !== false) {
            if (strlen($datestr) == $pos + 5) {
                $datestr = substr($datestr, 0, $pos + 3) . ':' . substr($datestr, -2);
            }
        }
        if ($utc) {
            $pattern = '/' .
                    '([0-9]{4})-' . // centuries & years CCYY-
                    '([0-9]{2})-' . // months MM-
                    '([0-9]{2})' . // days DD
                    'T' . // separator T
                    '([0-9]{2}):' . // hours hh:
                    '([0-9]{2}):' . // minutes mm:
                    '([0-9]{2})(\.[0-9]*)?' . // seconds ss.ss...
                    '(Z|[+\-][0-9]{2}:?[0-9]{2})?' . // Z to indicate UTC, -/+HH:MM:SS.SS... for local tz's
                    '/';
            $regs = array();
            if (preg_match($pattern, $datestr, $regs)) {
                return sprintf('%04d-%02d-%02dT%02d:%02d:%02dZ', $regs[1], $regs[2], $regs[3], $regs[4], $regs[5], $regs[6]);
            }
            return false;
        } else {
            return $datestr;
        }
    }

}
