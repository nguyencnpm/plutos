/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//jQuery(function () {
//    "use strict";
//    jQuery("#contract-date").daterangepicker()
//}), jQuery(function () {
//    "use strict";
//    jQuery("#daterangepicker-time").daterangepicker({
//        timePicker: !0, timePickerIncrement: 30, format: "MM/DD/YYYY h:mm A"
//    })
//}), jQuery(function () {
//    "use strict";
//    jQuery("#daterangepicker-custom").daterangepicker({
//        startDate: moment().subtract("days", 29),
//        endDate: moment(), minDate: "01/01/2012",
//        maxDate: "12/31/2014",
//        dateLimit: {days: 60},
//        showDropdowns: !0,
//        showWeekNumbers: !0,
//        timePicker: !1,
//        timePickerIncrement: 1,
//        timePicker12Hour: !0,
//        ranges: {
//            Today: [moment(), moment()], Yesterday: [moment().subtract("days", 1),
//                moment().subtract("days", 1)],
//            "Last 7 Days": [moment().subtract("days", 6), moment()],
//            "Last 30 Days": [moment().subtract("days", 29), moment()],
//            "This Month": [moment().startOf("month"), moment().endOf("month")],
//            "Last Month": [moment().subtract("month", 1).startOf("month"), moment().subtract("month", 1).endOf("month")]},
//        opens: "left", buttonClasses: ["btn btn-default"],
//        applyClass: "small bg-green",
//        cancelClass: "small ui-state-default",
//        format: "MM/DD/YYYY", separator: " to ",
//        locale: {
//            applyLabel: "Apply"
//            , fromLabel: "From",
//            toLabel: "To",
//            customRangeLabel: "Custom Range",
//            daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
//            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
//            firstDay: 1
//        }
//    }, function (a, b) {
//        console.log("Callback has been called!"),
//                jQuery("#daterangepicker-custom span").html(a.format("MMMM D, YYYY") + " - " + b.format("MMMM D, YYYY"))
//    }), jQuery("#daterangepicker-custom span").html(moment().subtract("days", 29).format("MMMM D, YYYY") + " - " + moment().format("MMMM D, YYYY"))
//});

/* Dynamic Form Fields - Add & Remove Multiple fields */
jQuery(document).ready(function () {

    jQuery("#jform_contract-date0").daterangepicker();

    //@naresh action dynamic childs
    var next = 0;
    jQuery("#add-more").click(function (e) {
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;

        var newIn = ' \n\
            <div id="field' + next + '" name="field' + next + '">\n\
                <div class="row-fluid"> \n\
                    <div class="span6">\n\
                        <div class="row-fluid">\n\
                            <div class="span12">\n\
                                <div class="input-prepend input-group ">\n\
                                    <span class="add-on input-group-addon">\n\
                                        <i class="glyph-icon icon-calendar"></i>\n\
                                    </span>\n\
                                    <input type="text" name="jform[contract-date[' + next + ']]" id="jform_contract-date' + next + '" class="form-control required" required="required" aria-required="true" value="">\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="span6"> \n\
                        <div class="row-fluid">\n\
                            <div class="span12">\n\
                                <div class="form-group"> \n\
                                    <label class="span4 control-label" for="action_id">Action Id</label> \n\
                                    <div class="span5"> \n\
                                        <input id="action_id" name="action_id" type="text" placeholder="" class="form-control input-md"> \n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="row-fluid">\n\
                            <div class="span12">\n\
                                <div class="form-group"> \n\
                                    <label class="span4 control-label" for="action_name">Action Name</label> \n\
                                    <div class="span5"> \n\
                                        <input id="action_name" name="action_name" type="text" placeholder="" class="form-control input-md"> \n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
            </div>';

        var newInput = jQuery(newIn);

        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div><div id="field">';
        var removeButton = jQuery(removeBtn);
        jQuery(addto).after(newInput);
        jQuery(addRemove).after(removeButton);
        jQuery("#field" + next).attr('data-source', jQuery(addto).attr('data-source'));
        jQuery("#count").val(next);

        // call daterangepicker next
        jQuery("#jform_contract-date" + next).daterangepicker();

        jQuery('.remove-me').click(function (e) {
            e.preventDefault();
            var fieldNum = this.id.charAt(this.id.length - 1);
            var fieldID = "#field" + fieldNum;
            jQuery(this).remove();
            jQuery(fieldID).remove();
        });
    });

});

