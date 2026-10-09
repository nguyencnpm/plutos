<div style="font-family:Arial, Helvetica, sans-serif; background-color:#f3f3f3;">
    <table style="margin-top:20px; margin-left:auto; margin-right:auto; border:solid 0px #002060; max-width:580px; width: 100%;" border="0" cellpadding="0" cellspacing="0">
        <tr><td colspan="2" style="height:32px;"></td></tr>
        <tr valign="top">
            <td width="100%" colspan="2" valign="middle"  style="padding:10px; text-align:center;">
                {if $data["logo"] ne ""}
                    <img src="{$data["logo"]}"/>
                {/if}
            </td>
        </tr>
        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="padding:10px 16px;">
                <p style="color:#003c71; text-align:center; text-transform: uppercase; font-size: 23px;">Thông tin đăng ký tài khoản</p>
                <p style="color:#8a8585;">Ngày gửi thông tin đăng ký &nbsp; &nbsp; <span style="color: #3f3b3b;">{$data["today"]}</span></p> 
            </td>
        </tr>

        <tr><td colspan="2" style="height:5px;"></td></tr> 

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="color: #2f3f8c; padding: 16px;">Thông tin cá nhân</td>
        </tr>
        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["fullName"]}</td>
            <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["fullName"]}</b></td>
        </tr>

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="height:0.5px; padding: 0 10px;">
                <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
            </td>
        </tr> 

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["phone"]}</td>
            <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["phone"]}</b></td>
        </tr>

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="height:0.5px; padding: 0 10px;">
                <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
            </td>
        </tr> 

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["email"]}</td>
            <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["email"]}</b></td>
        </tr>

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="height:0.5px; padding: 0 10px;">
                <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
            </td>
        </tr> 

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["position"]}</td>
            <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["position"]}</b></td>
        </tr>

        {if $data["referrerphonenumber"]!=""}
            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td colspan="2" style="height:0.5px; padding: 0 10px;">
                    <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
                </td>
            </tr>
            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["referrerphonenumber"]}</td>
                <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["referrerphonenumber"]}</b></td>
            </tr>
        {/if}

        <tr><td colspan="2" style="height:5px;"></td></tr> 

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="color: #2f3f8c; padding: 16px; ">Thông tin doanh nghiệp</td>
        </tr>

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["companyName"]}</td>
            <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["companyName"]}</b></td>
        </tr>

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="height:0.5px; padding: 0 10px;">
                <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
            </td>
        </tr> 

        {if $data["rentalCode"]!=""}
            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["rentalCode"]}</td>
                <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["rentalCode"]}</b></td>
            </tr>

            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td colspan="2" style="height:0.5px; padding: 0 10px;">
                    <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
                </td>
            </tr> 

        {/if}
        {if $data["city"]!=""}
            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["city"]}</td>
                <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["city"]}</b></td>
            </tr>

            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td colspan="2" style="height:0.5px; padding: 0 10px;">
                    <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
                </td>
            </tr> 

        {/if}
        {if $data["nation"]!=""}
            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["nation"]}</td>
                <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["nation"]}</b></td>
            </tr>

            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td colspan="2" style="height:0.5px; padding: 0 10px;">
                    <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
                </td>
            </tr> 

        {/if}
        {if $data["address"]!=""}
            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["address"]}</td>
                <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["address"]}</b></td>
            </tr>

            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td colspan="2" style="height:0.5px; padding: 0 10px;">
                    <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
                </td>
            </tr> 

        {/if}
        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["typeOfBusiness"]}</td>
            <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["typeOfBusiness"]}</b></td>
        </tr>

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["revenueLevel"]}</td>
            <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["revenueLevel"]}</b></td>
        </tr>
        {if $data["fbWebsite"]!=""}
            <tr valign="top" style="background-color:#ffffff; width:100%;">
                <td width="40%" style="padding:10px 7px 10px 16px; color: #8a8585;">{$language["fbWebsite"]}</td>
                <td width="60%" style="padding:10px 16px 10px 7px; color: #3f3b3b;"><b>{$data["fbWebsite"]}</b></td>
            </tr>
        {/if}
        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="height:0.5px; padding: 0 10px;">
                <div style="height: 0.5px; background-color: #bdbdbd; opacity: 0.5;"></div>
            </td>
        </tr> 

        <tr valign="top" style="background-color:#ffffff; width:100%;">
            <td colspan="2" style="color: #f58220; padding:10px 16px 0 16px; ">
                Vui lòng cập nhật và hỗ trợ khách hàng sớm nhất có thể
            </td>
        </tr>

        <tr valign="top" style="background-color:#ffffff; width:100%; color: #3f3b3b;">
            <td colspan="2" style="padding: 10px 16px; ">
                <p style="color: #2f3f8c;">PLUTOS - Travel Agent’s Growth Platform</p>
                <p>
                    <b>Huế:</b> 15 Lý Thường Kiệt, Quận Phú Nhuận, Tp. Thừa Thiên Huế<br/>
                    <b>HN:</b> 46 Nguyễn Trường Tộ, Quận Ba Đình, Tp. Hà Nội<br/>
                    <b>HCM:</b> Tầng 8, Toà nhà EMM, 157 Pasteur, Quận 3, TP HCM<br/>
                    <b>Hotline:</b> 1900 2124<br/>
                    <b>Email:</b> info@plutos.vn
                </p>
            </td>
        </tr>

        <tr><td colspan="2" style="height:32px;"></td></tr>
    </table>
</div>