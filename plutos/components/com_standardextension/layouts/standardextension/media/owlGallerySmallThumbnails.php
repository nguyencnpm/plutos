<?php
defined('JPATH_BASE') or die;

$flag = 0;
$itemSmallThumbnails = "";
$slides = "";
$cActive = "";

$oGalleries = json_decode($displayData->galleries);

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
                . " <div class=\"item\">"
                . " <div class=\"position-relative\">"
                // -- Small Thumbnail --
                . " <img"
                . " class=\"{$tooltip}\""
                . " src=\"{$imageThumbnail}\" "
                . " alt=\"{$alt}\""
                . " >"
                // -- /.Small Thumbnail --
                . " <div class=\"shaded\"></div>"
                . " </div>"
                . " </div>";

        $image = ""
                . " <img"
                . " class=\"{$tooltip}\""
                . " src=\"{$image_slide}\" "
                . " alt=\"{$alt}\""
                . " >";

        $slides .= "<div class=\"item {$cActive}\">{$image}</div>"; //-- /.item --
    }
    ?>
    <div class="owl-carousel-thumbnails">
        <div class="synchronize1 owl-carousel owl-theme">
            <?php echo $slides; ?>
        </div>
        <div class="synchronize2 owl-carousel owl-theme mt-3 d-none d-md-block">
            <?php echo $itemSmallThumbnails; ?>
        </div>
    </div>
<?php endif; ?>