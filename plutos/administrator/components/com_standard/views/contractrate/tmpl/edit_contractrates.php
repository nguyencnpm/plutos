<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$editor = JFactory::getEditor();

//echo '<pre>';
//print_r($this->item->inforates);
//exit;

?>
<div class="row-fluid">
    <div class="span12">
        <div id="inforate-field">
            <?php $j = 0; ?>
            <?php if (!empty($this->item->inforates)): ?>
                <?php foreach ($this->item->inforates as $i => $v_item) : ?>
                    <div id="inforate-field<?php echo $i; ?>" class="row<?php echo $i % 2; ?>">
                        <fieldset class="form-vertical">
                            <div class="row-fluid">
                                <div class="span5">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label id="jform_rate-date-lbl<?php echo $i; ?>" for="jform_rate-date<?php echo $i; ?>" class="required" aria-invalid="false">
                                                <?php echo JText::_('COM_STANDARD_FIELD_RATE_DATE_LABEL'); ?><span class="star">&nbsp;*</span>
                                            </label>
                                        </div>
                                        <div class="controls">
                                            <div class="input-prepend input-group daterangepicker-calendar">
                                                <label for="jform_rate-date<?php echo $i; ?>" class="add-on input-group-addon">
                                                    <i class="glyph-icon icon-calendar"></i>
                                                </label>
                                                <input type="text" name="jform[inforate][<?php echo $i; ?>][ratedate]" id="jform_rate-date<?php echo $i; ?>" class="form-control required" required="required" aria-required="true" value="<?php echo JHtml::_('date', $v_item->start_date, JText::_('DATE_FORMAT_LC4')); ?> - <?php echo JHtml::_('date', $v_item->expiry_date, JText::_('DATE_FORMAT_LC4')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end daterangepicker -->

                                <div class="span4">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label id="jform_inforate_price-lbl<?php echo $i; ?>" for="jform_inforate_price<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_PRICE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_PRICE_LABEL'); ?>">
                                                <?php echo JText::_('COM_STANDARD_FIELD_PRICE_LABEL'); ?>
                                            </label>
                                        </div>
                                        <div class="controls">
                                            <input class="span12" name="jform[inforate][<?php echo $i; ?>][price]" id="jform_inforate_price<?php echo $i; ?>" value="<?php echo $v_item->price; ?>" step="0.00001" min="0.00000" type="number">
                                        </div>
                                    </div>
                                </div><!-- end price -->

                                <div class="span3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label id="jform_inforate_status-lbl<?php echo $i; ?>" for="jform_inforate_status<?php echo $i; ?>" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_INFORATE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_INFORATE_LABEL'); ?>">
                                                <?php echo JText::_('COM_STANDARD_SHOW_INFORATE_LABEL'); ?>
                                            </label>
                                        </div>
                                        <div class="controls">
                                            <fieldset id="jform_fieldset_inforate_status<?php echo $i; ?>" class="btn-group btn-group-yesno radio">
                                                <input id="jform_show_inforate_status<?php echo $i; ?>" name="jform[inforate][<?php echo $i; ?>][inforate_status]" value="1" <?php echo empty($v_item->inforate_status) ? "" : "checked=\"checked\"" ?> type="radio">			
                                                <label for="jform_show_inforate_status<?php echo $i; ?>" class="btn">
                                                    <?php echo JText::_('JSHOW'); ?>			
                                                </label>
                                                <input id="jform_hide_inforate_status<?php echo $i; ?>" name="jform[inforate][<?php echo $i; ?>][inforate_status]" value="0" <?php echo empty($v_item->inforate_status) ? "checked=\"checked\"" : "" ?> type="radio">			
                                                <label for="jform_hide_inforate_status<?php echo $i; ?>" class="btn">
                                                    <?php echo JText::_('JHIDE'); ?>			
                                                </label>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div><!-- /.inforate status -->
                            </div>
                        </fieldset>

                    </div><!-- end field Add More -->
                    <?php // ---- type="hidden" use update table #__standard_rate_details ---- ?>
                    <input type="hidden" name="jform[inforate][<?php echo $i; ?>][id]" value="<?php echo $v_item->id; ?>">
                    <?php $j = $i; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo $this->loadTemplate('addnewrates'); ?>
            <?php endif; ?>
        </div>
        <!-- Button -->
        <div class="control-group">
            <div class="span4">
                <button id="inforate-add-more" name="add-more" class="btn btn-primary">
                    <span class="icon-new icon-white" aria-hidden="true"></span>
                    <?php echo JText::_('COM_STANDARD_ADD_MORE'); ?>
                </button>
            </div>
        </div>         
        <hr />
    </div>
