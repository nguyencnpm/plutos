/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {
    $(document).ready(function ()
    {
        if ($('.cDescription').length) {
            // Initialize scaling
            parallaxScrolling();
            // Update scaling on window resize
            // Uses jQuery throttle plugin to limit strain on the browser
            $(window).resize($.throttle(10, parallaxScrolling));
        }
    });

    function parallaxScrolling() {
        var minHeight = 0;
        //var containerWidth = $('.cDescription').width();
        var containerHeight = $('.cDescription').height();
        if (typeof (containerHeight) != 'undefined' && containerHeight != null) {
            if (minHeight < containerHeight) {
                $('.exception .parallax-scrolling.background-image').css({
                    'min-height': (containerHeight - minHeight) + minHeight + 'px'
                });
            }
        }

    }
})(jQuery);


