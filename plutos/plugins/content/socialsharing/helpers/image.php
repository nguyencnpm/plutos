<?php

/**
 * @package     Giaiphapcongnghethongtin.vn.Plugin
 * @subpackage  Content.socialsharing
 * @author      Binh Nguyen
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

abstract class PluginImageHelper {

    /**
     * @author      Binh Nguyen
     * check the image source is existed ?
     *
     * @param string $imageSource the path of image source.
     * @access public,
     * @return boolean,
     */
    public static function parseImage($row) {

        //check to see if there is an  intro image or fulltext image  first
        $images = "";
        if (isset($row->images)) :
            $images = json_decode($row->images); //image_medium
        endif;
        if ((isset($images->image_fulltext) and ! empty($images->image_fulltext)) || (isset($images->image_intro) and ! empty($images->image_intro))) :
            $image = (isset($images->image_intro) and ! empty($images->image_intro)) ? $images->image_intro : ((isset($images->image_fulltext) and ! empty($images->image_fulltext)) ? $images->image_fulltext : "");
        elseif ((isset($images->image_full) and ! empty($images->image_full)) || (isset($images->image_medium) and ! empty($images->image_medium))) :
            $image = (isset($images->image_medium) and ! empty($images->image_medium)) ? $images->image_medium : ((isset($images->image_full) and ! empty($images->image_full)) ? $images->image_full : "");
        else:
            $regex = '/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/';
            $text = '';
            $text .= (isset($row->fulltext)) ? $row->fulltext : '';
            $text .= (isset($row->introtext)) ? $row->introtext : '';
            preg_match($regex, $text, $matches);
            $images = (count($matches)) ? $matches : array();
            $image = count($images) > 1 ? $images[1] : '';
        endif;
        return $image;
    }

}
