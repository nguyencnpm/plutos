<?php
defined('_JEXEC') or die;
?>
<div id="gallery-field0" class="row0 alert alert-info sortable-cursor-move">
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_galleries_thumbnail-lbl0" for="jform_galleries_thumbnail0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_LABEL'); ?>">
                        <span class="icon-menu"></span> <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <div class="control-group well thumbnail">
                        <img src="<?php echo empty($this->item->galleries[0]['images']['image_small']) ? $this->focus_view_gallery : JURI::root(FALSE) . $this->item->galleries[0]['images']['image_small']; ?>" alt="<?php echo empty($this->item->galleries[0]['gallery_alt']) ? $this->focus_view_gallery_alt : $this->item->galleries[0]['gallery_alt']; ?>">					
                    </div>
                </div>
            </div>
        </div>

        <div class="span4">
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_gallery_status-lbl0" for="jform_gallery_status0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_GALLERY_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_SHOW_GALLERY_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <fieldset id="jform_fieldset_gallery_status0" class="btn-group btn-group-yesno radio">
                        <input id="jform_show_gallery_status0" name="jform[galleries][0][gallery_status]" value="1" checked="checked" type="radio">			
                        <label for="jform_show_gallery_status0" class="btn">
                            <?php echo JText::_('JSHOW'); ?>			
                        </label>
                        <input id="jform_hide_gallery_status0" name="jform[galleries][0][gallery_status]" value="0" type="radio">			
                        <label for="jform_hide_gallery_status0" class="btn">
                            <?php echo JText::_('JHIDE'); ?>			
                        </label>
                    </fieldset>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_GALLERY_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_GALLERY_LABEL'); ?>">
                        <input name="jform[galleries][0][gallery_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_GALLERY_LABEL'); ?>						
                    </label>
                </div>
            </div>
            <div class="control-group">
                <input type="file" name="gallery[0]" id="gallery0" value="" class="" />
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
                    <label id="jform_galleries_gallery_title-lbl0" for="jform_galleries_gallery_title0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_TITLE_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[galleries][0][gallery_title]" id="jform_galleries_gallery_title0" value="" type="text">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_galleries_gallery_alt-lbl0" for="jform_galleries_gallery_alt0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_ALT_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[galleries][0][gallery_alt]" id="jform_galleries_gallery_alt0" value="" type="text">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_galleries_gallery_caption-lbl0" for="jform_galleries_gallery_caption0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_GALLERY_CAPTION_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" size="" name="jform[galleries][0][gallery_caption]" id="jform_galleries_gallery_caption0" value="" type="text">
                </div>
            </div>
        </div>
    </div>
    <button id="gallery-remove0" class="btn btn-danger remove-me" >
        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
    </button>
</div><!-- end gallery field Add More -->