/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */

(function ($) {
    if ($('.cDescription').length) {
        // Initialize scaling
        parallaxScrolling();
        // Update scaling on window resize
        // Uses jQuery throttle plugin to limit strain on the browser
        $(window).resize($.throttle(10, parallaxScrolling));
    }

    function parallaxScrolling() {
        var minHeight = 500;
        //var containerWidth = $('.cDescription').width();
        var containerCLeftHeight = $('.right .cLeft-description').height();
        var containerCRightHeight = $('.left .cRight-description').height();
        if (typeof (containerCLeftHeight) != 'undefined' && containerCLeftHeight != null) {
            if (minHeight < containerCLeftHeight) {
                $('.exception .parallax-scrolling.right').css({
                    'min-height': (containerCLeftHeight - minHeight) + minHeight + 120 + 'px'
                });

                $('.exception .parallax-scrolling.right .cDescription').css({
                    'min-height': (containerCLeftHeight - minHeight) + minHeight + 120 + 'px'
                });
            }
        }
        if (typeof (containerCRightHeight) != 'undefined' && containerCRightHeight != null) {
            if (minHeight < containerCRightHeight) {
                $('.exception .parallax-scrolling.left').css({
                    'min-height': (containerCRightHeight - minHeight) + minHeight + 120 + 'px'
                });

                $('.exception .parallax-scrolling.left .cDescription').css({
                    'min-height': (containerCRightHeight - minHeight) + minHeight + 120 + 'px'
                });
            }
        }
    }
})(jQuery);