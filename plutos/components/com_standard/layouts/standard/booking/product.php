<?php
defined('JPATH_BASE') or die;
$params = $displayData['params'];
$item = $displayData['item'];
$linktarget = "_blank";
$class = isset($displayData['class']) ? $displayData['class'] : " mb-3";
switch ((int) $item->paymenttype_id) {
    case 11:
        ?>
        <form target="<?php echo $linktarget; ?>" class="contactForm form-validate needs-validation form-vertical" novalidate action="<?php //echo JRoute::_('index.php?option=com_standard&view=confirm');     ?>" method="post">
            <button class="btn booknow using-btn-danger text-uppercase px-3 <?php echo $class; ?>" type="submit">
                <i class="processing display-none display-processing fa fa-spinner fa-pulse"></i>
                <?php echo JText::_('COM_STANDARD_BOOK_NOW'); ?>
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
            <button class="btn booknow using-btn-danger text-uppercase px-3 <?php echo $class; ?>" type="submit">
                <i class="processing display-none display-processing fa fa-spinner fa-pulse"></i>
                <?php echo JText::_('COM_STANDARD_BOOK_NOW'); ?>
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