<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_utilities
 */
defined('_JEXEC') or die;
?>
<?php // --Modal --   ?>
<div id="confirmBox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered gp-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
                <div class="col-12 pt-3">
                    <div class="row">
                        <div class="col-6 mb-4 text-left" data-dismiss="modal" aria-label="Close">
                            <a class="" href="">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                <?php echo JText::_('MOD_UTILITIES_CONTINUE_SHOPPING');?>
                            </a>
                        </div>
                        <div class="col-6 mb-4 text-right">
                            <a <?php echo $link != '' ? " href=\"{$link}\" " : " "; ?>  class="<?php echo!empty($show_popover) ? " cart-popover " : ""; ?>" data-placement="bottom" title="<?php JText::_("MOD_UTILITIES_SHOPPING_CART"); ?>">
                                <i class="fa fa-shopping-cart icon-shopping" aria-hidden="true"></i>
                                <?php echo JText::_("MOD_UTILITIES_SHOW_CART"); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <h5 class="item-title gp-item-title-space"><div class="product-info"></div></h5>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //-- /.Modal -- ?>

