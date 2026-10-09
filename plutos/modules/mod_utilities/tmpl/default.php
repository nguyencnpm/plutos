<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_utilities
 */
defined('_JEXEC') or die;
?>
<div class="<?php echo $class_sfx; ?>">
    <?php require JModuleHelper::getLayoutPath('mod_utilities', 'navbar'); ?>

    <?php if (!empty($show_popover)): ?>
        <div id="cart-popover-content-wrapper" class="cart-content">
            <span class="cart_details"></span>
            <div class="text-right">
                <a href="#" class="btn btn-primary" id="check_out_cart">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo JText::_('MOD_UTILITIES_CHECK_OUT'); ?> 
                </a>
                <a href="#" class="btn btn-default" id="clear_cart">
                    <i class="fa fa-trash" aria-hidden="true"></i> <?php echo JText::_('MOD_UTILITIES_CLEAR'); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>