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
            <div class="row-fluid form-vertical">
                <div class="span6">
                    <?php echo $this->form->getControlGroup('plans_mediadisplaytype'); ?>
                </div>

                <div class="span6">
                    <?php echo $this->form->getControlGroup('plans_medialayoutelement'); ?>
                </div>
            </div>
            <div class="row-fluid">
                <?php echo $this->loadTemplate('imagesplan'); ?>
            </div>
        </div>
    </div>
    <div class="span8">
        <div class="alert alert-success">
            <div class="row-fluid form-vertical">

                <div class="span4">
                    <?php echo $this->form->getControlGroup('plans_displaytype_id'); ?>
                </div>

                <div class="span4">
                    <?php echo $this->form->getControlGroup('plans_layout'); ?>
                </div>

                <div class="span4">
                    <?php echo $this->form->getControlGroup('plans_layoutelement'); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6 alert">
                    <div class="row-fluid">
                        <div class="span12">
                            <?php echo $this->form->getControlGroup('plans_num_leading'); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <?php echo $this->form->getControlGroup('plans_column_leading'); ?>
                        </div>
                    </div>
                </div>
                <div class="span6 alert">
                    <div class="row-fluid">
                        <div class="span12">
                            <?php echo $this->form->getControlGroup('plans_num_intro'); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <?php echo $this->form->getControlGroup('plans_column_intro'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <?php echo $this->loadTemplate('plan'); ?>
            </div>
        </div>
    </div>
</div>
