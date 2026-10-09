<?php
defined('JPATH_BASE') or die;

$kTestimonial = 'testimonial-' . $displayData->id;
$cCarousel = "testimonial carousel item-image bg-image w-100"; //  slider

$flag = 0;
$slides = "";
$cActive = "";
$countSlider = 0;

//echo '<pre>';
//print_r($displayData);
//echo '</pre>';

$oImage = json_decode($displayData->images);
$oChildimages = json_decode($displayData->childimages);

$autoplay = 1;
$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";

if (isset($oImage->image_medium) && !empty($oImage->image_medium)):
    $cActive = $flag === 0 ? " active" : "";
    $tooltip = "hover percent polaroid animated";
    $alt = htmlspecialchars(empty($oImage->image_intro_alt) ? $displayData->title : $oImage->image_intro_alt, ENT_COMPAT, 'UTF-8');
    $image_slide = JURI::base() . htmlspecialchars($oImage->image_medium);

    $image = ""
            . " <img"
            . " class=\"{$tooltip}\""
            . " src=\"{$image_slide}\" "
            . " alt=\"{$alt}\""
            . " >";

    $slides .= "<div class=\"carousel-item {$cActive}\">{$image}</div>"; //-- /.item --

    $flag = 1;
    $countSlider++;
endif;

if (isset($oChildimages)):
    foreach ($oChildimages as $oChildimage) {
        if (empty($oChildimage->images->image_medium)):
            continue;
        endif;
        $cActive = $flag === 0 ? " active" : "";
        $tooltip = "hover percent polaroid animated";
        $alt = htmlspecialchars(empty($oImage->image_intro_alt) ? $displayData->title : $oImage->image_intro_alt, ENT_COMPAT, 'UTF-8');
        $image_slide = htmlspecialchars($oChildimage->images->image_medium);

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
endif;

if ($countSlider > 1):
    $cCarousel .= " touch-swipe "; // . $params->get('effect')
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
