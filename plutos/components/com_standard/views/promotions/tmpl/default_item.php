<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;

$images = json_decode($this->item->images);
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');

$info = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));

$columns = (int) $this->columns;

$isStringhandling = false;
$introtext = $this->item->introtext;
$introlengthtext = $this->item->introtext;
if ($isStringhandling):
    if (!class_exists('Stringhandling')) {
        jimport("informationtechnology.stringhandling.stringhandling");
    }
    //$mobile = new MobileDetect();
    // Desktop - default
    $numberwords = 200;
    /*
      // Phone
      if ($mobile->isMobile()) {
      $numberwords = 200;
      }
      // Tablet
      if ($mobile->isTablet()) {
      $numberwords = 130;
      }
     */
    $moretxt = "...";
    $lengthtitles = round(80 / ($columns == 1 ? $columns + 1 : $columns));
    $lengthReadmoreText = round($numberwords / ($columns == 1 ? $columns + 1 : $columns));
    $lengthtext = round(1230 / ($columns == 1 ? $columns + 1 : $columns));

    $introtext = Stringhandling::trimString($this->item->introtext, $lengthReadmoreText);
    $introlengthtext = Stringhandling::trimString($this->item->introtext, $lengthtext);
endif;

//echo '<pre>';
//print_r($this->item);
//exit;
?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate()) || ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) :
    ?>
    <div class="system-unpublished">
    <?php endif; ?>
    <?php
    $class_item_media = "post d-flex col-12 col-md-6 col-lg-4";
    $class_item_media .= " pr-md-0";
    //$class_item_media .= ($this->row % 2) > 0 ? " order-md-2 pl-md-0" : " pr-md-0";

    $class_item_text = "post d-flex col-12 col-md-6 col-lg-8";
    $class_item_text .= " pl-md-0";
    // $class_item_text .= ($this->row % 2) > 0 ? " order-md-1 pr-md-0" : " pl-md-0";

    $cItemText = "featurette d-flex item-text text-justify-center"; // align-items-center 
    ?>
    <div class="row">
        <?php if (isset($images->image_medium) && !empty($images->image_medium)) : ?>
            <?php $imgfloat = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro; ?>
            <div class="<?php echo $class_item_media; ?> pull-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?>">
                <?php // echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => 'galleryChild'));   ?>
                <?php echo JLayoutHelper::render('standard.promotionIntro_image', $this->item); ?>
            </div>
        <?php else: ?>
            <?php
            $class_item_text = "post d-flex col-12";
            $cItemText = "featurette d-flex p-3 text-justify-center"; // align-items-center 
            ?>
        <?php endif; ?>
        <div class="<?php echo $class_item_text; ?>">
            <div class="<?php echo $cItemText; ?>">
                <div class="flex-fill">
                    <?php //-- start title --    ?>
                    <?php echo JLayoutHelper::render('standard.promotion_styleItemTitle', $this->item); ?>

                    <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
                        <?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
                    <?php endif; ?>

                    <?php if ($params->get('show_tags') && !empty($this->item->tags->itemTags)) : ?>
                        <?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
                    <?php endif; ?>

                    <?php // Todo Not that elegant would be nice to group the params     ?>
                    <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date') || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam);
                    ?>

                    <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
                        <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block  ?>
                        <?php //echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
                    <?php endif; ?>

                    <?php if (!$params->get('show_intro')) : ?>
                        <?php // Content is generated by content plugin event "onContentAfterTitle"  ?>
                        <?php echo $this->item->event->afterDisplayTitle; ?>
                    <?php endif; ?>
                    <!-- end title -->
                    <div class="info-group-vertical mb-3">
                        <?php
                        if ($params->get('show_price') || $params->get('show_call_price') || $params->get('show_call_hotline')) :
                            echo JLayoutHelper::render('standard.rate', array('item' => $this->item, 'params' => $params, 'sublayout' => 'promotionrate', 'class' => 'featurette'));
                        endif;
                        ?>
                        <?php
                        $startDate = JHtml::_('date', trim($this->item->start_date), JText::_('TPL_DAY_MONTH_FORMAT'));
                        $expiryDate = JHtml::_('date', trim($this->item->expiry_date), JText::_('TPL_DAY_MONTH_YEAR_FORMAT'));
                        echo JText::sprintf('COM_STANDARD_PROMOTION_VALID_FROM_TO', $startDate, $expiryDate);
                        ?>
                    </div>
                    <?php // Content is generated by content plugin event "onContentBeforeDisplay"      ?>
                    <?php // echo $this->item->event->beforeDisplayContent; ?>

                    <?php //echo $this->item->introtext;    ?>
                    <?php echo $introtext; ?>

                    <?php // --- Book now - Learn more ---  ?>
                    <div class="more row justify-content-center">
                        <?php
                        $collapseIn = $this->flag == 0 ? "" : ""; // show
                        $faIcon = $this->flag == 0 ? "fa-caret-up" : "fa-caret-down"; // "fa-minus" : "fa-plus";
                        $eActive = $this->flag == 0 ? "is-active" : "deeper";
                        $keyCollapse = 'key-promotion-' . $this->item->id;
                        $this->keyForm = 'key-form-' . $this->item->id;
                        $link = "#section-scrolling-form"; // JRoute::_(StandardHelperRoute::getProductRoute($this->item->slug, $this->item->catid, $this->item->language));
                        
                        ?>
                        <div class="col-auto">
                            <?php if ($this->isMultiForm): ?>
                                <div class="accordion__item <?php echo $eActive; ?>">
                                    <div class="accordion-more accordion-treeview" role="button" data-toggle="collapse"> <?php //  more{$key % 2}                      ?>
                                        <?php echo JLayoutHelper::render('standard.booknow_collapse', array('item' => $this->item, 'params' => $params, 'link' => $keyCollapse, 'sublayout' => 'promotion', 'class' => ' mb-3 check-forms', 'attributes' => 'data-toggle="collapse" data-keyform=' . $this->keyForm)); ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php echo JLayoutHelper::render('standard.booknow', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'promotion', 'class' => ' mb-3 check-forms')); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php // --- /.Book now - Learn more ---  ?>

                    <?php /*
                      if ($params->get('show_readmore')) :// && $this->item->readmore
                      if ($params->get('access-view')) :
                      $link = JRoute::_(StandardHelperRoute::getProductRoute($this->item->slug, $this->item->catid, $this->item->language));
                      else :
                      $menu = JFactory::getApplication()->getMenu();
                      $active = $menu->getActive();
                      $itemId = $active->id;
                      $link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
                      $link->setVar('return', base64_encode(StandardHelperRoute::getProductRoute($this->item->slug, $this->item->catid, $this->item->language)));
                      endif;
                      ?>

                      <?php echo JLayoutHelper::render('standard.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

                      <?php endif; */ ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->isMultiForm): ?>
        <div class="row">
            <div class="col-12">
                <div id="<?php echo $keyCollapse; ?>" class="collapse <?php echo $collapseIn; ?> <?php echo $this->params->get('formclass_sfx'); ?>" role="tabpanel">
                    <?php // --- form ---   ?>
                    <?php echo $this->loadTemplate('form'); ?>
                    <?php // --- /.form --- ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate()) || ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) :
        ?>
    </div>
<?php endif; ?>

<?php // Content is generated by content plugin event "onContentAfterDisplay"       ?>
<?php echo $this->item->event->afterDisplayContent; ?>
