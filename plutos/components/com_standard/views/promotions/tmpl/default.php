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
$fakePageHeader = "fake-page-heading";
$headerLevel = "1";

$this->flag = 0;
$this->isMultiForm = false;
?>
<div class="col-12">
    <div class="promotions<?php echo $this->pageclass_sfx; ?>" id="promotions">
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
            <?php $headerLevel = "2"; // set item_title  ?>
        <?php endif; ?>

        <?php if ($headerLevel == "1"): ?>
            <div class="<?php echo $fakePageHeader; ?>"></div>
        <?php endif; ?>

        <?php $leadingcount = 0; ?>
        <?php if (!empty($this->lead_items)) : ?>
            <div class="items-leading clearfix">
                <?php foreach ($this->lead_items as &$item) : ?>
                    <div class="treeview mb-4 leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
                        <?php
                        $this->item = & $item;
                        echo $this->loadTemplate('item');
                        $this->flag = 1;
                        ?>
                    </div>
                    <?php $leadingcount++; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; // end items-leading ?>

        <?php
        $introcount = count($this->intro_items);
        $counter = 0;
        $this->row = 0;
        ?>

        <?php if (!empty($this->intro_items)) : ?>
            <?php foreach ($this->intro_items as $key => &$item) : ?>
                <?php $rowcount = ((int) $key % (int) $this->columns) + 1; ?>
                <?php if ($rowcount === 1) : ?>
                    <?php $row = $counter / $this->columns; ?>
                    <?php $this->row = $row; ?>
                    <div class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?> row">
                    <?php endif; ?>
                    <div class="d-flex col-12 col-lg-<?php echo round(12 / $this->columns); ?>">
                        <div class="item treeview mb-4 column-<?php echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
                            <?php
                            $this->item = & $item;
                            echo $this->loadTemplate('item');
                            $this->flag = 1;
                            ?>
                        </div>
                        <?php // -- end item -- ?>
                        <?php $counter++; ?>
                    </div>
                    <?php // -- end col -- ?>
                    <?php if (($rowcount == $this->columns) or ( $counter == $introcount)) : ?>
                    </div>
                    <?php // -- end row -- ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>


        <?php // --- fix temp --- ?>
        <?php if (!$this->isMultiForm): ?>
            <div class="row">
                <div class="col-12">
                    <div id="section-scrolling-form" class="<?php echo $this->params->get('formclass_sfx'); ?>">
                        <?php // --- form ---   ?>
                        <?php echo $this->loadTemplate('form'); ?>
                        <?php // --- /.form --- ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php // --- /.fix temp --- ?>

        <?php if (!empty($this->link_items)) : ?>
            <div class="items-more">
                <?php echo $this->loadTemplate('links'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
            <div class="pagination navigation justify-content-center ">
                <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                    <p class="counter pull-right">
                        <?php echo $this->pagination->getPagesCounter(); ?>
                    </p>
                <?php endif; ?>
                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
