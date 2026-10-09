/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {
    $(document).ready(function ()
    {
        if ($('#banner-scrolling').length) {
            $('#banner-scrolling').on(smoothScrolling('#banner-scrolling a', 20));
        }

        if ($('.scrolling').length) {
            $('.scrolling').on(smoothScrolling('.scrolling a', 10));
        }
        if ($('.load-page-location').length) {
            loadPageSmoothScrolling('.load-page-location', 0);
        }
    });

    function smoothScrolling(info, fix) {
        // Add smooth scrolling on all links inside the navbar
        $(info).on('click', function (event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;
                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - fix
                }, 800, function () {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    //window.location.hash = hash;
                });
            }  // End if
        });
    }

    function loadPageSmoothScrolling(info, fix) {
        $('html, body').animate({
            scrollTop: $(info).offset().top - fix
        }, 800);
        return false;
    }
})(jQuery);

