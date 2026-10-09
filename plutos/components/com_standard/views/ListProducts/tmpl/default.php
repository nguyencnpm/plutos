<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

//JHtml::_('behavior.caption');
// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space

$pageHeader = "page-header";
$headerLevel = "1";
$sLayoutForm = trim($this->params->get('layout_form'));
$sItemLayout = trim($this->params->get('item_layout'));
$this->rowcount = 1;

$aCategory = array();
//echo '<pre>';
//print_r($this->params);
//exit;
?>
<div class="col-12">
    <div class="products<?php echo $this->pageclass_sfx; ?>" id="products">
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

        <?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
            <div class="<?php echo $pageHeader; ?>">
                <h<?php echo $headerLevel; ?> class="<?php echo $this->params->get('pageclass_subheading'); ?>">
                    <?php if ((int) $headerLevel == 1): ?>
                        <i class="<?php echo $this->params->get('menu-anchor_css'); ?>" aria-hidden="true"></i>
                    <?php endif; ?>
                    <?php echo nl2br($this->escape($this->params->get('page_subheading'))); ?>
                    <?php if ($this->params->get('show_category_title')) : ?>
                        <span class="subheading-category"><?php echo $this->category->title; ?></span>
                    <?php endif; ?>
                </h<?php echo $headerLevel; ?>>
                <?php if ($this->params->get('show_page_masthead')): ?>
                    <div class="masthead">&nbsp;</div>
                <?php endif; ?>
            </div>
            <?php $headerLevel = "2"; // set item_title   ?>
        <?php endif; ?>

        <?php
        $leadingcount = 0;
        $this->flagleading = 0;
        ?>
        <?php if (!empty($this->lead_items)) : ?>
            <div class="items-leading clearfix">
                <?php foreach ($this->lead_items as &$item) : ?>
                    <div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> clearfix">
                        <?php
                        $this->flagleading = 1;
                        $this->item = &$item;
                        echo $this->loadTemplate('item');
                        ?>
                    </div>
                    <?php
                    $leadingcount++;
                    ?>
                <?php endforeach; ?>
            </div>
            <?php $this->flagleading = 0; // set state leading Binh Nguyen    ?>
        <?php endif; ?>

        <?php if (!empty($this->intro_items)) : ?>
            <div class="items-row cols-<?php $this->columns; ?> row">
                <?php
                // $cColumns = "";
                /*
                  if ($sLayoutForm === "group_items_category"):
                  $cColumns = "d-flex col";
                  endif;
                 */
                ?>
                <?php foreach ($this->intro_items as $key => &$item) : ?>
                    <?php
                    $this->merge_column = (int) $item->merge_column > 1 ? (int) $item->merge_column : 1;
                    $cCol = " col-12 using-col-xs-6 col-sm-6  col-lg-" . (round(12 / (($this->columns - 1) > 0 ? $this->columns - 1 : 1))) * $this->merge_column;
                    if($this->merge_column > 1):
                        $cCol = " col-12 using-col-xs-6 col-sm-12";
                    endif;
                    
                    $cColumns = "d-flex ".$cCol." col-xl-" . (round(12 / $this->columns)) * $this->merge_column;
                    ?>
                    <?php if ($sLayoutForm === "group_items_category"): ?>
                        <?php if (!array_key_exists($item->catid, $aCategory)): ?>
                            <div class="col-12 mb-4">
                                <h3 class="category-title border-bottom">
                                    <div class="w-auto pull-left px-2 py-1 rounded-top bg-category-title"><?php echo $item->category_title; ?></div>
                                    <div class="clearfix"></div>
                                </h3>
                                <?php if (!empty($item->category_description)): ?>
                                    <div class="text-justify-left">
                                        <?php echo $item->category_description; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php $aCategory[$item->catid] = $item->category_title; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="<?php echo $cColumns; ?>">
                        <?php
                        $this->item = &$item;
                        switch ($sItemLayout) {
                            case 'vertical':
                            case 'inline':
                                if ($this->merge_column > 1) {
                                    echo $this->loadTemplate('item');
                                } else {
                                    echo $this->loadTemplate('itemvertical');
                                }
                                break;
                            case 'horizontal':
                            default:
                                echo $this->loadTemplate('item');
                                break;
                        }
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($this->link_items)) : ?>
            <div class="items-more">
                <?php echo $this->loadTemplate('links'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
            <div class="navigation">
                <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                    <p class="counter pull-right">
                        <?php echo $this->pagination->getPagesCounter(); ?>
                    </p>
                <?php endif; ?>
                <div class="pagination justify-content-center ">
                    <?php echo $this->pagination->getPagesLinks(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
