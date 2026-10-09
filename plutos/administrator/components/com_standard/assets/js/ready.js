jQuery(document).ready(function ()
{

    checkAll = function (checkbox, stub) {
        if (!checkbox.form) {
            return false;
        }
        stub = stub ? stub : 'jform_cb';

        var c = 0, i, e, n;
        var table = document.getElementById("checkList");
        var elements = table.getElementsByTagName("input");

        for (i = 0, n = elements.length; i < n; i++) {
            e = elements[ i ];

            if (e.type == "checkbox" && e.id.indexOf(stub) === 0) {
                e.checked = checkbox.checked;
                c += e.checked ? 1 : 0;
            }
        }

        if (checkbox.form.boxchecked) {
            checkbox.form.boxchecked.value = c;
        }

        return true;
    };

    isChecked = function (isitchecked, form) {

        if (typeof form === 'undefined') {
            form = document.getElementById('item-form');
        }

        form.boxchecked.value = isitchecked ? parseInt(form.boxchecked.value) + 1 : parseInt(form.boxchecked.value) - 1;

        // If we don't have a checkall-toggle, done.
        if (!form.elements[ 'checkall-toggle' ])
            return;

        // Toggle main toggle checkbox depending on checkbox selection
        var c = true,
                i, e, n;

        for (i = 0, n = form.elements.length; i < n; i++) {
            e = form.elements[ i ];

            if (e.type == 'checkbox' && e.name != 'checkall-toggle' && !e.checked) {
                c = false;
                break;
            }
        }

        form.elements[ 'checkall-toggle' ].checked = c;
    };
});

//function menuHide(val)
//{
//    if (val == 0 || val == '-')
//    {
//        jQuery('#menuselect-group').hide();
//    }
//    else
//    {
//        jQuery('#menuselect-group').show();
//    }
//}

