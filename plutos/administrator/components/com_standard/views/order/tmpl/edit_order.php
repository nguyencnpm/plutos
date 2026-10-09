<?php
defined('_JEXEC') or die;
?>
<div class="row-fluid">
    <div class="span6">
        <div class="row-fluid">
            <div class="span12"><?php echo $this->form->getControlGroup('number'); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span12"><?php echo $this->form->getControlGroup('created'); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span12"><?php echo $this->form->getControlGroup('order_item_currency'); ?></div>
        </div>
    </div>
    <div class="span6">
        <div class="row-fluid">
            <div class="span12"><?php echo $this->form->getControlGroup('totalQuantity'); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span12"><?php echo $this->form->getControlGroup('salesPrice'); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span12"><?php echo $this->form->getControlGroup('billTaxAmount'); ?></div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12"><hr /></div>
</div>
<div class="row-fluid">
    <div class="span12">
        <span class=""><b><?php echo JText::_("COM_STANDARD_TOTAL"); ?>: </b></span>
        <span class="total-amount text-danger-price">
            <b>
                <?php
                if ($this->item->total > 0):
                    echo $this->currency->getFormatCurrency($this->item->total, $this->item->payment_currency_id);
                else:
                    echo " - ";
                endif;
                ?>
            </b>
        </span>
    </div>
</div>



