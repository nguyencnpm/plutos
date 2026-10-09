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

$autoplay = 0;
$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";
if (isset($list)):
    foreach ($list as $i => $item):
        $title = "";
        if ($params->get('item_title')) :
            $item_heading = $params->get('item_heading', 'h4');
            $title = "<{$item_heading} class=\"item-title cut-string-multiple-lines one-line\">";

            if ($item->link !== '' && $params->get('link_titles')) :
                $title .= " <a href=\"{$item->link}\">{$item->title}</a>";
            else :
                $title .= $item->title;
            endif;
            $title .= "</{$item_heading}>";
        endif;

        $itemHeader = "<div class=\"item-header {$params->get('item_header_class')}\"> {$title}</div>";
        // ==== ====
        $image = "";
        if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) :
            $image .= "<img class=\"hover percent\" src=\"{$item->imageSrc}\" alt=\"{$item->imageAlt}\">";
            if (!empty($item->imageCaption)) :
                $image .= "<figcaption>{$item->imageCaption}</figcaption>";
            endif;
        endif;
        $figure = "<figure class=\"item-image bg-image zoom\">{$image}</figure>";
        // === ===
        $introtext = "";
        if (!$params->get('intro_only')) :
            $introtext .= $item->afterDisplayTitle;
        endif;
        if ($params->get('show_introtext', 1)) :
            $introtext .= $item->introtext;
        endif;
        $introtext .= $item->afterDisplayContent;
        
        $itemText = "<div class=\"item-text flex-fill text-justify-center\">{$introtext}</div>";
        // === ===
        $more = "";
        if ($params->get('booknow') || $params->get('readmore')) :
            if ($params->get('booknow')):
                $cLayoutButton = $params->get('layout_button') === 'vertical' ? "col-12" : "col-12 col-md-auto";
                
            
            $more = "<div class=\"{$cLayoutButton}\">{}</div>";
            endif;
        endif;
        
        $cActive = $flag === 0 ? "active" : "";
        $tooltip = "hover percent polaroid animated";

        $slides .= "<div class=\"{$cCarouselItem} {$cActive}\">{$itemHeader} {$figure}</div>"; //-- /.item --

        $flag = 1;
        $countSlider++;
    endforeach;

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