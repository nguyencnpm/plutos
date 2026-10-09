<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_product_itineraries
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<?php if ($params->get('showtitle', 0)): ?>
    <<?php echo $params->get('header_tag'); ?> class="<?php echo $params->get('header_class', ''); ?>">
    <?php echo $titleContent; ?> <?php echo $params->get('title', ''); ?>
    </<?php echo $params->get('header_tag'); ?>>
<?php else: ?>
<?php endif; ?>
    
<div class="products<?php echo $class_sfx; ?>">
    <?php if (!empty(trim($params->get('subheading')))): ?>
        <div class="<?php echo $cSubheadingLayoutElement; ?> ">
            <div class="row">
                <div class="col-12">
                    <?php echo $params->get('subheading'); ?>
                    <?php if (!empty($sLinkType) && !empty($sUrlText)): ?>
                        <div class="clearfix"></div>
                        <div class="more mt-3">
                            <a class="btn learnmore radius-0 border-0 using-bg-yellow" href="" itemprop="url"> <?php echo $sUrlText; ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php require JModuleHelper::getLayoutPath('mod_product_itineraries', $params->get('layout', 'default') . '_items'); ?>
</div>

