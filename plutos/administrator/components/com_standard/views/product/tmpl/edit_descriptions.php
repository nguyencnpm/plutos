<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$editor	= JFactory::getEditor();
$width = '100%';
$height = '280';
$columns = '15';
$rows = '5';
?>
<div class="form-vertical">
    <div class="row-fluid">
        <div class="span3 alert">
            <?php echo $this->form->getControlGroup('description_layoutelement'); ?>
        </div>
        <div class="span4 alert">
            <?php echo $this->form->getControlGroup('description_title'); ?>
        </div>
        <div class="span3 alert">
            <?php echo $this->form->getControlGroup('displaytype_id'); ?>
        </div>
        <div class="span2 alert">
            <?php echo $this->form->getControlGroup('description_column'); ?>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div id="description-field">
            <?php $j = 0; ?>
            <?php if (!empty($this->item->descriptions)): ?>
                <?php foreach ($this->item->descriptions as $i => $v_item) : ?>
                    <div id="description-field<?php echo $i; ?>" class="row<?php echo $i % 2; ?> alert alert-info sortable-cursor-move">
                        <span class="icon-menu"></span>
                        <div class="row-fluid form-vertical">
                            <div class="span5">
                                <!-- Text input-->
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_descriptions_title-lbl<?php echo $i; ?>" for="jform_descriptions_title<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" name="jform[descriptions][<?php echo $i; ?>][title]" id="jform_descriptions_title<?php echo $i; ?>" value="<?php echo $v_item['title']; ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="span7">
                                <div class="row-fluid">
                                    <div class="span4">
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_description_merge_column-lbl<?php echo $i; ?>" for="jform_description_merge_column<?php echo $i; ?>" class="hasTooltip" title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>">
                                                    <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <input type="number" name="jform[descriptions][<?php echo $i; ?>][merge_column]" id="jform_description_merge_column<?php echo $i; ?>" value="<?php echo $v_item['merge_column']; ?>" step="1" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_description_status-lbl<?php echo $i; ?>" for="jform_description_status<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>">
                                                    <?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <fieldset id="jform_fieldset_description_status<?php echo $i; ?>" class="btn-group btn-group-yesno radio">
                                                    <input id="jform_show_description_status<?php echo $i; ?>" name="jform[descriptions][<?php echo $i; ?>][description_status]" value="1" <?php echo $v_item['description_status'] == 1 ? "checked='checked'" : ""; ?> type="radio">			
                                                    <label for="jform_show_description_status<?php echo $i; ?>" class="btn ">
                                                        <?php echo JText::_('JSHOW'); ?>			
                                                    </label>
                                                    <input id="jform_hide_description_status<?php echo $i; ?>" name="jform[descriptions][<?php echo $i; ?>][description_status]" value="0" <?php echo $v_item['description_status'] == 0 ? "checked='checked'" : ""; ?> type="radio">			
                                                    <label for="jform_hide_description_status<?php echo $i; ?>" class="btn">
                                                        <?php echo JText::_('JHIDE'); ?>			
                                                    </label>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <label>&nbsp;</label>
                                        <select id="jform_featured<?php echo $i; ?>" name="jform[descriptions][<?php echo $i; ?>][featured]" class="chzn-color-state">
                                            <option value="2" <?php echo $v_item['featured'] == 2 ? "selected='selected'" : ""; ?>><?php echo JText::_('COM_STANDARD_UN_FEATURED'); ?></option>
                                            <option value="1" <?php echo $v_item['featured'] == 1 ? "selected='selected'" : ""; ?>><?php echo JText::_('COM_STANDARD_FEATURED'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $name = "jform[descriptions][$i][description]";
                            $value = $v_item['description'];
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <?php echo $editor->display($name, $value, $width, $height, $columns, $rows); ?>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 alert">
                                <div class="row-fluid">
                                    <div class="span4">
                                        <div class="control-group well thumbnail">
                                            <img src="<?php echo empty($this->item->descriptions[$i]['images']['image_small']) ? $this->focus_view_descriptionimage : JURI::root(FALSE) . $this->item->descriptions[$i]['images']['image_small']; ?>" alt="<?php echo empty($this->item->descriptions[$i]['descriptionimages_alt']) ? $this->focus_view_descriptionimage_alt : $this->item->descriptions[$i]['descriptionimages_alt']; ?>">					                                        
                                        </div>                                        
                                        <div class="control-group alert alert-success">
                                            <select id="jform_descriptions_targeta0" name="jform[descriptions][<?php echo $i; ?>][effect]">
                                                <?php foreach ($this->aEffect as $keyEffect => $vEffect) : ?>
                                                    <option value="<?php echo $keyEffect; ?>" <?php echo $this->item->descriptions[$i]['effect']== $keyEffect? " selected=\"selected\" ":" "; ?>>
                                                        <?php echo $vEffect; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>">
                                                    <input name="jform[descriptions][<?php echo $i; ?>][descriptionimages_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>						
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <input type="file" name="descriptions[<?php echo $i; ?>]" id="descriptions<?php echo $i; ?>" value="" class="" />
                                            <p class="help-block">
                                                <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                                                <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                                                <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                                            </p>
                                        </div>

                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_descriptions_url-lbl<?php echo $i; ?>" for="jform_descriptions_url<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('The actual link to which users will be redirected.');?>" data-original-title="<?php echo JText::_('Link A');?>">
                                                    <?php echo JText::_('Link'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <input type="text" name="jform[descriptions][<?php echo $i; ?>][url]" id="jform_descriptions_url<?php echo $i; ?>" value="<?php echo $this->item->descriptions[$i]['url'];?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_descriptions_urltext-lbl<?php echo $i; ?>" for="jform_descriptions_urltext<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('Text to display for the link.');?>" data-original-title="<?php echo JText::_('Link A Text');?>">
                                                    <?php echo JText::_('Link Text'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <input type="text" name="jform[descriptions][<?php echo $i; ?>][urltext]" id="jform_descriptions_urltext<?php echo $i; ?>" value="<?php echo $this->item->descriptions[$i]['urltext'];?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_descriptions_targeta-lbl<?php echo $i; ?>" for="jform_descriptions_targeta<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('Target browser window when the link is selected.');?>" data-original-title="<?php echo JText::_('URL Target Window');?>">
                                                    <?php echo JText::_('URL Target Window'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <select id="jform_descriptions_targeta<?php echo $i; ?>" name="jform[descriptions][<?php echo $i; ?>][targeta]">
                                                    <?php foreach ($this->aTargeta as $keyTargeta => $vTargeta) : ?>
                                                        <option value="<?php echo $keyTargeta; ?>" <?php echo $this->item->descriptions[$i]['targeta']== $keyTargeta? " selected=\"selected\" ":" "; ?>><?php echo $vTargeta; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_descriptions_float_fulltext-lbl<?php echo $i; ?>" for="jform_descriptions_float_fulltext<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FLOAT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FLOAT_LABEL'); ?>">
                                                    <?php echo JText::_('COM_STANDARD_FLOAT_LABEL'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <select id="jform_descriptions_float_fulltext<?php echo $i; ?>" name="jform[descriptions][<?php echo $i; ?>][float_fulltext]">
                                                    <?php foreach ($this->aFloatFullText as $keyFloatFullText => $vFloatFullText) : ?>
                                                        <option value="<?php echo $keyFloatFullText; ?>" <?php echo $this->item->descriptions[$i]['float_fulltext']== $keyFloatFullText? " selected=\"selected\" ":" "; ?>><?php echo $vFloatFullText; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_descriptions_descriptionimages_title-lbl<?php echo $i; ?>" for="jform_descriptions_descriptionimages_title<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>">
                                                    <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <input class="span12" name="jform[descriptions][<?php echo $i; ?>][descriptionimages_title]" id="jform_descriptions_descriptionimages_title<?php echo $i;?>" value="<?php echo $this->item->descriptions[$i]['descriptionimages_title'];?>" type="text">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_descriptions_descriptionimages_alt-lbl<?php echo $i; ?>" for="jform_descriptions_descriptionimages_alt<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>">
                                                    <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <input class="span12" name="jform[descriptions][<?php echo $i; ?>][descriptionimages_alt]" id="jform_descriptions_descriptionimages_alt<?php echo $i; ?>" value="<?php echo $this->item->descriptions[$i]['descriptionimages_alt'];?>" type="text">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_descriptions_descriptionimages_caption-lbl<?php echo $i; ?>" for="jform_descriptions_descriptionimages_caption<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>">
                                                    <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <input class="span12" name="jform[descriptions][<?php echo $i; ?>][descriptionimages_caption]" id="jform_descriptions_descriptionimages_caption<?php echo $i; ?>" value="<?php echo $this->item->descriptions[$i]['descriptionimages_caption'];?>" type="text">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label id="jform_descriptions_descriptionimage-lbl<?php echo $i; ?>" for="jform_descriptions_descriptionimage<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('Image'); ?>" data-original-title="<?php echo JText::_('Description'); ?>">
                                                    <?php echo JText::_('Description'); ?>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <textarea class="span12" name="jform[descriptions][<?php echo $i; ?>][descriptionimage]" id="jform_descriptions_descriptionimage<?php echo $i; ?>" rows="3"><?php echo $this->item->descriptions[$i]['descriptionimage'];?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="description-remove<?php echo $i;?>" class="btn btn-danger remove-me" >
                            <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE');?>
                        </button>
                    </div><!-- end field Add More -->
                    <?php $j = $i; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo $this->loadTemplate('addnewdesc'); ?>
            <?php endif; ?>
        </div>
        <!-- Button -->
        <div class="control-group">
            <div class="span4">
                <button id="description-add-more" name="add-more" class="btn btn-primary">
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
        jQuery("#description-field").sortable();
        jQuery("#description-field").disableSelection();
        // --- /.sortable ---
    <?php //for ($next = 0; $next < $j; $next ++) { ?>
            // call daterangepicker
    <?php //} ?>
    //@naresh action dynamic childs
    var next = <?php echo $j;?>;
    jQuery("#description-add-more").click(function(e){
        e.preventDefault();
        var fieldroot ="#description-field";
        var addto = "#description-field" + next;
        // var addRemove = "#description-field" + (next);
        next = next + 1;
        var newIn = ' \n\
            <div id="description-field' + next + '" name="field' + next + '" class="row' + next%2 + ' alert alert-info sortable-cursor-move">\n\
                <span class="icon-menu"></span>\n\
                <div class="row-fluid form-vertical">\n\
                    <div class="span5">\n\
                        <!-- Text input-->\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_descriptions_title-lbl' + next + '" for="jform_descriptions_title' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_FIELD_TITLE_DESCRIPTION_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" name="jform[descriptions][' + next + '][title]" id="jform_descriptions_title' + next + '" value="" type="text">\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="span7">\n\
                        <div class="row-fluid">\n\
                            <div class="span4">\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_description_merge_column-lbl' + next + '" for="jform_description_merge_column' + next + '" class="hasTooltip" title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input type="number" name="jform[descriptions][' + next + '][merge_column]" id="jform_description_merge_column' + next + '" value="0" step="1" min="0">\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                            <div class="span4">\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_description_status-lbl' + next + '" for="jform_description_status' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_SHOW_DESCRIPTION_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <fieldset id="jform_fieldset_description_status' + next + '" class="btn-group btn-group-yesno radio">\n\
                                            <input id="jform_show_description_status' + next + '" name="jform[descriptions][' + next + '][description_status]" value="1" checked="checked" type="radio">\n\
                                            <label for="jform_show_description_status' + next + '" class="btn active btn-success">\n\
                                                <?php echo JText::_('JSHOW'); ?>\n\
                                            </label>\n\
                                            <input id="jform_hide_description_status' + next + '" name="jform[descriptions][' + next + '][description_status]" value="0" type="radio">\n\
                                            <label for="jform_hide_description_status' + next + '" class="btn">\n\
                                                <?php echo JText::_('JHIDE'); ?>\n\
                                            </label>\n\
                                        </fieldset>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                            <div class="span4">\n\
                                <label>&nbsp;</label>\n\
                                <select id="jform_featured' + next + '" name="jform[descriptions][' + next + '][featured]" class="chzn-color-state">\n\
                                    <option value="2" selected="selected"><?php echo JText::_('COM_STANDARD_UN_FEATURED'); ?></option>\n\
                                    <option value="1"><?php echo JText::_('COM_STANDARD_FEATURED'); ?></option>\n\
                                </select>\n\
                            </div>\n\
                         </div>\n\
                    </div>\n\
                </div>\n\
                <div class="row-fluid">\n\
                    <div class="span12">\n\
                        <div class="editor wf-editor-container">\n\
                            <textarea spellcheck="false" id="jform[descriptions][' + next + '][description]" name="jform[descriptions][' + next + '][description]" cols="<?php echo $columns; ?>" rows="<?php echo $rows; ?>" style="width: <?php echo $width;?>; height: <?php echo $height;?>;" class="wf-editor mce_editable" aria-hidden="true" wrap="off"></textarea>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <div class="row-fluid">\n\
                    <div class="span12 alert">\n\
                        <div class="row-fluid">\n\
                            <div class="span4">\n\
                                <div class="control-group well thumbnail">\n\
                                    <img src="<?php echo $this->focus_view_descriptionimage;?>" alt="<?php echo $this->focus_view_descriptionimage_alt; ?>">\n\
                                </div>\n\
                                <div class="control-group alert alert-success">\n\
                                    <select id="jform_descriptions_targeta0" name="jform[descriptions][' + next + '][effect]">\n\
                                        <?php foreach ($this->aEffect as $keyEffect => $vEffect) : ?>\n\
                                            <option value="<?php echo $keyEffect; ?>"><?php echo $vEffect; ?></option>\n\
                                        <?php endforeach; ?>\n\
                                    </select>\n\
                                </div>\n\
                            </div>\n\
                            <div class="span4">\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>">\n\
                                            <input name="jform[descriptions][' + next + '][descriptionimages_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <input type="file" name="descriptions[' + next + ']" id="descriptions' + next + '" value="" class="" />\n\
                                    <p class="help-block">\n\
                                        <?php $cMax = (int) $this->params->image_upload_maxsize; ?>\n\
                                        <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>\n\
                                        <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>\n\
                                    </p>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_descriptions_url-lbl' + next + '" for="jform_descriptions_url' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('The actual link to which users will be redirected.');?>" data-original-title="<?php echo JText::_('Link A');?>">\n\
                                            <?php echo JText::_('Link'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input type="text" name="jform[descriptions][' + next + '][url]" id="jform_descriptions_url' + next + '" value="">\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_descriptions_urltext-lbl' + next + '" for="jform_descriptions_urltext' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('Text to display for the link.');?>" data-original-title="<?php echo JText::_('Link A Text');?>">\n\
                                            <?php echo JText::_('Link Text'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input type="text" name="jform[descriptions][' + next + '][urltext]" id="jform_descriptions_urltext' + next + '" value="">\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_descriptions_targeta-lbl' + next + '" for="jform_descriptions_targeta' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('Target browser window when the link is selected.');?>" data-original-title="<?php echo JText::_('URL Target Window');?>">\n\
                                            <?php echo JText::_('URL Target Window'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <select id="jform_descriptions_targeta' + next + '" name="jform[descriptions][' + next + '][targeta]">\n\
                                            <?php foreach ($this->aTargeta as $keyTargeta => $vTargeta) : ?>\n\
                                                <option value="<?php echo $keyTargeta; ?>"><?php echo $vTargeta; ?></option>\n\
                                            <?php endforeach; ?>\n\
                                        </select>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                            <div class="span4">\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_descriptions_float_fulltext-lbl' + next + '" for="jform_descriptions_float_fulltext' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FLOAT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FLOAT_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FLOAT_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <select id="jform_descriptions_float_fulltext' + next + '" name="jform[descriptions][' + next + '][float_fulltext]">\n\
                                            <?php foreach ($this->aFloatFullText as $keyFloatFullText => $vFloatFullText) : ?>\n\
                                                <option value="<?php echo $keyFloatFullText; ?>"><?php echo $vFloatFullText; ?></option>\n\
                                            <?php endforeach; ?>\n\
                                        </select>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_descriptions_descriptionimages_title-lbl' + next + '" for="jform_descriptions_descriptionimages_title' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input class="span12" name="jform[descriptions][' + next + '][descriptionimages_title]" id="jform_descriptions_descriptionimages_title' + next + '" value="" type="text">\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_descriptions_descriptionimages_alt-lbl' + next + '" for="jform_descriptions_descriptionimages_alt' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input class="span12" name="jform[descriptions][' + next + '][descriptionimages_alt]" id="jform_descriptions_descriptionimages_alt' + next + '" value="" type="text">\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_descriptions_descriptionimages_caption-lbl' + next + '" for="jform_descriptions_descriptionimages_caption' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input class="span12" name="jform[descriptions][' + next + '][descriptionimages_caption]" id="jform_descriptions_descriptionimages_caption' + next + '" value="" type="text">\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_descriptions_descriptionimage-lbl' + next + '" for="jform_descriptions_descriptionimage' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('Image'); ?>" data-original-title="<?php echo JText::_('Description'); ?>">\n\
                                            <?php echo JText::_('Description'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <textarea class="span12" name="jform[descriptions][' + next + '][descriptionimage]" id="jform_descriptions_descriptionimage' + next + '" rows="3"></textarea>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <button id="description-remove' + next + '" class="btn btn-danger remove-me" >\n\
                    <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE');?>\n\
                </button>\n\
            </div>';
            var newInput = jQuery(newIn);
            jQuery(fieldroot).append(newInput);
            jQuery("#description-field" + next).attr('data-source',jQuery(addto).attr('data-source'));
            jQuery("#count").val(next);  
        });
        // remove event
        jQuery('#description-field').on('click','.remove-me', function(e){
            e.preventDefault();
            if(confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_DESCRIPTION'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#description-field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });
    });
</script>