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
    <div class="warning">
        <div class="text-danger text-center"><?php echo JText::_('Not allowed to access this page');?></div>
    </div>
</div>

