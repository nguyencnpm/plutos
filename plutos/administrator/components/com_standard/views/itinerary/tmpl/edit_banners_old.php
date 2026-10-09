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
        <div class="control-group">
            <div class="control-label">
                <label id="" class="hasPopover" for="" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_BANNER_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_BANNER_LABEL'); ?>"><?php echo JText::_('COM_STANDARD_FIELD_BANNER_LABEL'); ?></label>
            </div>
            <div class="controls">
                <div class="control-group well">
                    <img src="<?php echo $this->item->view_banner; ?>" alt="<?php echo $this->item->view_banner_alt; ?>">					
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="control-label">
                            <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_BANNER_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_BANNER_TOOLTIP_LABEL'); ?>">
                                <input name="banner_delete" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_BANNER_TOOLTIP_LABEL'); ?>						
                            </label>
                        </div>
                    </div>
                </div>
                <input type="file" name="banner" id="banner" value="" class="" />
                <p class="help-block">
                    <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                    <?php $maxSize = $cMax . 'MB';//JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                    <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                </p>
            </div>
        </div>

    </div>
    <div class="span6">
        <?php //echo $this->form->renderField('banners'); ?>
        <?php echo $this->form->getControlGroup('banner_status'); ?>
        <?php echo $this->form->getControlGroup('banner_home'); ?>
        <?php foreach ($this->form->getGroup('banners') as $field) : ?>
            <?php echo $field->renderField(); ?>
        <?php endforeach; ?>
    </div>
</div>