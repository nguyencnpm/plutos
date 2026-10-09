<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_utilities
 */
defined('_JEXEC') or die;

?>

<div class="navbar-cart navbar-collapse">
    <ul class="nav navbar-nav <?php echo $class_sfx; ?>">
        <li>
            <a <?php echo $link != '' ? " href=\"{$link}\" " : " "; ?>  class="nav-link <?php echo !empty($show_popover) ? " cart-popover " : ""; ?>" data-placement="bottom" title="<?php JText::_("MOD_UTILITIES_SHOPPING_CART"); ?>">
                <i class="fa fa-shopping-cart icon-shopping" aria-hidden="true"></i>
                <span class="bg-quantity-shopping-cart rounded-circle badge-quantity px-1"></span>
                <span class="total_price d-none d-sm-inline-block"></span>
            </a>
        </li>
    </ul>
</div>