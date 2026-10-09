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
$sItemLayout = trim($this->params->get('item_layout'));
$this->rowcount = 1;
?>
<div class="col-12">
    <div class="page-featured<?php echo $this->pageclass_sfx; ?>" id="products">
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
            <?php $headerLevel = "2"; // set item_title ?>
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
                        switch ($sItemLayout) {
                            case 'vertical':
                            case 'inline':
                                echo $this->loadTemplate('itemvertical');
                                break;
                            case 'horizontal':
                            default:
                                echo $this->loadTemplate('item');
                                break;
                        }
                        ?>
                    </div>
                    <?php
                    $leadingcount++;
                    ?>
                <?php endforeach; ?>
            </div>
            <?php $this->flagleading = 0; // set state leading Binh Nguyen ?>
        <?php endif; ?>
        <?php
        $introcount = count($this->intro_items);
        $counter = 0;
        ?>
        <?php if (!empty($this->intro_items)) : ?>
            <div class="row items-row cols-<?php echo (int) $this->columns; ?>">
                <?php foreach ($this->intro_items as $key => &$item) : ?>
                    <?php
                    $key = ($key - $leadingcount) + 1;
                    $this->rowcount = (((int) $key - 1) % (int) $this->columns) + 1;
                    $row = $counter / $this->columns;
                    ?>
                    <div class="d-flex col-12 col-lg-<?php echo round(12 / $this->columns); ?>">                        
                        <?php
                        $this->item = &$item;
                        switch ($sItemLayout) {
                            case 'vertical':
                            case 'inline':
                                echo $this->loadTemplate('itemvertical');
                                break;
                            case 'horizontal':
                            default:
                                echo $this->loadTemplate('item');
                                break;
                        }
                        ?>
                        <?php // -- end item -- ?>
                        <?php $counter++; ?>
                    </div>
                    <?php // -- end col -- ?>
                <?php endforeach; ?>
            </div>
            <?php // -- end row -- ?>
        <?php endif; ?>

        <?php if (!empty($this->link_items)) : ?>
            <div class="items-more">
                <?php echo $this->loadTemplate('links'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
            <div class="pagination navigation">
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
