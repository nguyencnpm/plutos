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
<div id="childimages-field0" class="row0 alert alert-secondary sortable-cursor-move">
    <div class="row-fluid">
        <div class="span1"><span class="icon-menu"></span></div>
        <div class="span3">
            <div class="control-group well thumbnail">
                <img src="<?php echo $this->focus_view_image; ?>" alt="<?php echo ''; ?>">
            </div>
        </div>
        <div class="span8">
            <div class="control-group">
                <input type="file" name="childimages[0]" id="childimages0" value="" class="" />
                <p class="help-block">
                    <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                    <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                    <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                </p>
            </div>
        </div>
    </div>
    <button id="childimages-remove0" class="btn btn-danger remove-me" >
        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
    </button>
</div><!-- end field Add More -->
