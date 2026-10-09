<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_products_related
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$show_icon = "";
if ($params->get('show_icon')):
    $show_icon = "featurette-bg-icon-small-";
endif;
?>
<div class="row">
    <div class="post d-flex flex-column col-12">
        <?php //-- show title --   ?>
        <div class="item-header <?php echo $params->get('item_header_class'); ?> <?php echo $show_icon . $params->get('position_icon_top') ?>">
            <?php if ($params->get('item_title')) : ?>
                <?php $item_heading = $params->get('item_heading', 'h4'); ?>
                <<?php echo $item_heading; ?> class="item-title cut-string-multiple-lines one-line">
                <?php if ($item->link !== '' && $params->get('link_titles')) : ?>
                    <a href="<?php echo $item->link; ?>">
                        <?php echo $item->title; ?>
                    </a>
                <?php else : ?>
                    <?php echo $item->title; ?>
                <?php endif; ?>
                </<?php echo $item_heading; ?>>
            <?php endif; ?>
        </div>
        <?php //--  /.show title --   ?> 

        <?php if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) : ?>	
            <figure class="item-image bg-image zoom">
                <img class="hover percent" src="<?php echo $item->imageSrc; ?>" alt="<?php echo $item->imageAlt; ?>">
                <?php if (!empty($item->imageCaption)) : ?>
                    <figcaption>
                        <?php echo $item->imageCaption; ?>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <div class="item-text flex-fill text-justify-center">
            <?php if (!$params->get('intro_only')) : ?>
                <?php echo $item->afterDisplayTitle; ?>
            <?php endif; ?>

            <?php echo $item->beforeDisplayContent; ?>

            <?php if ($params->get('show_introtext', 1)) : ?>
                <?php echo $item->introtext; ?>
            <?php endif; ?>

            <?php echo $item->afterDisplayContent; ?>
        </div>

        <?php if ($params->get('booknow') || $params->get('readmore')) : ?>
            <?php // --- Book now - Learn more --- ?>
            <div class="more row justify-content-center">
                <?php if ($params->get('booknow')): ?>
                    <div class="<?php echo $params->get('layout_button') === 'vertical' ? "col-12" : "col-12 col-md-auto" ?>">
                        <?php require JModuleHelper::getLayoutPath('mod_products', '_booking'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($params->get('readmore')): ?>
                    <div class="<?php echo $params->get('layout_button') === 'vertical' ? "col-12" : "col-12 col-md-auto" ?>">
                        <?php require JModuleHelper::getLayoutPath('mod_products', '_readmore'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php // --- /.Book now - Learn more ---    ?>
        <?php endif; ?>
    </div>
</div>