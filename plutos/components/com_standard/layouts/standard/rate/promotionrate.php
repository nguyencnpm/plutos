<?php
defined('JPATH_BASE') or die;
$params = $displayData['params'];
$item = $displayData['item'];
?>
<div class="rate <?php echo $displayData['class']; ?>">
    <?php if ($params->get('show_price')) : ?>
        <?php
        if (!class_exists('CalculationHelper')) {
            JLoader::register('CalculationHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/calculation.php');
        }
        ?>
        <?php if (!empty($item->price)): ?> 
            <span class="rate-title font-weight-bold"><?php echo JText::_("COM_STANDARD_FROM_RATE"); ?> </span>
            <span class="price">
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
            </span>
            
            <?php if ($params->get('show_call_hotline')) : ?>
                <span><i class="fa fa-phone-square currency-price" aria-hidden="true"></i> <?php echo $params->get('hotline_phone'); ?></span>
            <?php endif; ?>
        <?php else: ?>
            <?php if ($params->get('show_call_price')) : ?>
                <p class="currency-price"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo JText::_("COM_STANDARD_CALL_PRICE"); ?></p>
            <?php endif; ?>
            <?php if ($params->get('show_call_hotline')) : ?>
                <p><i class="fa fa-phone-square currency-price" aria-hidden="true"></i> <?php echo $params->get('hotline_phone'); ?></p>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($params->get('show_call_price')) : ?>
            <p class="currency-price"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo JText::_("COM_STANDARD_CALL_PRICE"); ?></p>
        <?php endif; ?>
        <?php if ($params->get('show_call_hotline')) : ?>
            <p><i class="fa fa-phone-square currency-price" aria-hidden="true"></i> <?php echo $params->get('hotline_phone'); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>