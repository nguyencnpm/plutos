<?php

defined('JPATH_BASE') or die;

JHtml::_('bootstrap.tooltip');

$params = $displayData['params'];
$legacy = $displayData['legacy'];
?>
<?php if ($params->get('show_icons')) : ?>
    <?php if ($legacy) : ?>
        <?php echo JHtml::_('image', 'system/new.png', JText::_('JNEW'), null, true); ?>
    <?php else : ?>
        <span class="icon-plus"></span>
        <?php echo JText::_('JNEW'); ?>
    <?php endif; ?>
<?php else : ?>
    <?php echo JText::_('JNEW') . '&#160;'; ?>
<?php endif; ?>
