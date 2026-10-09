<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="row-fluid">
    <div class="span4">
        <div class="alert alert-info">
            <div class="row-fluid">
                <?php echo $this->loadTemplate('imagesplan'); ?>
            </div>
        </div>
    </div>
    <div class="span8">
        <div class="alert alert-success">
            <div class="row-fluid">
                <div class="span6 alert">
                    <?php echo $this->form->getControlGroup('plans_displaytype_id'); ?>
                </div>
                <div class="span6 alert">
                    <?php echo $this->form->getControlGroup('plans_column'); ?>
                </div>
            </div>
            <div class="row-fluid">
                <?php echo $this->loadTemplate('plan'); ?>
            </div>
        </div>
    </div>
</div>
