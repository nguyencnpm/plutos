<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="item flex-fill mb-4 column-<?php echo $this->rowcount; ?><?php echo $this->itemplan->plans_status == 0 ? ' system-unpublished' : null; ?>">
    <h4 class="item-subtitle cut-string-multiple-lines"><?php echo $this->itemplan->title; ?></h4>
    <div class="item-subtitle-masthead line-1 mb-1"></div>
    <div class="content tag-p-mtb-0"><?php echo $this->itemplan->plans; ?></div>
</div>

