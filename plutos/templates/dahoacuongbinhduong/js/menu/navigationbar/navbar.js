/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 * navigationbar
 */
(function ($)
{
    $(document).ready(function () {
        $(".btn-group, .dropdown").hover(
                function () {
                    $('>.dropdown-menu', this).stop(true, true).fadeIn("fast");
                    $(this).addClass('show');
                },
                function () {
                    $('>.dropdown-menu', this).stop(true, true).fadeOut("fast");
                    $(this).removeClass('show');
                });
    });
})(jQuery);