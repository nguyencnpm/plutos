/* Copyright (c) 2016 Binh Nguyen */
(function ($) {
    var synchronize1 = $(".synchronize1");
    var synchronize2 = $(".synchronize2");
    var slidesPerPage = 6; //globaly define number of elements per page
    var synchronizeedSecondary = true;

    $(document).ready(function () {
        if ($('.owl-carousel-thumbnails').length) {
            $('.owl-carousel-thumbnails').on(carouselSmallThumbnails());

            synchronize2.on("click", ".owl-item", function (e) {
                e.preventDefault();
                var number = $(this).index();
                synchronize1.data('owl.carousel').to(number, 300, true);
            });
        }
    });

    function carouselSmallThumbnails() {
        synchronize1.owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: true,
            autoplay: false,
            dots: false,
            loop: true,
            responsiveRefreshRate: 200,
            navText: ["<i class='fa fa-angle-left fa-2x'></i>", "<i class='fa fa-angle-right fa-2x'></i>"]
        }).on('changed.owl.carousel', synchronizePosition);

        synchronize2
                .on('initialized.owl.carousel', function () {
                    synchronize2.find(".owl-item").eq(0).addClass("current");
                })
                .owlCarousel({
                    items: slidesPerPage,
                    dots: false,
                    nav: false,
                    smartSpeed: 200,
                    slideSpeed: 500,
                    slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                    responsiveRefreshRate: 100
                }).on('changed.owl.carousel', synchronizePosition2);
    }


    function synchronizePosition(el) {
        //if you set loop to false, you have to restore this next line
        //var current = el.item.index;

        //if you disable loop you have to comment this block
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);

        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }

        //end block

        synchronize2
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
        var onscreen = synchronize2.find('.owl-item.active').length - 1;
        var start = synchronize2.find('.owl-item.active').first().index();
        var end = synchronize2.find('.owl-item.active').last().index();

        if (current > end) {
            synchronize2.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
            synchronize2.data('owl.carousel').to(current - onscreen, 100, true);
        }
    }

    function synchronizePosition2(el) {
        if (synchronizeedSecondary) {
            var number = el.item.index;
            synchronize1.data('owl.carousel').to(number, 100, true);
        }
    }
})(jQuery);