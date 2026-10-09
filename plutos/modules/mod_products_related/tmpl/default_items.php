<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_products_related
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$input = JFactory::getApplication()->input;
$option = $input->getCmd('option');
$view = $input->getCmd('view');
$id = $input->getInt('id');

$introcount = count($list);
$counter = 0;
?>

<?php foreach ($list as $i => $item) : ?>
    <?php
    if ($i < $numLeading) {
        $lead_items[] = $item;
    } elseif ($i >= $numLeading && $i < $numLeading + $numIntro) {
        $intro_items[] = $item;
    } elseif ($i < $numLeading + $numIntro + $numLinks) {
        $link_items[] = $item;
    } else {
        continue;
    }
    ?>
<?php endforeach; ?>

<?php if (isset($lead_items)): ?>
    <?php if (!empty($lead_items)) : ?>
        <div class="<?php echo $cLeadingLayoutElement; ?>">
            <div class="items-row row">
                <?php foreach ($lead_items as $key => $item) : ?>
                    <?php $rowcount = ((int) $key % (int) $columnLeading) + 1; ?>
                    <div class="d-flex col-12 col-lg-<?php echo round(12 / $columnLeading); ?>">
                        <div class="item d-flex flex-fill mb-4 column-<?php echo $rowcount; ?><?php echo $item->published == 0 ? ' system-unpublished' : null; ?>">
                            <?php require JModuleHelper::getLayoutPath('mod_products_related', '_item'); ?>
                        </div>
                        <?php // -- end item --   ?>
                    </div>
                    <?php // -- end col --   ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if (isset($intro_items)): ?>
    <?php if (!empty($intro_items)) : ?>
        <div class="<?php echo $cIntroLayoutElement; ?>">
            <div class="items-row row">
                <?php foreach ($intro_items as $key => $item) : ?>
                    <?php $rowcount = ((int) $key % (int) $columnIntro) + 1; ?>
                    <div class="d-flex col-12 col-lg-<?php echo round(12 / $columnIntro); ?>">
                        <div class="item d-flex flex-fill mb-4 column-<?php echo $rowcount; ?><?php echo $item->published == 0 ? ' system-unpublished' : null; ?>">
                            <?php require JModuleHelper::getLayoutPath('mod_products_related', '_item'); ?>
                        </div>
                        <?php // -- end item --   ?>
                    </div>
                    <?php // -- end col --   ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
