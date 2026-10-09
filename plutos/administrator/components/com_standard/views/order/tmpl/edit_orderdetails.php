<?php
defined('_JEXEC') or die;
$columns = 10;
?>

<div class="row-fluid">
    <div class="span12 alert alert-success"><?php echo JText::_('COM_STANDARD_DETAIL'); ?></div>
</div>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped" id="orderList">
            <thead>
                <tr>
                    <th width="1%" class="nowrap center hidden-phone">
                        <?php echo JText::_('#'); ?>
                    </th>
                    <th>
                        <?php echo JText::_('COM_STANDARD_NAME'); ?>
                    </th>
                    <th class="hidden-phone">
                        <?php echo JText::_('COM_STANDARD_PRODUCT_QUANTITY'); ?>
                    </th>
                    <th class="hidden-phone">
                        <?php echo JText::_('COM_STANDARD_PRODUCT_FORM_PRICE_NET'); ?>
                    </th>

                    <th class="hidden-phone">
                        <?php echo JText::_('COM_STANDARD_PRODUCT_FORM_PRICE_BASEWITHTAX'); ?>
                    </th>
                    <th class="hidden-phone">
                        <?php echo JText::_('COM_STANDARD_PRODUCT_FORM_PRICE_GROSS'); ?>
                    </th>

                    <th class="hidden-phone">
                        <?php echo JText::_('COM_STANDARD_PRODUCT_TAX'); ?>
                    </th>
                    <th class="hidden-phone">
                        <?php echo JText::_('COM_STANDARD_TOTAL'); ?>
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="<?php echo $columns; ?>"> </td>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($this->item->orderitems as $key => $oitem) : ?>
                    <tr class="row<?php echo $key % 2; ?>">
                        <th width="1%" class="nowrap center hidden-phone">
                            <?php echo $key + 1; ?>
                        </th>
                        <td class="has-context">
                            <?php echo $oitem->order_item_name; ?>
                        </td>
                        <td class="hidden-phone">
                            <?php echo empty($oitem->product_quantity) ? " - " : $this->escape($oitem->product_quantity); ?>
                        </td>
                        <td class="hidden-phone">
                            <?php
                            if ($oitem->product_item_price > 0):
                                echo $this->currency->getFormatCurrency($oitem->product_item_price, $oitem->order_item_currency);
                            else:
                                echo ' - ';
                            endif;
                            ?>
                        </td>

                        <td class="hidden-phone">
                            <?php
                            if ($oitem->product_basePriceWithTax > 0):
                                echo $this->currency->getFormattedCurrency($oitem->product_basePriceWithTax);
                            else:
                                echo ' - ';
                            endif;
                            ?>
                        </td>

                        <td class="hidden-phone">
                            <?php
                            if ($oitem->product_final_price > 0):
                                echo $this->currency->getFormattedCurrency($oitem->product_final_price);
                            else:
                                echo ' - ';
                            endif;
                            ?>
                        </td>

                        <td class="hidden-phone">
                            <?php
                            if ($oitem->product_tax > 0):
                                echo $this->currency->getFormattedCurrency($oitem->product_tax);
                            else:
                                echo ' - ';
                            endif;
                            ?>
                        </td>
                        <td class="hidden-phone">
                            <?php
                            if ($oitem->product_subtotal_with_tax > 0):
                               echo $this->currency->getFormattedCurrency($oitem->product_subtotal_with_tax);
                            else:
                                echo ' - ';
                            endif;
                            ?>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>



