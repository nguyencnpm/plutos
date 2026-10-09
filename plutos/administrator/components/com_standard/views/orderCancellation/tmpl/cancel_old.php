<?php
/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JFactory::getDocument()->addScriptDeclaration("
        (function ($){
            $(document).ready(function (){
                $('#cancel-load').click(function() {
                    // Add version item id to URL
                    var url = $('#cancel-load').attr('data-url');
                    if (window.parent) {
                        window.parent.location = url;
                    }
		});
            });
        })(jQuery);
");
$task = "order.cancelReservation";
?>
<form action="<?php echo JRoute::_('index.php?option=com_standard&view=orders'); ?>" method="post" name="adminForm" id="adminForm">
    <?php foreach ($this->items as $key => $oitem) : ?>
    <?php $loadUrl = JRoute::_("index.php?option=com_standard&amp;task={$task}&amp;orderid={$oitem->order_id}&amp;cancelid={$oitem->id}"); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="">- <?php echo $oitem->order_item_name; ?></div>
                    <div class="">- <?php echo $oitem->route_name; ?>: <?php echo $oitem->number_days; ?> <?php echo $oitem->number_days > 1 ? JText::_('DAYS') : JText::_('DAY') ?></div>
                    <div class="">- <?php echo JText::_('COM_STANDARD_FIELD_DEPARTURE_DAY_LABEL'); ?>: <?php echo JHtml::_('date', $oitem->departure_day, JText::_('DATE_FORMAT_LC4')); ?></div>
                </div>
            </div>
            <hr />
            <div class="row-fluid">
                <div class="span12">
                    <button class="btn" type="button" onclick="window.parent.jQuery('#cancelModal_<?php echo $oitem->id; ?>').modal('hide');">
                        <i class="icon-cancel" aria-hidden="true"></i>
                        <?php echo JText::_('JNO'); ?>
                    </button>
                    &nbsp;
                    <button id="cancel-load" class="btn btn-danger" type="submit" 
                            data-url="<?php echo JRoute::_($loadUrl); ?>"
                            onclick="this.form.submit();<?php //echo "window.top.setTimeout('window.parent.jQuery(\'#cancelModal_{$oitem->id}\').modal(\'hide\')', 700);"; ?>">
                        <i class="icon-trash" aria-hidden="true"></i>
                        <?php echo JText::_('JYES'); ?>
                    </button>
                </div>
            </div>
        </div>

        <input type="hidden" name="jform[orderid]" value="<?php echo $oitem->order_id; ?>" />
        <input type="hidden" name="jform[cancelid]" value="<?php echo $oitem->id; ?>" />

        <input type="hidden" name="jform[product_id]" value="<?php echo $oitem->product_id; ?>" />
        <input type="hidden" name="jform[catid]" value="<?php echo $oitem->catid; ?>" />
        <input type="hidden" name="jform[allotment_date]" value="<?php echo $oitem->departure_day; ?>" />
        <input type="hidden" name="jform[quantity]" value="<?php echo $oitem->product_quantity; ?>" />
        <input type="hidden" name="jform[order_status]" value="<?php echo $oitem->order_status; ?>" />

    <?php endforeach; ?>
    <input type="hidden" name="option" value="com_standard" />
    <input type='hidden' name='view' value='orders'/>
    <input type="hidden" name="task" value="order.cancelReservation" />
    <input type="hidden" name="return" value="orders" />
    <?php echo JHtml::_('form.token'); ?>
</form>
