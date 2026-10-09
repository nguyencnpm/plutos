<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_carousel
 */
defined('_JEXEC') or die;

// $mobile = new MobileDetect();
// Desktop - default
$nameImageSize = "image_medium";
/*
  // Phone
  if ($mobile->isMobile()) {
  $nameImageSize = "image_medium";
  }
  // Tablet
  if ($mobile->isTablet()) {
  $nameImageSize = "image_medium";
  }
 */
$kCarousel = "gpTextOnSide";
$cCarousel = "carousel";
$cNumber = "carouselNumber";

$cItemImg = "d-flex col-sm-6 col-md-5 col-lg-4 col-xl-4";
$cItemText = "d-flex align-items-center col-sm-6 col-md-7 col-lg-8 col-xl-8";


$countSlider = count($list);
if ($show_custom_nav == 1 && $countSlider > 1):
    $cCarousel .= " touch-swipe " . $params->get('effect');
endif;
$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";
$item_heading = $params->get('item_heading', 'h4');
$flag = 0;
$indicators = "";
$slides = "";
$cActive = "";
?>
<div id="<?php echo $kCarousel; ?>" class="<?php echo $cCarousel; ?>" data-ride="carousel" <?php echo $interval; ?>>
    <?php if (!empty($list)): ?>
        <?php
        foreach ($list as $key => $item) :
            $cActive = $flag == 0 ? " active" : "";
            $iNumber = $key + 1;
            $indicators .= ""
                    . " <li data-target=\"#{$kCarousel}\" "
                    . " data-slide-to=\"{$key}\" "
                    . " class=\"{$cActive}\" >"
                    . " </li>";
            $tooltip = "hover percent";
            $itemParams = $item->params;

            // images
            $images = json_decode($item->images);
            $alt = htmlspecialchars(empty($images->image_intro_alt) ? $item->title : $images->image_intro_alt, ENT_COMPAT, 'UTF-8');
            $image_slide = htmlspecialchars($images->$nameImageSize);

            $itemTitle = "";
            if ($params->get('item_title')) :
                $item_title = $item->title;
                $itemTitle = "<{$item_heading} class=\"item_title\">";
                if ($item->link !== '' && $params->get('link_titles')) :
                    $itemTitle .= "<a href=\"{$item->link}\">";
                    $itemTitle .= "{$item_title}";
                    $itemTitle .= " </a>";
                else :
                    $itemTitle .= "{$item_title}";
                endif;
                $itemTitle .= "</{$item_heading}>";
            endif;

            $description = "";
            if ((int) $params->get('show_introtext')):
                $description = "<div class=\"description\">" . $item->introtext . "</div>";
            endif;

            $readmore = "";
            if (isset($item->link) && $params->get('readmore')) :
                $linkItem = $item->link;
                $linkText = $item->linkText;
                $readmore = "<p class=\"readmore\"><a class=\"btn btn-lg btn--override\" href=\"{$linkItem}\"> {$linkText}</a></p>";
            endif;

            $cTextAlign = $params->get('textalign');

            $image = "";
            if (!empty($image_slide)):
                $image = " <img"
                        . " class=\"{$tooltip}\""
                        . " src=\"{$image_slide}\" "
                        . " alt=\"{$alt}\""
                        . " >";
            else:
                $cItemImg = "col-0";
                $cItemText = "col-12";
            endif;

            $slides .= " "
                    . "<div class=\"carousel-item {$cActive}\"> " //-- item --
                    . "<div class=\"row\">"//-- row --
                    . "<div class=\"{$cItemImg}\">"//-- col image --
                    . "<div class=\"flex-fill item-image border-image zoom bg-image flex-fill animated fadeInLeft\">"
                    . "{$image}"
                    . " </div>"//-- /.item-image --
                    . " </div>"//-- /.col image --
                    . " <div class=\"{$cItemText}\">"//-- col text --
                    . " <div class=\"item-text flex-fill animated fadeInRight\">"//-- col text --
                    . "{$itemTitle}"
                    . "{$description}"
                    . "{$readmore}"
                    . " </div>"
                    . " </div>"//-- /.col text --
                    . " </div>"//-- /.row --
                    . " </div>"; //-- /.item --
            $flag = 1;

        endforeach;
        ?>
    <?php endif; ?>
    <?php if ($show_custom_nav == 1 && $countSlider > 1): ?>
        <ol class="circle carousel-indicators">
            <?php echo $indicators; ?>
        </ol>
    <?php endif; ?>

    <div class="carousel-inner d-flex">
        <?php echo $slides; ?>
    </div>
    <?php if ($show_arrows == 1 && $countSlider > 1): ?>
        <a class="carousel-control-prev" href="#<?php echo $kCarousel; ?>" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only"><?php echo JText::_('Previous'); ?></span>
        </a>
        <a class="carousel-control-next" href="#<?php echo $kCarousel; ?>" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only"><?php echo JText::_('Next'); ?></span>
        </a>
    <?php endif; ?>
</div>