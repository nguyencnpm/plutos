<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$pageHeader = "page-header";
$headerLevel = "1";
$showMasthead = true;
?>
<div class="col-12">
    <div class="inventory<?php echo $this->pageclass_sfx; ?>">
        <div id="jsonInventory" data-inventory='<?php //echo $this->jsonInventory; ?>'></div>
        <input type="hidden" id="sTypeChart" value="<?php echo $this->sTypeChart; ?>"/>
        <canvas class="my-4 w-100" id="chartDrawingPosition" height="auto"></canvas>
    </div>
</div>