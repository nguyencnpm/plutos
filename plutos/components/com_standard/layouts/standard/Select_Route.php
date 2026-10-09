<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

$params = $displayData['params'];
$item = $displayData['item'];

//echo '<pre>';
//print_r($params);
//exit;
?>

<div class="route">
    <p class="title">
        <?php echo $item->route_title; ?>: 
        <?php
        echo $item->route_number_days;
        echo ' ';
        echo $item->route_number_days > 1 ? JText::_('DAYS') : JText::_('DAY');
        ?>
    </p>
    <?php if (!empty($item->route_subtitle)): ?>
        <p class="route-Sub">
            <?php echo $item->route_subtitle; ?>
        </p>
    <?php endif; ?>
    <p class="title">
        <?php echo JText::_('COM_STANDARD_DEPARTURE_DAY'); ?>:
        <span class="date"><?php echo JHtml::_('date', trim($item->allotment_date), JText::_('TPL_DAY_FORMAT')); ?></span>
    </p>

    <p class="title">
        <?php echo JText::_('COM_STANDARD_ARRIVAL_DAY'); ?>:
        <?php
        $d = (int)$item->route_number_days - 1;
        $oArrival = new JDate($item->allotment_date . "+" . $d . " days");
        $sArrival = $oArrival->format('Y-m-d H:i:s');
        ?>
        <span class="date"><?php echo JHtml::_('date', $sArrival, JText::_('TPL_DAY_FORMAT')); ?></span>
    </p>
</div>
