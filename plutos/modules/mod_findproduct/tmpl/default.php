<?php
defined('_JEXEC') or die;
?>
<div class="findproduct<?php echo $moduleclass_sfx; ?>">
    <?php if (empty($sLayoutCurrency)): ?>
        <?php require JModuleHelper::getLayoutPath('mod_findproduct', '_default'); ?>
    <?php else: ?>
        <?php require JModuleHelper::getLayoutPath('mod_findproduct', '_default_currencyreadonly'); ?>
    <?php endif; ?>
</div>