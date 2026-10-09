/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {
    $(document).ready(function () {
        /* --- use Masonry layouts with Bootstrap grid system --- */
        if ($('.masonry-grid-system').length) {
            $('.masonry-grid-system').on(masonryGridSystem());
        }
        /* --- /.use Masonry layouts with Bootstrap grid system --- */
    });

    function masonryGridSystem() {
        $('.grid').masonry({
            itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
            columnWidth: '.grid-sizer',
            percentPosition: true
        });
    }
    /*
    // masonry 
    var $grid = $('.gallery-wrapper').masonry({
        itemSelector: '.grid-item',
        columnWidth: '.grid-sizer',
        percentPosition: true,
        transitionDuration: 0,
    });

    $grid.imagesLoaded().progress(function () {
        $grid.masonry();
    });
    */
})(jQuery);


