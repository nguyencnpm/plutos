/*
 * Authors Binh Nguyen ---
 */
(function ($) {
    if (typeof Standard === "undefined") {
        var Standard = {};
    }

    $(document).ready(function () {
        confirmation();
        loadCartData();
        $('.cart-popover').on(cartPopover());
        updDynFormListeners();
        inputNumberChange();
        selectShipmentMethodChange();
    });

    function callback() {
        loadCartData();
        confirmation();// call fresh 
        updDynFormListeners();// call fresh 
        inputNumberChange();// call fresh 
        selectShipmentMethodChange();// call fresh 
    }

    function confirmation() {
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            container: 'body'
        });
    }

    /* ==== show on menu ==== */
    loadCartData = function ()
    {
        var sUrlRoot = document.getElementById("urlRoot").value;
        $.ajax({
            url: sUrlRoot + "index.php",
            method: "POST",
            data: {option: 'com_standard', task: 'cart.fetchCart'},
            dataType: "json",
            beforeSend: function () {
                // $(".loading-progress").addClass("not-allowed");
            },
            success: function (data)
            {
                $('.cart_details').html(data.cart_details);
                $('.total_price').text(data.total_price);
                $('.badge-quantity').text(data.total_item);
            }
        }).done(function () {
            // $(".loading-progress").removeClass("not-allowed");
        });
    }

    function cartPopover() {
        $('.cart-popover').popover({
            html: true,
            container: 'body',
            content: function () {
                return $('#cart-popover-content-wrapper').html();
            }
        });
    }
    /* ==== /. show on menu ==== */
    /* ==== Form Cart: View information ==== */
    function updDynFormListeners() {
        $('#checkoutForm').find('*[data-dynamic-update=1]').each(function (i, el) {
            var nodeName = el.nodeName;
            el = $(el);
            //console.log('updDynFormListeners ' + nodeName, el);
            switch (nodeName) {
                case 'BUTTON':
                    el[0].onchange = null;
                    el.off('click', updForm);
                    el.on('click', updForm);
                default:
                    el[0].onchange = null;
                    el.off('click', updFormS);
                    el.on('click', updFormS);
                    break;
            }
        });
    }

    function updForm() {
        var cartform = $("#checkoutForm");
        var carturl = document.getElementById("urlRoot").value; // cartform.attr('action');
        var urlSuf = 'tmpl=component';
        var carturlcmp = carturl;

        if (carturlcmp.indexOf(urlSuf) == -1) {
            var glue = '&';
            if (carturlcmp.indexOf('&') == -1 && carturlcmp.indexOf('?') == -1) {
                glue = '?';
            }
            carturlcmp += glue + urlSuf;
        }
        // alert-message
        var alertMessage = '.alert-message';
        // var isUpdatingContent = true;
        var containerSelector = '#cart-view';
        var container = $(containerSelector);
        cartform.submit(function () {

            $.ajax({
                type: "POST",
                url: carturlcmp,
                dataType: "html",
                data: cartform.serialize(), // serializes the form's elements.
                beforeSend: function () {
                    // $(".loading-progress").addClass("not-allowed");
                    startLoading();
                },
                success: function (datas) {
                    // --- Alert Message ---
                    var elAlertMessage = $(datas).find(alertMessage);
                    if (elAlertMessage.length) {
                        $('.message').html(elAlertMessage);
                        $('#confirmBoxMessage').modal("show");
                    }
                    // --- /.Alert Message ---
                    
                    var el = $(datas).find(containerSelector);
                    if (!el.length)
                        el = $(datas).filter(containerSelector);
                    if (el.length) {
                        container.html(el.html());
                        // call fresh 
                        Standard.minusPlusInInput();
                    }
                },
                error: function (datas) {
                    alert('Error updating cart');
                    // isUpdatingContent = false;
                    stopLoading();
                },
                statusCode: {
                    404: function () {
                        // isUpdatingContent = false;
                        stopLoading();
                        alert("page not found");
                    }
                }
            }).done(function () {
                // $(".loading-progress").removeClass("not-allowed");
                stopLoading();
                callback();
            });
            return false; // avoid to execute the actual submit of the form.
        });
    }

    function updFormS() {
        updForm();
        $("#checkoutForm").submit();
    }

    // ---- Quantity: input-number ----
    function inputNumberChange() {
        var name;
        $('.cart-view .input-number').change(function () { // Using in layouts cart view ".cart-view"
            name = $(this).attr('name');
            updFormS();
        });
    }
    // ---- /.Quantity: input-number ----
    // ---- Shipmentmethod: select Change ----

    function selectShipmentMethodChange() {
        var name;
        $('.shipment-method-change').change(function () { // Using in layouts cart view ".cart-view"
            name = $(this).attr('name');
            updFormS();
        });
    }
    // ---- /.Shipmentmethod: select Change ----
    /* ==== /. Form Cart: View information ==== */

    startLoading = function () {
        var msg = '<i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>';
        $('body').addClass('gpLoading');
        if (!$('div.gpLoadingDiv').length) {
            $('body').append('<div class="gpLoadingDiv"><div class="gpLoadingDivMsg text-info">' + msg + '</div></div>');
        }
    };

    stopLoading = function () {
        if ($('body').hasClass('gpLoading')) {
            $('body').removeClass('gpLoading');
            $('div.gpLoadingDiv').remove();
        }
    };
    
    
    /* ==== Minus Plus In Input ==== */
    Standard.minusPlusInInput = function () {
        // Buttons minus and plus in input
        $('.btn-number').click(function (e) {
            //e.preventDefault();

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
    };
    /* ==== /. Minus Plus In Input ==== */
})(jQuery);