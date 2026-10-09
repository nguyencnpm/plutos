<?php
defined('_JEXEC') or die;
/*
  $app = JFactory::getApplication();
  $template = $app->getTemplate(true);
  $templateParams = $template->params;
  $templateParams->get('tooltip_viewport');

  $tooltip = "percent polaroid " . $templateParams->get('tooltip_viewport');
 */
$tooltip = "";
$params = $item->params;
$images = json_decode($item->images);
?>
<?php if (isset($images->image_full) && !empty($images->image_full)) : ?>
    <?php
    $alt = htmlspecialchars(empty($images->image_intro_alt) ? $item->title : $images->image_intro_alt, ENT_COMPAT, 'UTF-8');
    ?>
    <img class="<?php echo $tooltip; ?>" src="<?php echo htmlspecialchars($images->image_full); ?>"  alt="<?php echo $alt; ?>">
<?php endif; ?>