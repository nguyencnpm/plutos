<?php

/**
 * @author      Binh Nguyen! Project
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_smartmenus
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$attributes = array();
$class = '';
if ($item->anchor_title) {
    $attributes['title'] = $item->anchor_title;
}
/*
  if ($item->anchor_css) {
  $class .= $item->anchor_css;
  }
 */
if ($item->anchor_rel) {
    $attributes['rel'] = $item->anchor_rel;
}

if ($item->level > 1):
    $class .= ' dropdown-item ';
else:
    $class .= ' nav-link ';
endif;

if ($item->parent) :// Binh Nguyen modify
    if (!$end || ($end && $item->level < $end)) ://Binh Nguyen modify
        // $class .= ' dropdown-toggle ';
    endif;
    
    $attributes['data-toggle'] = ''; // 'dropdown'
    $attributes['aria-haspopup'] = 'true';
    $attributes['aria-expanded'] = 'false';
endif;

$attributes['class'] = $class;
// nav-link
// $linktype = $item->title;
// Binh Nguyen modify
if ($item->anchor_css):
    $linktype = '<i class="' . $item->anchor_css . '" aria-hidden="true"></i> ' . $item->title;
else:
    $linktype = $item->title;
endif;


if ($item->menu_image) {
    if ($item->menu_image_css) {
        $image_attributes['class'] = $item->menu_image_css;
        $linktype = JHtml::_('image', $item->menu_image, $item->title, $image_attributes);
    } else {
        $linktype = JHtml::_('image', $item->menu_image, $item->title);
    }

    if ($item->params->get('menu_text', 1)) {
        $linktype .= '<span class="image-title">' . $item->title . '</span>';
    }
}

if ($item->browserNav == 1) {
    $attributes['target'] = '_blank';
} elseif ($item->browserNav == 2) {
    $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes';

    $attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

echo JHtml::_('link', JFilterOutput::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
