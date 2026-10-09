<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$params = $this->item->params;
$images = json_decode($this->item->images);
$info = $params->get('info_block_position', 0);

$class_item_media = "post d-flex col-12 col-md-6 col-lg-6 pr-md-0";
$class_item_text = "post d-flex col-12 col-md-6 col-lg-6 pl-md-0";
$cItemText = "featurette flex-fill text-justify-center featurette-bg-icon-medium-left-bottom";


$pageHeader = "item-header";
$headerLevel = 1;
?>
<div class="row">
    <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
        <div class="row">
            <div class="col-12">
                <div class="no-page-heading">
                    <div class="row mb-5">
                        <?php if (isset($images->image_medium) && !empty($images->image_medium)) : ?>
                            <?php $imgfloat = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro; ?>
                            <div class="<?php echo $class_item_media; ?> pull-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?>">
                                <?php echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => 'popupVideo')); ?>
                            </div>
                        <?php else: ?>
                            <?php
                            $class_item_text = "post d-flex col-12";
                            $cItemText = "featurette p-3 text-justify-center";
                            ?>
                        <?php endif; ?>

                        <div class="<?php echo $class_item_text; ?>">
                            <div class="<?php echo $cItemText; ?>">
                                <div class="item-text pl-lg-5 pr-lg-5 bg-icon-medium-right-top">
                                    <?php if ($params->get('show_title') || $params->get('show_author')) : ?>
                                        <?php if ($this->params->get('show_page_heading')) : ?>
                                            <div class="<?php echo $pageHeader; ?>">
                                                <h<?php echo $headerLevel; ?> class="item-title cut-string-multiple-lines <?php echo $this->params->get('pageclass_heading'); ?>"> 
                                                    <?php if ((int) $headerLevel == 1): ?>
                                                        <i class="<?php echo $this->params->get('menu-anchor_css'); ?>" aria-hidden="true"></i> 
                                                    <?php endif; ?>
                                                    <?php echo $this->escape($this->params->get('page_heading')); ?> 
                                                </h<?php echo $headerLevel; ?>>
                                                <?php if ($this->params->get('show_page_masthead')): ?>
                                                    <div class="masthead">&nbsp;</div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                    <?php endif; ?>

                                    <?php echo $this->item->introtext; ?>
                                    <?php echo $this->item->fulltext; ?>

                                    <?php // --- Book now ---?>
                                    <div class="more row justify-content-center">
                                        <?php
                                        $link = JRoute::_(StandardHelperRoute::getProductRoute($this->item->slug, $this->item->catid, $this->item->language));
                                        ?>
                                        <div class="col-12 col-md-auto">
                                            <?php echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'product', 'class' => '')); ?>
                                        </div>
                                    </div>
                                    <?php // --- /.Book now ---?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php // --- Plan -- ?>
                    <?php
                    $layoutMediaDisplayType = (isset($this->item->plans_mediadisplaytype) && !empty($this->item->plans_mediadisplaytype)) ? $this->item->plans_mediadisplaytype : "singleslides";
                    echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => $layoutMediaDisplayType));
                    ?>
                    <?php // --- /.Plan -- ?>
                    <?php
                    $sDisplaytype = $this->aDisplayType[$this->item->plans_displaytype_id];
                    switch ($sDisplaytype) {
                        case 'gridworks':
                            echo $this->loadTemplate('gridworks');
                            break;

                        default:
                            //echo $this->loadTemplate('plan');
                            echo $this->loadTemplate('gridworks');
                            break;
                    }
                    ?>
                    <?php
                    // --- carousel -- 
                    if (isset($this->item->galleries)):
                        echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => 'carouselMutItems'));
                    endif;
                    // --- /.carousel -- 
                    ?>
                    <?php // --- Book now ---?>
                    <div class="more row mb-5">
                        <?php
                        $link = JRoute::_(StandardHelperRoute::getProductRoute($this->item->slug, $this->item->catid, $this->item->language));
                        ?>
                        <?php if (true): // (int) $this->item->paymenttype_id === 11 ?>
                            <div class="col-12 col-md-4"></div>
                            <div class="col-12 col-md-4">
                                <?php echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'product', 'class' => 'using-md-w-100 mb-3')); ?>
                            </div>
                            <div class="col-12 col-md-4"></div>
                        <?php else: ?>
                            <div class="col-12 col-md-2"></div>
                            <div class="col-12 col-md-4">
                                <?php echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'product', 'class' => 'using-md-w-100 mb-3')); ?>
                            </div>
                            <div class="col-12 col-md-4">
                                <?php echo JLayoutHelper::render('standard.detial_noBg', array('item' => $this->item, 'params' => $params, 'link' => $link, 'class' => 'using-md-w-100 mb-3')); ?>
                            </div>
                            <div class="col-12 col-md-2"></div>
                        <?php endif; ?>

                    </div>
                    <?php // --- /.Book now --- ?>
                </div>
            </div>
        </div>
    </div>
</div>