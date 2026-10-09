/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {
    if (typeof Standard === "undefined") {
        var Standard = {};
    }

    $("button.filterproduct").click(function () {
        $(".searchForm").submit();
    });

    if ($('.searchForm').length) {
        $('.searchForm').on(needsValidation());
    }

    if ($('#informationForm').length) {
        $('#informationForm').on(needsValidation());
    }

    if ($('#contactForm').length) {
        $('#contactForm').on(needsValidation());
    }

    if ($('.check-forms').length) {
        var keyForm = "";
        $('.check-forms').on('click', function (e) {
            keyForm = $(this).attr('data-keyform');
        });
        $('.check-forms').on(multiNeedsValidation(keyForm));
    }

    if ($('.subscribeForm').length) {
        var keyForm = "subscribeForm ";
        $('.subscribeForm').on(multiNeedsValidation(keyForm));
    }

    $(document).ready(function () {
        // --- mod_falang: dropdown filter flag ---
        var speed = 150;
        $('div.advanced-dropdown').hover(
                function () {
                    $(this).find('ul').filter(':not(:animated)').slideDown({duration: speed});
                },
                function () {
                    $(this).find('ul').filter(':not(:animated)').slideUp({duration: speed});
                }
        );
        // --- /.dropdown filter flag ---

        if ($('#logout').length) {
            $('#logout').on(user());
        }
        if ($('.navbar').length) {
            $('.navbar').on(navigationBar());
        }
        minusPlusInInput(); // fix load-more in case "minus Plus In Input"  infinitescrol: ajax/infinitescrol/jquery-ias.js

        autoPlayYouTubeModal();

        $(".currency").on("change", function () {
            $('button').prop('disabled', true);
            $('button').addClass("not-allowed");

            $('input').prop('disabled', true);
            $('input').addClass("not-allowed");

        });

        $("button.findproduct").click(function () {
            $(".searchForm").submit();
        });

        $("button.check-availability").click(function () {
            $(".searchForm").submit();
        });

        $(".page-loading-progress-click").click(function () {
            progress();
        });

        $(".page-loading-progress-change").on("change", function () {
            progress();
        });

        if ($('.loading-progress-circle').length) {
            $(".loading-progress-circle").click(function () {
                $(".loading-progress-circle").addClass("disabled");
                // var clickedName = this.name;
                var dataIds = $(this).data("ids");
                // $(".display-processing" + dataIds).removeClass("display-none");
            });
        }
    });

    function user() {
        // --- Submit form logout module  mod_agentlogin ---
        $("a#logout").click(function () {
            $("#logoutform").submit();
        });
    }

    function progress() {
        $(".progress").removeClass("d-none");
        $(".loading-progress-circle").addClass("disabled");
        $(".btn-custom-number").addClass("disabled");
        $(".progress div").each(function () {
            $('button').prop('disabled', true);
            $('button').addClass("not-allowed");
            $('input').prop('disabled', true);
            $('input').addClass("not-allowed");
            var display = $(this),
                    currentValue = parseInt(display.text()),
                    nextValue = parseInt($(this).attr("data-values")),
                    diff = nextValue - currentValue,
                    step = (0 < diff ? 1 : -1);
            if (nextValue === 0) {
                $(display).css("padding", "0");
            } else {
                $(display).css("color", "#fff").animate({
                    "width": nextValue + "%"
                }, "slow");
            }

            for (var i = 0; i < Math.abs(diff); ++i) {
                setTimeout(function () {
                    currentValue += step;
                    display.html(currentValue + "%");
                    setTimeout(function () {
                        $(".progress").css('display', 'd-none');
                    }, 20 * nextValue);
                }, 20 * i);
            }
        });
    }

    function navigationBar() {
        $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
            var $el = $(this);
            var $parent = $(this).offsetParent(".dropdown-menu");
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');

            $(this).parent("li").toggleClass('show');

            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                $('.dropdown-menu .show').removeClass("show");
            });

            if (!$parent.parent().hasClass('navbar-nav')) {
                // $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
            }

            return false;
        });
    }
    function needsValidation() {
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    var isReCaptcha = $("div").hasClass("g-recaptcha");
                    $('.g-recaptcha').removeClass('error');
                    switch (isReCaptcha) {
                        case true:
                            var captcha_response = grecaptcha.getResponse();
                            if ((form.checkValidity() === false) || (captcha_response.length === 0)) {
                                event.preventDefault();
                                event.stopPropagation();
                                if (captcha_response.length === 0) {
                                    $('.g-recaptcha').addClass('error');
                                }
                            } else {
                                processing();
                                $("button[type=submit]").addClass('disabled');
                            }
                            form.classList.add('was-validated');
                            break;

                        default:

                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            } else {
                                processing();
                                $("button[type=submit]").addClass('disabled');
                            }
                            form.classList.add('was-validated');
                            break;
                    }

                }, false);
            });
        }, false);
    }

    function multiNeedsValidation(keyForm) {
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName(keyForm + 'needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    var isReCaptcha = $("div").hasClass("g-recaptcha");
                    $('.g-recaptcha').removeClass('error');
                    switch (isReCaptcha) {
                        case true:
                            var captcha_response = grecaptcha.getResponse();
                            if ((form.checkValidity() === false) || (captcha_response.length === 0)) {
                                event.preventDefault();
                                event.stopPropagation();
                                if (captcha_response.length === 0) {
                                    $('.g-recaptcha').addClass('error');
                                }
                            } else {
                                processing();
                                $("button[type=submit]").addClass('disabled');
                            }
                            form.classList.add('was-validated');
                            break;

                        default:

                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            } else {
                                processing();
                                $("button[type=submit]").addClass('disabled');
                            }
                            form.classList.add('was-validated');
                            break;
                    }

                }, false);
            });
        }, false);
    }

    function processing() {
        if ($('.processing').length) {// general
            $(".processing").removeClass("display-none");
        }

        $(".credit").on('click blur submit keyup change', function () {
            $(".processing-credit").removeClass("display-none");
        });

        $(".reserve").on('click blur submit keyup change', function () {
            $(".processing-reserve").removeClass("display-none");
        });

        $(".online-payment").on('click blur submit keyup change', function () {
            $(".processing-online-payment").removeClass("display-none");
        });
    }

    function minusPlusInInput() {
        // Buttons minus and plus in input
        $('.btn-number').click(function (e) {
            e.preventDefault();

            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    var minValue = parseInt(input.attr('min'));
                    if (!minValue)
                        minValue = 1;
                    if (currentVal > minValue) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == minValue) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {
                    var maxValue = parseInt(input.attr('max'));
                    if (!maxValue)
                        maxValue = 9999999999999;
                    if (currentVal < maxValue) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == maxValue) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });
        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function () {

            var minValue = parseInt($(this).attr('min'));
            var maxValue = parseInt($(this).attr('max'));
            if (!minValue)
                minValue = 1;
            if (!maxValue)
                maxValue = 9999999999999;
            var valueCurrent = parseInt($(this).val());

            var name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }


        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                            (e.keyCode == 65 && e.ctrlKey === true) ||
                            // Allow: home, end, left, right
                                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
    }

    //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG
    function autoPlayYouTubeModal() {
        var trigger = $("body").find('[data-toggle="modal"]');
        trigger.click(function () {
            var theModal = $(this).data("target"),
                    videoSRC = $(this).attr("data-theVideo"),
                    videoSRCauto = videoSRC + "?autoplay=1";
            $(theModal + ' iframe').attr('src', videoSRCauto);
            $(theModal + ' button.close').click(function () {
                $(theModal + ' iframe').attr('src', videoSRC);
            });

            $(theModal).on('hide.bs.modal', function (e) {
                $(theModal + ' iframe').attr('src', videoSRC);
            });

        });
    }
})(jQuery);