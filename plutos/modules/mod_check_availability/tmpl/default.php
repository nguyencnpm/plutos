<?php
defined('_JEXEC') or die;
?>
<div class="check-availability<?php echo $class_sfx; ?>">
    <?php if (empty($sLayoutCurrency)):?>
        <?php require JModuleHelper::getLayoutPath('mod_check_availability', '_default'); ?>
    <?php else: ?>
        <?php require JModuleHelper::getLayoutPath('mod_check_availability', '_default_currencyreadonly'); ?>
    <?php endif; ?>
</div>