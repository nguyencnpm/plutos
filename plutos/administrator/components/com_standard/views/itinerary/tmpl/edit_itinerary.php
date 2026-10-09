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
<div class="form-vertical">
    <div class="row-fluid">
        <div class="span3 alert">
            <?php echo $this->form->getControlGroup('itinerary_layoutelement'); ?>
        </div>
        <div class="span4 alert">
            <?php echo $this->form->getControlGroup('itinerary_title'); ?>
        </div>
        <div class="span3 alert">
            <?php echo $this->form->getControlGroup('itinerary_displaytype_id'); ?>
        </div>
        <div class="span2 alert">
            <?php echo $this->form->getControlGroup('itinerary_column'); ?>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div id="itinerary-field">
            <?php $j = 0; ?>
            <?php if (!empty($this->item->itinerary)): ?>
                <?php foreach ($this->item->itinerary as $i => $v_item) : ?>
                    <div id="itinerary-field<?php echo $i; ?>" class="row<?php echo $i % 2; ?> alert alert-info sortable-cursor-move">
                        <span class="icon-menu"></span>
                        <div class="form-vertical">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label id="jform_itinerary_title-lbl<?php echo $i; ?>" for="jform_itinerary_title<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_ITINERARY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_ITINERARY_LABEL'); ?>">
                                                <?php echo JText::_('COM_STANDARD_FIELD_TITLE_ITINERARY_LABEL'); ?>
                                            </label>
                                        </div>
                                        <div class="controls">
                                            <input class="span12" name="jform[itinerary][<?php echo $i; ?>][title]" id="jform_itinerary_title<?php echo $i; ?>" value="<?php echo $v_item['title']; ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label id="jform_itinerary_status-lbl<?php echo $i; ?>" for="jform_itinerary_status<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_ITINERARY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_ITINERARY_LABEL'); ?>">
                                                <?php echo JText::_('COM_STANDARD_SHOW_ITINERARY_LABEL'); ?>
                                            </label>
                                        </div>
                                        <div class="controls">
                                            <fieldset id="jform_fieldset_itinerary_status<?php echo $i; ?>" class="btn-group btn-group-yesno radio">
                                                <input id="jform_show_itinerary_status<?php echo $i; ?>" name="jform[itinerary][<?php echo $i; ?>][itinerary_status]" value="1" <?php echo $v_item['itinerary_status'] == 1 ? "checked='checked'" : ""; ?> type="radio">			
                                                <label for="jform_show_itinerary_status<?php echo $i; ?>" class="btn ">
                                                    <?php echo JText::_('JSHOW'); ?>			
                                                </label>
                                                <input id="jform_hide_itinerary_status<?php echo $i; ?>" name="jform[itinerary][<?php echo $i; ?>][itinerary_status]" value="0" <?php echo $v_item['itinerary_status'] == 0 ? "checked='checked'" : ""; ?> type="radio">			
                                                <label for="jform_hide_itinerary_status<?php echo $i; ?>" class="btn">
                                                    <?php echo JText::_('JHIDE'); ?>			
                                                </label>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <label>&nbsp;</label>
                                    <select id="jform_featured<?php echo $i; ?>" name="jform[itinerary][<?php echo $i; ?>][featured]" class="chzn-color-state">
                                        <option value="2" <?php echo $v_item['featured'] == 2 ? "selected='selected'" : ""; ?>><?php echo JText::_('COM_STANDARD_UN_FEATURED'); ?></option>
                                        <option value="1" <?php echo $v_item['featured'] == 1 ? "selected='selected'" : ""; ?>><?php echo JText::_('COM_STANDARD_FEATURED'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php
                        $name = "jform[itinerary][$i][itinerary]";
                        $value = $v_item['itinerary'];
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <?php echo $editor->display($name, $value, $width, $height, $columns, $rows); ?>
                            </div>
                        </div>
                        <button id="itinerary-remove<?php echo $i; ?>" class="btn btn-danger remove-me" >
                            <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
                        </button>
                    </div><!-- end field Add More -->
                    <?php $j = $i; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo $this->loadTemplate('addnewitinerary'); ?>
            <?php endif; ?>
        </div>
        <!-- Button -->
        <div class="control-group">
            <div class="span4">
                <button id="itinerary-add-more" name="add-more" class="btn btn-primary">
                    <span class="icon-new icon-white" aria-hidden="true"></span>
                    <?php echo JText::_('COM_STANDARD_ADD_MORE'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        // --- sortable ---
        jQuery("#itinerary-field").sortable();
        jQuery("#itinerary-field").disableSelection();
        // --- /.sortable ---
<?php //for ($next = 0; $next < $j; $next ++) {     ?>
        // call daterangepicker
<?php //}     ?>
        //@naresh action dynamic childs
        var next = <?php echo $j; ?>;
        jQuery("#itinerary-add-more").click(function (e) {
            e.preventDefault();
            var fieldroot = "#itinerary-field";
            var addto = "#itinerary-field" + next;
            // var addRemove = "#itinerary-field" + (next);
            next = next + 1;
            var newIn = ' \n\
            <div id="itinerary-field' + next + '" name="field' + next + '" class="row' + next % 2 + ' alert alert-info sortable-cursor-move">\n\
                <span class="icon-menu"></span>\n\
                <div class="form-vertical">\n\
                    <div class="row-fluid">\n\
                        <div class="span6">\n\
                            <div class="control-group">\n\
                                <div class="control-label">\n\
                                    <label id="jform_itinerary_title-lbl' + next + '" for="jform_itinerary_title' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_ITINERARY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_ITINERARY_LABEL'); ?>">\n\
<?php echo JText::_('COM_STANDARD_FIELD_TITLE_ITINERARY_LABEL'); ?>\n\
                                    </label>\n\
                                </div>\n\
                                <div class="controls">\n\
                                    <input class="span12" name="jform[itinerary][' + next + '][title]" id="jform_itinerary_title' + next + '" value="" type="text">\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="span3">\n\
                            <div class="control-group">\n\
                                <div class="control-label">\n\
                                    <label id="jform_itinerary_status-lbl' + next + '" for="jform_itinerary_status' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_ITINERARY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_ITINERARY_LABEL'); ?>">\n\
<?php echo JText::_('COM_STANDARD_SHOW_ITINERARY_LABEL'); ?>\n\
                                    </label>\n\
                                </div>\n\
                                <div class="controls">\n\
                                    <fieldset id="jform_fieldset_itinerary_status' + next + '" class="btn-group btn-group-yesno radio">\n\
                                        <input id="jform_show_itinerary_status' + next + '" name="jform[itinerary][' + next + '][itinerary_status]" value="1" checked="checked" type="radio">\n\
                                        <label for="jform_show_itinerary_status' + next + '" class="btn active btn-success">\n\
<?php echo JText::_('JSHOW'); ?>\n\
                                        </label>\n\
                                        <input id="jform_hide_itinerary_status' + next + '" name="jform[itinerary][' + next + '][itinerary_status]" value="0" type="radio">\n\
                                        <label for="jform_hide_itinerary_status' + next + '" class="btn">\n\
<?php echo JText::_('JHIDE'); ?>\n\
                                        </label>\n\
                                    </fieldset>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="span3">\n\
                            <label>&nbsp;</label>\n\
                            <select id="jform_featured' + next + '" name="jform[itinerary][' + next + '][featured]" class="chzn-color-state">\n\
                                <option value="2" selected="selected"><?php echo JText::_('COM_STANDARD_UN_FEATURED'); ?></option>\n\
                                <option value="1"><?php echo JText::_('COM_STANDARD_FEATURED'); ?></option>\n\
                            </select>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <div class="row-fluid">\n\
                    <div class="span12">\n\
                        <div class="editor wf-editor-container">\n\
                            <textarea spellcheck="false" id="jform[itinerary][' + next + '][itinerary]" name="jform[itinerary][' + next + '][itinerary]" cols="<?php echo $columns; ?>" rows="<?php echo $rows; ?>" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>;" class="wf-editor mce_editable" aria-hidden="true" wrap="off"></textarea>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <button id="itinerary-remove' + next + '" class="btn btn-danger remove-me" >\n\
                    <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>\n\
                </button>\n\
            </div>';
            var newInput = jQuery(newIn);
            jQuery(fieldroot).append(newInput);
            jQuery("#itinerary-field" + next).attr('data-source', jQuery(addto).attr('data-source'));
            jQuery("#count").val(next);
        });
        // remove event
        jQuery('#itinerary-field').on('click', '.remove-me', function (e) {
            e.preventDefault();
            if (confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_ITINERARY'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length - 1);
                var fieldID = "#itinerary-field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });
    });
</script>

