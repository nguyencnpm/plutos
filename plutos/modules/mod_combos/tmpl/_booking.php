<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_product_itineraries
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$linktarget = "_blank";
switch ((int) $item->paymenttype_id) {
    case 11:
        ?>
        <form target="<?php echo $linktarget; ?>" class="contactForm form-validate needs-validation form-vertical" novalidate action="<?php // echo JRoute::_('index.php?option=com_standard&view=confirm');         ?>" method="post">
            <button class="btn booknow using-btn-yellow radius-0 text-uppercase px-3 mb-3" type="submit">
                <i class="processing display-none display-processing fa fa-spinner fa-pulse"></i>
                <?php
                if (empty($params->get('booknow_text'))):
                    echo JText::_('COM_STANDARD_BOOK_NOW');
                else:
                    echo $params->get('booknow_text');
                endif;
                ?>
            </button>

            <input type="hidden" name="jform[product_id]" value="<?php echo $item->id; ?>" />
            <input type="hidden" name="option" value="com_standard" />
            <input type='hidden' name='task' value='selectproduct.getRedirectToItemRequest'/>
            <input type='hidden' name='check' value='product'/>
            <?php echo JHtml::_('form.token'); ?>
        </form>
        <?php
        break;

    default:
        ?>
        <form target="" class="contactForm form-validate needs-validation form-vertical" novalidate action="<?php echo JRoute::_(StandardHelperRoute::getLinkMenuItemRoute("index.php?option=com_standard&view=contact")); ?>" method="post">
            <button class="btn booknow using-btn-yellow radius-0 text-uppercase px-3 mb-3" type="submit">
                <i class="processing display-none display-processing fa fa-spinner fa-pulse"></i>
                <?php
                if (empty($params->get('booknow_text'))):
                    echo JText::_('COM_STANDARD_BOOK_NOW');
                else:
                    echo $params->get('booknow_text');
                endif;
                ?>
            </button>
            <input type="hidden" name="jform[product_id]" value="<?php echo $item->id; ?>" />
            <input type="hidden" name="option" value="com_standard" />
            <input type='hidden' name='view' value='contact'/>
            <input type='hidden' name='check' value='product'/>
            <?php echo JHtml::_('form.token'); ?>
        </form>
        <?php
        break;
}
?>

