<?php
defined('_JEXEC') or die;
?>
<div class="filterproduct<?php echo $class_sfx; ?>">
    <?php if (empty($sLayoutCurrency)): ?>
        <?php require JModuleHelper::getLayoutPath('mod_filterproduct', '_default'); ?>
    <?php else: ?>
        <?php require JModuleHelper::getLayoutPath('mod_filterproduct', '_default_currencyreadonly'); ?>
    <?php endif; ?>
</div>