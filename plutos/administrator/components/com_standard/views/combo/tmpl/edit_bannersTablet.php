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
    <div class="span5">
        <div class="control-group">
            <div class="control-label">
                <label id="" class="hasPopover" for="" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_BANNER_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_BANNER_TABLET_LABEL'); ?>"><?php echo JText::_('COM_STANDARD_FIELD_BANNER_TABLET_LABEL'); ?></label>
            </div>
            <div class="controls thumbnail">
                <img src="<?php echo $this->item->view_banner_tablet; ?>" alt="<?php echo $this->item->view_banner_alt; ?>">					
            </div>
        </div>
    </div>
    <div class="span7">
        <div class="control-label">
            <label>&nbsp;</label>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="control-label">
                    <label class="checkbox hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_DELETE_BANNER_TOOLTIP_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_DELETE_BANNER_TOOLTIP_LABEL'); ?>">
                        <input name="banner_tablet_delete" value="1" type="checkbox" /><?php echo JText::_('COM_STANDARD_DELETE_BANNER_TOOLTIP_LABEL'); ?>						
                    </label>
                </div>
            </div>
        </div>

        <input type="file" name="banner_tablet" id="banner_tablet" value="" class="" />
        <p class="help-block">
            <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
            <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>
            <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
        </p>
    </div>
</div>