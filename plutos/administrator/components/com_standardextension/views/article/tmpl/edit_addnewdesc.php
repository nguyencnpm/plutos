<?php
defined('_JEXEC') or die;
$editor = JFactory::getEditor();
$name = "jform[descriptions][0][description]";
$value = "";
$width = '100%';
$height = '280';
$columns = '15';
$rows = '5';
?>
<div id="description-field0" class="row0 alert alert-info sortable-cursor-move">
    <span class="icon-menu"></span>
    <div class="row-fluid form-vertical">
        <div class="span5">
            <!-- Text input-->
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_descriptions_title-lbl0" for="jform_descriptions_title0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_TITLE_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_TITLE_DESCRIPTION_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARDEXTENSION_FIELD_TITLE_DESCRIPTION_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[descriptions][0][title]" id="jform_descriptions_title0" value="" type="text">
                </div>
            </div>
        </div>
        <div class="span7">
            <div class="row-fluid">
                <div class="span4">
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_description_merge_column-lbl0" for="jform_description_merge_column0" class="hasTooltip" title="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>">
                                <?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_MERGE_COLUMN_LABEL'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <input type="number" name="jform[descriptions][0][merge_column]" id="jform_description_merge_column0" value="0" step="1" min="0">
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_description_status-lbl0" for="jform_description_status0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARDEXTENSION_SHOW_DESCRIPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARDEXTENSION_SHOW_DESCRIPTION_LABEL'); ?>">
                                <?php echo JText::_('COM_STANDARDEXTENSION_SHOW_DESCRIPTION_LABEL'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <fieldset id="jform_fieldset_description_status0" class="btn-group btn-group-yesno radio">
                                <input id="jform_show_description_status0" name="jform[descriptions][0][description_status]" value="1" checked="checked" type="radio">			
                                <label for="jform_show_description_status0" class="btn">
                                    <?php echo JText::_('JSHOW'); ?>			
                                </label>
                                <input id="jform_hide_description_status0" name="jform[descriptions][0][description_status]" value="0" type="radio">			
                                <label for="jform_hide_description_status0" class="btn">
                                    <?php echo JText::_('JHIDE'); ?>			
                                </label>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <label>&nbsp;</label>
                    <select id="jform_featured0" name="jform[descriptions][0][featured]" class="chzn-color-state">
                        <option value="2" selected="selected"><?php echo JText::_('COM_STANDARDEXTENSION_UN_FEATURED'); ?></option>
                        <option value="1"><?php echo JText::_('COM_STANDARDEXTENSION_FEATURED'); ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
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
                        <img src="<?php echo $this->focus_view_descriptionimage; ?>" alt="<?php echo $this->focus_view_descriptionimage_alt; ?>">
                    </div>
                    <div class="control-group alert alert-success">
                        <select id="jform_descriptions_targeta0" name="jform[descriptions][0][effect]" class="span12">
                            <?php foreach ($this->aEffect as $keyEffect => $vEffect) : ?>
                                <option value="<?php echo $keyEffect; ?>"><?php echo $vEffect; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <div class="control-label">
                            <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARDEXTENSION_DELETE_DESCRIPTION_IMAGE_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARDEXTENSION_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>">
                                <input name="jform[descriptions][0][descriptionimages_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARDEXTENSION_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>						
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <input type="file" name="descriptions[0]" id="descriptions0" value="" class="" />
                        <p class="help-block">
                            <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                            <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                            <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                        </p>
                    </div>

                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_descriptions_url-lbl0" for="jform_descriptions_url0" class="hasPopover" title="" data-content="<?php echo JText::_('The actual link to which users will be redirected.'); ?>" data-original-title="<?php echo JText::_('Link A'); ?>">
                                <?php echo JText::_('Link'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <input type="text" name="jform[descriptions][0][url]" id="jform_descriptions_url0" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_descriptions_urltext-lbl0" for="jform_descriptions_urltext0" class="hasPopover" title="" data-content="<?php echo JText::_('Text to display for the link.'); ?>" data-original-title="<?php echo JText::_('Link A Text'); ?>">
                                <?php echo JText::_('Link Text'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <input type="text" name="jform[descriptions][0][urltext]" id="jform_descriptions_urltext0" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_descriptions_targeta-lbl0" for="jform_descriptions_targeta0" class="hasPopover" title="" data-content="<?php echo JText::_('Target browser window when the link is selected.'); ?>" data-original-title="<?php echo JText::_('URL Target Window'); ?>">
                                <?php echo JText::_('URL Target Window'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <select id="jform_descriptions_targeta0" name="jform[descriptions][0][targeta]">
                                <?php foreach ($this->aTargeta as $keyTargeta => $vTargeta) : ?>
                                    <option value="<?php echo $keyTargeta; ?>"><?php echo $vTargeta; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_descriptions_float_fulltext-lbl0" for="jform_descriptions_float_fulltext0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARDEXTENSION_FLOAT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARDEXTENSION_FLOAT_LABEL'); ?>">
                                <?php echo JText::_('COM_STANDARDEXTENSION_FLOAT_LABEL'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <select id="jform_descriptions_float_fulltext0" name="jform[descriptions][0][float_fulltext]">
                                <?php foreach ($this->aFloatFullText as $keyFloatFullText => $vFloatFullText) : ?>
                                    <option value="<?php echo $keyFloatFullText; ?>"><?php echo $vFloatFullText; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_descriptions_descriptionimages_title-lbl0" for="jform_descriptions_descriptionimages_title0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>">
                                <?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <input class="span12" name="jform[descriptions][0][descriptionimages_title]" id="jform_descriptions_descriptionimages_title0" value="" type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_descriptions_descriptionimages_alt-lbl0" for="jform_descriptions_descriptionimages_alt0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>">
                                <?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <input class="span12" name="jform[descriptions][0][descriptionimages_alt]" id="jform_descriptions_descriptionimages_alt0" value="" type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_descriptions_descriptionimages_caption-lbl0" for="jform_descriptions_descriptionimages_caption0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>">
                                <?php echo JText::_('COM_STANDARDEXTENSION_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <input class="span12" name="jform[descriptions][0][descriptionimages_caption]" id="jform_descriptions_descriptionimages_caption0" value="" type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">
                            <label id="jform_descriptions_descriptionimage-lbl0" for="jform_descriptions_descriptionimage0" class="hasPopover" title="" data-content="<?php echo JText::_('Image'); ?>" data-original-title="<?php echo JText::_('Description'); ?>">
                                <?php echo JText::_('Description'); ?>
                            </label>
                        </div>
                        <div class="controls">
                            <textarea class="span12" name="jform[descriptions][0][descriptionimage]" id="jform_descriptions_descriptionimage0" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="description-remove0" class="btn btn-danger remove-me" >
        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARDEXTENSION_REMOVE'); ?>
    </button>
</div><!-- end field Add More -->