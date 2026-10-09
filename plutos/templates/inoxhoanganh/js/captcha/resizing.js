/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */

(function ($) {
    if ($('.g-recaptcha').length) {
        // Initialize scaling
        scaleCaptcha();

        // Update scaling on window resize
        // Uses jQuery throttle plugin to limit strain on the browser
        $(window).resize($.throttle(10, scaleCaptcha));
    }

    // Resize reCAPTCHA to fit a specific size. We're scaling using CSS3 transforms ||| captchaScale = reCaptchaContainerWidth / elementWidth

    function scaleCaptcha(elementWidth) {

        // Width of the reCAPTCHA element | 640 
        var reCaptchaWidth = 304;
        // Height of the reCAPTCHA element
        var reCaptchaHeight = 78;
        // Get the containing element's width
        var reCaptchaContainerWidth = parseFloat($('.g-recaptcha').width());
        // alert(reCaptchaContainerWidth);
        //var scale = (1 - (reCaptchaWidth - reCaptchaContainerWidth) * (0.05 / 15));
        //var captchaHeight = reCaptchaHeight * scale;

        // Calculate the scale
        var captchaScale = reCaptchaContainerWidth / reCaptchaWidth;
        // --- ---
        var captchaHeight = reCaptchaHeight * captchaScale;

        if (typeof (reCaptchaContainerWidth) !== 'undefined' && reCaptchaContainerWidth !== null) {
            // Apply the transformation
            $('.captcha--fluid .g-recaptcha').css({
                '-webkit-transform': 'scale(' + captchaScale + ')'
                , '-moz-transform': 'scale(' + captchaScale + ')'
                , '-ms-transform': 'scale(' + captchaScale + ')'
                , '-o-transform': 'scale(' + captchaScale + ')'
                , 'transform': 'scale(' + captchaScale + ')'

                , '-webkit-transform-origin': '0 0'
                , '-moz-transform-origin': '0 0'
                , '-ms-transform-origin': '0 0'
                , '-o-transform-origin': '0 0'
                , 'transform-origin': '0 0'
            });
            // --- button ---
            $('.captcha-submit--fluid').css({
                'margin-top': captchaHeight - reCaptchaHeight + 'px'
            });
        }

        // Only scale the reCAPTCHA if it won't fit inside the container
        if (typeof (reCaptchaContainerWidth) !== 'undefined' && reCaptchaContainerWidth !== null) {
            if (304 > reCaptchaContainerWidth && reCaptchaContainerWidth > 0 && reCaptchaContainerWidth!=304) {
                // Apply the transformation
                $('.captcha--center .g-recaptcha').css({
                    '-webkit-transform': 'scale(' + captchaScale + ')'
                    , '-moz-transform': 'scale(' + captchaScale + ')'
                    , '-ms-transform': 'scale(' + captchaScale + ')'
                    , '-o-transform': 'scale(' + captchaScale + ')'
                    , 'transform': 'scale(' + captchaScale + ')'

                    , '-webkit-transform-origin': '0 0'
                    , '-moz-transform-origin': '0 0'
                    , '-ms-transform-origin': '0 0'
                    , '-o-transform-origin': '0 0'
                    , 'transform-origin': '0 0'
                });

                // --- button ---
                $('.captcha-submit--center').css({
                    'margin-top': captchaHeight - reCaptchaHeight + 'px'
                });

            } else {
                $('.captcha--center .g-recaptcha').css({
                    'margin': '0 auto',
                    'width': '304px'
                });
            }
        }
    }
})(jQuery);
