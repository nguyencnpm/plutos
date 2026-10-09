
(function ($)
{
    $(document).ready(function ()
    {
        $('#charterForm').submit(function (e)
        {
            e.preventDefault();
            var sUrlRoot = document.getElementById("urlRoot").value;

            var form = $(this);
            //show some response on the button
            $('button[type="submit"]', form).each(function ()
            {
//                var btn = $(this);
//                btn.prop('type', 'button');
//                btn.prop('orig_label', btn.text());
//                btn.text('Sending ...');
            });


            $.ajax({
                type: "POST",
                url: sUrlRoot + 'captcha/handler.php',
                data: form.serialize(),
                // dataType: 'json',
                success: function (data) {
                    after_form_submitted(data);
                },
                error: function (e) {
                    alert('error');
                    //called when there is an error
                    console.log(e.message);
                }

            }).done(function () {

            });

        });

        $('#captcha_reload').on('click', function (e)
        {
            e.preventDefault();
            d = new Date();
            var src = $("img#captcha_image").attr("src");
            src = src.split(/[?#]/)[0];

            $("img#captcha_image").attr("src", src + '?' + d.getTime());
        });
    });



    function after_form_submitted(data)
    {
        var oData = JSON.parse(data);
        if (oData.result == 'success')
        {
            $('form#charterForm').hide();
//            $('#success_message').show();
//            $('#error_message').hide();
        } else
        {
//            $('#error_message').append('<ul></ul>');
//
//            $.each(oData.errors, function (key, val)
//            {
//                $('#error_message ul').append('<li>' + key + ':' + val + '</li>');
//            });
//            $('#success_message').hide();
//            $('#error_message').show();
//
//            //reverse the response on the button
//            $('button[type="button"]', $form).each(function ()
//            {
//                var btn = $(this);
//                var label = btn.prop('orig_label');
//                if (label)
//                {
//                    btn.prop('type', 'submit');
//                    btn.text(label);
//                    btn.prop('orig_label', '');
//                }
//            });

        }//else
    }

})(jQuery);
