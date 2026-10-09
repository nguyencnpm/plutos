<?php
defined('_JEXEC') or die;
?>
<div class="row-fluid">
    <div class="span4">
        <div id="field" class="daterangepicker-calendar">
            <?php $j = 0; ?>
            <?php if (!empty($this->item->period_block)): ?>
                <?php foreach ($this->item->period_block as $i => $v_item) : ?>
                    <div id="field<?php echo $i; ?>" class="row<?php echo $i % 2; ?>">
                        <div class="well">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label id="jform_product-block-date-lb<?php echo $i; ?>" for="jform_product-block-date<?php echo $i; ?>" class="hasTooltip" title="" data-original-title="<?php echo JText::_('COM_STANDARD_FIELD_PRODUCT_BLOCK_LABEL'); ?>">
                                                <?php echo JText::_('COM_STANDARD_FIELD_PRODUCT_BLOCK_LABEL'); ?>
                                            </label>
                                        </div>
                                        <div class="input-prepend input-group">
                                            <label for="jform_product-block-date<?php echo $i; ?>" class="add-on input-group-addon">
                                                <i class="glyph-icon icon-calendar"></i>
                                            </label>
                                            <input type="text" name="jform[period_block][<?php echo $i; ?>]" id="jform_product-block-date<?php echo $i; ?>" class="form-control" value="<?php echo $v_item; ?>">
                                        </div>
                                    </div>
                                </div>
                                <button id="remove<?php echo $i; ?>" class="btn btn-danger remove-me" ><span class="icon-trash" aria-hidden="true"></span><?php echo JText::_("COM_STANDARD_REMOVE"); ?></button>
                            </div>
                        </div><!-- end daterangepicker -->
                    </div><!-- end field Add More -->
                    <?php $j = $i; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo $this->loadTemplate('addnewproductblock'); ?>
            <?php endif; ?>
        </div>
        <!-- Button -->
        <div class="form-group">
            <div class="span12">
                <span class="icon-new icon-white" aria-hidden="true"></span>
                <button id="add-more" name="add-more" class="btn btn-primary"><?php echo JText::_('COM_STANDARD_ADD_MORE'); ?></button>
            </div>
        </div>
    </div>
    <div class="span8">
        <?php echo JLayoutHelper::render("standard.views.periodblock", array('item' => $this->item)); ?>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function () {
        <?php for ($next = 0; $next < $j; $next ++): ?>
            // call daterangepicker    
            jQuery("#jform_product-block-date<?php echo $next; ?>").daterangepicker({
                format: "YYYY-MM-DD"
            });
            // End call daterangepicker

        <?php endfor; ?>
        // call daterangepicker    
        jQuery("#jform_product-block-date<?php echo $j; ?>").daterangepicker({
            format: "YYYY-MM-DD"
        });
        // End call daterangepicker

        //@naresh action dynamic childs
        var next = <?php echo $j; ?>;
        jQuery("#add-more").click(function (e) {
            e.preventDefault();
            var fieldroot = "#field";
            var addto = "#field" + next;
            // var addRemove = "#field" + (next);
            next = next + 1;
            var newIn = ' \n\
                <div id="field' + next + '" name="field' + next + '" class="row' + next % 2 + '">\n\
                    <div class="well">\n\
                        <div class="row-fluid">\n\
                            <div class="span12">\n\
                                <div class="control-group">\n\
                                    <div class="control-label">\n\
                                        <label id="jform_product-block-date-lb' + next + '" for="jform_product-block-date' + next + '">\n\
                                            <?php echo JText::_('COM_STANDARD_FIELD_PRODUCT_BLOCK_LABEL'); ?>\n\
                                        </label>\n\
                                    </div>\n\
                                    <div class="input-prepend input-group ">\n\
                                        <label for="jform_product-block-date' + next + '" class="add-on input-group-addon">\n\
                                            <i class="glyph-icon icon-calendar"></i>\n\
                                        </label>\n\
                                        <input type="text" name="jform[period_block][' + next + ']" id="jform_product-block-date' + next + '" class="form-control" value="">\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                            <button id="remove' + next + '" class="btn btn-danger remove-me" ><span class="icon-trash" aria-hidden="true"></span><?php echo JText::_("COM_STANDARD_REMOVE"); ?></button>\n\
                        </div>\n\
                    </div>\n\
                </div>';
            var newInput = jQuery(newIn);
            jQuery(fieldroot).append(newInput);
            jQuery("#field" + next).attr('data-source', jQuery(addto).attr('data-source'));
            jQuery("#count").val(next);

            // call daterangepicker next
            jQuery("#jform_product-block-date" + next).daterangepicker({
                format: "YYYY-MM-DD"
            });
            // End call daterangepicker next
        });

        // remove event
        jQuery('#field').on('click','.remove-me', function(e){
            e.preventDefault();
            if (confirm("<?php echo JText::_('COM_STANDARD_REMOVE_THIS_PRODUCT_BLOCK_PERIOD'); ?>")) {
                var fieldNum = this.id.charAt(this.id.length - 1);
                var fieldID = "#field" + fieldNum;
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }
        });

        jQuery("#jform_product-block-date-custom<?php echo $j; ?>").daterangepicker({
            startDate: moment().subtract("days", 29),
            endDate: moment(),
            minDate: "01/01/2012",
            maxDate: "12/31/2014",
            dateLimit: {days: 60},
            showDropdowns: !0,
            showWeekNumbers: !0,
            timePicker: !1,
            timePickerIncrement: 1,
            timePicker12Hour: !0,
            ranges: {
                Today: [moment(), moment()], Yesterday: [moment().subtract("days", 1),
                    moment().subtract("days", 1)],
                "Last 7 Days": [moment().subtract("days", 6), moment()],
                "Last 30 Days": [moment().subtract("days", 29), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract("month", 1).startOf("month"), moment().subtract("month", 1).endOf("month")]},
            opens: "left", buttonClasses: ["btn btn-default"],
            applyClass: "small bg-green",
            cancelClass: "small ui-state-default",
            format: "MM/DD/YYYY", separator: " to ",
            locale: {
                applyLabel: "Apply"
                , fromLabel: "From",
                toLabel: "To",
                customRangeLabel: "Custom Range",
                daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                firstDay: 1
            }
        }, function (a, b) {
            console.log("Callback has been called!"),
                    jQuery("#daterangepicker-custom span").html(a.format("MMMM D, YYYY") + " - " + b.format("MMMM D, YYYY"))
        }), jQuery("#daterangepicker-custom span").html(moment().subtract("days", 29).format("MMMM D, YYYY") + " - " + moment().format("MMMM D, YYYY"))

    });
</script>