
<?php
defined('_JEXEC') or die;

$popup_class = " popup-video";
$uri = JUri::getInstance($link);
//$vId = $uri->getVar('v');
$default_img = "default.jpg";
$hqdefault_img = "hqdefault.jpg";
$mqdefault_img = "mqdefault.jpg";
$sddefault_img = "sddefault.jpg";
$maxresdefault_img = "maxresdefault.jpg";

//$imageurl = "//img.youtube.com/vi/{$vId}/" . $hqdefault_img;
if (!empty($thumbnail)) {
    $imageurl = JURI::base() . $thumbnail;
}

$vId = 'video_'.$uniqid;
$allow = ""; //"autoplay; encrypted-media";
$allowfullscreen = "allowfullscreen";
$videos_width = "100%";
$videos_height = "315";

$cVideo = "post d-flex col-12 col-sm-6 col-md-6 col-lg-5 order-sm-2 mb-4";
$cColText = "post d-flex align-items-center col-12 col-sm-6 col-md-6 col-lg-7 order-sm-1 mb-4";
?>
<div class="pt-4">
    <div class="row">
        <div class="<?php echo $cVideo; ?>">
            <?php // -- Trigger the modal with a button -- ?>
            <div class="video flex-fill">
                <div class="video__thumbnail item-image zoom">
                    <a class="<?php echo $popup_class; ?>" data-toggle="modal" data-target="#<?php echo trim($vId); ?>" data-theVideo="<?php echo $link; ?>">
                        <img class="hover w-100" src="<?php echo $imageurl; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>">
                        <?php // <div class="shaded"></div> ?>
                        <i class="icon-video fa fa-play-circle fa-3x" aria-hidden="true"></i>
                    </a>
                    <div class="zooming4 text-center"><?php echo $params->get('title'); ?></div>
                </div>
            </div>
        </div>
        <div class="<?php echo $cColText; ?>">
            <div class="flex-fill">
                <?php echo $params->get('description'); ?>
            </div>
        </div>
    </div>
</div>

<?php // --Modal -- ?>
<div id="<?php echo trim($vId); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered gp-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" allow="<?php echo $allow; ?>" <?php echo $allowfullscreen; ?>></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//-- /.Modal -- ?>