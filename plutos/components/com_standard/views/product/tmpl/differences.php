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
$cItemText = "featurette item-text flex-fill text-justify-center";

$pageHeader = "item-header";
$headerLevel = "1";
$isItemPage = true;
?>
<div class="item-page<?php echo $this->pageclass_sfx; ?>">
    <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
    <?php if (isset($this->item->descriptions)): ?>
        <?php
        $data = array();
        $column = (int) $this->item->description_column;
        $oDescriptions = json_decode($this->item->descriptions);
        foreach ($oDescriptions as $oDescription) :
            if (!$oDescription->description_status):
                continue;
            endif;
            $data[] = $oDescription;
        endforeach;
        ?>
        <?php if (sizeof($data) > 0): ?>
            <div class="differences differences-bg-icon-left-bottom">
                <div class="bg-icon-right-top">
                    <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
                        <div class="row">
                            <div class="col-12">
                                <?php if ($this->params->get('show_page_heading')) : ?>
                                    <div class="<?php echo $pageHeader; ?>">
                                        <h<?php echo $headerLevel; ?> class="<?php echo $this->params->get('pageclass_heading'); ?>"> 
                                            <?php if ((int) $headerLevel == 1): ?>
                                                <i class="<?php echo $this->params->get('menu-anchor_css'); ?>" aria-hidden="true"></i> 
                                            <?php endif; ?>
                                            <?php echo $this->escape($this->params->get('page_heading')); ?> 
                                        </h<?php echo $headerLevel; ?>>
                                        <?php if ($this->params->get('show_page_masthead')): ?>
                                            <div class="masthead">&nbsp;</div>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                    $pageHeader = "subheading";
                                    $headerLevel = "2"; // set item_title 
                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="items-row row">
                            <?php foreach ($data as $key => $item) : ?>
                                <?php $rowcount = ((int) $key % (int) $column) + 1; ?>
                                <div class="d-flex col-12 col-lg-<?php echo round(12 / $column); ?>">
                                    <div class="item flex-fill mb-4 column-<?php echo $rowcount; ?>">
                                        <?php if (!empty($item->title)): ?>
                                            <h2 class="item-title cut-string-multiple-lines"><?php echo htmlspecialchars($item->title); ?></h2>
                                            <div class="masthead"></div>
                                        <?php endif; ?>
                                        <div class="content"><?php echo $item->description; ?></div>
                                    </div>
                                    <?php // -- end item --   ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php // --- Book now ---?>
                        <div class="more row pb-3">
                            <?php
                            $link = JRoute::_(StandardHelperRoute::getProductRoute($this->item->slug, $this->item->catid, $this->item->language));
                            ?>
                            <div class="col-12 col-md-4"></div>
                            <div class="col-12 col-md-4">
                                <?php echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'product', 'class' => 'using-md-w-100 mb-3')); ?>
                            </div>
                            <div class="col-12 col-md-4"></div>
                        </div>
                        <?php // --- /.Book now --- ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        <?php else: ?>
            <div class="clearfix mt-5"></div>
        <?php endif; ?>
    <?php else: ?>
        <div class="clearfix mt-5"></div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 mb-5 pl-0 pr-0">
                <?php
                // --- carousel -- 
                if (isset($this->item->galleries)):
                    echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => 'gallery'));
                endif;
                // --- /.carousel -- 
                ?>
            </div>
            <div class="col-lg-6 mt-5 mb-5 pl-lg-5 pr-lg-5">
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
            </div>
        </div>
    </div>
    <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
        <?php // --- Plan --  ?>
        <?php
        $layoutMediaDisplayType = (isset($this->item->plans_mediadisplaytype) && !empty($this->item->plans_mediadisplaytype)) ? $this->item->plans_mediadisplaytype : "singleslides";
        ?>
        <?php // --- fix temp ---  ?>
        <div class="d-none d-lg-block">
            <?php echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => $layoutMediaDisplayType)); ?>
        </div>
        <div class="d-lg-none"> <?php // --- fix temp case phone ---  ?>
            <?php echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => 'singleslides')); ?>
        </div>
        <?php // --- /.fix temp ---  ?>
        <?php // --- /.Plan -- ?>
        <?php // --- Book now ---?>
        <div class="more row mb-5">
            <?php
            $link = JRoute::_(StandardHelperRoute::getProductRoute($this->item->slug, $this->item->catid, $this->item->language));
            ?>
            <div class="col-12 col-md-4"></div>
            <div class="col-12 col-md-4">
                <?php echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'product', 'class' => 'using-md-w-100 mb-3')); ?>
            </div>
            <div class="col-12 col-md-4"></div>
        </div>
        <?php // --- /.Book now --- ?>
    </div>