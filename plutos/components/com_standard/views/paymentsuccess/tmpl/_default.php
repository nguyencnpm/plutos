<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="mx-auto using-max-width-sm page-payment success mb-3 rounded h-100">
    <div class="row h-100">
        <div class="d-flex flex-column col-12 h-100">
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <img class="" src="./images/payment/success.svg" alt="" itemprop="thumbnailUrl" data-original-title="" title="">
                </div> 
                <div class="col-12 text-center">
                    <h2 class="title"><?php echo array_key_exists("msg", $this->params) ? $this->params["msg"] : ""; ?> </h2>
                    <p>
                        Cảm ơn Quý khách đã sử dụng dịch vụ Plutos.<br />
                        Mã đơn hàng <b class="title"><?php echo array_key_exists("bookingCode", $this->params) ? $this->params["bookingCode"] : ""; ?></b><br/>
                        Quý đại lý vui lòng kiểm tra trạng thái Booking trên App Plutos mục "<b>Đơn hàng</b>"
                    </p>
                </div> 
            </div>
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <a href="<?php echo JURI::root(false); ?>" class="btn text-white using-btn-orange">
                        Quay về trang chủ           
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
