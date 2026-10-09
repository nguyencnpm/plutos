jQuery(document).ready(function ()
{
    jQuery("#jform_periodDate").daterangepicker({
        format: "YYYY-MM-DD"
    });
    
    jQuery("#filter_orderDate").daterangepicker({
        format: "YYYY-MM-DD"
    });
    
    jQuery("#filter_requestDate").daterangepicker({
        format: "YYYY-MM-DD"
    });
    
    jQuery("#filter_registrationDate").daterangepicker({
        format: "YYYY-MM-DD"
    });
});