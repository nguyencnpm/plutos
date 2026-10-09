<?php
defined('_JEXEC') or die;
?>
<div id="video-field0" class="row0 alert alert-secondary sortable-cursor-move">
    <span class="icon-menu"></span>
    <div class="row-fluid">
        <div class="span6">
            <!-- Text input-->
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_videos_urltext-lbl0" for="jform_videos_urltext0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_TITLE_VIDEO_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[videos][0][urltext]" id="jform_videos_urltext0" value="" size="20" type="text">
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_video_status-lbl0" for="jform_video_status0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_VIDEO_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_SHOW_VIDEO_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <fieldset id="jform_fieldset_video_status0" class="btn-group btn-group-yesno radio">
                        <input id="jform_show_video_status0" name="jform[videos][0][video_status]" value="1" checked="checked" type="radio">			
                        <label for="jform_show_video_status0" class="btn">
                            <?php echo JText::_('JSHOW'); ?>			
                        </label>
                        <input id="jform_hide_video_status0" name="jform[videos][0][video_status]" value="0" type="radio">			
                        <label for="jform_hide_video_status0" class="btn">
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
                    <label id="jform_videos_url-lbl0" for="jform_videos_url0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_LINK_VIDEO_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[videos][0][url]" id="jform_videos_url0" value="" type="text">
                </div>
            </div>
        </div>
    </div>    
    <div class="row-fluid form-vertical">
        <div class="span3">
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_videos_thumbnail-lbl0" for="jform_videos_thumbnail0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <div class="control-group well thumbnail">
                        <img src="<?php echo empty($this->item->videos[0]['images']['image_small']) ? $this->focus_view_video : JURI::root(FALSE) . $this->item->videos[0]['images']['image_small']; ?>" alt="<?php echo empty($this->item->videos[0]['video_alt']) ? $this->focus_view_video_alt : $this->item->videos[0]['video_alt']; ?>">					
                    </div>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <div class="control-label">
                    <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_LABEL'); ?>">
                        <input name="jform[videos][0][video_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_VIDEO_TOOLTIP_LABEL'); ?>						
                    </label>
                </div>
            </div>
            <div class="control-group">
                <input type="file" name="video[0]" id="video0" value="" class="" />
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
                    <label id="jform_videos_video_title-lbl0" for="jform_videos_video_title0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_TITLE_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[videos][0][video_title]" id="jform_videos_video_title0" value="" type="text">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_videos_video_alt-lbl0" for="jform_videos_video_alt0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_ALT_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[videos][0][video_alt]" id="jform_videos_video_alt0" value="" type="text">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_videos_video_caption-lbl0" for="jform_videos_video_caption0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_VIDEO_THUMBNAIL_CAPTION_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" size="" name="jform[videos][0][video_caption]" id="jform_videos_video_caption0" value="" type="text">
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_descriptions_descriptionimage-lbl0" for="jform_videos_description0" class="hasPopover" title="" data-content="<?php echo JText::_('Video'); ?>" data-original-title="<?php echo JText::_('Description'); ?>">
                        <?php echo JText::_('Description'); ?>
                    </label>
                </div>
                <div class="controls">
                    <textarea class="span12" name="jform[videos][0][description]" id="jform_videos_description0" rows="9"></textarea>
                </div>
            </div>
        </div>
    </div>    
    <button id="remove0" class="btn btn-danger remove-me" >
        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
    </button>
</div><!-- end video-video-field Add More -->