<?php

defined('_JEXEC') or die;

// Create the copy/move options.
$options = array(
    JHtml::_('select.option', 'add', JText::_('COM_STANDARD_BATCH_ADD')),
    JHtml::_('select.option', 'del', JText::_('COM_STANDARD_BATCH_DELETE')),
    JHtml::_('select.option', 'set', JText::_('COM_STANDARD_BATCH_SET'))
);

// Create the reset password options.
$resetOptions = array(
    JHtml::_('select.option', '', JText::_('COM_STANDARD_NO_ACTION')),
    JHtml::_('select.option', 'yes', JText::_('JYES')),
    JHtml::_('select.option', 'no', JText::_('JNO'))
);
JHtml::_('formbehavior.chosen', 'select');
?>

<div class="container-fluid">
    <div class="row-fluid">
        <div id="batch-choose-action" class="combo control-group">
            <label id="batch-choose-action-lbl" class="control-label" for="batch-choose-action">
                <?php echo JText::_('COM_STANDARD_BATCH_GROUP'); ?>
            </label>
        </div>
        <div id="batch-choose-action" class="combo controls">
            <div class="control-group">
                <select name="batch[group_id]" id="batch-group-id">
                    <option value=""><?php echo JText::_('JSELECT'); ?></option>
                    <?php echo JHtml::_('select.options', JHtml::_('user.groups')); ?>
                </select>
            </div>
        </div>
        <div class="control-group radio">
            <?php echo JHtml::_('select.radiolist', $options, 'batch[group_action]', '', 'value', 'text', 'add'); ?>
        </div>
    </div>
    <label><?php echo JText::_('COM_STANDARD_REQUIRE_PASSWORD_RESET'); ?></label>
    <div class="control-group radio">
        <?php echo JHtml::_('select.radiolist', $resetOptions, 'batch[reset_id]', '', 'value', 'text', ''); ?>
    </div>
</div>
