<?php defined('_JEXEC') or die; ?>
<div class="row-fluid">
    <div class="span12 alert well">
        <div class="row-fluid">
            <div class="span12"><?php echo $this->form->getControlGroup('kind'); ?></div>
        </div>

        <div class="row-fluid">
            <div class="span12"><?php echo $this->form->getControlGroup('value_mathop'); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span6"><?php echo $this->form->getControlGroup('value'); ?></div>
            <div class="span6"><?php echo $this->form->getControlGroup('currency_id'); ?></div>
        </div>
        <?php echo $this->form->getControlGroup('descr'); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span12 alert alert-success">
        <?php echo $this->form->getControlGroup('catid'); ?>
        <?php echo $this->form->getControlGroup('manufacturer_id'); ?>
    </div>
</div>