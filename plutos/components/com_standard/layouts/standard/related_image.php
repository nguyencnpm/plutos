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
// $params = $displayData['params'];
$item = $displayData['item'];
$params = $item->params;

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$templateParams = $template->params;
$templateParams->get('tooltip_viewport');

$tooltip = "hover percent polaroid " . $templateParams->get('tooltip_viewport');

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
<?php $images = json_decode($item->images); ?>
<?php if (isset($images->$nameImageSize) && !empty($images->$nameImageSize)) : ?>
    <div class="<?php echo isset($displayData['class'])? $displayData['class']:""; ?>">
        <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
            <a href="<?php echo JRoute::_(StandardHelperRoute::getProductRoute($item->slug, $item->catid, $item->language)); ?>"><img
                <?php
                /*
                  if ($images->image_intro_caption) :
                  switch ($templateParams->get('tooltip_viewport')) {
                  case 'hasPopover':
                  echo ' title="' . $this->escape($item->title) . '"';
                  echo ' data-content="' . htmlspecialchars($images->image_intro_caption) . '"';
                  break;

                  default:
                  echo ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
                  break;
                  }
                  else:
                  switch ($templateParams->get('tooltip_viewport')) {
                  case 'hasPopover':
                  echo ' title="' . $this->escape($item->title) . '"';
                  echo ' data-content="' . htmlspecialchars($item->introtext, ENT_COMPAT, 'UTF-8') . '"';
                  break;

                  default:
                  echo ' title="' . htmlspecialchars($item->introtext, ENT_COMPAT, 'UTF-8') . '"';
                  break;
                  }
                  endif;
                 */
                ?>
                    class="<?php echo $tooltip; ?> <?php echo isset($displayData['subClass'])? $displayData['subClass']:""; ?>"
                    src="<?php echo htmlspecialchars($images->$nameImageSize, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(empty($images->image_intro_alt) ? $this->escape($item->title) : $images->image_intro_alt, ENT_COMPAT, 'UTF-8'); ?>" itemprop="thumbnailUrl"/></a>
        <?php else : ?><img
            <?php
            /*
              if ($images->image_intro_caption) :
              switch ($templateParams->get('tooltip_viewport')) {
              case 'hasPopover':
              echo ' title="' . $this->escape($item->title) . '"';
              echo ' data-content="' . htmlspecialchars($images->image_intro_caption) . '"';
              break;

              default:
              echo ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
              break;
              }
              else:
              switch ($templateParams->get('tooltip_viewport')) {
              case 'hasPopover':
              echo ' title="' . $this->escape($item->title) . '"';
              echo ' data-content="' . htmlspecialchars($item->introtext, ENT_COMPAT, 'UTF-8') . '"';
              break;

              default:
              echo ' title="' . htmlspecialchars($item->introtext, ENT_COMPAT, 'UTF-8') . '"';
              break;
              }
              endif;
             */
            ?>
                class="<?php echo $tooltip; ?>"
                src="<?php echo htmlspecialchars($images->$nameImageSize, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(empty($images->image_intro_alt) ? $this->escape($item->title) : $images->image_intro_alt, ENT_COMPAT, 'UTF-8'); ?>" itemprop="thumbnailUrl"/>
            <?php endif; ?>
    </div>
<?php endif; ?>

