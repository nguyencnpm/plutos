
jQuery(function ($)
{
    // Checks all checkboxes the tree
    $('#treeCheckAll').click(function ()
    {
        $('.treeselect input').attr('checked', 'checked');
    });

    // Unchecks all checkboxes the tree
    $('#treeUncheckAll').click(function ()
    {
        $('.treeselect input').attr('checked', false);
    });
    
    // Checks all checkboxes the tree
    $('#treeCheckAllRoute').click(function ()
    {
        $('.treeselect.route input').attr('checked', 'checked');
    });

    // Unchecks all checkboxes the tree
    $('#treeUncheckAllRoute').click(function ()
    {
        $('.treeselect.route input').attr('checked', false);
    });
    
    // Checks all checkboxes the tree
    $('#treeCheckAllProduct').click(function ()
    {
        $('.treeselect.product input').attr('checked', 'checked');
    });

    // Unchecks all checkboxes the tree
    $('#treeUncheckAllProduct').click(function ()
    {
        $('.treeselect.product input').attr('checked', false);
    });
});
