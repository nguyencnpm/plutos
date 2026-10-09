<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<fieldset class="adminform">
    <div class="form-vertical">
        <div class="row-fluid">
            <div class="span6"><?php echo $this->form->getControlGroup('paymenttype_id'); ?></div>
            <div class="span6"><?php echo $this->form->getControlGroup('in_stock'); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span6"><?php echo $this->form->getControlGroup('price'); ?></div>
            <div class="span6"><?php echo $this->form->getControlGroup('currency_id'); //echo $this->form->getInput('currency');   ?></div>
        </div>

        <?php echo $this->form->getInput('producttext'); ?>
    </div>
</fieldset>
