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
        <?php echo $this->form->getControlGroup('shipmentmethod_id'); ?>
    </div>
</div>
<?php if (!empty($this->cart->cartPrices['shipmentName'])): ?>
    <div class="row">
        <div class="col-12 mb-3"><?php echo JText::_('COM_STANDARD_CART_SELECTED_SHIPMENT'); ?>:</div>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <?php echo $this->cart->cartPrices['shipmentName']; ?>
            <span>(<?php echo $this->currency->priceDisplay($this->cart->cartPrices['salesPriceShipment']); ?>)</span>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-12 mb-3">
            <?php echo $this->cart->cartData['shipmentName']; ?>
        </div>
    </div>
<?php endif; ?>
