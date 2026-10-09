<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_itineraries_itinerary_types
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="itinerary-types-module<?php echo $class_sfx; ?>">
    <?php if (!empty(trim($params->get('subheading')))): ?>
        <div class="<?php echo $cSubheadingLayoutElement; ?> ">
            <div class="row">
                <div class="col-12">
                    <?php echo $params->get('subheading'); ?>
                    <?php if (!empty($sLinkType) && !empty($oLink->url_text) && $oLink->link_position == 'top'): ?>
                        <div class="clearfix"></div>
                        <div class="more mt-3">
                            <a class="btn learnmore radius-0 border-0 using-bg-yellow" href="<?php echo $sLinkType; ?>" target="<?php echo $oLink->link_target; ?>" itemprop="url"> <?php echo $oLink->url_text; ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php require JModuleHelper::getLayoutPath('mod_itineraries_itinerary_types', $params->get('layout', 'default') . '_items'); ?>

    <?php if (!empty($sLinkType) && !empty($oLink->url_text) && $oLink->link_position == 'bottom'): ?>
        <div class="row">
            <div class="col-12">
                <div class="more mt-3">
                    <a class="btn learnmore radius-0 border-0" href="<?php echo $sLinkType; ?>" target="<?php echo $oLink->link_target; ?>" itemprop="url"> <?php echo $oLink->url_text; ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

