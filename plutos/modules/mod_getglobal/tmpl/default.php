<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_carousel
 */
defined('_JEXEC') or die;

$mobile = new MobileDetect();
// Desktop - default
$nameImageSize = "image_full";
$nameTabletImageSize = "image_full";
$namePhoneImageSize = "image_full";

$numberwords = (int) $params->get('introtext_limit');
$cCutStringNumberLine = "";
// $cCutStringNumberLine  = " three-lines";
//$cCutStringNumberLine = " cut-string-multiple-lines one-line";
/*
  // Phone
  if ($mobile->isMobile()) {
  $nameImageSize = "image_medium";
  //$numberwords = number_format((int) $params->get('introtext_limit') / 4, 0);
  $cCutStringNumberLine  = " one-line";
  }
  // Tablet
  if ($mobile->isTablet()) {
  $nameImageSize = "image_screen";
  //$numberwords = $numberwords = number_format((int) $params->get('introtext_limit') / 2, 0);
  $cCutStringNumberLine  = " two-lines";
  }
 */
if (!class_exists('Stringhandling')) {
    jimport("informationtechnology.stringhandling.stringhandling");
}

$kCarousel = "gpCarousel-{$uniqid}";
$cCarousel = "carousel"; //  slider
$cContainer = $params->get('fluidContainer') ? 'container-fluid' : 'container';

$cIntroLayoutElement = $params->get('intro_medialayoutelement', '');
if (!empty($params->get('position_layoutelemen', ''))):
    $cIntroLayoutElement .= " " . $params->get('position_layoutelemen', '');
endif;
if (!empty($params->get('position_sfx', ''))):
    $cIntroLayoutElement .= " " . $params->get('position_sfx', '');
endif;

$itemTitleMasthead = "item-title-masthead mb-3";
$cTextAlign = $params->get('textalign');
switch ($cTextAlign) {

    case 'text-center':
        $itemTitleMasthead .= " mx-auto";

        break;

    case 'text-right':
        $itemTitleMasthead .= " mx-auto float-right";

        break;

    case 'text-left':
    default:
        break;
}

$cRow = "";
$cCol = "";

$countSlider = count($list);
if ($show_custom_nav == 1 && $countSlider > 1):
    $cCarousel .= " touch-swipe " . $params->get('effect');
endif;

$interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";

$breadcrumbs = "";

