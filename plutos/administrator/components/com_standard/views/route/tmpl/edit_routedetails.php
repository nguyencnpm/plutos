<?php defined('_JEXEC') or die; ?>
<div class="row-fluid">
    <div class="span6"><?php echo $this->form->getControlGroup('code'); ?></div>
    <div class="span6"><?php echo $this->form->getControlGroup('catid'); ?></div>
</div>
<fieldset class="form-vertical">
    <div class="row-fluid">
        <div class="span5 alert well">
            <div class="row-fluid">
                <div class="span8"><?php echo $this->form->getControlGroup('departure_day'); ?></div>
                <div class="span4"><?php echo $this->form->getControlGroup('number_days'); ?></div>
            </div>
        </div>
        <div class="span7 alert alert-success">
            <div class="row-fluid">
                <div class="span6"><?php echo $this->form->getControlGroup('departure_time'); ?></div>
                <div class="span6"><?php echo $this->form->getControlGroup('arrival_time'); ?></div>
            </div>
        </div>
    </div>
</fieldset>