<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
?>
<div class="span12">
    <div id="plans_image-field">
        <?php $j = 0; ?>
        <?php if (!empty($this->item->plans_image)): ?>
            <?php foreach ($this->item->plans_image as $i => $v_item) : ?>
                <div id="plans_image-field<?php echo $i; ?>" class="row<?php echo $i % 2; ?> alert alert-info sortable-cursor-move">
                    <span class="icon-menu"></span>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="control-group well thumbnail">
                                <img src="<?php echo empty($this->item->plans_image[$i]['images']['image_small']) ? $this->focus_view_plansimage : JURI::root(FALSE) . $this->item->plans_image[$i]['images']['image_small']; ?>" alt="<?php echo empty($this->item->plans_image[$i]['plans_image_alt']) ? $this->focus_view_plansimage_alt : $this->item->plans_image[$i]['plans_image_alt']; ?>">					                                        
                            </div>                                        
                            <div class="control-group">
                                <div class="control-label">
                                    <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>">
                                        <input name="jform[plans_image][<?php echo $i; ?>][plans_image_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>						
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <input type="file" name="plans_image[<?php echo $i; ?>]" id="plans_image<?php echo $i; ?>" value="" class="" />
                                <p class="help-block">
                                    <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                                    <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                                    <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="control-group">
                                <div class="control-label">
                                    <label id="jform_plans_plans_image_title-lbl<?php echo $i; ?>" for="jform_plans_plans_image_title<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>">
                                        <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>
                                    </label>
                                </div>
                                <div class="controls">
                                    <input class="span12" name="jform[plans_image][<?php echo $i; ?>][plans_image_title]" id="jform_plans_plans_image_title<?php echo $i; ?>" value="<?php echo $this->item->plans_image[$i]['plans_image_title']; ?>" type="text">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">
                                    <label id="jform_plans_plans_image_alt-lbl<?php echo $i; ?>" for="jform_plans_plans_image_alt<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>">
                                        <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>
                                    </label>
                                </div>
                                <div class="controls">
                                    <input class="span12" name="jform[plans_image][<?php echo $i; ?>][plans_image_alt]" id="jform_plans_plans_image_alt<?php echo $i; ?>" value="<?php echo $this->item->plans_image[$i]['plans_image_alt']; ?>" type="text">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">
                                    <label id="jform_plans_plans_image_caption-lbl<?php echo $i; ?>" for="jform_plans_plans_image_caption<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>">
                                        <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>
                                    </label>
                                </div>
                                <div class="controls">
                                    <input class="span12" name="jform[plans_image][<?php echo $i; ?>][plans_image_caption]" id="jform_plans_plans_image_caption<?php echo $i; ?>" value="<?php echo $this->item->plans_image[$i]['plans_image_caption']; ?>" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="plans_image-remove<?php echo $i; ?>" class="btn btn-danger remove-me" >
                        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
                    </button>
                </div><!-- end field Add More -->
            <?php endforeach; ?>
        <?php else: ?>
            <?php echo $this->loadTemplate('addnewimagesplan'); ?>
        <?php endif; ?>
    </div>
    <!-- Button -->
    <div class="control-group">
        <div class="span4">
            <button id="plans_image-add-more" name="add-more" class="btn btn-primary">
                <span class="icon-new icon-white" aria-hidden="true"></span>
                <?php echo JText::_('COM_STANDARD_ADD_MORE'); ?>
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        // --- sortable ---
        jQuery("#plans_image-field").sortable();
        jQuery("#plans_image-field").disableSelection();
        // --- /.sortable ---
    //@naresh action dynamic childs
    var next = <?php echo $j;?>;
    jQuery("#plans_image-add-more").click(function(e){
        e.preventDefault();
        var fieldroot ="#plans_image-field";
        var addto = "#plans_image-field" + next;
        next = next + 1;
        var newIn = ' \n\
            <div id="plans_image-field' + next + '" name="field' + next + '" class="row' + next%2 + ' alert alert-info sortable-cursor-move">\n\
                <span class="icon-menu"></span>\n\
                <div class="row-fluid">\n\
                    <div class="span12">\n\
                        <div class="control-group well thumbnail">\n\
                            <img src="<?php echo $this->focus_view_plansimage;?>" alt="<?php echo $this->focus_view_plansimage_alt; ?>">\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>">\n\
                                    <input name="jform[plans_image][' + next + '][plans_imageimages_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <input type="file" name="plans_image[' + next + ']" id="plans_image' + next + '" value="" class="" />\n\
                            <p class="help-block">\n\
                                <?php $cMax = (int) $this->params->image_upload_maxsize; ?>\n\
                                <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>\n\
                                <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>\n\
                            </p>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <div class="row-fluid">\n\
                    <div class="span12">\n\
                    <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_plans_plans_image_title-lbl' + next + '" for="jform_plans_plans_image_title' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input class="span12" name="jform[plans_image][' + next + '][plans_image_title]" id="jform_plans_plans_image_title' + next + '" value="" type="text">\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_plans_plans_image_alt-lbl' + next + '" for="jform_plans_plans_image_alt' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input class="span12" name="jform[plans_image][' + next + '][plans_image_alt]" id="jform_plans_plans_image_alt' + next + '" value="" type="text">\n\
                                    </div>\n\
                                </div>\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_plans_plans_image_caption-lbl' + next + '" for="jform_plans_plans_image_caption' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="controls">\n\
                                        <input class="span12" name="jform[plans_image][' + next + '][plans_image_caption]" id="jform_plans_plans_image_caption' + next + '" value="" type="text">\n\
                                    </div>\n\
                                </div>\n\
                    </div>\n\
                </div>\n\
                <button id="plans_image-remove' + next + '" class="btn btn-danger remove-me" >\n\
                    <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE');?>\n\
                </button>\n\
            </div>';
            var newInput = jQuery(newIn);
            jQuery(fieldroot).append(newInput);
            jQuery("#plans_image-field" + next).attr('data-source',jQuery(addto).attr('data-source'));
            jQuery("#count").val(next);  
        });
        // remove event
        jQuery('#plans_image-field').on('click','.remove-me', function(e){
            e.preventDefault();
            if(confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_GALLERY'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#plans_image-field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });
    });
</script>


