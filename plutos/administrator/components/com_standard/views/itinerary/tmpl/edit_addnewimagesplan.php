<?php
defined('_JEXEC') or die;
$editor = JFactory::getEditor();
$name = "jform[plans_image][0][plans]";
$value = "";
$width = '100%';
$height = '280';
$columns = '15';
$rows = '5';
?>

<div id="plans_image-field0" class="row0 alert alert-secondary sortable-cursor-move">
    <span class="icon-menu"></span>
    <div class="row-fluid">
        <div class="span12">
            <div class="control-group well thumbnail">
                <img src="<?php echo $this->focus_view_plansimage; ?>" alt="<?php echo $this->focus_view_descriptionimage_alt; ?>">
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>">
                        <input name="jform[plans_image][0][plans_image_delete]" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_DESCRIPTION_IMAGE_TOOLTIP_LABEL'); ?>						
                    </label>
                </div>
            </div>
            <div class="control-group">
                <input type="file" name="plans_image[0]" id="plans_image0" value="" class="" />
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
                    <label id="jform_plans_plans_image_title-lbl0" for="jform_plans_plans_image_title0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_TITLE_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[plans_image][0][plans_image_title]" id="jform_plans_plans_image_title0" value="" type="text">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_plans_plans_image_alt-lbl0" for="jform_plans_plans_image_alt0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_ALT_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[plans_image][0][plans_image_alt]" id="jform_plans_plans_image_alt0" value="" type="text">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_plans_plans_image_caption-lbl0" for="jform_plans_plans_image_caption0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>">
                        <?php echo JText::_('COM_STANDARD_FIELD_DESCRIPTION_IMAGE_CAPTION_LABEL'); ?>
                    </label>
                </div>
                <div class="controls">
                    <input class="span12" name="jform[plans_image][0][plans_image_caption]" id="jform_plans_plans_image_caption0" value="" type="text">
                </div>
            </div>
        </div>
    </div>
    <button id="plans_image-remove0" class="btn btn-danger remove-me" >
        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
    </button>
</div><!-- end field Add More -->