<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="row">
    <div class="col-12 mb-3">
        <div class="input-group">
            <input type="text" name="coupon_code" class="form-control coupon hasTooltip" title="<?php echo $this->coupon_text; ?>" placeholder="<?php echo $this->coupon_text; ?>">
            <div class="input-group-append">
                <button type="submit"  name="setcoupon" class="btn btn-secondary hasTooltip" title="<?php echo JText::_('COM_STANDARD_ADD_COUPON'); ?>" data-dynamic-update="1">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    <!--<div class="col-2 mb-3"> </div>-->
</div>
