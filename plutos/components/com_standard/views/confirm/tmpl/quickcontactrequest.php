<?php
defined('_JEXEC') or die;
?>

<div class="col-12">
    <div class="confirm-request-page">
        <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
        <div class="clearfix">&nbsp;</div>
        <div class="confirm text-center">
            <?php echo JText::_('COM_STANDARD_QUICK_CONTACT_THANKS_YOU'); ?>
            <div class="clearfix"></div>
            <?php echo JText::_('COM_STANDARD_QUICK_CONTACT_TEAM'); ?>
        </div>
    </div>
</div>

