<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<ul class=""><?php // nav nav-tabs nav-stacked ?>
    <?php foreach ($this->link_items as &$item) : ?>
        <li>
            <a href="<?php echo JRoute::_(StandardHelperRoute::getItineraryRoute($item->slug, $item->itinerarytype_id, $item->language)); ?>">
                <?php echo $item->title; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
