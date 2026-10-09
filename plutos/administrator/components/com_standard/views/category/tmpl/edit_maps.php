<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="row-fluid">
    <div class="span6">
        <div class="row-fluid form-vertical">
            <div class="span6">
                <div class="control-group">
                    <div class="control-label">
                        <label id="" class="hasPopover" for="" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_IMAGE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_IMAGE_LABEL'); ?>"><?php echo JText::_('COM_STANDARD_FIELD_IMAGE_LABEL'); ?></label>
                    </div>
                    <div class="controls">
                        <div class="control-group well">
                            <img src="<?php echo $this->item->view_map; ?>" alt="<?php echo $this->item->view_map_alt; ?>">					
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="row-fluid">
                    <div class="span12">
                        &nbsp;
                        <div class="control-label">
                            <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_IMAGE_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_IMAGE_TOOLTIP_LABEL'); ?>">
                                <input name="map_delete" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_IMAGE_TOOLTIP_LABEL'); ?>						
                            </label>
                        </div>
                    </div>
                </div>
                <input type="file" name="map" id="map" value="" class="" />
                <p class="help-block">
                    <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                    <?php $maxSize = $cMax . 'MB'; //JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                    <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="span6">
        <?php echo $this->form->renderField('maps'); ?>
        <?php foreach ($this->form->getGroup('maps') as $field) : ?>
            <?php echo $field->renderField(); ?>
        <?php endforeach; ?>
    </div>
</div>