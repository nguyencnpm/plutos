/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {
    $(document).ready(function () {
        if ($('.treeview-icon').length) {
            $('.treeview-icon').on(treeviewToggleIcon());
        }

        if ($('.treeview').length) {
            $('.treeview').on(treeviewToggle());
        }
    });

    function treeviewToggleIcon() {
        $('.accordion-treeview').on('click', function (e) {
            var parent = this.parentNode;
            //var content = parent.children[1];
            if (!parent.classList.contains('is-active')) {
                $('.treeview').find(".is-active").removeClass('is-active');
                parent.classList.add('is-active');
            } else {
                parent.classList.remove('is-active');
            }
        });
        $('.collapse').on('shown.bs.collapse', function (e) {
            $(e.target).prev().find(".fa-caret-down").removeClass("fa-caret-down").addClass("fa-caret-up");
        }).on('hidden.bs.collapse', function (e) {
            $(e.target).prev().find(".fa-caret-up").removeClass("fa-caret-up").addClass("fa-caret-down");
        });

        $('.treeview').on('show.bs.collapse', function () {
            $('.treeview .show').collapse('hide');
        });
    }

    function treeviewToggle() {
        $('.accordion-treeview').on('click', function (e) {
            var parent = this.parentNode;
            //var content = parent.children[1];
            if (!parent.classList.contains('is-active')) {
                $('.treeview').find(".is-active").removeClass('is-active');
                parent.classList.add('is-active');
            } else {
                parent.classList.remove('is-active');
            }
        });

        $('.treeview').on('show.bs.collapse', function () {
            $('.treeview .show').collapse('hide');
        });
    }
})(jQuery);