</div>
<script type="text/javascript">
   jQuery(document).ready(function () {
    <?php for ($next = 0; $next < $j; $next ++) { ?>
             // call daterangepicker
            <?php if ($next == 0): ?>
                    var minDate = document.getElementById("jform_rate-date<?php echo $next; ?>").value;
                    var array_minDate = minDate.split(" - ");
                    var minDateIn = new Date(array_minDate[0]);
            <?php else: ?>
                    var minDate = document.getElementById("jform_rate-date<?php echo $next-1; ?>").value;
                    var array_minDate = minDate.split(" - ");
                    var minDateIn = new Date(array_minDate[1]);
                    var minDateIntemp = new Date(array_minDate[1]);
                    minDateIn.setDate(minDateIntemp.getDate() + 1);
            <?php endif; ?>
                
            jQuery("#jform_rate-date<?php echo $next;?>").daterangepicker({
                    format: "YYYY-MM-DD",
                    minDate: minDateIn
            });
            // End call daterangepicker
                
            var addRemove = "#inforate-field" + (<?php echo $next;?>);
            var removeBtn = '\
                    <button id="inforate-remove' + (<?php echo $next;?>) + '" class="btn btn-danger remove-me" >\n\
                        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE');?>\n\
                    </button>\n\
                    <hr />';
                            
            var removeButton = jQuery(removeBtn);
            jQuery(addRemove).after(removeButton);
            // remove
            jQuery('#inforate-remove<?php echo $next;?>').click(function(e){
                e.preventDefault();
                if(confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_INFORATE'); ?>")) {
                    var fieldNum = this.id.charAt(this.id.length-1);
                    var fieldID = "#inforate-field" + fieldNum;
                    jQuery(this).remove();
                    jQuery(fieldID).remove();
                } 
            });      
    <?php } ?>
    // call daterangepicker
    <?php if ($j == 0): ?>
            var minDate = document.getElementById("jform_rate-date<?php echo $j; ?>").value;
            var array_minDate = minDate.split(" - ");
            var minDateIn = new Date(array_minDate[0]);
    <?php else: ?>
            var minDate = document.getElementById("jform_rate-date<?php echo $j-1; ?>").value;
            var array_minDate = minDate.split(" - ");
            var minDateIn = new Date(array_minDate[1]);
            var minDateIntemp = new Date(array_minDate[1]);
            minDateIn.setDate(minDateIntemp.getDate() + 1);
    <?php endif; ?>
        
    jQuery("#jform_rate-date<?php echo $j; ?>").daterangepicker({
            format: "YYYY-MM-DD",
            minDate: minDateIn
    });
    // End call daterangepicker
 
    //@naresh action dynamic childs
    var next = <?php echo $j;?>;
    jQuery("#inforate-add-more").click(function(e){
        e.preventDefault();
        var addto = "#inforate-field" + next;
        var addRemove = "#inforate-field" + (next);
        next = next + 1;
        var newIn = ' \n\
            <div id="inforate-field' + next + '" name="field' + next + '" class="row' + next%2 + '">\n\
            <fieldset class="form-vertical">\n\
                <div class="row-fluid">\n\
                    <div class="span5">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_rate-date-lbl' + next + '" for="jform_rate-date' + next + '" class="required" aria-invalid="false">\n\
                                    <?php echo JText::_('COM_STANDARD_FIELD_RATE_DATE_LABEL'); ?><span class="star">&nbsp;*</span>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <div class="input-prepend input-group daterangepicker-calendar">\n\
                                    <label for="jform_rate-date' + next + '" class="add-on input-group-addon">\n\
                                        <i class="glyph-icon icon-calendar"></i>\n\
                                    </label>\n\
                                    <input type="text" name="jform[inforate][' + next + '][ratedate]" id="jform_rate-date' + next + '" class="form-control required" required="required" aria-required="true" value="<?php echo $this->start_date; ?> - <?php echo $this->expiry_date; ?>">\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div><!-- end daterangepicker -->\n\
                    <div class="span4">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_inforate_price-lbl' +  next +  '" for="jform_inforate_price' +  next +  '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_PRICE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_PRICE_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_FIELD_PRICE_LABEL'); ?><span class="star">&nbsp;*</span>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <input class="span12" name="jform[inforate][' + next + '][price]" id="jform_inforate_price' + next +
                                        '" value="" step="0.00001" min="0.00000" type="number">\n\
                            </div>\n\
                        </div>\n\
                    </div><!-- end price -->\n\
                    <div class="span3">\n\
                        <div class="control-group">\n\
                            <div class="control-label">\n\
                                <label id="jform_inforate_status-lbl' + next + '" for="jform_inforate_status' + next + '" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_INFORATE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_INFORATE_LABEL'); ?>">\n\
                                    <?php echo JText::_('COM_STANDARD_SHOW_INFORATE_LABEL'); ?>\n\
                                </label>\n\
                            </div>\n\
                            <div class="controls">\n\
                                <fieldset id="jform_fieldset_inforate_status' + next + '" class="btn-group btn-group-yesno radio">\n\
                                    <input id="jform_show_inforate_status' + next + '" name="jform[inforate][' + next + '][inforate_status]" value="1" checked="checked" type="radio">\n\
                                    <label for="jform_show_inforate_status' + next + '" class="btn btn-success">\n\
                                        <?php echo JText::_('JSHOW'); ?>\n\
                                    </label>\n\
                                    <input id="jform_hide_inforate_status' + next + '" name="jform[inforate][' + next + '][inforate_status]" value="0" type="radio">\n\
                                    <label for="jform_hide_inforate_status' + next + '" class="btn">\n\
                                        <?php echo JText::_('JHIDE'); ?>\n\
                                    </label>\n\
                                </fieldset>\n\
                            </div>\n\
                        </div>\n\
                    </div><!-- /.inforate status -->\n\
                </div>\n\
            </fieldset>\n\
        </div>';
        var newInput = jQuery(newIn);
        var removeBtn = '\
                    <button id="inforate-remove' + (next - 1) + '" class="btn btn-danger remove-me" >\n\
                        <span class="icon-trash" aria-hidden="true"></span><?php echo JText::_('COM_STANDARD_REMOVE'); ?>\n\
                    </button>\n\
                    <hr />';
        var removeButton = jQuery(removeBtn);
        jQuery(addto).after(newInput);
        jQuery(addRemove).after(removeButton);
        jQuery("#inforate-field" + next).attr('data-source',jQuery(addto).attr('data-source'));
        jQuery("#count").val(next);  
        
        // call daterangepicker next
            var minDate = document.getElementById("jform_rate-date"+(next - 1)).value;
            var array_minDate = minDate.split(" - ");
            var minDateIn = new Date(array_minDate[1]);
            var minDateIntemp = new Date(array_minDate[1]);
            minDateIn.setDate(minDateIntemp.getDate() + 1);
            
            var endDate = new Date(array_minDate[1]);
            endDate.setDate(minDateIn.getDate() + 31);
            
        jQuery("#jform_rate-date" + next).daterangepicker({
                format: "YYYY-MM-DD",
                minDate: minDateIn,
                startDate: minDateIn,
                endDate: endDate
        });
        jQuery("#jform_rate-date" + next).val(moment(minDateIn).format("YYYY-MM-DD") + ' - ' + moment(endDate).format("YYYY-MM-DD"));
            
        // End call daterangepicker next
            
        jQuery('#inforate-remove' + (next - 1)).click(function(e){
            e.preventDefault();
            if(confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_INFORATE'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#inforate-field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });
    });
});
</script>