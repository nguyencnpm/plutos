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
<div class="mx-auto using-max-width-sm page-payment failed mb-3 rounded">
    <div class="d-md-flex flex-md-row align-items-center text-center text-md-left">
        <div class="p-3">
            <img class="" src="./images/payment/fail.svg" alt="<?php echo array_key_exists("msg", $this->params) ? $this->params["msg"] : "Giao dịch thất bại"; ?>" itemprop="thumbnailUrl" data-original-title="">
        </div> 
        <div class="p-3">
            <?php if(array_key_exists("msg", $this->params)): ?>
                <?php if($this->params["msg"]=="{0}" || $this->params["msg"]=="{1}" || $this->params["msg"]=="{2}"):?>
                    <b>Liên kết không tồn tại!</b>
                <?php else:?>
                    <h2 class="title"><?php echo array_key_exists("msg", $this->params) ? $this->params["msg"] : "Giao dịch thất bại"; ?></h2>
                    <p>
                        Quý khách vui lòng kiểm tra với Ngân hàng phát hành thẻ hoặc liên hệ nhân viên phụ trách đơn hàng để được trợ giúp:
                        <b><?php echo array_key_exists("agentPhone", $this->params) ? $this->params["agentPhone"] : "-"; ?></b>
                    </p>
                <?php endif;?>
            <?php else: ?>
                <b>Liên kết không tồn tại!</b>
            <?php endif;?>
        </div> 
    </div>
</div>