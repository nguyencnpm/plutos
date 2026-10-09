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
<div id="childimages-field">
    <?php $j = 0; ?>
    <?php if (!empty($this->item->childimages)): ?>
        <?php foreach ($this->item->childimages as $i => $v_item) : ?>
            <div id="childimages-field<?php echo $i; ?>" class="row<?php echo $i % 2; ?> alert alert-secondary sortable-cursor-move">
                <div class="row-fluid">
                    <div class="span1"><span class="icon-menu"></span></div>
                    <div class="span3">
                        <div class="control-group well thumbnail">
                            <img src="<?php echo empty($this->item->childimages[$i]['images']['image_small']) ? $this->focus_view_image : JURI::root(FALSE) . $this->item->childimages[$i]['images']['image_small']; ?>" alt="<?php echo ''; ?>">					                                        
                        </div>
                    </div>
                    <div class="span8">
                        <div class="control-group">
                            <input type="file" name="childimages[<?php echo $i; ?>]" id="childimages<?php echo $i; ?>" value="" class="" />
                            <p class="help-block">
                                <?php $cMax = (int) $this->params->image_upload_maxsize; ?>
                                <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>
                                <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <button id="childimages-remove<?php echo $i; ?>" class="btn btn-danger remove-me" >
                    <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>
                </button>
            </div><!-- end field Add More -->
            <?php $j = $i; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <?php echo $this->loadTemplate('addnewchildimages'); ?>
    <?php endif; ?>
</div>

<!-- Button -->
<div class="control-group">
    <button id="childimages-add-more" name="add-more" class="btn btn-primary">
        <span class="icon-new icon-white" aria-hidden="true"></span>
        <?php echo JText::_('COM_STANDARD_ADD_MORE'); ?>
    </button>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        // --- sortable ---
        jQuery("#childimages-field").sortable();
        jQuery("#childimages-field").disableSelection();
        // --- /.sortable ---
        
        //@naresh action dynamic childs
        var next = <?php echo $j;?>;
        jQuery("#childimages-add-more").click(function(e){
            e.preventDefault();
            var fieldroot ="#childimages-field";
            var addto = "#childimages-field" + next;
            next = next + 1;
            var newIn = ' \n\
            <div id="childimages-field' + next + '" class="row' + next%2 + ' alert alert-secondary sortable-cursor-move">\n\
                <div class="row-fluid">\n\
                    <div class="span1"><span class="icon-menu"></span></div>\n\
                    <div class="span3">\n\
                        <div class="control-group well thumbnail">\n\
                            <img src="<?php echo $this->focus_view_image; ?>" alt="<?php echo ''; ?>">\n\
                        </div>\n\
                    </div>\n\
                    <div class="span8">\n\
                        <div class="control-group">\n\
                            <input type="file" name="childimages[' + next + ']" id="childimages' + next + '" value="" class="" />\n\
                            <p class="help-block">\n\
                                <?php $cMax = (int) $this->params->image_upload_maxsize; ?>\n\
                                <?php $maxSize = JUtility::getMaxUploadSize($cMax . 'MB'); ?>\n\
                                <?php echo JText::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', JHtml::_('number.bytes', $maxSize)); ?>\n\
                            </p>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <button id="childimages-remove' + next + '" class="btn btn-danger remove-me" >\n\
                    <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>\n\
                </button>\n\
            </div>\n\
            ';
            var newInput = jQuery(newIn);
            jQuery(fieldroot).append(newInput);
            jQuery("#childimages-field" + next).attr('data-source',jQuery(addto).attr('data-source'));
            jQuery("#count").val(next);  
        });
        // remove event
        jQuery('#childimages-field').on('click','.remove-me', function(e){
            e.preventDefault();
            if(confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_CHILD_IMAGE'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#childimages-field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });
    });
</script>
