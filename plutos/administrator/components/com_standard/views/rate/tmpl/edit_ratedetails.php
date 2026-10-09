<?php defined('_JEXEC') or die; ?>
<div class="row-fluid">
    <div class="well well--rate">
        <div class="span6"><?php echo $this->form->getControlGroup('currency_id'); ?></div>
        <div class="span6"><?php echo $this->form->getControlGroup('code'); ?></div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php echo $this->loadTemplate('rates'); ?>
    </div>
</div>
