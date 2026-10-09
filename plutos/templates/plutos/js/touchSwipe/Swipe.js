/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($)
{
    $(".touch-swipe").swipe({

        swipe: function (event, direction, distance, duration, fingerCount, fingerData) {

            if (direction == 'left')
                $(this).carousel('next');
            if (direction == 'right')
                $(this).carousel('prev');

        },
        allowPageScroll: "vertical"

    });
})(jQuery);