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

$tooltip = "hover percent polaroid h-100 object-fit-cover " . $templateParams->get('tooltip_viewport');
$isShowTooltipImage = false;

//$mobile = new MobileDetect();
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
    <?php
    $sTooltip = "";
    if ($isShowTooltipImage):
        if ($images->image_intro_caption) :
            switch ($templateParams->get('tooltip_viewport')) {
                case 'hasPopover':
                    $sTooltip .= ' title="' . $this->escape($displayData->title) . '"';
                    $sTooltip .= ' data-content="' . htmlspecialchars($images->image_intro_caption) . '"';
                    break;

                default:
                    $sTooltip .= ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
                    break;
            }
        else:
            switch ($templateParams->get('tooltip_viewport')) {
                case 'hasPopover':
                    $sTooltip .= ' title="' . $this->escape($displayData->title) . '"';
                    $sTooltip .= ' data-content="' . htmlspecialchars($displayData->introtext, ENT_COMPAT, 'UTF-8') . '"';
                    break;

                default:
                    $sTooltip .= ' title="' . htmlspecialchars($displayData->introtext, ENT_COMPAT, 'UTF-8') . '"';
                    break;
            }
        endif;
    endif;
    ?>
    <div class="item-image bg-image zoom w-100">
        <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
            <a href="<?php echo JRoute::_(StandardHelperRoute::getItineraryRoute($displayData->slug, $displayData->itinerarytype_id, $displayData->language)); ?>"><img
                <?php echo $sTooltip; ?>
                    class="<?php echo $tooltip; ?>"
                    src="<?php echo htmlspecialchars($images->$nameImageSize, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(empty($images->image_intro_alt) ? $this->escape($displayData->title) : $images->image_intro_alt, ENT_COMPAT, 'UTF-8'); ?>" itemprop="thumbnailUrl"/></a>
        <?php else : ?><img
            <?php echo $sTooltip; ?>
                class="<?php echo $tooltip; ?>"
                src="<?php echo htmlspecialchars($images->$nameImageSize, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(empty($images->image_intro_alt) ? $this->escape($displayData->title) : $images->image_intro_alt, ENT_COMPAT, 'UTF-8'); ?>" itemprop="thumbnailUrl"/>
            <?php endif; ?>
    </div>
<?php endif; ?>

