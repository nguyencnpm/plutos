<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$editor = JFactory::getEditor();
$width = '100%';
$height = '280';
$columns = '15';
$rows = '5';
?>
<div class="span12">
    <div id="plans-field">
        <?php $j = 0; ?>
        <?php if (!empty($this->item->plans)): ?>
            <?php foreach ($this->item->plans as $i => $v_item) : ?>
                <div id="plans-field<?php echo $i; ?>" class="row<?php echo $i % 2; ?> alert alert-info sortable-cursor-move">
                    <span class="icon-menu"></span>
                    <div class="form-vertical">
                        <div class="row-fluid">
                            <div class="span8">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_plans_title-lbl<?php echo $i; ?>" for="jform_plans_title<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" name="jform[plans][<?php echo $i; ?>][title]" id="jform_plans_title<?php echo $i; ?>" value="<?php echo $v_item['title']; ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_plans_merge_column-lbl<?php echo $i; ?>" for="jform_plans_merge_column<?php echo $i; ?>" class="hasTooltip" title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input type="number" name="jform[plans][<?php echo $i; ?>][merge_column]" id="jform_plans_merge_column<?php echo $i; ?>" value="<?php echo $v_item['merge_column']; ?>" step="1" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_plans_status-lbl<?php echo $i; ?>" for="jform_plans_status<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <fieldset id="jform_fieldset_plans_status<?php echo $i; ?>" class="btn-group btn-group-yesno radio">
                                            <input id="jform_show_plans_status<?php echo $i; ?>" name="jform[plans][<?php echo $i; ?>][plans_status]" value="1" <?php echo $v_item['plans_status'] == 1 ? "checked='checked'" : ""; ?> type="radio">			
                                            <label for="jform_show_plans_status<?php echo $i; ?>" class="btn ">
                                                <?php echo JText::_('JSHOW'); ?>			
                                            </label>
                                            <input id="jform_hide_plans_status<?php echo $i; ?>" name="jform[plans][<?php echo $i; ?>][plans_status]" value="0" <?php echo $v_item['plans_status'] == 0 ? "checked='checked'" : ""; ?> type="radio">			
                                            <label for="jform_hide_plans_status<?php echo $i; ?>" class="btn">
                                                <?php echo JText::_('JHIDE'); ?>			
                                            </label>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <label>&nbsp;</label>
                                <select id="jform_featured<?php echo $i; ?>" name="jform[plans][<?php echo $i; ?>][featured]" class="chzn-color-state">
                                    <option value="2" <?php echo $v_item['featured'] == 2 ? "selected='selected'" : ""; ?>><?php echo JText::_('COM_STANDARD_UN_FEATURED'); ?></option>
                                    <option value="1" <?php echo $v_item['featured'] == 1 ? "selected='selected'" : ""; ?>><?php echo JText::_('COM_STANDARD_FEATURED'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                    $name = "jform[plans][$i][plans]";
                    $value = $v_item['plans'];
                    ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <?php echo $editor->display($name, $value, $width, $height, $columns, $rows); ?>
                        </div>
                    </div>
                    <button id="plans-remove<?php echo $i; ?>" class="btn btn-danger remove-me" >
                        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
                    </button>
                </div><!-- end field Add More -->
                <?php $j = $i; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <?php echo $this->loadTemplate('addnewplan'); ?>
        <?php endif; ?>
    </div>
    <!-- Button -->
    <div class="control-group">
        <div class="span4">
            <button id="plans-add-more" name="add-more" class="btn btn-primary">
                <span class="icon-new icon-white" aria-hidden="true"></span>
                <?php echo JText::_('COM_STANDARD_ADD_MORE'); ?>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        // --- sortable ---
        jQuery("#plans-field").sortable();
        jQuery("#plans-field").disableSelection();
        // --- /.sortable ---
    <?php //for ($next = 0; $next < $j; $next ++) { ?>
            // call daterangepicker
    <?php //} ?>
    //@naresh action dynamic childs
    var next = <?php echo $j;?>;
    jQuery("#plans-add-more").click(function(e){
        e.preventDefault();
        var fieldroot ="#plans-field";
        var addto = "#plans-field" + next;
        // var addRemove = "#plans-field" + (next);
        next = next + 1;
        var newIn = ' \n\
            <div id="plans-field' + next + '" name="field' + next + '" class="row' + next%2 + ' alert alert-info sortable-cursor-move">\n\
                <span class="icon-menu"></span>\n\
                <div class="form-vertical">\n\
                    <div class="row-fluid">\n\
                        <div class="span8">\n\
                            <div class="control-group">\n\
                                <div class="control-label">\n\
                                    <label id="jform_plans_title-lbl' + next + '" for="jform_plans_title' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>">\n\
                                        <?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>\n\
                                    </label>\n\
                                </div>\n\
                                <div class="controls">\n\
                                    <input class="span12" name="jform[plans][' + next + '][title]" id="jform_plans_title' + next + '" value="" type="text">\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="span4">\n\
                            <div class="control-group">\n\
                                <div class="control-label">\n\
                                    <label id="jform_plans_merge_column-lbl' + next + '" for="jform_plans_merge_column' + next + '" class="hasTooltip" title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>\n\
                                    </label>\n\
                                </div>\n\
                                <div class="controls">\n\
                                    <input type="number" name="jform[plans][' + next + '][merge_column]" id="jform_plans_merge_column' + next + '" value="0" step="1" min="0">\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row-fluid">\n\
                        <div class="span6">\n\
                            <div class="control-group">\n\
                                <div class="control-label">\n\
                                    <label id="jform_plans_status-lbl' + next + '" for="jform_plans_status' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>">\n\
                                        <?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>\n\
                                    </label>\n\
                                </div>\n\
                                <div class="controls">\n\
                                    <fieldset id="jform_fieldset_plans_status' + next + '" class="btn-group btn-group-yesno radio">\n\
                                        <input id="jform_show_plans_status' + next + '" name="jform[plans][' + next + '][plans_status]" value="1" checked="checked" type="radio">\n\
                                        <label for="jform_show_plans_status' + next + '" class="btn active btn-success">\n\
                                            <?php echo JText::_('JSHOW'); ?>\n\
                                        </label>\n\
                                        <input id="jform_hide_plans_status' + next + '" name="jform[plans][' + next + '][plans_status]" value="0" type="radio">\n\
                                        <label for="jform_hide_plans_status' + next + '" class="btn">\n\
                                            <?php echo JText::_('JHIDE'); ?>\n\
                                        </label>\n\
                                    </fieldset>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="span6">\n\
                            <label>&nbsp;</label>\n\
                            <select id="jform_featured' + next + '" name="jform[plans][' + next + '][featured]" class="chzn-color-state">\n\
                                <option value="2" selected="selected"><?php echo JText::_('COM_STANDARD_UN_FEATURED'); ?></option>\n\
                                <option value="1"><?php echo JText::_('COM_STANDARD_FEATURED'); ?></option>\n\
                            </select>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <div class="row-fluid">\n\
                    <div class="span12">\n\
                        <div class="editor wf-editor-container">\n\
                            <textarea spellcheck="false" id="jform[plans][' + next + '][plans]" name="jform[plans][' + next + '][plans]" cols="<?php echo $columns; ?>" rows="<?php echo $rows; ?>" style="width: <?php echo $width;?>; height: <?php echo $height;?>;" class="wf-editor mce_editable" aria-hidden="true" wrap="off"></textarea>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <button id="plans-remove' + next + '" class="btn btn-danger remove-me" >\n\
                    <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE');?>\n\
                </button>\n\
            </div>';
            var newInput = jQuery(newIn);
            jQuery(fieldroot).append(newInput);
            jQuery("#plans-field" + next).attr('data-source',jQuery(addto).attr('data-source'));
            jQuery("#count").val(next);  
        });
        // remove event
        jQuery('#plans-field').on('click','.remove-me', function(e){
            e.preventDefault();
            if(confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_DESCRIPTION'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#plans-field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });
    });
</script>

