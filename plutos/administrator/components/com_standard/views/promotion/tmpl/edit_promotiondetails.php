<?php defined('_JEXEC') or die; ?>

<?php echo $this->form->getControlGroup('value_mathop'); ?>

<div class="row-fluid">
    <div class="span6"><?php echo $this->form->getControlGroup('value'); ?></div>
    <div class="span6"><?php echo $this->form->getControlGroup('currency_id'); ?></div>
</div>
<div class="row-fluid datepicker_date">
    <div class="span6"><?php echo $this->form->getControlGroup('start_date'); ?></div>
    <div class="span6"><?php echo $this->form->getControlGroup('expiry_date'); ?></div>
</div>
<?php //echo $this->form->getControlGroup('catid'); ?>
<?php //echo $this->form->getControlGroup('manufacturer_id'); ?>
<?php echo $this->form->getInput('promotiontext'); ?>




