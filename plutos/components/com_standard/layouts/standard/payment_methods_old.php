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

$params = $displayData['params'];
$item = $displayData['item'];
?>

<div class="payment-method mb-2">
    <form action="<?php echo JRoute::_('index.php?option=com_standard&view=information'); ?>" method="post" name="informationForm" id="informationForm<?php echo $item->id; ?>">
        <?php if ($params->get('show_cart')) : ?>
            <p class="addtocart">
                <input type="submit" disabled="true" name="addtocart" class="btn btn-info" value="<?php echo JText::_('COM_STANDARD_ADD_TO_CART'); ?>">
            </p>
        <?php endif; ?>
        <?php if ($params->get('show_reserve')) : ?>
            <input type="submit" name="reserve" class="btn btn-info" value="<?php echo JText::_('COM_STANDARD_RESERVE'); ?>">
        <?php endif; ?>
        <?php if ($params->get('show_order')) : ?>
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6 col-lg-5">
                    <div class="input-group">
                        <input type="text" name="quantity[<?php echo $item->id; ?>]" class="form-control input-number" value="1" min="1" max="100">
                        <span class="btn-group-vertical">
                            <button type="button" class="btn btn-number quantity-plus" data-type="plus" data-field="quantity[<?php echo $item->id; ?>]">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-number quantity-minus"  data-type="minus" data-field="quantity[<?php echo $item->id; ?>]">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-7">
                    <div class="input-group">
                        <input type="submit" name="order" class="btn btn-info" value="<?php echo JText::_('COM_STANDARD_ORDER'); ?>">
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <input type='hidden' name='option' value='com_standard'/>
        <input type='hidden' name='view' value='information'/>
        <input type='hidden' name='id' value='<?php echo $item->id; ?>'/>
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
