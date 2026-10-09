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
            <?php $this->flagleading = 0; // set state leading Binh Nguyen  ?>
        <?php endif; ?>
        <?php
        $introcount = count($this->intro_items);
        $counter = 0;
        ?>
        <?php if (!empty($this->intro_items)) : ?>
            <?php foreach ($this->intro_items as $key => &$item) : ?>

                <?php
                $key = ($key - $leadingcount) + 1;
                $rowcount = (((int) $key - 1) % (int) $this->columns) + 1;
                $row = $counter / $this->columns;

                if ($rowcount === 1) :
                    ?>
                    <div class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?> row-fluid row">
                    <?php endif; ?>
                    <div class="d-flex span<?php echo round(12 / $this->columns); ?> col-lg-<?php echo round(12 / $this->columns); ?>">
                        <div class="item d-flex flex-fill rounded border border-color-item mb-4 box-shadow column-<?php echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
                            <?php
                            $this->item = &$item;
                            echo $this->loadTemplate('item');
                            ?>
                        </div><?php // -- end item --   ?>
                        <?php $counter++; ?>
                    </div><?php // -- end span --      ?>
                    <?php if (($rowcount == $this->columns) or ( $counter == $introcount)) : ?>
                    </div><?php // -- end row --      ?>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($this->link_items)) : ?>
            <div class="items-more">
                <?php echo $this->loadTemplate('links'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
            <div class="pagination navigation justify-content-center">
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
