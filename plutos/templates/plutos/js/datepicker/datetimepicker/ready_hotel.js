/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {

    var sLocale = document.getElementById("sLocale").value;
    // var sTimeZone = document.getElementById("sTimeZone").value;
    var now = new Date(document.getElementById("today").value);
    // var dayOfWeek = parseInt($('#jform_route_id').children("option:selected").attr('data-dayOfWeek'));
    /*
     var year = now.getFullYear();
     var numberOfDaysInTheYear = 365;
     if ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0) {//Leap year ->February 29 Days
     numberOfDaysInTheYear = numberOfDaysInTheYear + 1;
     }
     var endDateRangYear = new Date(document.getElementById("today").value);
     endDateRangYear.setDate(now.getDate() + numberOfDaysInTheYear);
     */

    $(document).ready(function () {
        var weekdayCheckin = document.querySelector("#hotel #weekday-checkin");
        var weekdayChechout = document.querySelector("#hotel #weekday-chechout");
        // --- Check: In-Out Date ---
        $('#hotel #hotel_start_date').datetimepicker({
            date: now,
            ignoreReadonly: true,
            // timeZone: sTimeZone,
            locale: sLocale,
            minDate: now,
            format: 'DD-MM-YYYY'
        }).on('blur', function () {
            $('#hotel #hotel_end_date').focus();
        });

        $('#hotel #hotel_end_date').datetimepicker({
            ignoreReadonly: true,
            // timeZone: sTimeZone,
            locale: sLocale,
            useCurrent: false, //Important! See issue #1075
            format: 'DD-MM-YYYY'
        });
        $("#hotel #hotel_start_date").on("dp.change", function (e) {


            weekdayCheckin.innerHTML = WeekDay(e.date, sLocale);

            var newDate = moment(e.date).add(1, 'days');//.format('YYYY-MM-DD')
            $('#hotel #hotel_end_date').data("DateTimePicker").minDate(newDate);// e.date

            var selectedIn = $('#hotel #hotel_start_date').data("DateTimePicker").date();
            var selectedOut = $('#hotel #hotel_end_date').data("DateTimePicker").date();

            if (!selectedOut) {// fix case selectedOut == null
                var newDateOut = moment(e.date).add(1, 'days');//.format('YYYY-MM-DD')
                $('#hotel #hotel_end_date').data("DateTimePicker").date(newDateOut);

                weekdayChechout.innerHTML = WeekDay(newDateOut, sLocale);

            } else if (selectedIn.valueOf() >= selectedOut.valueOf()) {
                // var newDateOut = new Date(e.date);
                // newDateOut.setDate(newDateOut.getDate() + 1);
                var newDateOut = moment(e.date).add(1, 'days');//.format('YYYY-MM-DD')
                $('#hotel #hotel_end_date').data("DateTimePicker").date(newDateOut);

                weekdayChechout.innerHTML = WeekDay(newDateOut, sLocale);

            }
        });

        $("#hotel #hotel_end_date").on("dp.change", function (e) {
            weekdayChechout.innerHTML = WeekDay(e.date, sLocale);
        });

        $("#hotel #hotel_start_date").trigger("dp.change");
        // --- /.Check: In-Out Date ---
    });

    function WeekDay(date, sLocale) {
        moment.locale(sLocale);
        return  moment(date).format("dddd");
    }
})(jQuery);