/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {
    $(document).ready(function () {
        $('#products').on(navigation());
    });
    function navigation() {
        var ias = $.ias({
            container: "#products",
            item: ".items-row",
            pagination: ".navigation",
            next: ".next-posts a"
        });

        ias.extension(new IASSpinnerExtension());
        ias.extension(new IASTriggerExtension({text: 'Xem thêm sản phẩm', offset: 0}));
        ias.extension(new IASNoneLeftExtension({text: ''}));
    }
})(jQuery);

