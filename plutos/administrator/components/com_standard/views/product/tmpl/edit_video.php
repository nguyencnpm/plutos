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
    <div class="span6 alert">
        <?php echo $this->form->getControlGroup('aspect_ratio'); ?>
    </div>
    <div class="span6 alert">
        <?php echo $this->form->getControlGroup('frame_rate'); ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div id="video-field">
            <?php $j = 0; ?>
            <?php if (!empty($this->item->videos)): ?>
                <?php foreach ($this->item->videos as $i => $v_item) : ?>
                    <div id="video-field<?php echo $i; ?>" class="row<?php echo $i % 2; ?> alert alert-secondary sortable-cursor-move">
                        <span class="icon-menu"></span>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_videos_urltext-lbl<?php echo $i; ?>" for="jform_videos_urltext<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" name="jform[videos][<?php echo $i; ?>][urltext]" id="jform_videos_urltext<?php echo $i; ?>" value="<?php echo $v_item['urltext']; ?>" size="20" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_video_status-lbl<?php echo $i; ?>" for="jform_video_status<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_VIDEO_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_SHOW_VIDEO_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <fieldset id="jform_fieldset_video_status<?php echo $i; ?>" class="btn-group btn-group-yesno radio">
                                            <input id="jform_show_video_status<?php echo $i; ?>" name="jform[videos][<?php echo $i; ?>][video_status]" value="1" <?php echo $v_item['video_status'] == 1 ? "checked='checked'" : ""; ?> type="radio">			
                                            <label for="jform_show_video_status<?php echo $i; ?>" class="btn ">
                                                <?php echo JText::_('JSHOW'); ?>			
                                            </label>
                                            <input id="jform_hide_video_status<?php echo $i; ?>" name="jform[videos][<?php echo $i; ?>][video_status]" value="0" <?php echo $v_item['video_status'] == 0 ? "checked='checked'" : ""; ?> type="radio">			
                                            <label for="jform_hide_video_status<?php echo $i; ?>" class="btn">
                                                <?php echo JText::_('JHIDE'); ?>			
                                            </label>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_videos_url-lbl<?php echo $i; ?>" for="jform_videos_url<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" name="jform[videos][<?php echo $i; ?>][url]" id="jform_videos_url<?php echo $i; ?>" value="<?php echo $v_item['url'] ?>" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid form-vertical">
                            <div class="span3">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_videos_thumbnail-lbl<?php echo $i; ?>" for="jform_videos_thumbnail<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <div class="control-group well">
                                            <img src="<?php echo empty($this->item->videos[$i]['images']['image_small']) ? $this->focus_view_video : JURI::root(FALSE) . $this->item->videos[$i]['images']['image_small']; ?>" alt="<?php echo empty($this->item->videos[$i]['video_alt']) ? $this->focus_view_video_alt : $this->item->videos[$i]['video_alt']; ?>">					
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_LABEL'); ?>">
                                            <input name="jform[videos][<?php echo $i; ?>][video_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_LABEL'); ?>						
                                        </label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <input type="file" name="video[<?php echo $i; ?>]" id="video<?php echo $i; ?>" value="" class="" />
                                    <p class="help-block">
                                        <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                                        <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                                        <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_videos_video_title-lbl<?php echo $i; ?>" for="jform_videos_video_title<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" name="jform[videos][<?php echo $i; ?>][video_title]" id="jform_videos_video_title<?php echo $i; ?>" value="<?php echo $v_item['video_title'] ?>" type="text">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_videos_video_alt-lbl<?php echo $i; ?>" for="jform_videos_video_alt<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" name="jform[videos][<?php echo $i; ?>][video_alt]" id="jform_videos_video_alt<?php echo $i; ?>" value="<?php echo $v_item['video_alt'] ?>" type="text">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_videos_video_caption-lbl<?php echo $i; ?>" for="jform_videos_video_caption<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_LABEL'); ?>">
                                            <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_LABEL'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <input class="span12" size="" name="jform[videos][<?php echo $i; ?>][video_caption]" id="jform_videos_video_caption<?php echo $i; ?>" value="<?php echo $v_item['video_caption'] ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <div class="control-label">
                                        <label id="jform_descriptions_descriptionimage-lbl0" for="jform_videos_description<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('Video'); ?>" data-original-title="<?php echo JText::_('Description'); ?>">
                                            <?php echo JText::_('Description'); ?>
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <textarea class="span12" name="jform[videos][<?php echo $i; ?>][description]" id="jform_videos_description<?php echo $i; ?>" rows="9"><?php echo $v_item['description']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="remove<?php echo $i; ?>" class="btn btn-danger remove-me">
                            <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE');?>
                        </button>
                    </div><!-- end video-field Add More -->
                    <?php $j = $i; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo $this->loadTemplate('addnewvideos'); ?>
            <?php endif; ?>
        </div>
        <!-- Button -->
        <div class="control-group">
            <div class="span4">
                <button id="video-add-more" name="add-more" class="btn btn-primary">
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
        jQuery("#video-field").sortable();
        jQuery("#video-field").disableSelection();
        // --- /.sortable ---
    //@naresh action dynamic childs
    var next = <?php echo $j;?>;
    jQuery("#video-add-more").click(function(e){
        e.preventDefault();
        var fieldroot ="#video-field";
        var addto = "#video-field" + next;
        next = next + 1;
        var newIn = ' \n\
            <div id="video-field' + next + '" name="field' + next + '" class="row' + next%2 + ' alert alert-secondary sortable-cursor-move">\n\
                <span class="icon-menu"></span>\n\
                <div class="row-fluid">\n\
                    <div class="span6">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_videos_urltext-lbl' + next + '" for="jform_videos_urltext' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" name="jform[videos][' + next + '][urltext]" id="jform_videos_urltext' + next + '" value="" size="20" type="text">\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="span6">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_video_status-lbl' + next + '" for="jform_video_status' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_VIDEO_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_SHOW_VIDEO_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <fieldset id="jform_fieldset_video_status' + next + '" class="btn-group btn-group-yesno radio">\n\
                                    <input id="jform_show_video_status' + next + '" name="jform[videos][' + next + '][video_status]" value="1" checked="checked" type="radio">\n\
                                    <label for="jform_show_video_status' + next + '" class="btn active btn-success">\n\
                                        <?php echo JText::_('JSHOW'); ?>\n\
                                    </label>\n\
                                    <input id="jform_hide_video_status' + next + '" name="jform[videos][' + next + '][video_status]" value="0" type="radio">\n\
                                    <label for="jform_hide_video_status' + next + '" class="btn">\n\
                                        <?php echo JText::_('JHIDE'); ?>\n\
                                    </label>\n\
                                </fieldset>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <div class="row-fluid">\n\
                    <div class="span12">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_videos_url-lbl' + next + '" for="jform_videos_url' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" name="jform[videos][' + next + '][url]" id="jform_videos_url' + next + '" value="" type="text">\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <div class="row-fluid form-vertical">\n\
                    <div class="span3">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_videos_thumbnail-lbl' + next + '" for="jform_videos_thumbnail' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <div class="control-group well thumbnail">\n\
                                    <img src="<?php echo $this->focus_view_video ?>" alt="<?php echo $this->focus_view_video_alt ?>">\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="span3">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_LABEL'); ?>">\n\
                                    <input name="jform[videos][' + next + '][video_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <input type="file" name="video[' + next + ']" id="video' + next + '" value="" class="" />\n\
                                <p class="help-block">\n\
                                    <?php $cMax = (int) $this->params->image_upload_maxsize; ?>\n\
                                    <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>\n\
                                    <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>\n\
                                </p>\n\
                        </div>\n\
                    </div>\n\
                    <div class="span3">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_videos_video_title-lbl' + next + '" for="jform_videos_video_title' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" name="jform[videos][' + next + '][video_title]" id="jform_videos_video_title' + next + '" value="" type="text">\n\
                            </div>\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_videos_video_alt-lbl' + next + '" for="jform_videos_video_alt' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" name="jform[videos][' + next + '][video_alt]" id="jform_videos_video_alt' + next + '" value="" type="text">\n\
                            </div>\n\
                        </div>\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_videos_video_caption-lbl' + next + '" for="jform_videos_video_caption' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_LABEL'); ?>">\n\
                                     <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" size="" name="jform[videos][' + next + '][video_caption]" id="jform_videos_video_caption' + next + '" value="" type="text">\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="span3">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_descriptions_descriptionimage-lbl0" for="jform_videos_description' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('Video'); ?>" data-original-title="<?php echo JText::_('Description'); ?>">\n\
                                    <?php echo JText::_('Description'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <textarea class="span12" name="jform[videos][' + next + '][description]" id="jform_videos_description' + next + '" rows="9"></textarea>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <button id="remove' + next + '" class="btn btn-danger remove-me">\n\
                    <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE');?>\n\
                </button>\n\
            </div>';
            var newInput = jQuery(newIn);
            jQuery(fieldroot).append(newInput);
            jQuery("#video-field" + next).attr('data-source',jQuery(addto).attr('data-source'));
            jQuery("#count").val(next);  
        });
        // remove event
        jQuery('#video-field').on('click','.remove-me', function(e){
            e.preventDefault();
            if(confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_VIDEO'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#video-field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });
    });
</script>