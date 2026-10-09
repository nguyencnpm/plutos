<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;
$params = $displayData->params;

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$templateParams = $template->params;
$templateParams->get('tooltip_viewport');

$tooltip = "percent polaroid " . $templateParams->get('tooltip_viewport');

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
?>
<?php $images = json_decode($displayData->images); ?>
<?php if (isset($images->$nameImageSize) && !empty($images->$nameImageSize)) : ?>
    <div class="item-image bg-image mb-4 box-shadow"> <img
            <?php
            /*
            if ($images->image_fulltext_caption) :
                switch ($templateParams->get('tooltip_viewport')) {
                    case 'hasPopover':
                        echo ' title="' . $this->escape($displayData->title) . '"';
                        echo ' data-content="' . htmlspecialchars($images->image_fulltext_caption) . '"';
                        break;

                    default:
                        echo ' title="' . htmlspecialchars($images->image_fulltext_caption) . '"';
                        break;
                }
            endif;
            */
            ?>
            class="<?php echo $tooltip; ?>"
            src="<?php echo htmlspecialchars($images->$nameImageSize); ?>" alt="<?php echo htmlspecialchars(empty($images->image_intro_alt)? $this->escape($displayData->title):$images->image_intro_alt, ENT_COMPAT, 'UTF-8'); ?>" itemprop="image"/> 
    </div>
<?php endif; ?>