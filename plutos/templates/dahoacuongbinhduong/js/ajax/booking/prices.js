/* 
 * Authors Binh Nguyen
 */
(function ($) {
    if (typeof Standard === "undefined") {
        var Standard = {};
    }
    Standard.stopSendtocart = false;

    $(document).ready(function () {
        //document.getElementsByClassName("product")[0].addEventListener("click", Standard.product($("form.product")))
        Standard.product($("form.product"));
    });

    Standard.callback = function () {
        var sPathCartFileJS = document.getElementById("pathCartFileJS").value;
        $.getScript(sPathCartFileJS, function () {
            loadCartData();
        });
    }

    Standard.product = function (carts) {
        carts.each(function () {
            var cart = $(this),
                    quantityInput = cart.find('input[name="quantity[]"]'),
                    plus = cart.find('.quantity-plus'),
                    minus = cart.find('.quantity-minus'),
                    select = cart.find('select:not(.no-gp-bind)'),
                    radio = cart.find('input:radio:not(.no-gp-bind)'),
                    product_id = cart.find('input[name="id[]"]').val(),
                    quantity = cart.find('.quantity-input');
            var Ste = parseInt(quantityInput.attr("step"));
            //Fallback for layouts lower than 2.0.18b
            if (isNaN(Ste)) {
                Ste = 1;
            }
            this.action = "#";
            /*
             plus
             .off('click', Standard.incrQuantity)
             .on('click', {cart: cart}, Standard.incrQuantity);
             
             minus
             .off('click', Standard.decrQuantity)
             .on('click', {cart: cart}, Standard.decrQuantity);
             
             select
             .off('change', Standard.eventsetproducttype)
             .on('change', {cart: cart, product_id: product_id}, Standard.eventsetproducttype);
             
             radio
             .off('change', Standard.eventsetproducttype)
             .on('change', {cart: cart, product_id: product_id}, Standard.eventsetproducttype);
             
             quantity
             .off('click blur submit', Standard.quantityErrorAlert)
             .on('click blur submit', Standard.quantityErrorAlert)
             .off('keyup', Standard.eventsetproducttype)
             .on('keyup', {cart: cart, product_id: product_id}, Standard.eventsetproducttype);
             */

            var addtocart = cart.find('button[name="addtocart"], input[name="addtocart"], a[name="addtocart"]');

            addtocart
                    .off('click submit', Standard.addtocart)
                    .on('click submit', {cart: cart}, Standard.addtocart);
        });
    }

    Standard.addtocart = function (e) {
        var targ;
        if (!e) {
            e = window.event;
        }
        e.preventDefault();
        /*
         if (!Standard.quantityErrorAlert(e)) {
         return false;
         }
         
         if (e.hasOwnProperty('stopSendtocart') && e.stopSendtocart == true) {
         return false;
         }
         */
        if (e.target) {
            targ = e.target;
        } else if (e.srcElement) {
            targ = e.srcElement;
        }
        if (targ.nodeType == 3) { // defeat Safari bug
            targ = targ.parentNode;
        }

        Standard.sendtocart(e.data.cart);

        return false;
    }

    Standard.sendtocart = function (form) {
        var addtocart_popup = 1;
        if (addtocart_popup == 1) {
            Standard.cartEffect(form);
        } else {
            // form.append('<input type="hidden" name="task" value="cart.add" />'); // isset in layouts 
            form.submit();
        }
    }

    Standard.cartEffect = function (form) {
        var sUrlRoot = document.getElementById("urlRoot").value;
        var datas = JSON.stringify(form.serializeArray());// serialize
        /*
         if (usefancy) {
         $.fancybox.showActivity();
         }
         */
        var sUrlRoot = document.getElementById("urlRoot").value;
        // , format: 'json'
        $.ajax({
            url: sUrlRoot + "index.php",
            method: "POST",
            data: {option: 'com_standard', task: 'cart.addJS', datas: datas},
            dataType: "json",
            timeout: "20000",
            beforeSend: function () {
                // $(".loading-progress").addClass("not-allowed");
            },
            success: function (data)
            {
                $('.product-info').text(data.productInfo);
            }
        }).done(function (data) {
            if(typeof(data.products[0].errorMsg)!='undefined' && data.products[0].errorMsg !=null){
                $('.product-info').html(data.productInfo + "<br /> <span class=\"text-danger\">" + data.products[0].errorMsg + "</span>");
            }
            // console.log(data.products[0].errorMsg);
            // $(".loading-progress").removeClass("not-allowed");
            $('#confirmBox').modal("show");
            Standard.callback();
        });
    }
})(jQuery);


