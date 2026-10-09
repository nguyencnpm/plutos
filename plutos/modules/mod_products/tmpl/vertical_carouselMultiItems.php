<?php
defined('JPATH_BASE') or die;

$keyCarousel = 'carousel-multiple-items-' . $uniqid;
$cCarousel = "carousel-multiple-items carousel mb-5";
$cCarouselItem = "carousel-multiple-item carousel-item col-12 col-sm-6 col-md-4 col-lg-3";
$cImg = "img-fluid mx-auto d-block";

$flag = 0;
$slides = "";
$cActive = "";
$countSlider = count((array) $list);

$autoplay = 0;
$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";
if ($countSlider > 0):
    if ($countSlider > 1):// --- co thoi gian viet js xu ly cho nay --- 
        $cCarousel .= " touch-swipe slide "; //   . $params->get('effect')
    else:
    // $cCarousel .= " zoom ";
    endif;
    ?>
    <div id="<?php echo $keyCarousel; ?>" class="row <?php echo $cCarousel; ?>" data-ride="carousel" <?php echo $interval; ?>>
        <div class="carousel-inner w-100 mx-auto d-flex" role="listbox">
            <?php foreach ($list as $i => $item): ?>
                <?php
                $cActive = $flag === 0 ? "active" : "";
                ?>
                <div class="<?php echo $cCarouselItem; ?> <?php echo $cActive; ?>">
                    <?php require JModuleHelper::getLayoutPath('mod_products', '_item'); ?>
                </div>
                <?php $flag = 1; ?>
            <?php endforeach; ?>
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