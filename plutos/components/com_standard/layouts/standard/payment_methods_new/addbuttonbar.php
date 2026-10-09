<?php
defined('JPATH_BASE') or die;
$params = $displayData['params'];
$countButton = $displayData['countButton'];

$classButton = (int) $countButton > 0 ? "col-" . number_format(12 / (int) $countButton, 0) : " ";

?>
<?php if ($countButton == 1): ?>

    <?php if ($params->get('show_cart')) : ?>
        <div class="input-group">
            <?php echo JLayoutHelper::render('standard.payment_methods.addtocart', ''); ?>
        </div>
    <?php endif; ?>

    <?php if ($params->get('show_reserve')) : ?>
        <div class="input-group">
            <?php echo JLayoutHelper::render('standard.payment_methods.reserve', ''); ?>
        </div>
    <?php endif; ?>

    <?php if ($params->get('show_order')) : ?>
        <div class="input-group">
            <?php echo JLayoutHelper::render('standard.payment_methods.order', ''); ?>
        </div>
    <?php endif; ?>

<?php elseif ($countButton > 1) : ?>
    <div class="row">
        <?php if ($params->get('show_cart')) : ?>
            <div class="<?php echo $classButton; ?>">
                <div class="input-group">
                    <?php echo JLayoutHelper::render('standard.payment_methods.addtocart', ''); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($params->get('show_reserve')) : ?>
            <div class="<?php echo $classButton; ?>">
                <div class="input-group">
                    <?php echo JLayoutHelper::render('standard.payment_methods.reserve', ''); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($params->get('show_order')) : ?>
            <div class="<?php echo $classButton; ?>">
                <div class="input-group">
                    <?php echo JLayoutHelper::render('standard.payment_methods.order', ''); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
