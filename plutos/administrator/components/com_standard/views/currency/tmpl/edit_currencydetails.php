<?php
defined('_JEXEC') or die;
?>

<?php echo $this->form->getControlGroup('exchange_rate'); ?>
<?php echo $this->form->getControlGroup('code_2'); ?>
<?php echo $this->form->getControlGroup('code_3'); ?>
<?php //echo $this->form->getControlGroup('numeric_code'); ?>
<?php echo $this->form->getControlGroup('symbol'); ?>
<?php echo $this->form->getControlGroup('decimal_place'); ?>
<?php echo $this->form->getControlGroup('decimal_symbol'); ?>
<?php echo $this->form->getControlGroup('thousands'); ?>
<?php echo $this->form->getControlGroup('positive_style'); ?>
<?php echo $this->form->getControlGroup('negative_style'); ?>

<?php echo JText::_("COM_STANDARD_CURRENCY_DISPLAY_EXPL");?>

