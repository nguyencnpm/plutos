<?php
defined('JPATH_BASE') or die;

$vId = 'video-' . $displayData->id;
$oVideos = json_decode($displayData->videos);
$popup_class = "popup-video";
$allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture";
$imageurl = "";

if (isset($oVideos)):
    foreach ($oVideos as $oVideo) :
        if (!$oVideo->video_status):
            continue;
        endif;
        $video_title = (isset($oVideo->video_title) && !empty($oVideo->video_title) ? $oVideo->video_title : isset($oVideo->urltext)) && !empty($oVideo->urltext) ? $oVideo->urltext : $displayData->title;
        $video_alt = isset($oVideo->video_alt) && !empty($oVideo->video_alt) ? $oVideo->video_alt : $displayData->title;

        if (!empty($oVideo->images->image_medium)) {
            $imageurl = JURI::base() . $oVideo->images->image_medium;
        }
        $link = isset($oVideo->url) ? $oVideo->url : "";
        ?>
        <?php if ((isset($oVideo) && !empty($oVideo)) && (!empty($imageurl) || !empty($link))): ?>
            <div class="video flex-fill">
                <div class="video__thumbnail item-image zoom">
                    <div class="embed-responsive embed-responsive-<?php echo $displayData->aspect_ratio; // 16by9          ?>">
                        <iframe class="embed-responsive-item" src="<?php echo $link; ?>" allow="<?php echo $allow; ?>" <?php echo $displayData->frame_rate; ?>></iframe>
                    </div>
                </div>
            </div>
            <?php break; // fix temp ?>
        <?php endif; ?>
        <?php
    endforeach;
endif;
?>



