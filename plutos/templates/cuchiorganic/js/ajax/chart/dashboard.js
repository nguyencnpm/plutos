/* 
 * Authors --- Custom by Binh Nguyen --- 
 * globals Chart:false, feather:false 
 */

(function ($) {
    'use strict';
    /* feather.replace()*/
    var sUrlRoot = "";
    var sTypeChart = "";
    var chartDrawingPosition = "";
    $(document).ready(function () {
        //test();
        if ($('#jsonInventory').length) {
            /* Graphs */
            sUrlRoot = document.getElementById("urlRoot").value;
            sTypeChart = document.getElementById("sTypeChart").value;
            chartDrawingPosition = document.getElementById('chartDrawingPosition').getContext('2d');
     
            // Initialize scaling
            getChart();
            // Update scaling on window resize
            // Uses jQuery throttle plugin to limit strain on the browser
            $(window).resize($.throttle(10, getChart)); /*$(window).resize(function () { viewChart(); });*/
        }

    });

    function getChart() {
        $.ajax({
            url: sUrlRoot + "index.php",
            method: "POST",
            data: {option: 'com_standard', task: 'inventory.infoChart', typechart: sTypeChart},
            dataType: "json",
            timeout: "20000",
            beforeSend: function () {

            },
            success: function (infoChart)
            {
                //console.log(infoChart);

            },
            error: function (infoChart) {
                //console.log(infoChart);

            }
        }).done(function (infoChart) {
            // console.log(infoChart);
            viewChart(infoChart);
        });
    }

    function viewChart(infoChart) {
        var myChart = new Chart(chartDrawingPosition, infoChart);/* eslint-disable-next-line no-unused-vars*/
    }
})(jQuery);
