<?php
defined('JPATH_BASE') or die;

$kTestimonial = 'testimonial-' . $displayData->id;
$cCarousel = "testimonial carousel item-image bg-image"; //  slider

$flag = 0;
$slides = "";
$cActive = "";
$countSlider = 0;
$oGalleries = json_decode($displayData->galleries);

$autoplay = 0;
$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";
if (isset($oGalleries)):
    foreach ($oGalleries as $oGallery) {
        if (!$oGallery->gallery_status):
            continue;
        endif;
        $cActive = $flag === 0 ? " active" : "";
        $tooltip = "hover percent polaroid animated";
        $alt = htmlspecialchars(empty($oImage->image_intro_alt) ? $displayData->title : $oImage->image_intro_alt, ENT_COMPAT, 'UTF-8');
        $image_slide = htmlspecialchars($oGallery->images->image_medium);

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
    <div id="<?php echo $kTestimonial; ?>" class="<?php echo $cCarousel; ?>" data-ride="carousel" <?php echo $interval; ?>>
        <div class="carousel-inner">
            <?php echo $slides; ?>
        </div>
        <?php if ($countSlider > 1): ?>
            <div class="control-prev-next">
                <a class="btn btn-control testimonial-control-prev" href="#<?php echo $kTestimonial; ?>" role="button" data-slide="prev">
                    <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo JText::_('Previous') ?></span>
                </a>
                <a class="btn btn-control testimonial-control-next" href="#<?php echo $kTestimonial; ?>" role="button" data-slide="next">
                    <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo JText::_('Next') ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>