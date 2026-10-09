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
        $video_title = isset($oVideo->video_title) && !empty($oVideo->video_title) ? $oVideo->video_title : isset($oVideo->urltext) && !empty($oVideo->urltext) ? $oVideo->urltext : $displayData->title;
        $video_alt = isset($oVideo->video_alt) && !empty($oVideo->video_alt) ? $oVideo->video_alt : $displayData->title;

        if (!empty($oVideo->images->image_medium)):
            $imageurl = JURI::base() . $oVideo->images->image_medium;
        else:
            if (isset($displayData->images)):
                $images = json_decode($displayData->images);
                $imageurl = JURI::base() . $images->image_medium;
            endif;
        endif;
        $link = isset($oVideo->url) ? $oVideo->url : "";
        ?>
        <?php if ((isset($oVideo) && !empty($oVideo)) && (!empty($imageurl) || !empty($link))): ?>
            <?php // -- Trigger the modal with a button --            ?>
            <div class="video flex-fill">
                <div class="video__thumbnail item-image zoom">
                    <a class="<?php echo $popup_class; ?>" data-toggle="modal" data-target="#<?php echo trim($vId); ?>" data-theVideo="<?php echo $link; ?>">
                        <img class="hover w-100" src="<?php echo $imageurl; ?>" alt="<?php echo $video_alt; ?>" title="<?php echo $video_title; ?>">
                        <div class="shaded">
                            <i class="icon-video fa fa-play-circle fa-3x" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
            </div>
            <?php // --Modal --     ?>
            <?php if (!empty($link)): ?>
                <div id="<?php echo trim($vId); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered gp-modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                                </button>
                                <div class="embed-responsive embed-responsive-<?php echo $displayData->aspect_ratio; // 16by9             ?>">
                                    <iframe class="embed-responsive-item" allow="<?php echo $allow; ?>" <?php echo $displayData->frame_rate; ?>></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php //-- /.Modal --   ?>
            <?php break; // fix temp ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>

<?php endif; ?>
