<?php

defined('JPATH_BASE') or die;

$params = $displayData['params'];
$legacy = $displayData['legacy'];
?>
<?php if ($params->get('show_icons')) : ?>
    <?php if ($legacy) : ?>
        <?php echo JHtml::_('image', 'system/emailButton.png', JText::_('JGLOBAL_EMAIL'), null, true); ?>
    <?php else : ?>
        <span class="icon-envelope"></span>
        <?php echo JText::_('JGLOBAL_EMAIL'); ?>
    <?php endif; ?>
<?php else : ?>
    <?php echo JText::_('JGLOBAL_EMAIL'); ?>
<?php endif; ?>
