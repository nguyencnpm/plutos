<?php
defined('_JEXEC') or die;
?>

<div class="col-12">
    <div class="confirm-request-page text-center <?php echo $this->pageclass_sfx; ?>">
        <meta itemprop="inLanguage" content="<?php echo ($this->item['language'] === '*') ? JFactory::getConfig()->get('language') : $this->item['language']; ?>" />
        <?php if ($this->item['status']): ?>
            <i class="fa fa-check-circle-o thank-you-icon text-success" aria-hidden="true"></i>
        <?php else: ?>
            <i class="fa fa-exclamation-circle thank-you-icon text-danger" aria-hidden="true"></i>
        <?php endif; ?>
        <h1 class="thank-you-title mb-3"><?php echo $this->item['status'] == 1 ? JText::_('COM_STANDARD_CONTACT_THANKS_YOU') : "<span class=\"text-danger\">" . JText::_('COM_STANDARD_CONTACT_ERROR') . "</span>"; ?></h1>
        <div class="confirm mb-3">
            <?php echo $this->item['status'] == 1 ? JText::_('COM_STANDARD_CONTACT_TEAM') : JText::_(''); ?>
        </div>
    </div>
</div>

