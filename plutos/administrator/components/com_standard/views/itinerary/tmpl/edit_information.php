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
            <div class="span8"><?php echo $this->form->getControlGroup('paymenttype_id');?></div>
            <div class="span4"><?php echo $this->form->getControlGroup('merge_column'); ?></div>
        </div>
        <!--
        <div class="row-fluid">
             <div class="span6">&nbsp;</div>
            <div class="span6"><?php // echo $this->form->getControlGroup('in_stock');    ?></div>
        </div>
        -->
        <div class="row-fluid">
            <div class="alert alert-info">
                <div class="span12">
                    <div class="row-fluid">
                        <div class="span6"><?php echo $this->form->getControlGroup('number_days'); ?></div>
                        <div class="span6"><?php echo $this->form->getControlGroup('number_nights'); ?></div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="row-fluid">
                                <div class="span4"><?php echo $this->form->getControlGroup('adult'); ?></div>
                                <div class="span4"><?php echo $this->form->getControlGroup('children'); ?></div>
                                <div class="span4"><?php echo $this->form->getControlGroup('infant'); ?></div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="row-fluid">
                                <div class="span6"><?php echo $this->form->getControlGroup('price'); ?></div>
                                <div class="span6"><?php echo $this->form->getControlGroup('currency_id'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php echo $this->form->getInput('itinerarytext'); ?>
    </div>
</fieldset>
