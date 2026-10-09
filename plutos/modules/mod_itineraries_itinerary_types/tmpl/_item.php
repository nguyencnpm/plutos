<?php
defined('_JEXEC') or die;

$tooltip = "hover percent polaroid animated";
$cEffect = "zoom";

$levelup = $item->level - $startLevel - 1;
$oBanners = json_decode($item->banners);
$oImages = json_decode($item->images);
$link = "";
if ($params->get('link_titles')):
    $link = JRoute::_(StandardHelperRoute::getItineraryTypeRoute($item->id));
endif;
$sBannerUrlsLink = ModItinerariesItineraryTypesHelper::getbannerLink($oBanners);
?>

<?php
$cBackgroundEffect = "";
$sUrlBannerText = "";
if (isset($oBanners)):
    $sUrlBannerText = $oBanners->urlbannertext;
    if (!empty($oBanners->image_full)):
        $cBackgroundEffect = empty($oBanners->effect) ? "" : $oBanners->effect;
    endif;
endif;
?>
<?php if (!empty($oBanners->image_full) && !empty($cBackgroundEffect) && $params->get('use_banner_if_available')): ?>
    <?php if ($params->get('item_title') || $params->get('show_description', 0)) : ?>
        <div class="row <?php echo $cBackgroundEffect; ?> " style="background-image: url(<?php echo JUri::root() . htmlspecialchars($oBanners->image_full); ?>);">
            <div class="col-12">
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
                        <div class="d-flex col-12 <?php echo $col; ?> <?php echo $orderText; ?>">
                            <div class="item flex-fill mb-0">
                                <div class="featurette transparency item-text text-justify-center custom-min-height d-flex align-items-center">
                                    <div class="flex-fill <?php echo empty($oBanners->device) ? "" : "px-3 px" . $oBanners->device . "-0"; ?>">
                                        <?php //-- start title --     ?>
                                        <?php if ($params->get('item_title')): ?>
                                            <h<?php echo $params->get('item_heading') + $levelup; ?> class="item-title cut-string-multiple-lines one-line">
                                                <?php if ($link !== '') : ?>
                                                    <a href="<?php echo $link; ?>">
                                                        <?php echo $item->title; ?>
                                                    </a>
                                                <?php else : ?>
                                                    <?php echo $item->title; ?>
                                                <?php endif; ?>
                                            </h<?php echo $params->get('item_heading') + $levelup; ?>>
                                        <?php endif; ?>
                                        <?php //-- /.start title --  ?>
                                        <?php if ($params->get('show_description', 0)) : ?>
                                            <?php echo JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_itineraries_itinerary_types.content'); ?>
                                        <?php endif; ?>
                                        <?php if (!empty($sUrlBannerText)): ?>
                                            <div class="clearfix"></div>
                                            <div class="more my-3">
                                                <a class="btn booknow radius-0 " href="<?php echo $sBannerUrlsLink; ?>" target="<?php echo $oBanners->linktarget;?>" itemprop="url"> <?php echo $sUrlBannerText; ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($columns > 1): ?>
                            <?php $tempCol = $columns - 1; ?>
                            <?php for ($iCol = 0; $iCol < $tempCol; $iCol++): ?>
                                <div class="d-flex col-12 <?php echo $col; ?> <?php echo $orderSpace; ?>">
                                    <div class="item flex-fill mb-0"></div><?php //  rounded border border-color-item mb-0 box-shadow                   ?>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="post d-flex flex-column mb-4">
        <?php if (isset($oImages) && $params->get('image') == 1): ?>
            <?php if (empty($oImage->image_medium)): ?>
                <?php
                $caption = htmlspecialchars(empty($oImage->image_intro_caption) ? $item->title : $oImage->image_intro_caption);
                $alt = htmlspecialchars(empty($oImage->image_intro_alt) ? $item->title : $oImage->image_intro_alt, ENT_COMPAT, 'UTF-8');
                ?>
                <div class="item-image bg-image <?php echo $cEffect; ?>">
                    <img class="<?php echo $tooltip; ?>"src="<?php echo JURI::base() . htmlspecialchars($oImages->image_medium); ?>"alt="<?php echo $alt; ?>">
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($params->get('item_title') || $params->get('show_description', 0)) : ?>
            <?php
            $show_icon = "";
            if ($params->get('show_icon')):
                $show_icon = "bg-icon-small-";
            endif;
            ?>
            <div class="featurette flex-fill text-justify-center <?php echo "featurette-".$show_icon.$params->get('position_icon_bottom');?>">
                <div class="item-text <?php echo $show_icon.$params->get('position_icon_top')?>">
                    <?php //-- start title --     ?>
                    <?php if ($params->get('item_title')): ?>
                        <h<?php echo $params->get('item_heading') + $levelup; ?> class="item-title cut-string-multiple-lines one-line">
                            <?php if ($link !== '') : ?>
                                <a href="<?php echo $link; ?>">
                                    <?php echo $item->title; ?>
                                </a>
                            <?php else : ?>
                                <?php echo $item->title; ?>
                            <?php endif; ?>
                        </h<?php echo $params->get('item_heading') + $levelup; ?>>
                    <?php endif; ?>
                    <?php //-- /.start title --  ?>
                    <?php if ($params->get('show_description', 0)) : ?>
                        <?php echo JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_itineraries_itinerary_types.content'); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>


