/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {
    $(document).ready(function () {

        var current_fs, next_fs, previous_fs;

        $(".next").click(function () {

            str1 = "next1";
            str2 = "next2";

            if (!str1.localeCompare($(this).attr('id')) && validate1(0) === true) {
                val1 = true;
            } else {
                val1 = false;
            }

            if (!str2.localeCompare($(this).attr('id')) && validate2(0) === true) {
                progressDynFormListeners($(this), current_fs, next_fs, previous_fs);
            }

            if ((!str1.localeCompare($(this).attr('id')) && val1 === true)) {
                progressNext($(this), current_fs, next_fs, previous_fs);
            }
        });

        $(".prev").click(function () {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            $(current_fs).removeClass("show");
            $(previous_fs).addClass("show");

            $("#progressbar li").eq($(".card-step").index(next_fs)).removeClass("active");

            current_fs.animate({}, {
                step: function () {

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });

                    previous_fs.css({
                        'display': 'block'
                    });
                }
            });
        });

        $(".reset").click(function () {
            $(".card-step").first().addClass('show')
                    .siblings().removeClass('show');

            $("#progressbar li").first().addClass('active')
                    .siblings().removeClass('active');
        });

        function progressNext(pointerThis, current_fs, next_fs, previous_fs) {

            current_fs = pointerThis.parent().parent().parent();
            next_fs = pointerThis.parent().parent().parent().next();

            $(current_fs).removeClass("show");
            $(next_fs).addClass("show");

            $("#progressbar li").eq($(".card-step").index(next_fs)).addClass("active");

            current_fs.animate({}, {
                step: function () {

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });

                    next_fs.css({
                        'display': 'block'
                    });
                }
            });
        }
        function progressDynFormListeners(pointerThis, current_fs, next_fs, previous_fs) {

            var fullName = document.getElementById("jform_fullName");
            var phone = document.getElementById("jform_phone");
            var email = document.getElementById("jform_email");
            var position = document.getElementById("jform_position");
            var referrerphonenumber = document.getElementById("jform_referrerphonenumber");

            var companyName = document.getElementById("jform_companyName");
            var rentalCode = document.getElementById("jform_rentalCode");
            var city = document.getElementById("jform_city");
            var nation = document.getElementById("jform_nation");
            var address = document.getElementById("jform_address");
            var typeOfBusiness = document.getElementById("jform_typeOfBusiness");
            var revenueLevel = document.getElementById("jform_revenueLevel");
            var fbWebsite = document.getElementById("jform_fbWebsite");
            // ---- 
            var sUrlRoot = document.getElementById("urlRoot").value;

            $.ajax({
                url: sUrlRoot + "index.php",
                method: "POST",

                data: {
                    option: 'com_standard',
                    task: 'payment.registrationJS',

                    fullName: fullName.value,
                    phone: phone.value,
                    email: email.value,
                    position: position.value,
                    referrerphonenumber: referrerphonenumber.value,

                    companyName: companyName.value,
                    rentalCode: rentalCode.value,
                    city: city.value,
                    nation: nation.value,
                    address: address.value,
                    typeOfBusiness: typeOfBusiness.value,
                    revenueLevel: revenueLevel.value,
                    fbWebsite: fbWebsite.value
                },
                dataType: "json",
                // timeout: "20000",
                beforeSend: function () {
                    // $(".loading-progress").addClass("not-allowed");
                    startLoading();
                },
                success: function (response)
                {
                    if (response === 1) {
                        progressNext(pointerThis, current_fs, next_fs, previous_fs);
                    } else {
                        stopLoading();
                        // console.log(response);
                        alert("Đã có lỗi trong quá trình gởi email cho Quí khách. Xin vui lòng đăng ký lại hoặc chat với chúng tôi để hoàn tất quá trình đăng ký.");
                    }
                    // console.log(response);
                },
                error: function (response) {
                    alert('Error: System');
                    stopLoading();
                    // console.log(response);
                },
                statusCode: {
                    404: function () {
                        // isUpdatingContent = false;
                        alert("page not found");
                        stopLoading();
                    }
                }
            }).done(function (response) {
                stopLoading();
                // console.log(response);
            });
        }

        ValidateEmail = function (inputText)
        {
            var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (inputText.value.match(mailformat))
            {
                //alert("Valid email address!");
                // document.form1.text1.focus();
                return true;
            } else
            {
                // alert("You have entered an invalid email address!");
                // document.form1.text1.focus();
                return false;
            }
        }


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

    });

    validate1 = function (val) {
        vA1 = document.getElementById("jform_fullName");
        vA2 = document.getElementById("jform_phone");
        vA3 = document.getElementById("jform_email");
        vA4 = document.getElementById("jform_position");

        flagA1 = true;
        flagA2 = true;
        flagA3 = true;
        flagA4 = true;

        if (val >= 1 || val === 0) {
            if (vA1.value === "") {
                vA1.style.borderColor = "red";
                flagA1 = false;
            } else {
                vA1.style.borderColor = "#cccccc";
                flagA1 = true;
            }
        }

        if (val >= 2 || val === 0) {
            if (vA2.value === "") {
                vA2.style.borderColor = "red";
                flagA2 = false;
            } else {
                vA2.style.borderColor = "#cccccc";
                flagA2 = true;
            }
        }

        if (val >= 3 || val === 0) {
            if (vA3.value == "") {
                vA3.style.borderColor = "red";
                flagA3 = false;
            } else {
                if (ValidateEmail(vA3)) {
                    vA3.style.borderColor = "#cccccc";
                    flagA3 = true;
                } else {
                    vA3.style.borderColor = "red";
                    flagA3 = false;
                }

            }
        }

        if (val >= 4 || val === 0) {
            if (vA4.value === "") {
                vA4.style.borderColor = "red";
                flagA4 = false;
            } else {
                vA4.style.borderColor = "#cccccc";
                flagA4 = true;
            }
        }

        flagA = flagA1 && flagA2 && flagA3 && flagA4;

        return flagA;
    };

    validate2 = function (val) {
        vB1 = document.getElementById("jform_companyName");
        vB2 = document.getElementById("jform_rentalCode");
        vB3 = document.getElementById("jform_city");
        vB4 = document.getElementById("jform_nation");
        vB5 = document.getElementById("jform_address");
        vB6 = document.getElementById("jform_typeOfBusiness");
        vB7 = document.getElementById("jform_revenueLevel");

        flagB1 = true;
        flagB2 = true;
        flagB3 = true;
        flagB4 = true;
        flagB5 = true;
        flagB6 = true;
        flagB7 = true;
        if (val >= 1 || val === 0) {
            if (vB1.value === "") {
                vB1.style.borderColor = "red";
                flagB1 = false;
            } else {
                vB1.style.borderColor = "#cccccc";
                flagB1 = true;
            }
        }
        /*
         if (val >= 2 || val == 0) {
         if (v2.value == "") {
         v2.style.borderColor = "red";
         flag2 = false;
         } else {
         v2.style.borderColor = "#cccccc";
         flag2 = true;
         }
         }
         
         if (val >= 2 || val == 0) {
         if (v3.value == "") {
         v3.style.borderColor = "red";
         flag3 = false;
         } else {
         v3.style.borderColor = "#cccccc";
         flag3 = true;
         }
         }
         
         if (val >= 2 || val == 0) {
         if (v4.value == "") {
         v4.style.borderColor = "red";
         flag4 = false;
         } else {
         v4.style.borderColor = "#cccccc";
         flag4 = true;
         }
         }
         
         if (val >= 2 || val == 0) {
         if (v5.value == "") {
         v5.style.borderColor = "red";
         flag5 = false;
         } else {
         v5.style.borderColor = "#cccccc";
         flag5 = true;
         }
         }
         */
        if (val >= 2 || val === 0) {
            if (vB6.value === "") {
                vB6.style.borderColor = "red";
                flagB6 = false;
            } else {
                vB6.style.borderColor = "#cccccc";
                flagB6 = true;
            }
        }

        if (val >= 2 || val === 0) {
            if (vB7.value === "") {
                vB7.style.borderColor = "red";
                flagB7 = false;
            } else {
                vB7.style.borderColor = "#cccccc";
                flagB7 = true;
            }
        }

        //    flag = flag1 && flag2 && flag3 && flag4 && flag5 && flag6;

        flagB = flagB1 && flagB6 && flagB7;
        return flagB;
    };

})(jQuery);
