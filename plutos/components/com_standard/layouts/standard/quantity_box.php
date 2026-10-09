<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;
$pkey = $displayData['pkey'];
$quantity = $displayData['quantity'];
?>
<div class="input-group">
    <input type="text" title="<?php echo JText::_('COM_STANDARD_CART_UPDATE') ?>" name="quantity[<?php echo $pkey; ?>]" class="form-control input-number quantity" value="<?php echo $quantity; ?>" min="1" max="1000000">
    <span class="btn-group-vertical">
        <button type="button" class="btn btn-number quantity-plus" data-type="plus" data-field="quantity[<?php echo $pkey; ?>]">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-number quantity-minus"  data-type="minus" data-field="quantity[<?php echo $pkey; ?>]">
            <i class="fa fa-minus" aria-hidden="true"></i>
        </button>
    </span>
</div>
