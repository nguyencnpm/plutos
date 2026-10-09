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
        <?php if (!empty($item->price) && ((float) $item->price) > 0): ?> 
            <?php
            $iCurrencyIdDisplayDefault = (int) $params->get('currency_id');
            $iCurrencyIdDisplayForeign = (int) $params->get('currency_id_foreign');
            ?>
            <span class="rate-title"><?php echo JText::_("COM_STANDARD_FROM_RATE"); ?> </span>
            <span class="price">
                <?php
                // Currency: Display Default (VN)
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
            <span class="rate-unit"><?php echo JText::sprintf('COM_STANDARD_UNIT', (int) $item->adult > 1 ? $item->adult : "", (int) $item->adult > 1 ? "s" : ""); ?></span>
            <?php if (trim(JFactory::getLanguage()->getTag()) === 'en-GB'): ?>
                <?php
                // Currency: Display Foreign
                $salesPriceForeign = $calculator->_currencyDisplay->convertCurrency($productPrices['salesPrice'], $iCurrencyIdDisplayDefault, $iCurrencyIdDisplayForeign, TRUE, TRUE);
                ?>
                <span class="price-foreign">(<?php echo $calculator->_currencyDisplay->getFormattedCurrencyForeign($salesPriceForeign); ?>)</span>
            <?php endif; ?>
                
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