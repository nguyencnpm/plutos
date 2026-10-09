/* Copyright (c) 2016 Binh Nguyen */
(function ($) {
    var classCarousel = ".carousel-multiple-items";
    if ($(classCarousel).length) {
        carouselMultipleItems();
        $(window).resize($.throttle(10, carouselMultipleItems));
    }

    function carouselMultipleItems() {
        /* --- fix temp --- */
        var Environment = findBootstrapEnvironment();
        var itemsPerSlide = 2;
        if (Environment === 'xl' || Environment === 'lg') {
            itemsPerSlide = 3;
        }
        /* --- /.fix temp --- */
        
        $(classCarousel).on('slide.bs.carousel', function (e) {
            var $e = $(e.relatedTarget);
            var idx = $e.index();
            // var itemsPerSlide = 2;
            var totalItems = $('.carousel-multiple-item').length;

            if (idx >= totalItems - (itemsPerSlide - 1)) {
                var it = itemsPerSlide - (totalItems - idx);
                for (var i = 0; i < it; i++) {
                    // append slides to end
                    if (e.direction == "left") {
                        $('.carousel-multiple-item').eq(i).appendTo(classCarousel + ' .carousel-inner');
                    } else {
                        $('.carousel-multiple-item').eq(0).appendTo(classCarousel + ' .carousel-inner');
                    }
                }
            }
        });
    }

    function findBootstrapEnvironment() {/* Bootstrap 4 */
        var envs = ['xs', 'sm', 'md', 'lg', 'xl'];

        var el = document.createElement('div');
        document.body.appendChild(el);

        var curEnv = envs.shift();

        for (var env of envs.reverse()) {
            el.classList.add(`d-${env}-none`);
            if (window.getComputedStyle(el).display === 'none') {
                curEnv = env;
                break;
            }
        }

        document.body.removeChild(el);
        return curEnv;
    }

})(jQuery);
