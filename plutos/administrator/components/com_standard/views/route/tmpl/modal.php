<?php
defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip', '.hasTooltip', array('placement' => 'bottom'));

// @deprecated 4.0 the function parameter, the inline js and the buttons are not needed since 3.7.0.
$function = JFactory::getApplication()->input->getCmd('function', 'jEditType_' . (int) $this->item->id);

// Function to update input title when changed
JFactory::getDocument()->addScriptDeclaration('
	function jEditTypeModal() {
		if (window.parent && document.formvalidator.isValid(document.getElementById("item-form"))) {
			return window.parent.' . $this->escape($function) . '(document.getElementById("jform_title").value);
		}
	}
');
?>
<button id="applyBtn" type="button" class="hidden" onclick="Joomla.submitbutton('route.apply'); jEditTypeModal();"></button>
<button id="saveBtn" type="button" class="hidden" onclick="Joomla.submitbutton('route.save'); jEditTypeModal();"></button>
<button id="closeBtn" type="button" class="hidden" onclick="Joomla.submitbutton('route.cancel');"></button>

<div class="container-popup">
    <?php $this->setLayout('edit'); ?>
    <?php echo $this->loadTemplate(); ?>
</div>
