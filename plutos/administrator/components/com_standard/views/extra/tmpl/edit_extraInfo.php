<?php defined('_JEXEC') or die; ?>
<fieldset class="form-vertical">
    <div class="row-fluid">
        <div class="span4 alert well">
            <?php echo $this->form->getControlGroup('currency_id'); ?>
        </div>
        <div class="span4 alert alert-info">
            <?php echo $this->form->getControlGroup('price'); ?>
        </div>
        <div class="span4 alert alert-info">
            <?php echo $this->form->getControlGroup('tax_id'); ?>
        </div>
    </div>
</fieldset>

<fieldset class="form-vertical">
    <!--
    <div class="row-fluid">
        <div class="span12 alert alert-success">
            <div class="row-fluid">
                <div class="span3">
                    <?php //echo $this->form->getControlGroup('nbproducts_start'); ?>
                </div>
                <div class="span3">
                    <?php //echo $this->form->getControlGroup('nbproducts_stop'); ?>
                </div>
                <div class="span3">
                    <?php //echo $this->form->getControlGroup('orderamount_start'); ?>
                </div>
                <div class="span3">
                    <?php //echo $this->form->getControlGroup('orderamount_stop'); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?php //echo $this->form->getControlGroup('package_fee'); ?>
                </div>
                <div class="span6">
                    <?php //echo $this->form->getControlGroup('free_extra'); ?>
                </div>
            </div>
        </div>
    </div>
    -->
    <div class="row-fluid">
        <div class="span12 alert alert-info">
            <div class="row-fluid">
                <div class="span12">
                    <?php echo $this->form->getControlGroup('catid'); ?>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="row-fluid">
        <div class="span12 alert alert-info">
            <div class="row-fluid">
                <div class="span12">
                    <?php // echo $this->form->getControlGroup('manufacturer_id'); ?>
                </div>
            </div>
        </div>
    </div>
    -->
</fieldset>