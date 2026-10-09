<?php
defined('_JEXEC') or die;
?>
<a class="btn" type="button" onclick="document.getElementById('batch-group-id').value = ''" data-dismiss="modal">
    <?php echo JText::_('JCANCEL'); ?>
</a>
<button class="btn btn-success" type="submit" onclick="Joomla.submitbutton('user.batch');">
    <?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
</button>