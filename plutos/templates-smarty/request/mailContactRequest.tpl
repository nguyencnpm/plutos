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
            <td width="100%" colspan="2" style="background-color: #303293;color:#ffffff; padding:10px;">
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

        <tr valign="top">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["contact_email"]}</td>
            <td width="60%" style="padding:5px 10px;"><b>{$data["contact_email"]}</b></td>
        </tr>
        <tr valign="top" style="background-color:#f0f0f0;">
            <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["contact_phone"]}</td>
            <td width="60%" style="padding:5px 10px;"><b>{$data["contact_phone"]}</b></td>
        </tr>

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
                    <div style="width: 25%; background-color: #303293; height: 2px; float: left;"></div>
                    <div style="width: 75%; background-color:#ed1c24; height: 2px; float: right;"></div>
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