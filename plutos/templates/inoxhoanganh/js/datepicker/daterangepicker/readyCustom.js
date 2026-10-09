/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {

    var moment = (typeof window !== 'undefined' && typeof window.moment !== 'undefined') ? window.moment : require('moment');

    var sLocale = document.getElementById("sLocale").value;
    var now = new Date(document.getElementById("today").value);

    if ($('#calendarStart').length) {
        var calendarStart = new Date(document.getElementById("calendarStart").value);
        var limitDaysBooking = parseInt(document.getElementById("limitDaysBooking").value);
        var dayOfWeek = parseInt($('#jform_route_id').children("option:selected").attr('data-dayOfWeek'));
        // --- ---
        if (calendarStart.valueOf() < now.valueOf()) {
            calendarStart = now;
        }
        var minDate = calendarStart;
        // --- ---
        var maxDateIn, maxDateOut;
        if (limitDaysBooking) {
            var numberOfDaysInTheYear = limitDaysBooking;// var numberOfDaysInTheYear = 730; // 2 year
            if (limitDaysBooking >= 365) {
                var year = now.getFullYear();
                if ((year % 4 == 0 && year % 100 != 0) || year % 400 == 0) {//Leap year ->February 29 Days
                    numberOfDaysInTheYear = numberOfDaysInTheYear + 1;
                }
            }
            var endDateRangYear = new Date(document.getElementById("today").value);
            endDateRangYear.setDate(now.getDate() + numberOfDaysInTheYear);
            maxDateIn = new Date(document.getElementById("today").value);
            maxDateOut = new Date(document.getElementById("today").value);
            maxDateIn.setDate(calendarStart.getDate() + numberOfDaysInTheYear);
            maxDateOut.setDate(calendarStart.getDate() + (numberOfDaysInTheYear + 1));
        } else {
            maxDateIn = false;
            maxDateOut = false;
        }
    }
    
    $(document).ready(function () {

        if ($('#jform_route_id').length) {
            //$('#jform_route_id').on(dateRangeDepartureDay());
            $('#jform_route_id').on(dateRangeDeparture());
        }
        $("#jform_route_id").change(function () {
            dayOfWeek = parseInt($(this).children("option:selected").attr('data-dayOfWeek'));
            var dfDate = calendarStart;
            if (calendarStart.getDay() !== dayOfWeek) {
                for (var index = 1; index < 7; index++) {
                    var nextDate = new Date(moment(calendarStart).add(index, 'days'));
                    if (nextDate.getDay() === dayOfWeek) {
                        dfDate = nextDate;
                        break;
                    }
                }
            }
            /*
             $('#jform_departure_day').data('daterangepicker').setStartDate(dfDate);
             $('#jform_departure_day').data('daterangepicker').setEndDate(dfDate);
             dateRangeDepartureDay();
             */
            $('#jform_departure_day_start').data('daterangepicker').setStartDate(dfDate);
            $('#jform_departure_day_start').data('daterangepicker').setEndDate(dfDate);
            dateRangeDeparture();
        });
    });


    function reformatDateString(sDate) {
        var d = sDate.split(/\D/);
        return d.reverse().join('-');
    }

    function dateRangeDeparture() {
        var checkin = $('#jform_departure_day_start').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            showDropdowns: true,
            linkedCalendars: false,
            minDate: minDate,
            maxDate: maxDateIn,
            locale: {
                locale: sLocale,
                format: 'DD/MM/YYYY'
            },
            isInvalidDate: function (d) {
                if (new Date(d).getDay() !== dayOfWeek) {
                    return 'off';
                }
                return false;
            }
        }).on('change.daterangepicker', function (ev) {
            // var newDate = moment(ev.date).add(1, 'days');//.format('YYYY-MM-DD ')
            // var newDate = moment(reformatDateString($('#jform_departure_day_start').val())).add(1, 'days');
            var newDate = moment(reformatDateString($('#jform_departure_day_start').val()));
            $('#jform_departure_day_end').data("daterangepicker").minDate = newDate;
            // --- ---
            $('#jform_departure_day_end').data("daterangepicker").setStartDate(newDate);
            $('#jform_departure_day_end').data("daterangepicker").setEndDate(newDate);
            // $('#jform_departure_day_end')[0].focus();
        });


        var checkout = $('#jform_departure_day_end').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            useCurrent: false,
            showDropdowns: true,
            linkedCalendars: false,
            minDate: minDate,
            maxDate: maxDateOut,
            locale: {
                locale: sLocale,
                format: 'DD/MM/YYYY'
            },
            isInvalidDate: function (d) {
                if (new Date(d).getDay() !== dayOfWeek) {
                    return 'off';
                }
                return false;
            }

        }).on('change.daterangepicker', function (ev) {});
    }
    /*
     function dateRangeDepartureDay() {
     $('#jform_departure_day').daterangepicker({
     autoApply: true,
     showDropdowns: true,
     linkedCalendars: false,
     minDate: minDate,
     maxDate: maxDateOut,
     locale: {
     locale: sLocale,
     format: 'DD/MM/YYYY'
     },
     isInvalidDate: function (d) {
     if (new Date(d).getDay() !== dayOfWeek) {
     return 'off';
     }
     return false;
     }
     });
     }
     */
})(jQuery);