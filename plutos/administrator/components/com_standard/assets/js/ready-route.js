jQuery(document).ready(function ()
{
    jQuery("#jform_catid").on("change", function () {
        var catid = jQuery("#jform_catid option:selected").val();
        //jQuery('select#jform_catid').prop('disabled', 'disabled');
        jQuery.ajax({
            url: "index.php?option=com_standard&task=ajax.ajaxRoute&id=" + catid,
            type: 'POST',
            success: function (data) {
                jQuery('#routes').empty().append(data);
            },
            error: function (e) {
                //called when there is an error
                console.log(e.message);
            }

        }).done(function (data) {
            jQuery('select#jform_catid').removeProp('disabled');
        });
    });
    jQuery("#jform_catid").trigger("change");
});

