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
            <td width="100%" colspan="2" style="border-top:solid #303293 2px;color:#ffffff; padding:0px;">
                <div style="background-color: #303293; padding:10px; float: left; width: auto;">
                    <b>{$language["contact_information_title"]}</b>
                </div>
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
            <td width="100%" colspan="2" style="border-top:solid #303293 2px;color:#ffffff; padding:0px;">
                <div style="background-color: #303293; padding:10px; float: left; width: auto;">
                    <b>{$language["order_request_title"]}</b>
                </div>
            </td>
        </tr>
        <tr valign="top"><td width="100%" colspan="2" >&nbsp;</td></tr>

        {foreach $data['cart']->products as $cart} 
            <tr valign="top" style="{if $cart@key mod 2}background-color:#f0f0f0;{/if}">
                <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["category_product"]}:</td>
                <td width="60%" style="padding:5px 10px;"><b>{$cart->title}</b></td>
            </tr>

            <tr valign="top" style="{if $cart@key mod 2}background-color:#f0f0f0;{/if}">
                <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["manufacturer"]}:</td>
                <td width="60%" style="padding:5px 10px;">
                    <b>
                        {if $cart->manufacturer_title!=""}
                            {$cart->manufacturer_title}
                        {else}
                            -
                        {/if}
                    </b>
                </td>
            </tr>
            {if $cart->prices["costPrice"]>0 && $data['params']['show_price']>0}
                <tr valign="top" style="{if $cart@key mod 2}background-color:#f0f0f0;{/if}">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["order_price"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #dc3545;">
                        <b>
                            {if $cart->prices["discountedPriceWithoutTax"]}
                                {$cart->prices["discountedPriceWithoutTaxFormatted"]}
                            {else}
                                {$cart->prices["basePriceVariantFormatted"]}
                            {/if}
                        </b>
                    </td>
                </tr>

                <tr valign="top" style="{if $cart@key mod 2}background-color:#f0f0f0;{/if}">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["quantity"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #28a745;">
                        <b>{$cart->quantity}</b>
                    </td>
                </tr>

                <tr valign="top" style="{if $cart@key mod 2}background-color:#f0f0f0;{/if}">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["tax"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #dc3545;">
                        <b>
                            {if $cart->prices["taxAmountTt"]>0}
                                {$cart->prices["taxAmountFormattedTt"]}
                            {else}
                                -
                            {/if}
                        </b>
                    </td>
                </tr>

                <tr valign="top" style="{if $cart@key mod 2}background-color:#f0f0f0;{/if}">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["product_prices_total"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #dc3545;"><b>{$cart->prices["salesPriceFormattedTt"]}</b></td>
                </tr>
            {else}
                <tr valign="top" style="{if $cart@key mod 2}background-color:#f0f0f0;{/if}">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["quantity"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #28a745;"><b>{$cart->quantity}</b></td>
                </tr>
                {$data['params']['show_price']=0}
            {/if}
        {/foreach} 

        {if $data['cart']->couponCode!=""}
            <tr valign="top">
                <td colspan="2" ><div style="border-bottom:dotted; color:#303293; height: 1px;"></div></td>
            </tr>
            <tr valign="top" style="background-color:#dff0d8;">
                <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["coupon_code"]}:</td>
                <td width="60%" style="padding:5px 10px; color: #31708f;"><b>{$data['cart']->couponCode}</b></td>
            </tr>
            {if $data['params']['show_price']>0 && ($data['cart']->cartPrices['couponValue']*-1)>0}
                <tr valign="top" style="background-color:#dff0d8;">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["sales_price_coupon"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #dc3545;"><b>{$data['cart']->cartPrices["couponValueFormatted"]}</b></td>
                </tr>
            {/if}
        {/if}

        {if $data['cart']->cartPrices['shipmentName']!=""}
            <tr valign="top">
                <td colspan="2" ><div style="border-bottom:dotted; color:#303293; height: 1px;"></div></td>
            </tr>
            <tr valign="top" style="background-color:#f2dede;">
                <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["selected_shipment"]}:</td>
                <td width="60%" style="padding:5px 10px; color: #31708f;"><b>{$data['cart']->cartPrices["shipmentName"]}</b></td>
            </tr>
            {if $data['cart']->cartPrices['salesPriceShipment']>0}
                <tr valign="top" style="background-color:#f2dede;">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["shipment_cost"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #dc3545;"><b>{$data['cart']->cartPrices["salesPriceShipmentFormatted"]}</b></td>
                </tr>
            {/if}
        {/if}

        {if $data['params']['show_price']>0 && $data['cart']->cartPrices['basePrice']>0}

            <tr valign="top">
                <td colspan="2" ><div style="background-color: #303293; height: 1px; margin-top: 15px;" ></div></td>
            </tr>

            <tr valign="top">
                <td colspan="2" style="padding: 5px 10px;"><b>{$language["bill_total"]}:</b></td>
            </tr>

            {if $data['cart']->cartPrices['taxAmount']>0}
                <tr valign="top" style="background-color:#fcf8e3;">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["tax"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #dc3545;"><b>{$data['billTaxAmountFormatted']}</b></td>
                </tr>
            {/if}

            {if $data['cart']->cartPrices['billTotal']>0 && $data['params']['show_price']>0}
                <tr valign="top" style="background-color:#d9edf7;">
                    <td width="40%" style="padding-left:10px; padding-bottom: 5px; padding-top: 5px;">{$language["total_amount_payable"]}:</td>
                    <td width="60%" style="padding:5px 10px; color: #dc3545;"><b>{$data['payableAmountFormatted']}</b></td>
                </tr>
            {/if}

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