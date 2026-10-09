<?php
defined('JPATH_BASE') or die;

$kSmallThumbnails = 'small-thumbnails-' . $displayData->id;
$cCarousel = "small-thumbnails carousel item-image"; //  bg-image  slider

$cCarouselThumbnail = "carousel-multiple-item carousel-item col-12 col-sm-6 col-md-4 col-lg-4 px-0";
$cCarouselMultipleThumbnails = "carousel-multiple-items carousel slide";

$flag = 0;
$indicators = "";
$itemSmallThumbnails = "";
$slides = "";
$cActive = "";
$countSlider = 0;
$oGalleries = json_decode($displayData->galleries);

$autoplay = 0;
$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";
if (isset($oGalleries)):
    foreach ($oGalleries as $key => $oGallery) {
        if (!$oGallery->gallery_status):
            continue;
        endif;
        $cActive = $flag === 0 ? " active" : "";
        $tooltip = "hover percent polaroid animated";

        $imageThumbnail = htmlspecialchars($oGallery->images->image_small);

        $alt = htmlspecialchars(empty($oImage->image_intro_alt) ? $displayData->title : $oImage->image_intro_alt, ENT_COMPAT, 'UTF-8');
        $image_slide = htmlspecialchars($oGallery->images->image_medium);



        $itemSmallThumbnails .= ""
                . " <div data-target=\"#{$kSmallThumbnails}\" "
                . " data-slide-to=\"{$key}\" "
                . " class=\"{$cCarouselThumbnail} {$cActive}\" >"
                . " <div class=\"position-relative\">"
                // -- Small Thumbnail --
                . " <img"
                . " class=\"{$tooltip}\""
                . " src=\"{$imageThumbnail}\" "
                . " alt=\"{$alt}\""
                . " >"
                // -- /.Small Thumbnail --
                . " <div class=\"shaded\"></div>"
                . " </div>"// -- /.position-relative --
                . " </div>";

        $image = ""
                . " <img"
                . " class=\"{$tooltip}\""
                . " src=\"{$image_slide}\" "
                . " alt=\"{$alt}\""
                . " >";

        $slides .= "<div class=\"carousel-item {$cActive}\">{$image}</div>"; //-- /.item --

        $flag = 1;
        $countSlider++;
    }

    if ($countSlider > 1):
        $cCarousel .= " touch-swipe slide "; // . $params->get('effect')
    else:
        $cCarousel .= " zoom ";
    endif;
    ?>
    <div id="<?php echo $kSmallThumbnails; ?>" class="<?php echo $cCarousel; ?>" data-ride="carousel" <?php echo $interval; ?>>
        <div class="px-4">
            <div class="carousel-inner">
                <?php echo $slides; ?>
            </div>

            <?php if (!empty($itemSmallThumbnails)): ?>
                <div class="<?php echo $cCarouselMultipleThumbnails; ?>" data-ride="carousel" <?php echo $interval; ?>>
                    <div class="carousel-indicators carousel-inner row w-100 mx-auto" role="listbox"> 
                        <?php echo $itemSmallThumbnails; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($countSlider > 1): ?>
            <a class="carousel-control-prev" href="#<?php echo $kSmallThumbnails; ?>" role="button" data-slide="prev">
                <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                <span class="sr-only"><?php echo JText::_('Previous') ?></span>
            </a>
            <a class="carousel-control-next" href="#<?php echo $kSmallThumbnails; ?>" role="button" data-slide="next">
                <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                <span class="sr-only"><?php echo JText::_('Next') ?></span>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>