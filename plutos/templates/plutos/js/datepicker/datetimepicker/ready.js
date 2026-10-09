/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {

    var sLocale = document.getElementById("sLocale").value;
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

        // --- Departure Day ---
        //if ($('#jform_route_id').length) {
            //$('#jform_route_id').on(dateDepartureDay());
        //}
        // --- /.Departure Day ---

        // --- date Birthday ---
        if ($('#jform_contact_birthday').length) {
            $('#jform_contact_birthday').on(dateBirthday());
        }
        // --- /.date Birthday ---
    });

    function dateDepartureDay() {
        var d = moment(now).format('YYYY-MM-DD');
        $('#jform_departure_day').datetimepicker({
            locale: sLocale,
            minDate: d,
            format: 'DD/MM/YYYY'
        });
    }

    function dateBirthday() {
        //var d = moment(now).format('YYYY-MM-DD');
        $('#jform_contact_birthday').datetimepicker({
            locale: sLocale,
            format: 'DD/MM/YYYY'
        });
    }
})(jQuery);


