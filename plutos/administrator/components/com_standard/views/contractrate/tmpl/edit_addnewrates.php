<?php
defined('_JEXEC') or die;
?>
<div id="inforate-field0" class="row0">
    <fieldset class="form-vertical">
        <div class="row-fluid">
            <div class="span5">
                <div class="control-group">
                    <div class="control-label">
                        <label id="jform_rate-date-lbl0" for="jform_rate-date0" class="required" aria-invalid="false">
                            <?php echo JText::_('COM_STANDARD_FIELD_RATE_DATE_LABEL'); ?><span class="star">&nbsp;*</span>
                        </label>
                    </div>
                    <div class="controls">
                        <div class="input-prepend input-group daterangepicker-calendar">
                            <label for="jform_rate-date0" class="add-on input-group-addon">
                                <i class="glyph-icon icon-calendar"></i>
                            </label>
                            <input type="text" name="jform[inforate][0][ratedate]" id="jform_rate-date0" class="form-control required" required="required" aria-required="true" value="<?php echo $this->start_date; ?> - <?php echo $this->expiry_date; ?>">
                        </div>
                    </div>
                </div>
            </div><!-- end daterangepicker -->
            
            <div class="span4">
                <div class="control-group">
                    <div class="control-label">
                        <label id="jform_inforate_price-lbl0" for="jform_inforate_price0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_FIELD_PRICE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_PRICE_LABEL'); ?>">
                            <?php echo JText::_('COM_STANDARD_FIELD_PRICE_LABEL'); ?><span class="star">&nbsp;*</span>
                        </label>
                    </div>
                    <div class="controls">
                        <input class="span12" name="jform[inforate][0][price]" id="jform_inforate_price0" value="" step="0.00001" min="0.00000" type="number">
                    </div>
                </div>
            </div><!-- end price -->
            
            <div class="span3">
                <div class="control-group">
                    <div class="control-label">
                        <label id="jform_inforate_status-lbl0" for="jform_inforate_status0" class="hasPopover" title="" data-content="<?php echo JText::_('COM_STANDARD_SHOW_INFORATE_DESC'); ?>" data-original-title="<?php echo JText::_('COM_STANDARD_SHOW_INFORATE_LABEL'); ?>">
                            <?php echo JText::_('COM_STANDARD_SHOW_INFORATE_LABEL'); ?>
                        </label>
                    </div>
                    <div class="controls">
                        <fieldset id="jform_fieldset_inforate_status0" class="btn-group btn-group-yesno radio">
                            <input id="jform_show_inforate_status0" name="jform[inforate][0][inforate_status]" value="1" checked="checked" type="radio">			
                            <label for="jform_show_inforate_status0" class="btn">
                                <?php echo JText::_('JSHOW'); ?>			
                            </label>
                            <input id="jform_hide_inforate_status0" name="jform[inforate][0][inforate_status]" value="0" type="radio">			
                            <label for="jform_hide_inforate_status0" class="btn">
                                <?php echo JText::_('JHIDE'); ?>			
                            </label>
                        </fieldset>
                    </div>
                </div>
            </div><!-- /.inforate status -->
        </div>
    </fieldset>
</div><!-- end field Add More -->