<?php
defined('JPATH_BASE') or die;

$keyCarousel = 'carousel-multiple-items';
$cCarousel = "carousel-multiple-items carousel mb-5";
$cCarouselItem = "carousel-multiple-item carousel-item col-12 col-md-6 col-lg-4";
$cImg = "img-fluid mx-auto d-block";

$flag = 0;
$slides = "";
$cActive = "";
$countSlider = 0;

$oGalleries = json_decode($displayData->galleries);

$autoplay = 0;
$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";
if (isset($oGalleries)):
    foreach ($oGalleries as $oGallery) {
        if (empty($oGallery->images->image_medium)):
            continue;
        endif;
        $cActive = $flag === 0 ? "active" : "";
        $tooltip = "hover percent polaroid animated";
        $alt = htmlspecialchars(empty($oGalleries->image_intro_alt) ? $displayData->title : $oGalleries->image_intro_alt, ENT_COMPAT, 'UTF-8');
        $image_slide = htmlspecialchars($oGallery->images->image_medium);

        $image = ""
                . " <img"
                . " class=\"{$cImg} {$tooltip}\""
                . " src=\"{$image_slide}\" "
                . " alt=\"{$alt}\""
                . " >";

        $slides .= "<div class=\"{$cCarouselItem} {$cActive}\">{$image}</div>"; //-- /.item --

        $flag = 1;
        $countSlider++;
    }

    if ($countSlider > 1):// --- co thoi gian viet js xu ly cho nay --- 
        $cCarousel .= " touch-swipe slide "; // . $params->get('effect')
    else:
    // $cCarousel .= " zoom ";
    endif;
    ?>
    <div id="<?php echo $keyCarousel; ?>" class="<?php echo $cCarousel; ?>" data-ride="carousel" <?php echo $interval; ?>>
        <div class="carousel-inner row w-100 mx-auto" role="listbox">
            <?php echo $slides; ?>
        </div>
        <?php // --- co thoi gian viet js xu ly cho nay --- ?>
        <?php if ($countSlider > 3): ?>
            <a class="carousel-control-prev" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="prev">
                <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                <span class="sr-only"><?php echo JText::_('Previous') ?></span>
            </a>
            <a class="carousel-control-next" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="next">
                <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                <span class="sr-only"><?php echo JText::_('Next') ?></span>
            </a>
        <?php elseif ($countSlider > 2): ?>
            <a class="carousel-control-prev d-lg-none" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="prev">
                <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                <span class="sr-only"><?php echo JText::_('Previous') ?></span>
            </a>
            <a class="carousel-control-next d-lg-none" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="next">
                <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                <span class="sr-only"><?php echo JText::_('Next') ?></span>
            </a>
        <?php elseif ($countSlider > 1): ?>
            <a class="carousel-control-prev d-md-none" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="prev">
                <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                <span class="sr-only"><?php echo JText::_('Previous') ?></span>
            </a>
            <a class="carousel-control-next d-md-none" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="next">
                <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                <span class="sr-only"><?php echo JText::_('Next') ?></span>
            </a>
        <?php endif; ?>
        <?php // --- /.co thoi gian viet js xu ly cho nay --- ?>
    </div>
<?php endif; ?>