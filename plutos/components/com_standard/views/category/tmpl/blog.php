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

$dispatcher = JEventDispatcher::getInstance();

$this->category->text = $this->category->description;
$dispatcher->trigger('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $dispatcher->trigger('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$pageHeader = "page-header";
$headerLevel = "1";

$this->rowcount = 1;
?>
<div class="col-12">
    <div id="products" class="blog<?php echo $this->pageclass_sfx; ?>">
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
                    <?php echo $this->escape($this->params->get('page_subheading')); ?>
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
        <?php echo $afterDisplayTitle; ?>

        <?php if (!empty($this->category->description)): ?>
            <div class="using-max-width-sm mx-auto text-justify-center">
                <?php echo $this->category->description; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
            <?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
            <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
        <?php endif; ?>

        <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
            <div class="category-desc clearfix">
                <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                    <img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
                <?php endif; ?>
                <?php echo $beforeDisplayContent; ?>
                <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                    <?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
                <?php endif; ?>
                <?php echo $afterDisplayContent; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
            <?php if ($this->params->get('show_no_products', 1)) : ?>
                <p><?php echo JText::_('COM_STANDARD_NO_PRODUCTS'); ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <?php $leadingcount = 0; ?>
        <?php if (!empty($this->lead_items)) : ?>
            <div class="items-leading clearfix">
                <?php foreach ($this->lead_items as &$item) : ?>
                    <div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
                        <?php
                        $this->item = & $item;
                        echo $this->loadTemplate('item');
                        ?>
                    </div>
                    <?php $leadingcount++; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; // end items-leading ?>

        <?php
        $introcount = count($this->intro_items);
        $counter = 0;
        ?>

        <?php if (!empty($this->intro_items)) : ?>
            <div class="items-row row">
                <?php foreach ($this->intro_items as $key => &$item) : ?>
                    <?php
                    $this->merge_column = (int) $item->merge_column > 1 ? (int) $item->merge_column : 1;
                    $cCol = " col-12 using-col-xs-6 col-sm-6  col-lg-" . (round(12 / (($this->columns - 1) > 0 ? $this->columns - 1 : 1))) * $this->merge_column;
                    if ($this->merge_column > 1):
                        $cCol = " col-12 using-col-xs-6 col-sm-12";
                    endif;

                    $cColumns = "d-flex " . $cCol . " col-xl-" . (round(12 / $this->columns)) * $this->merge_column;
                    ?>

                    <?php
                    $key = ($key - $leadingcount) + 1;
                    $rowcount = (((int) $key - 1) % (int) $this->columns) + 1;
                    $row = $counter / $this->columns;

                    //if ($rowcount === 1) :
                    ?>
                    <?php //echo "<div class=\"items-row cols-{$this->columns} row-{$row} row-fluid row\">"; ?>
                    <?php //endif; ?>
                    <div class="<?php echo $cColumns; ?>">

                        <?php
                        $this->item = &$item;
                        if ($this->merge_column > 1) {
                            echo $this->loadTemplate('item');
                        } else {
                            echo $this->loadTemplate('itemvertical');
                        }
                        ?>

                        <?php $counter++; ?>
                    </div><?php // -- end span --          ?>
                    <?php //if (($rowcount == $this->columns) or ( $counter == $introcount)) : ?>
                    <?php //echo "</div>";?>
                    <?php // -- end row --      ?>
                    <?php //endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($this->link_items)) : ?>
            <div class="items-more">
                <?php echo $this->loadTemplate('links'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
            <div class="cat-children">
                <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
                    <h3> <?php echo JText::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
                <?php endif; ?>
                <?php echo $this->loadTemplate('children'); ?> </div>
        <?php endif; ?>
        <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
            <div class="pagination navigation">
                <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                    <p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
                <?php endif; ?>
                <?php echo $this->pagination->getPagesLinks(); ?> </div>
        <?php endif; ?>
    </div>
</div>