$item_heading = $params->get('item_heading', 'h4');
$flag = 0;
$indicators = "";
$slides = "";
$cActive = "";
?>
<?php if (!empty($list)): ?>
    <div id="<?php echo $kCarousel; ?>" class="<?php echo $cCarousel; ?> <?php echo $class_sfx; ?>" data-ride="carousel" <?php echo $interval; ?>>
        <?php
        foreach ($list as $key => $item) :
            $cActive = $flag == 0 ? " active" : "";
            $indicators .= ""
                    . " <li data-target=\"#{$kCarousel}\" "
                    . " data-slide-to=\"{$key}\" "
                    . " class=\"{$cActive}\" >"
                    . " </li>";
            $tooltip = "percent animated ";
            // $tooltip .= $key % 2 ? "pulse" : "rotateIn";
            $itemParams = $item->params;
            /*
              $images = json_decode($item->images);
              $alt = htmlspecialchars(empty($images->image_intro_alt) ? $item->title : $images->image_intro_alt, ENT_COMPAT, 'UTF-8');
              $image_slide = htmlspecialchars($images->$nameImageSize);
             */
            // banners
            $images = json_decode($item->banners);
            $tablet_images = json_decode($item->banners_tablet);
            $phone_images = json_decode($item->banners_phone);

            $alt = htmlspecialchars(empty($images->banner_intro_alt) ? $item->title : $images->image_banner_alt, ENT_COMPAT, 'UTF-8');
            $image_slide = htmlspecialchars($images->$nameImageSize);
            $tablet_image_slide = htmlspecialchars($tablet_images->$nameTabletImageSize);
            $phone_image_slide = htmlspecialchars($phone_images->$namePhoneImageSize);

            $itemTitle = "";
            if ($params->get('item_title') && $images->bannertitle_status) :

                $item_title = $item->title;
                if (!empty($images->bannertitle)):
                    $item_title = nl2br($images->bannertitle);
                endif;

                $itemTitle = "<{$item_heading} class=\"item_title animated fadeInDown {$params->get('item_header_class', '')}\">";
                if ($item->link !== '' && $params->get('link_titles')) :
                    $itemTitle .= "<a href=\"{$item->link}\">";
                    $itemTitle .= "{$item_title}";
                    $itemTitle .= " </a>";
                else :
                    $itemTitle .= "{$item_title}";
                endif;
                $itemTitle .= "</{$item_heading}>";
                if ($params->get('show_item_title_masthead', 0)):
                    $itemTitle .= " <div class=\"{$itemTitleMasthead}\"></div>";
                endif;
            endif;

            $description = "";
            if ((int) $params->get('show_introtext')):
                if (!empty($images->bannerdesc)):
                    $sBannerDesc = nl2br($images->bannerdesc);
                else :
                    $sBannerDesc = $item->introtext;
                endif;

                $introtext = Stringhandling::trimString($sBannerDesc, $numberwords);

                $description = "<div class=\"bannerdesc {$cCutStringNumberLine} animated fadeInUp\">" . $introtext . "</div>";
            endif;

            $readmore = "";
            $linkBanner = "";
            $linkBannerEnd = "";

            if (!empty($images->linktype)):
                $linkItem = "";
                switch ($images->linktype) {
                    case 'bannercurrent':
                        $linkItem = isset($item->link) ? $item->link : "";

                        break;

                    default:
                        $linkItem = ModGetglobalHelper::getbannerLink($images);
                        break;
                }

                if (!empty($linkItem) && $params->get('readmore')):
                    if ((int) $images->url_type === 1):
                        $linkText = $images->urlbannertext;
                        $readmore = "<p class=\"readmore animated fadeInUp\"><a class=\"btn {$params->get('readmore_class', '')}\" href=\"{$linkItem}\"> {$linkText}</a></p>";
                    else:
                        $linkBanner = "<a href=\"{$linkItem}\">";
                        $linkBannerEnd = "</a>";
                    endif;
                endif;
            endif;

            // ----- Display: detect device ------
            // Desktop - default
            $image = ""
                    . " <img"
                    . " class=\"{$tooltip}\""
                    . " src=\"{$image_slide}\" "
                    . " alt=\"{$alt}\""
                    . " >";
            // Phone
            if ($mobile->isMobile() && !empty($phone_images->$namePhoneImageSize)):
                $image = ""
                        . " <img"
                        . " class=\"{$tooltip}\""
                        . " src=\"{$phone_image_slide}\" "
                        . " alt=\"{$alt}\""
                        . " >";
            endif;
            // Tablet
            if ($mobile->isTablet() && !empty($tablet_images->$nameTabletImageSize)):
                $image = ""
                        . " <img"
                        . " class=\"{$tooltip}\""
                        . " src=\"{$tablet_image_slide}\" "
                        . " alt=\"{$alt}\""
                        . " >";
            endif;
            // ----- /.Display: detect device ------
            $slides .= " "
                    . "<div class=\"carousel-item {$cActive}\"> " //-- item --
                    . "{$linkBanner}" // --- isset link banner --- 
                    . "{$image}"
                    . " <div class=\"{$cContainer} carousel-caption {$cTextAlign} \"> " //------ container -- carousel-caption------
                    . " <div class=\"{$cIntroLayoutElement}\">"
                    . "<div class=\"col-12\">"
                    . "{$itemTitle}"
                    . "{$description}"
                    . "{$breadcrumbs}"
                    . "{$readmore}"
                    . "</div>"
                    . "</div>"//------ /.Intro Layout Element ------
                    . "</div>" //------ /.container -- carousel-caption ------
                    . "{$linkBannerEnd}" // --- /.isset link banner --- 
                    . " </div>"; //-- /.item --
            $flag = 1;

        endforeach;
        ?>
    <?php endif; ?>
    <?php if ($show_custom_nav == 1 && $countSlider > 1): ?>
        <ol class="carousel-indicators">
            <?php echo $indicators; ?>
        </ol>
    <?php endif; ?>

    <div class="carousel-inner">
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
    </div>
<?php endif; ?>