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

//echo '<pre>';
//print_r($params);
//exit;
?>

<div class="rate">
    <?php if ($params->get('show_price')) : ?>
        <?php
        if (!class_exists('CalculationHelper')) {
            JLoader::register('CalculationHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/calculation.php');
        }
        ?>
        <?php if (!empty($item->price)): ?> 
            <i class="fa fa-credit-card icon" aria-hidden="true"></i>
            <span class="currency-price">
                <?php
                $calculator = CalculationHelper::getInstance();
                $productPrices = $calculator->getProductPrices($item);
                echo $calculator->_currencyDisplay->priceDisplay($productPrices['salesPrice']);
                /*
                  // echo $this->currency->priceDisplay($item->price, $item->currency_id);
                  // echo $this->currency->createPrice('salesPrice', '', $item->price, true);

                  //  $display_currency_id = (int) $params->get('currency_id');
                  //  $price = $this->currency->convertCurrency($item->price, $item->currency_id, $display_currency_id);
                  //  echo $this->currency->getFormattedCurrency($price);
                 */
                ?>
                <?php // echo "<span class=\"rate-unit\">" . JText::sprintf('COM_STANDARD_UNIT', "") . "</span>"; ?>
            </span><br />
            <?php if ($params->get('show_call_hotline')) : ?>
                <i class="fa fa-phone-square icon " aria-hidden="true"></i> 
                <span class="phone"><?php echo $params->get('hotline_phone'); ?></span><br />
            <?php endif; ?>
        <?php else: ?>
            <?php if ($params->get('show_call_price')) : ?>
                <i class="fa fa-credit-card" aria-hidden="true"></i>
                <span class="call_price"> <?php echo JText::_("COM_STANDARD_CALL_PRICE"); ?></span><br />
            <?php endif; ?>
            <?php if ($params->get('show_call_hotline')) : ?>
                <i class="fa fa-phone-square icon " aria-hidden="true"></i> 
                <span class="phone"><?php echo $params->get('hotline_phone'); ?></span><br />
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($params->get('show_call_price')) : ?>
             <i class="fa fa-credit-card" aria-hidden="true"></i>
                <span class="call_price"> <?php echo JText::_("COM_STANDARD_CALL_PRICE"); ?></span><br />
        <?php endif; ?>
        <?php if ($params->get('show_call_hotline')) : ?>
             <i class="fa fa-phone-square icon " aria-hidden="true"></i> 
                <span class="phone"><?php echo $params->get('hotline_phone'); ?></span><br />
        <?php endif; ?>
    <?php endif; ?>
</div>
