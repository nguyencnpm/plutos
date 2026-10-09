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
<?php if (!empty(trim($this->itemdescription->title))): ?>
    <div class="item flex-fill mb-4 <?php echo $this->itemdescription->description_status == 0 ? ' system-unpublished' : null; ?>">
        <h4 class="item-subtitle cut-string-multiple-lines"><?php echo $this->itemdescription->title; ?></h4>
        <div class="item-subtitle-masthead line-1 mb-1"></div>
        <div class="content tag-p-mtb-0">
            <?php echo $this->itemdescription->description; ?>
        </div>
    </div>
<?php endif; ?>