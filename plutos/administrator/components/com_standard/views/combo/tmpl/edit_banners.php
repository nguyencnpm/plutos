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
<div class="well alert-info">
    <div class="row-fluid">
        <div class="span6">
            <div class="row-fluid form-vertical">
                <div class="span12">
                    <?php echo $this->loadTemplate('bannersDesktop'); ?>
                </div>
            </div>
            <hr/>
            <div class="row-fluid form-vertical">
                <div class="span12">
                    <?php echo $this->loadTemplate('bannersTablet'); ?>
                </div>
            </div>
            <hr/>
            <div class="row-fluid form-vertical">
                <div class="span12">
                    <?php echo $this->loadTemplate('bannersPhone'); ?>
                </div>
            </div>
        </div>
        <div class="span6">
            <?php //echo $this->form->renderField('banners'); ?>
            <?php echo $this->form->getControlGroup('banner_status'); ?>
            <?php echo $this->form->getControlGroup('banner_home'); ?>
            <?php foreach ($this->form->getGroup('banners') as $field) : ?>
                <?php echo $field->renderField(); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>