<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_combos
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$show_icon = "";
if ($params->get('show_icon')):
    $show_icon = "featurette-bg-icon-small-";
endif;

$tooltip = "hover percent polaroid animated";
$cEffect = "zoom";
//
//echo '<pre>';
//print_r($item);
//exit;

$oBanners = json_decode($item->banners);

$cBackgroundEffect = "";
$sUrlBannerText = "";
$sUrlBannerTextA = "";
if (isset($oBanners)):
    $sUrlBannerText = $oBanners->urlbannertext;
    $sUrlBannerTextA = $oBanners->urlatext;
    if (!empty($oBanners->image_full)):
        $cBackgroundEffect = empty($oBanners->effect) ? "" : $oBanners->effect;
    endif;
endif;
?>
<?php if ($item->banner_status && !empty($oBanners->image_full) && !empty($cBackgroundEffect) && $params->get('use_banner_if_available')): ?>
    <?php
    $link = "";
    if ($params->get('link_titles')):
    //$link = JRoute::_(StandardHelperRoute::getItineraryTypeRoute($item->id));
    endif;
    $sBannerUrlsLink = ModCombosHelper::getbannerLink($oBanners);
    $sBannerUrlsLinkA = ModCombosHelper::getbannerLinkA($oBanners);
    ?>

    <?php if ($params->get('item_title') || $params->get('show_description', 0)) : ?>
        <div class="row <?php echo $cBackgroundEffect; ?> " style="background-image: url(<?php echo JUri::root() . htmlspecialchars($oBanners->image_full); ?>);">
            <div class="<?php echo ($params->get('fluidContainer') ? 'col-12' : 'container'); ?>">
                <div class="<?php echo $oBanners->text_medialayoutelement; ?>  mx-auto">
                    <?php
                    $sPosition = $oBanners->text_position;
                    $columns = (int) $oBanners->text_aspectratio;
                    $col = empty($oBanners->device) ? "" : "col" . $oBanners->device . "-" . round(12 / $columns);
                    switch (trim($sPosition)) {
                        case 'right':
                            $orderText = "order" . $oBanners->device . "-2";
                            $orderSpace = "order" . $oBanners->device . "-1";
                            break;
                        case 'left':
                            $orderText = "order" . $oBanners->device . "-1";
                            $orderSpace = "order" . $oBanners->device . "-2";
                            break;
                        default:
                            $orderText = "";
                            $orderSpace = "";
                            break;
                    }
                    ?>
                    <div class="row">
                        <div class="d-flex col-12 px-0 <?php echo empty($oBanners->device) ? "" : "px{$oBanners->device}-3"; ?> <?php echo $col; ?> <?php echo $orderText; ?>">
                            <div class="item flex-fill mb-0">
                                <div class="featurette transparency item-text custom-min-height d-flex align-items-center">
                                    <div class="flex-fill <?php echo empty($oBanners->device) ? "" : "px-3 px" . $oBanners->device . "-0"; ?>">
                                        <?php //-- start title --     ?>
                                        <?php if ($params->get('item_title')): ?>
                                            <div class="item-header <?php echo $show_icon . $params->get('position_icon_top') ?>">
                                                <<?php echo $params->get('item_heading'); ?> class="item-title <?php echo $params->get('item_header_class'); ?>">
                                                <?php if ($item->link !== '' && $params->get('link_titles')) : ?>
                                                    <a href="<?php echo $item->link; ?>">
                                                        <?php echo $item->title; ?>
                                                    </a>
                                                <?php else : ?>
                                                    <?php echo $item->title; ?>
                                                <?php endif; ?>
                                                </<?php echo $params->get('item_heading'); ?>>
                                            </div>
                                        <?php endif; ?>
                                        <?php //-- /.start title --  ?>

                                        <?php // --- show description --- ?>
                                        <div class=" text-justify-right mb-3">
                                            <?php if (!$params->get('intro_only')) : ?>
                                                <?php echo $item->afterDisplayTitle; ?>
                                            <?php endif; ?>

                                            <?php echo $item->beforeDisplayContent; ?>

                                            <?php if ($params->get('show_introtext', 1)) : ?>
                                                <?php echo $item->introtext; ?>
                                            <?php endif; ?>

                                            <?php echo $item->afterDisplayContent; ?>
                                        </div>
                                        <?php // --- /.show description --- ?>
                                        <?php require JModuleHelper::getLayoutPath('mod_combos', '_bannermore'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($columns > 1): ?>
                            <?php $tempCol = $columns - 1; ?>
                            <?php for ($iCol = 0; $iCol < $tempCol; $iCol++): ?>
                                <div class="d-flex col-12 <?php echo $col; ?> <?php echo $orderSpace; ?>">
                                    <div class="item flex-fill mb-0"></div><?php //  rounded border border-color-item mb-0 box-shadow                                                                    ?>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>

    <?php
    $class_item_media = "post d-flex col-12";
    $class_item_media .= " px-lg-0";

    $class_item_text = "post d-flex col-12";
    $class_item_text .= " px-lg-0";

    $cItemText = "featurette item-text flex-fill custom-min-height d-flex align-items-center";
    // ---- ----
    $oImages = json_decode($item->images);

    $sPosition = $oImages->text_position;
    $columns = (int) $oImages->text_aspectratio;
    $col = empty($oImages->device) ? "" : "col" . $oImages->device . "-" . round(12 / $columns);
    $colSpace = $columns > 1 ? empty($oImages->device) ? "" : "col" . $oImages->device . "-" . (round(12 / $columns)) * ($columns - 1) : "";

    switch (trim($sPosition)) {
        case 'right':
            $orderText = "order" . $oImages->device . "-2";
            $orderSpace = "order" . $oImages->device . "-1";
            break;
        case 'left':
            $orderText = "order" . $oImages->device . "-1";
            $orderSpace = "order" . $oImages->device . "-2";
            break;
        default:
            $orderText = "";
            $orderSpace = "";
            break;
    }

    // ------- 
//    echo '<pre>';
//    print_r($oImages);
//    exit;
    $link = "";
    if ($params->get('link_titles')):
    //$link = JRoute::_(StandardHelperRoute::getItineraryTypeRoute($item->id));
    endif;
    $sImageUrlsLink = ModCombosHelper::getImageLink($oImages);
    $sImageUrlsLinkA = ModCombosHelper::getbannerLinkA($oImages);

    $cBackgroundEffect = "parallax-scrolling";
    $sUrlImageText = "";
    $sUrlImageTextA = "";
    if (isset($oImages)):
        $sUrlImageText = $oImages->urltext;
        $sUrlImageTextA = $oImages->urlatext;
        if (!empty($oImages->image_full)):
            $cBackgroundEffect = empty($oImages->effect) ? "" : $oImages->effect;
        endif;
    endif;
    ?>
    <div class="exception d-none d-lg-block">
        <div class="row">
            <?php // --- set Background ---    ?>
            <div class="background-image <?php echo $colSpace; ?> <?php echo $cBackgroundEffect; ?> <?php echo $orderSpace; ?>" style="background-image: url(<?php echo $item->imageSrc; ?>);"></div>
            <div class="<?php echo $class_item_text; ?> <?php echo $col; ?> <?php echo $orderText; ?>">
                <div class="<?php echo $cItemText; ?>"> 
                    <div class="flex-fill"></div>
                </div>
            </div>
            <?php // --- /.set Background ---    ?>
        </div>
        <?php // --- set on Background --- ?>
        <div class="row">
            <div class="container exception--effect">
                <div class="row">
                    <?php if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) : ?>
                        <div class="<?php echo $class_item_media; ?> <?php echo $colSpace; ?> <?php echo $orderSpace; ?>">

                        </div>
                    <?php else: ?>
                        <?php
                        $class_item_text = "post d-flex col-12";
                        $class_item_text .= " px-lg-0";
                        $cItemText = " featurette item-text flex-fill mb-0 custom-min-height d-flex align-items-center";
                        ?>
                    <?php endif; ?>

                    <div class="cDescription <?php echo $class_item_text; ?> <?php echo $col; ?> <?php echo $orderText; ?>">
                        <div class="<?php echo $cItemText; ?>">
                            <div class="flex-fill">
                                <?php //-- show title --      ?>
                                <?php if ($params->get('item_title')) : ?>
                                    <div class="item-header <?php echo $params->get('item_header_class'); ?> <?php echo $show_icon . $params->get('position_icon_top') ?>">
                                        <?php $item_heading = $params->get('item_heading', 'h4'); ?>
                                        <<?php echo $item_heading; ?> class="item-title <?php echo $params->get('item_header_class'); ?>">
                                        <?php if ($item->link !== '' && $params->get('link_titles')) : ?>
                                            <a href="<?php echo $item->link; ?>">
                                                <?php echo $item->title; ?>
                                            </a>
                                        <?php else : ?>
                                            <?php echo $item->title; ?>
                                        <?php endif; ?>
                                        </<?php echo $item_heading; ?>>
                                    </div>
                                <?php endif; ?>
                                <?php //--  /.show title --    ?> 
                                <?php // --- show description --- ?>
                                <div class=" text-justify-right">
                                    <?php if (!$params->get('intro_only')) : ?>
                                        <?php echo $item->afterDisplayTitle; ?>
                                    <?php endif; ?>

                                    <?php echo $item->beforeDisplayContent; ?>

                                    <?php if ($params->get('show_introtext', 1)) : ?>
                                        <?php echo $item->introtext; ?>
                                    <?php endif; ?>

                                    <?php echo $item->afterDisplayContent; ?>
                                </div>
                                <?php // --- /.show description ---   ?>
                                <?php require JModuleHelper::getLayoutPath('mod_combos', '_imagemore'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php // --- /.set on Background --- ?>
    </div>

    <div class="d-lg-none">
        <div class="row">
            <?php if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) : ?>
                <div class="<?php echo $class_item_media; ?> <?php echo $colSpace; ?> <?php echo $orderSpace; ?>">
                    <figure class="item-image bg-image zoom mb-0">
                        <img class="hover percent" src="<?php echo $item->imageSrc; ?>" alt="<?php echo $item->imageAlt; ?>">
                        <?php if (!empty($item->imageCaption)) : ?>
                            <figcaption>
                                <?php echo $item->imageCaption; ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                </div>
            <?php else: ?>
                <?php
                $class_item_text = "post cDescription d-flex col-12";
                $class_item_text .= " px-lg-0";
                ?>
            <?php endif; ?>

            <div class="<?php echo $class_item_text; ?> <?php echo $col; ?> <?php echo $orderText; ?>">
                <div class="featurette item-text flex-fill mb-0">
                    <?php //-- show title --      ?>
                    <?php if ($params->get('item_title')) : ?>
                        <div class="item-header <?php echo $params->get('item_header_class'); ?> <?php echo $show_icon . $params->get('position_icon_top') ?>">
                            <?php $item_heading = $params->get('item_heading', 'h4'); ?>
                            <<?php echo $item_heading; ?> class="item-title">
                            <?php if ($item->link !== '' && $params->get('link_titles')) : ?>
                                <a href="<?php echo $item->link; ?>">
                                    <?php echo $item->title; ?>
                                </a>
                            <?php else : ?>
                                <?php echo $item->title; ?>
                            <?php endif; ?>
                            </<?php echo $item_heading; ?>>
                        </div>
                    <?php endif; ?>
                    <?php //--  /.show title --    ?> 
                    <?php // --- show description --- ?>
                    <div class=" text-justify-right">
                        <?php if (!$params->get('intro_only')) : ?>
                            <?php echo $item->afterDisplayTitle; ?>
                        <?php endif; ?>

                        <?php echo $item->beforeDisplayContent; ?>

                        <?php if ($params->get('show_introtext', 1)) : ?>
                            <?php echo $item->introtext; ?>
                        <?php endif; ?>

                        <?php echo $item->afterDisplayContent; ?>
                    </div>
                    <?php // --- /.show description ---   ?>
                    <?php require JModuleHelper::getLayoutPath('mod_combos', '_imagemore'); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>