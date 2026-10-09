<?php
defined('_JEXEC') or die;
?>
<div class="row-fluid">
    <div class="span6"><?php echo $this->form->getControlGroup('telephone'); ?></div>
    <div class="span6"><?php echo $this->form->getControlGroup('email'); ?></div>
</div>
<div class="row-fluid">
    <div class="span6"><?php echo $this->form->getControlGroup('mobile'); ?></div>
    <div class="span6"><?php echo $this->form->getControlGroup('address'); ?></div>
</div>
<div class="row-fluid">
    <div class="span6"><?php echo $this->form->getControlGroup('fax'); ?></div>
    <div class="span6"><?php echo $this->form->getControlGroup('country_id'); ?></div>
</div>
<div class="row-fluid">
    <div class="span6"><?php echo $this->form->getControlGroup('credit'); ?></div>
    <div class="span6"><?php echo $this->form->getControlGroup('state_id'); ?></div>
</div>
<?php //echo $this->form->getControlGroup('catid'); ?>
<?php echo $this->form->getInput('agenttext'); ?>
