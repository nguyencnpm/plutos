<div style="font-family:Arial, Helvetica, sans-serif; background-color:#f3f3f3;">
    <p style="height: 32px; width: 100%;"></p>
    <table style="margin-right:auto; margin-left:auto; border:solid 0px #002060; max-width:580px; width: 100%; background-color:#ffffff; color: #3f3b3b;" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td width="100%" style="padding-bottom:16px;">
                {if $data["logo"] ne ""}
                    <img style="width: 100%; height: auto;" src="{$data["logo"]}"/>
                {/if}
            </td>
        </tr>
        <tr valign="top">
            <td width="100%" style="padding:10px 16px;">
                <span>{$language["dear"]} {$data["fullName"]}, </span>
            </td>
        </tr>
        <tr valign="top">
            <td width="100%" style="padding:10px 16px;">
                Cảm ơn Quý đối tác đã gửi yêu cầu đăng ký tham gia nền tảng Plutos.vn. Để hoàn thành việc đăng ký, mời Quý đối tác thực hiện Xác thực thông tin đại lý bằng cách gửi chúng tôi các thông tin sau:
            </td>
        </tr>
        <tr valign="top">
            <td width="100%" style="padding:10px 16px;">
                1. CMND / Hộ chiếu của người đại diện doanh nghiệp (Ảnh mặt trước và sau)<br />
                2. Đăng ký kinh doanh công ty mới nhất<br />
                3. Trang bán hàng online của Quý đối tác nếu có(website, facebook, v.v.) <br />
            </td>
        </tr>
        <tr valign="top">
            <td width="100%" style="padding:10px 16px;">
                Nếu có bất kỳ thắc mắc nào, Quý đối tác có thể liên hệ với chúng tôi qua email support@plutos.vn, qua chức năng chat trên website hoặc hotline: 1900 2124
            </td>
        <tr valign="top">
            <td width="100%" style="padding:10px 16px;">
                Trân trọng,<br />
                <b>Đội ngũ Plutos</b>
            </td>
        </tr>

        <tr valign="top">
            <td width="100%" style="padding:10px 16px;">
                <div style="width: 80%; float: left;">
                    {if $data["footerLogo"] ne ""}
                        <img style="max-width: 100%; text-align: left;" src="{$data["footerLogo"]}"/>
                        {if $data["line"] ne ""}
                            <div style="height: 3px; clear: both; width: 100%;">
                                <img style="width: 100%;" src="{$data["line"]}"/>
                            </div>
                        {/if}
                    {/if}
                </div>
                <div style="width: 20%; float: right;"></div>
            </td>
        </tr>
        <tr valign="top">
            <td width="100%" style="padding:10px 16px; font-size: 12px;">
                <div style="width: 80%; float: left;">
                    <b>Công ty Cổ phần Plutos</b><br/>
                    Địa chỉ: 15 Lý Thường Kiệt, Phú Nhuận, Thừa Thiên Huế, Việt Nam.<br/>
                    T: +84 24 3926 3429 | F: +84 24 3926 3152 | E: info@plutos.vn | W: www.plutos.vn
                </div>
                <div style="width: 20%; float: right;">
                    {if $data["logoTMG"] ne ""}
                        <img style="max-width: 100%; float: right; padding-left: 10px;" src="{$data["logoTMG"]}"/>
                    {/if}
                </div>
            </td>
        </tr>

    </table>
    <p style="height: 32px; width: 100%;"></p>
</div>