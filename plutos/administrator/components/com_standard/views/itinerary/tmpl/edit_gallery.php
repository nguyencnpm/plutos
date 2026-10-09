<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="row-fluid">
    <!--
    <div class="span4 alert">
        <?php //echo $this->form->getControlGroup('gallery_mediadisplaytype'); ?>
    </div>
    -->
    <div class="span6 alert">
        <?php echo $this->form->getControlGroup('gallery_layout'); ?>
    </div>
    <div class="span6 alert">
        <?php echo $this->form->getControlGroup('gallery_medialayoutelement'); ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div id="gallery-field">
            <?php $j = 0; ?>
            <?php if (!empty($this->item->galleries)): ?>
                <?php foreach ($this->item->galleries as $i => $v_item) : ?>
                    <div id="gallery-field<?php echo $i; ?>" class="row<?php echo $i % 2; ?> alert alert-info sortable-cursor-move">
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_galleries_thumbnail-lbl<?php echo $i; ?>" for="jform_galleries_thumbnail<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_LABEL'); ?>">
                                            <span class="icon-menu"></span>  <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <div class="control-group well thumbnail">
                                            <img src="<?php echo empty($this->item->galleries[$i]['images']['image_small']) ? $this->focus_view_gallery : JURI::root(FALSE) . $this->item->galleries[$i]['images']['image_small']; ?>" alt="<?php echo empty($this->item->galleries[$i]['gallery_alt']) ? $this->focus_view_gallery_alt : $this->item->galleries[$i]['gallery_alt']; ?>">					
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_gallery_status-lbl<?php echo $i; ?>" for="jform_gallery_status<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_GALLERY_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_SHOW_GALLERY_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <fieldset id="jform_fieldset_gallery_status<?php echo $i; ?>" class="btn-group btn-group-yesno radio">
                                            <input id="jform_show_gallery_status<?php echo $i; ?>" name="jform[galleries][<?php echo $i; ?>][gallery_status]" value="1" <?php echo $v_item['gallery_status'] == 1 ? "checked='checked'" : ""; ?> type="radio">			
                                            <label for="jform_show_gallery_status<?php echo $i; ?>" class="btn ">
                                                <?php echo JText::_('JSHOW'); ?>			
                                            </label>
                                            <input id="jform_hide_gallery_status<?php echo $i; ?>" name="jform[galleries][<?php echo $i; ?>][gallery_status]" value="0" <?php echo $v_item['gallery_status'] == 0 ? "checked='checked'" : ""; ?> type="radio">			
                                            <label for="jform_hide_gallery_status<?php echo $i; ?>" class="btn">
                                                <?php echo JText::_('JHIDE'); ?>			
                                            </label>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="control-label">
                                        <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_GALLERY_LABEL'); ?>">
                                            <input name="jform[galleries][<?php echo $i; ?>][gallery_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_GALLERY_LABEL'); ?>						
                                        </label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <input type="file" name="gallery[<?php echo $i; ?>]" id="gallery<?php echo $i; ?>" value="" class="" />
                                    <p class="help-block">
                                        <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                                        <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                                        <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_galleries_gallery_title-lbl<?php echo $i; ?>" for="jform_galleries_gallery_title<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" name="jform[galleries][<?php echo $i; ?>][gallery_title]" id="jform_galleries_gallery_title<?php echo $i; ?>" value="<?php echo $v_item['gallery_title'] ?>" type="text">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_galleries_gallery_alt-lbl<?php echo $i; ?>" for="jform_galleries_gallery_alt<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" name="jform[galleries][<?php echo $i; ?>][gallery_alt]" id="jform_galleries_gallery_alt<?php echo $i; ?>" value="<?php echo $v_item['gallery_alt'] ?>" type="text">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_galleries_gallery_caption-lbl<?php echo $i; ?>" for="jform_galleries_gallery_caption<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" size="" name="jform[galleries][<?php echo $i; ?>][gallery_caption]" id="jform_galleries_gallery_caption<?php echo $i; ?>" value="<?php echo $v_item['gallery_caption'] ?>" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="gallery-remove<?php echo $i; ?>" class="btn btn-danger remove-me" >
                            <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
                        </button>
                    </div><!-- end field Add More -->
                    <?php $j = $i; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo $this->loadTemplate('addnewgallery'); ?>
            <?php endif; ?>
        </div>
        <!-- Button -->
        <div class="control-group">
            <div class="span4">
                <button id="gallery-add-more" name="add-more" class="btn btn-primary">
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
        jQuery("#gallery-field").sortable();
        jQuery("#gallery-field").disableSelection();
        // --- /.sortable ---
        //@naresh action dynamic childs
        var next = <?php echo $j; ?>;
        jQuery("#gallery-add-more").click(function (e) {
            e.preventDefault();
            var fieldroot = "#gallery-field";
            var addto = "#gallery-field" + next;
            next = next + 1;
            var newIn = ' \n\
            <div id="gallery-field' + next + '" name="field' + next + '" class="row' + next % 2 + ' alert alert-info sortable-cursor-move">\n\
                <div class="row-fluid">\n\
                    <div class="span4">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_galleries_thumbnail-lbl' + next + '" for="jform_galleries_thumbnail' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_LABEL'); ?>">\n\
                                    <span class="icon-menu"></span>  <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <div class="control-group well thumbnail">\n\
                                    <img src="<?php echo $this->focus_view_gallery ?>" alt="<?php echo $this->focus_view_gallery_alt ?>">\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="span4">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_gallery_status-lbl' + next + '" for="jform_gallery_status-lbl' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_GALLERY_LABEL'); ?>">\n\
<?php echo JText::_('COM_STANDARD_SHOW_GALLERY_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <fieldset id="jform_fieldset_gallery_status' + next + '" class="btn-group btn-group-yesno radio">\n\
                                    <input id="jform_show_gallery_status' + next + '" name="jform[galleries][' + next + '][gallery_status]" value="1" checked="checked" type="radio">\n\
                                    <label for="jform_show_gallery_status' + next + '" class="btn active btn-success">\n\
<?php echo JText::_('JSHOW'); ?>\n\
                                    </label>\n\
                                    <input id="jform_hide_gallery_status' + next + '" name="jform[galleries][' + next + '][gallery_status]" value="0" type="radio">\n\
                                    <label for="jform_hide_gallery_status' + next + '" class="btn">\n\
<?php echo JText::_('JHIDE'); ?>\n\
                                    </label>\n\
                                </fieldset>\n\
                            </div>\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_GALLERY_LABEL'); ?>">\n\
                                    <input name="jform[galleries][' + next + '][gallery_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_GALLERY_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <input type="file" name="gallery[' + next + ']" id="gallery' + next + '" value="" class="" />\n\
                                <p class="help-block">\n\
<?php $cMax = (int) $this->params->image_upload_maxsize; ?>\n\
<?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>\n\
<?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>\n\
                                </p>\n\
                        </div>\n\
                    </div>\n\
                    <div class="span4">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_galleries_gallery_title-lbl' + next + '" for="jform_galleries_gallery_title' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_LABEL'); ?>">\n\
<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" name="jform[galleries][' + next + '][gallery_title]" id="jform_galleries_gallery_title' + next + '" value="" type="text">\n\
                            </div>\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_galleries_gallery_alt-lbl' + next + '" for="jform_galleries_gallery_alt' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_LABEL'); ?>">\n\
<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" name="jform[galleries][' + next + '][gallery_alt]" id="jform_galleries_gallery_alt' + next + '" value="" type="text">\n\
                            </div>\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_galleries_gallery_caption-lbl' + next + '" for="jform_galleries_gallery_caption' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_LABEL'); ?>">\n\
<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" size="" name="jform[galleries][' + next + '][gallery_caption]" id="jform_galleries_gallery_caption' + next + '" value="" type="text">\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <button id="gallery-remove' + next + '" class="btn btn-danger remove-me" >\n\
                    <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>\n\
                </button>\n\
            </div>';
            var newInput = jQuery(newIn);
            jQuery(fieldroot).append(newInput);
            jQuery("#gallery-field" + next).attr('data-source', jQuery(addto).attr('data-source'));
            jQuery("#count").val(next);
        });
        // remove event
        jQuery('#gallery-field').on('click', '.remove-me', function (e) {
            e.preventDefault();
            if (confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_GALLERY'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length - 1);
                var fieldID = "#gallery-field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });
    });
</script>