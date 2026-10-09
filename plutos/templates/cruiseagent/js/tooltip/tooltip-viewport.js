(function ($) {
    'use strict'
    tooltip();
    
    function tooltip() {
        $('.tooltip-right').tooltip({
            placement: 'right',
            viewport: {
                selector: 'body',
                padding: 2
            }
        });
        $('.tooltip-bottom').tooltip({
            placement: 'bottom',
            viewport: {
                selector: 'body',
                padding: 2
            }
        });
        $('.tooltip-viewport-right').tooltip({
            placement: 'right',
            viewport: {
                selector: '.container-viewport',
                padding: 2
            }
        });
        $('.tooltip-viewport-bottom').tooltip({
            placement: 'bottom',
            viewport: {
                selector: '.container-viewport',
                padding: 2
            }
        });

        /* --- Binh Nguyen add --- */
        $('[data-toggle="tooltip"]').tooltip();
        $('.hasTooltip').tooltip({
            trigger: 'hover',
            animation: false,
            placement: getPlacement('.hasTooltip'),
            viewport: {selector: 'body', padding: 2},
            html: true
        });

        $('[data-toggle="popover"]').popover();
        $('.hasPopover').popover({
            trigger: 'hover',
            animation: false,
            placement: getPlacement('.hasPopover'),
            viewport: {selector: 'body', padding: 2},
            html: true
        });
    }
    
    function getPlacement(has) {
        var offset = $(has).offset(),
                height = $(document).outerHeight(),
                width = $(document).outerWidth(),
                vert = 0.5 * height - isOffsetTop(offset),
                vertPlacement = vert > 0 ? 'bottom' : 'top',
                horiz = 0.5 * width - isOffsetLeft(offset),
                horizPlacement = horiz > 0 ? 'right' : 'left',
                placement = horiz > vert ? horizPlacement : vertPlacement;
        return placement;
    }

    function isOffsetTop(offset) {
        if (!offset === 'undefined') {
            return offset.top;
        } else {
            return 0;
        }

    }

    function isOffsetLeft(offset) {
        if (!offset === 'undefined') {
            return offset.left;
        } else {
            return 0;
        }

    }
    /* --- /.Binh Nguyen add --- */

})(jQuery);