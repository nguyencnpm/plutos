<div style="font-family:Arial, Helvetica, sans-serif;">

    <table style="margin-top:20px;border:solid 0px #002060;" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td width="100%" colspan="2" style="padding:10px;">
                {if $data["logo"] ne ""}
                    <img style="max-width: 100%; text-align: center;" src="{$data["logo"]}"/><br/><br/>
                {/if}

                <span><b>{$language["dear"]} {$data["contact_fullName"]},</b></span><br/><br/>
                <span>{$language["content_head_title"]}</span><br/>
                <span>{$language["content_head"]}</span>
            </td>
        </tr>
        <tr valign="top">
            <td colspan="2" width="100%">&nbsp;</td>
        </tr>
        <tr valign="top">
            <td width="100%" colspan="2" style="background-color: #0052a7;color:#ffffff; padding:10px;">
                <span><b>{$language["order_request_title"]}</b></span>
            </td>
        </tr>

        <tr valign="top"><td width="100%" colspan="2" >&nbsp;</td></tr>

        <tr valign="top">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["contact_fullName"]}</td>
            <td width="60%" style="padding:5px 10px;"><b>{$data["contact_fullName"]}</b></td>
        </tr>
        <tr valign="top" style="background-color:#f0f0f0;">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["contact_gender"]}</td>
            <td width="60%" style="padding:5px 10px;"><b>{$data["gender"]}</b></td>
        </tr>
        {if $data['contact_birthday']!=""}
            <tr valign="top">
                <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["contact_birthday"]}</td>
                <td width="60%" style="padding:5px 10px;"><b>{$data["contact_birthday"]}</b></td>
            </tr>
        {/if}
        <tr valign="top" style="background-color:#f0f0f0;">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["contact_email"]}</td>
            <td width="60%" style="padding:5px 10px;"><b>{$data["contact_email"]}</b></td>
        </tr>
        <tr valign="top">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["contact_phone"]}</td>
            <td width="60%" style="padding:5px 10px;"><b>{$data["contact_phone"]}</b></td>
        </tr>
        {if $data['contact_birthday']!=""}
            <tr valign="top" style="background-color:#f0f0f0;">
                <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["contact_fax"]}</td>
                <td width="60%" style="padding:5px 10px;"><b>{$data["contact_fax"]}</b></td>
            </tr>
        {/if}
        <tr valign="top">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["category_product"]}</td>
            <td width="60%" style="padding:5px 10px;"><b>{$data["title"]}</b></td>
        </tr>

        <tr valign="top" style="background-color:#f0f0f0;">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["manufacturer"]}</td>
            <td width="60%" style="padding:5px 10px;">
                <b>
                    {if $data['manufacturer_title']!=""}
                        {$data["manufacturer_title"]}
                    {else}
                        -
                    {/if}
                </b>
            </td>
        </tr>

        {if $data['params']['show_price']>0}
            {if $data['order_price']>0}
                <tr valign="top">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["order_price"]}</td>
                    <td width="60%" style="padding:5px 10px;"><b>{$data["order_price_format"]}</b></td>
                </tr>
            {/if}

            {if $data['tax']>0}
                <tr valign="top" style="background-color:#f0f0f0;">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["tax"]}</td>
                    <td width="60%" style="padding:5px 10px;"><b>{$data["tax_format"]}</b></td>
                </tr>
            {/if}
        {/if}
        <tr valign="top">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["quantity"]}</td>
            <td width="60%" style="padding:5px 10px;"><b>{$data["quantity"]}</b></td>
        </tr>

        {if $data['payable_amount']>0 && $data['params']['show_price']>0}
            <tr valign="top" style="background-color:#f0f0f0;">
                <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["payable_amount"]}</td>
                <td width="60%" style="padding:5px 10px;"><b>{$data["payable_amount_format"]}</b></td>
            </tr>
        {/if}

        {if $data['message']!=""}
            <tr valign="top">
                <td colspan="2" style="padding:5px 10px;">{$language["message"]}</td>
            </tr>
            <tr valign="top">
                <td colspan="2" style="padding:10px;"><b>{$data["message"]}</b></td>
            </tr>
        {/if}

        <tr valign="top"><td width="100%" colspan="2" >&nbsp;</td></tr>

        <tr valign="top">
            <td width="100%" colspan="2" >
                <div style="width: 100%;">
                    <div style="width: 25%; background-color: #00aeef; height: 2px; float: left;"></div>
                    <div style="width: 75%; background-color:#8dc63f; height: 2px; float: right;"></div>
                </div>
            </td>
        </tr>
        <tr valign="top">
            <td width="100%" colspan="2" style="padding: 10px; text-align: left;">
                <span>{$language["address"]}</span><br /><br />
                <span>{$language["best_regards"]}</span><br /><br /><br />
                <span>{$language["team"]}</span>
            </td>
        </tr>

    </table>
</div>