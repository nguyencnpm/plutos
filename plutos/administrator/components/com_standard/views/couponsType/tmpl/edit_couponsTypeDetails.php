<?php defined('_JEXEC') or die; ?>
<div class="span12 alert well">
    <fieldset class="form-vertical">
        <div class="row-fluid">
            <div class="span4">
                <div class="row-fluid">
                    <div class="span6"><?php echo $this->form->getControlGroup('prefix'); ?></div>
                    <div class="span6"><?php echo $this->form->getControlGroup('limit'); ?></div>
                </div>
            </div>
            <div class="span8">
                <div class="row-fluid">
                    <div class="span6"><?php echo $this->form->getControlGroup('start_date'); ?></div>
                    <div class="span6"><?php echo $this->form->getControlGroup('expiry_date'); ?></div>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<fieldset class="form-vertical">
    <div class="row-fluid">
        <div class="span12 alert alert-success">
            <div class="row-fluid">
                <div class="span4">
                    <?php echo $this->form->getControlGroup('value_mathop'); ?>
                </div>
                <div class="span4">
                    <?php echo $this->form->getControlGroup('value'); ?>
                </div>

                <div class="span4">
                    <?php echo $this->form->getControlGroup('currency_id'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 alert alert-info">
            <div class="row-fluid">
                <div class="span12">
                    <?php echo $this->form->getControlGroup('catid'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 alert alert-info">
            <div class="row-fluid">
                <div class="span12">
                    <?php echo $this->form->getControlGroup('manufacturer_id'); ?>
                </div>
            </div>
        </div>
    </div>
</fieldset>