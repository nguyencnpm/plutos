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

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use nav instead
?>
<ul class="sidebar-menu mr-auto <?php echo $class_sfx; ?> <?php echo $justify_content; ?> <?php echo $direction; ?>"<?php echo $id; ?>">
    <li class="sidebar-dropdown">
        <a href="#"> Dashboard </a>

        <ul class="sidebar-submenu">
            <li>
                <a href="#">Dashboard 1</a>
            </li>
            <li>
                <a href="#">Dashboard 2</a>
            </li>
            <li>
                <a href="#">Dashboard 3</a>
            </li>
        </ul>
    </li>
    <li class="sidebar-dropdown">
        <a href="#"> E-commerce </a>
        <ul class="sidebar-submenu">
            <li>
                <a href="#">Products</a>
            </li>
            <li>
                <a href="#">Orders</a>
            </li>
            <li>
                <a href="#">Credit cart</a>
            </li>
        </ul>
    </li>
</ul>