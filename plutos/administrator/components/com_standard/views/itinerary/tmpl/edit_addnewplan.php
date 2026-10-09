<?php
defined('_JEXEC') or die;
$editor = JFactory::getEditor();
$name = "jform[plans][0][plans]";
$value = "";
$width = '100%';
$height = '280';
$columns = '15';
$rows = '5';
?>
<div id="plans-field0" class="row0 alert alert-info sortable-cursor-move">
    <span class="icon-menu"></span>
    <div class=" form-vertical">
        <div class="row-fluid">
            <div class="span8">
                <!-- Text input-->
                <div class="control-group">
                    <div class="control-label">
                        <label id="jform_plans_title-lbl0" for="jform_plans_title0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>">
                            <?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>
                        </label>
                    </div>
                    <div class="controls">
                        <input class="span12" name="jform[plans][0][title]" id="jform_plans_title0" value="" type="text">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <div class="control-label">
                        <label id="jform_plans_merge_column-lbl0" for="jform_plans_merge_column0" class="hasTooltip" title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>">
                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>
                        </label>
                    </div>
                    <div class="controls">
                        <input class="span12" type="number" name="jform[plans][0][merge_column]" id="jform_plans_merge_column0" value="0" step="1" min="0">
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <div class="control-label">
                        <label id="jform_plans_status-lbl0" for="jform_plans_status0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>">
                            <?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>
                        </label>
                    </div>
                    <div class="controls">
                        <fieldset id="jform_fieldset_plans_status0" class="btn-group btn-group-yesno radio">
                            <input id="jform_show_plans_status0" name="jform[plans][0][plans_status]" value="1" checked="checked" type="radio">			
                            <label for="jform_show_plans_status0" class="btn">
                                <?php echo JText::_('JSHOW'); ?>			
                            </label>
                            <input id="jform_hide_plans_status0" name="jform[plans][0][plans_status]" value="0" type="radio">			
                            <label for="jform_hide_plans_status0" class="btn">
                                <?php echo JText::_('JHIDE'); ?>			
                            </label>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="span6">
                <label>&nbsp;</label>
                <select id="jform_featured0" name="jform[plans][0][featured]" class="chzn-color-state span12">
                    <option value="2" selected="selected"><?php echo JText::_('COM_STANDARD_UN_FEATURED'); ?></option>
                    <option value="1"><?php echo JText::_('COM_STANDARD_FEATURED'); ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?php echo $editor->display($name, $value, $width, $height, $columns, $rows); ?>
        </div>
    </div>
    <button id="plans-remove0" class="btn btn-danger remove-me" >
        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
    </button>
</div><!-- end field Add More -->