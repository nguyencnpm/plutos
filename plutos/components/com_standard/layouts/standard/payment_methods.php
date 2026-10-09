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

$columns = $params->def('num_columns', 1);

$step = (int) isset($displayData['step']) ? $displayData['step'] : 1;

$classQuantity = "col-6 col-sm-6 col-md-6 col-lg-5 mb-2";
$classButton = "col-6 col-sm-6 col-md-6 col-lg-7 mb-2";
$countButton = 0;

switch ($step) {
    case 1:
        if ($columns > 1) {
            $classQuantity = "col-12 mb-2";
            $classButton = "col-12 mb-2";
        } else {
            $classQuantity = "col-12 col-md-6 col-lg-5 mb-2";
            $classButton = "col-12 col-md-6 col-lg-7 mb-2";
        }
        break;
    case 2:
        $classQuantity = "col-12 col-md-6 col-lg-5 mb-2";
        $classButton = "col-12 col-md-6 col-lg-7 mb-2";
        break;
    default :
        /*
          if ($params->get('show_cart'))
          $countButton++;

          if ($params->get('show_reserve'))
          $countButton++;

          if ($params->get('show_order', ''))
          $countButton++;
         */
        break;
}
?>

<div class="payment-method">
    <form class="product" action="<?php echo JRoute::_('index.php?option=com_standard&view=information'); ?>" method="post" name="informationForm" id="informationForm<?php echo $item->id; ?>">
        <div class="row">
            <div class="<?php echo $classQuantity; ?>">
                <div class="input-group">
                    <input type="text" name="quantity[<?php echo $item->id; ?>]" class="form-control input-number quantity-input" value="1" min="1" max="100">
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

            <div class="<?php echo $classButton; ?>">
                <?php
                if ($params->get('show_cart')) :
                    if ($columns > 1) :
                        echo $this->sublayout('addtocartcolumns', '');
                    else:
                        echo $this->sublayout('addtocart', '');
                    endif;

                endif;
                ?>
            </div>
        </div>

        <input type='hidden' name='option' value='com_standard'/>
        <input type='hidden' name='view' value='information'/>
        <input type='hidden' name='id' value='<?php echo $item->id; ?>'/>
        <input type="hidden" name="pname" value="<?php echo $item->title ?>"/>
        <input type="hidden" name="pid" value="<?php echo $item->id ?>"/>
        <?php echo "<input type=\"hidden\" name=\"task\" value=\"cart.add\"/>" ?>
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
