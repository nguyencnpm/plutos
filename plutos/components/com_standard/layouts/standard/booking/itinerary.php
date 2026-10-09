<?php
defined('JPATH_BASE') or die;
$params = $displayData['params'];
$item = $displayData['item'];
//echo '<pre>';
//print_r($item);
//exit;
$linktarget = "_blank";
$class = isset($displayData['class']) ? $displayData['class'] : " mb-3";
switch ((int) $item->paymenttype_id) {
    case 11:
        ?>
        <form target="<?php echo $linktarget; ?>" class="contactForm form-validate needs-validation form-vertical" novalidate action="<?php // echo JRoute::_('index.php?option=com_standard&view=confirm'); ?>" method="post">
            <button class="btn booknow using-btn-danger text-uppercase px-3 <?php echo $class; ?>" type="submit">
                <i class="processing display-none display-processing fa fa-spinner fa-pulse"></i>
                <?php echo JText::_('COM_STANDARD_BOOK_NOW'); ?>
            </button>

            <input type="hidden" name="jform[tour_id]" value="<?php echo $item->id; ?>" />
            <input type="hidden" name="option" value="com_standard" />
            <input type='hidden' name='task' value='selectproduct.getRedirectToItemRequest'/>
            <input type='hidden' name='check' value='itinerary'/>
            <?php echo JHtml::_('form.token'); ?>
        </form>
        <?php
        break;

    default:
        ?>
        <div class="scrolling smooth-scrolling">
            <a class="btn booknow radius-0 <?php echo $displayData['class']; ?>" href="<?php echo $displayData['link']; ?>" itemprop="url">
                <?php
                echo JText::_('COM_STANDARD_BOOK_NOW');
                ?>
            </a>
        </div>

        <?php
        break;
}
?>