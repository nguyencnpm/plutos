<?php
defined('JPATH_BASE') or die;

$kPlan = 'plan-' . $displayData->id;
$cCarousel = "plan carousel item-image";

$cCarouselItem = " pl-5 pr-5 ";
$flag = 0;
$slides = "";
$cActive = "";
$countSlider = 0;

$oImages = json_decode($displayData->plans_image);

$autoplay = 0;
$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";
if (isset($oImages)):
    foreach ($oImages as $oImage) :
        if (empty($oImage->images->image_big)):
            continue;
        endif;
        $cActive = $flag === 0 ? " active" : "";
        $tooltip = "hover percent polaroid animated";

        $image_title = "";
        $title = htmlspecialchars(empty($oImage->plans_image_title) ? "" : $oImage->plans_image_title);
        if (!empty($title)):
            $image_title = "<h4 class=\"subtitle\">{$title}</h4>";
        endif;

        $caption = htmlspecialchars(empty($oImage->plans_image_caption) ? $displayData->title : $oImage->plans_image_caption);
        $alt = htmlspecialchars(empty($oImage->plans_image_alt) ? $displayData->title : $oImage->plans_image_alt, ENT_COMPAT, 'UTF-8');
        $image_slide = JURI::base() . htmlspecialchars($oImage->images->image_big);

        $image = ""
                . " <img"
                . " class=\"{$tooltip}\""
                . " src=\"{$image_slide}\" "
                . " alt=\"{$alt}\""
                . " >";

        $slides .= "<div class=\"carousel-item {$cCarouselItem} {$cActive}\">"
                . "{$image}"
                . "{$image_title}"
                . "</div>"; //-- /.item --

        $flag = 1;
        $countSlider++;
    endforeach;
endif;
if ($countSlider > 1):
    $cCarousel .= " touch-swipe slide "; // . $params->get('effect')
else:
    $cCarousel .= " zoom ";
endif;
?>
<?php if ($countSlider > 0): ?>
    <?php $cMedialayoutelement = isset($displayData->plans_medialayoutelement) ? $displayData->plans_medialayoutelement : ""; ?>
    <div class="<?php echo $cMedialayoutelement; ?> mx-auto text-center mb-5">
        <div class="row">
            <div class="col-12">
                <div class="item-header">
                    <h2 class="item-title cut-string-multiple-lines"><?php echo JText::_("COM_STANDARD_DECKPLAN"); ?></h2>
                </div>
                <div id="<?php echo $kPlan; ?>" class="<?php echo $cCarousel; ?>" data-ride="carousel" <?php echo $interval; ?>>
                    <div class="carousel-inner">
                        <?php echo $slides; ?>
                    </div>
                    <?php if ($countSlider > 1): ?>
                        <a class="plan-control-prev" href="#<?php echo $kPlan; ?>" role="button" data-slide="prev">
                            <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                            <span class="sr-only"><?php echo JText::_('Previous') ?></span>
                        </a>
                        <a class="plan-control-next" href="#<?php echo $kPlan; ?>" role="button" data-slide="next">
                            <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                            <span class="sr-only"><?php echo JText::_('Next') ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>