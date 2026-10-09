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
$taskRoute = "";

//echo '<pre>';
//print_r($this->cart->products);
//exit;
?>
<div class="mb-3 pt-3 pl-3 pr-3">
    <div class="row">
        <div class="col-12 mb-3">
            <a class="continue_link" href="<?php echo JURI::root(false); ?>"> 
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                <?php echo JText::_('COM_STANDARD_CONTINUE_SHOPPING'); ?>
            </a>
        </div>
    </div>
    <?php if (count($this->cart->products) > 0): ?>
        <div id="cart-view" class="cart-view">
            <form method="post" id="checkoutForm" name="checkoutForm" action="<?php echo JRoute::_('index.php?option=com_standard&view=information' . $taskRoute); ?>">
                <div class="info-order">
                    <?php
                    $i = 0;
                    $isBillTotal = true;
                    ?>
                    <?php foreach ($this->cart->products as $pkey => $prow): ?>
                        <?php
                        $prow->prices = array_merge($prow->prices, $this->cart->cartPrices[$pkey]);
                        if (empty($prow->prices['costPrice'])):
                            $isBillTotal = false;
                        endif;
                        ?>

                        <?php if ($i): //if $i >0: show line ?>
                            <div class="divider"></div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-3 mb-3">
                                <?php echo JLayoutHelper::render('standard.intro_image_order', $prow); ?>
                            </div>
                            <div class="col-9">
                                <h5 class="item-title cut-string-multiple-lines"><a href="<?php echo $prow->url; ?>"><?php echo $this->escape($prow->title); ?></a></h5>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <i class="fa fa-building-o" aria-hidden="true"></i> 
                                        <?php echo JText::_('COM_STANDARD_MANUFACTURER') . ': '; ?>
                                        <?php echo empty($prow->manufacturer_title) ? " - " : $prow->manufacturer_title; ?>
                                    </div>
                                </div>
                                <?php if ($this->params->get('show_price') && !empty($prow->prices['costPrice'])): ?>
                                    <div class="row item-basicprice">
                                        <div class="col-6 mb-3"><?php echo JText::_('ORDER_PRICE'); ?></div>
                                        <div class="col-6 mb-3 font-size-important Price">
                                            <?php
                                            if ($prow->prices['discountedPriceWithoutTax']) :
                                                echo $this->currency->createPrice('discountedPriceWithoutTax', '', $prow->prices, true, false, 1.0, false, true);
                                            else:
                                                echo $this->currency->createPrice('basePriceVariant', '', $prow->prices, false, true, 1.0, false, true);
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row align-items-center item-quantity">
                            <div class="col-4 mb-3"><?php echo JText::_('COM_STANDARD_QUANTITY'); ?>: </div>
                            <div class="col-4 mb-3 font-size-important">
                                <?php echo JLayoutHelper::render('standard.quantity_box', array('pkey' => $pkey, 'quantity' => $prow->quantity)); ?>
                            </div>
                            <div class="col-4 mb-3">
                                <button type="submit" class="btn btn-info btn-icon updatecart loading-progress" name="updatecart.<?php echo $pkey ?>" title="<?php echo JText::_('COM_STANDARD_CART_UPDATE') ?>" data-dynamic-update="1">
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>

                                <button type="submit" class="btn btn-danger btn-icon delete loading-progress" 
                                        name="delete.<?php echo $pkey ?>" 
                                        title="<?php echo JText::_('COM_STANDARD_CART_DELETE') ?>" 
                                        data-toggle="confirmation" 
                                        data-content="<?php echo JText::_("COM_STANDARD_ARE_YOU_SURE_DELETE"); ?>" 
                                        data-btn-ok-label="<?php echo JText::_("COM_STANDARD_YES"); ?>" data-btn-ok-class="btn-success"
                                        data-btn-cancel-label="<?php echo JText::_("COM_STANDARD_NO"); ?>" data-btn-cancel-class="btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <?php if ($this->params->get('show_price') && !empty($prow->prices['costPrice'])): ?>
                            <?php $r = 0; ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php if ($this->params->get('show_tax') && $prow->prices['taxAmountTt'] != 0): ?>
                                        <div class="row <?php echo 'row-' . $r % 2; ?>">
                                            <div class="col-6 mb-3"><?php echo JText::_('TAX'); ?></div>
                                            <div class="col-6 mb-3 font-size-important item-tax">
                                                <?php echo $this->currency->createPrice('taxAmount', '', $prow->prices, true, false, $prow->quantity, false, true); ?>
                                            </div>
                                        </div>
                                        <?php $r++; ?>
                                    <?php endif; ?>
                                    <div class="row <?php echo 'row-' . $r % 2; ?>">
                                        <div class="col-6 mb-3"><?php echo JText::_('PRODUCT_PRICES_TOTAL'); ?></div>
                                        <div class="col-6 mb-3 font-size-important item-total">
                                            <?php echo $this->currency->createPrice('salesPrice', '', $prow->prices, true, false, $prow->quantity); ?>
                                        </div>
                                    </div>
                                    <?php $r++; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php $i = 1; ?>
                    <?php endforeach; ?>

                    <?php if ($isBillTotal && $this->params->get('show_coupon')): ?>
                        <hr class="style3" />
                        <div class="row">
                            <div class="col-12">
                                <?php echo $this->loadTemplate('coupon'); ?>
                            </div>
                        </div>
                        <?php if (!empty($this->cart->cartData['couponCode'])) : ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    echo $this->cart->cartData['couponCode'];
                                    echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($this->params->get('show_shipment_method')): ?>
                        <hr class="style3" />
                        <?php echo $this->loadTemplate('shipment'); ?>
                    <?php endif; ?>
                    <?php if (count($this->cart->products) > 0): ?>
                        <hr class="" />
                        <div class="row row-0">
                            <div class="col-12 mb-3">
                                <?php echo JText::_("COM_STANDARD_CART_TOTAL"); ?>:
                            </div>
                            <div class="col-12 mb-3">
                                <span><?php echo JText::_('COM_STANDARD_QUANTITY'); ?>:</span>
                                <span><?php echo $this->cart->totalProduct; ?></span>
                            </div>
                        </div>
                        <?php if ($this->params->get('show_price') && $isBillTotal): ?>
                            <div class="row row-1">
                                <div class="col-12 mb-3 font-size-important bill-total">
                                    <span><?php echo JText::_('TOTAL_AMOUNT_PAYABLE'); ?>:</span>
                                    <span><?php echo $this->currency->createPrice('billTotal', '', $this->cart->cartPrices['billTotal'], true); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (count($this->cart->products) > 1): ?>
                        <hr class="" />
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-danger clear_cart loading-progress" 
                                        name="clear_cart" 
                                        title="<?php echo JText::_('COM_STANDARD_CART_CLEAR') ?>"
                                        data-toggle="confirmation" 
                                        data-content="<?php echo JText::_("COM_STANDARD_ARE_YOU_SURE_DELETE"); ?>" 
                                        data-btn-ok-label="<?php echo JText::_("COM_STANDARD_YES"); ?>" data-btn-ok-class="btn-success"
                                        data-btn-cancel-label="<?php echo JText::_("COM_STANDARD_NO"); ?>" data-btn-cancel-class="btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    <?php echo JText::_('COM_STANDARD_CART_CLEAR') ?>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <input type='hidden' name='task' value='cart.updatecart'/>
                <input type='hidden' name='option' value='com_standard'/>
                <input type='hidden' name='view' value='information'/>
            </form>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12 mb-3 text-warning text-center">
                <?php echo JText::_("COM_STANDARD_YOUR_CART_IS_EMPTY"); ?>
            </div>
        </div>
    <?php endif; ?>
</div>