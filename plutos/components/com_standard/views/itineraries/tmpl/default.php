<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// JHtml::_('behavior.caption');
// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
$pageHeader = "page-header";
$fakePageHeader = "fake-page-heading";
$headerLevel = "1";
// set here case(leading or intro)
$iItineraryTypeID = 0;
$sItemLayout = trim($this->params->get('item_layout'));
$this->flagleading = 0;
$this->flagintro = 0;
$this->rowcount = 1;
$rowcount = 1;
$rowcountEnd = 0;

$leadingcount = 0;
//echo '<pre>';
//print_r($this->params);
//exit;
?>
<div class="blog-itineraries<?php echo $this->pageclass_sfx; ?>">
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
            </div>
        </div>
    </div>

    <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
        <div class="row">
            <div class="col-12">
                <?php if (!empty($this->lead_items)) : ?>
                    <div class="items-leading clearfix <?php echo!empty($this->leading_medialayoutelement) ? $this->leading_medialayoutelement . " mx-auto" : ""; ?>">
                        <?php foreach ($this->lead_items as &$item) : ?>
                            <?php
                            $this->flagleading = 1;
                            ?>
                            <?php if ((int) $item->itinerarytype_id != $iItineraryTypeID): ?>
                                <?php if (((int) $item->itinerarytype_id != $iItineraryTypeID) && $iItineraryTypeID > 0): //End items row?>
                                    <div class="clearfix mb-4"></div>
                                <?php endif; ?>
                                <?php
                                $this->item = &$item;
                                echo $this->loadTemplate('itinerarytype');
                                $iItineraryTypeID = (int) $item->itinerarytype_id;
                                ?>
                            <?php endif; ?>
                            <div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> clearfix">
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
                            </div>
                            <?php
                            $leadingcount++;
                            ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php $introcount = count($this->intro_items); ?>
                <?php if (!empty($this->intro_items)) : ?>
                    <?php
                    $counter = 0;
                    ?>
                    <?php foreach ($this->intro_items as $key => &$item) : ?>
                        <?php $this->flagintro = 1; ?>
                        <?php
                        $this->merge_column = (int) $item->merge_column > 1 ? (int) $item->merge_column : 1;

                        $key = ($key - $leadingcount) + 1;
                        $this->rowcount = (((int) $key - 1) % ((int) $this->intro_columns + ($this->merge_column - 1))) + 1;
                        $row = $counter / $this->intro_columns;
                        ?>
                        <?php if ((int) $item->itinerarytype_id != $iItineraryTypeID): ?>
                            <?php if (((int) $item->itinerarytype_id != $iItineraryTypeID) && $iItineraryTypeID > 0): //End items row?>
                                <?php
                                if ($rowcount === 0):
                                    echo "</div>";
                                endif;
                                ?>
                                <div class="clearfix mb-4"></div>
                            <?php endif; ?>
                            <?php
                            $this->item = &$item;
                            echo $this->loadTemplate('itinerarytype');

                            $iItineraryTypeID = (int) $item->itinerarytype_id;
                            $rowcount = 1;
                        else:
                            if (!empty($this->lead_items) && $this->flagleading === 1) :
                                $this->flagleading = 0;
                                $rowcount = (((int) $key - 1) % ((int) $this->intro_columns + ($this->merge_column - 1))) + 1;
                            else:
                                $rowcount = 0;
                            endif;
                            ?>
                        <?php endif; ?>

                        <?php
                        if ($rowcount === 1) :
                            ?>
                            <?php if (!empty($this->intro_medialayoutelement)): ?>
                                <div class="mx-auto <?php echo $this->intro_medialayoutelement; ?>">
                                <?php endif; ?>
                                <div class="items-row cols-<?php echo (int) $this->intro_columns; ?> <?php echo 'row-' . $row; ?> row">
                                <?php endif; ?>
                                <div class="d-flex col-12 col-lg-<?php echo (round(12 / $this->intro_columns)) * $this->merge_column; ?>">
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
                                    <?php $counter++; ?>
                                </div>
                                <?php // -- end col --    ?>
                                <?php //if (($rowcount == $this->intro_columns) or ( $counter == $introcount)) :  ?>
                                <?php if ($counter == $introcount) : ?>
                                </div>
                                <?php if (!empty($this->intro_medialayoutelement)): ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $endcount = count($this->end_items); ?>
    <?php if (!empty($this->end_items)) : ?>

        <?php
        $counter = 0;
        ?>
        <?php foreach ($this->end_items as $key => &$item) : ?>
            <?php
            $this->merge_column = (int) $item->merge_column > 1 ? (int) $item->merge_column : 1;

            $key = ($key - ($leadingcount + $introcount)) + 1;
            $this->rowcount = (((int) $key - 1) % ((int) $this->end_columns + ($this->merge_column - 1))) + 1;
            $row = $counter / $this->end_columns;
            ?>
            <?php if ((int) $item->itinerarytype_id != $iItineraryTypeID): ?>
                <?php if (((int) $item->itinerarytype_id != $iItineraryTypeID) && $iItineraryTypeID > 0): //End items row?>
                    <?php
                    if ($rowcount === 0):
                        echo "</div>";
                    endif;
                    ?>
                    <div class="clearfix mb-4"></div>
                <?php endif; ?>
                <?php
                $this->item = &$item;

                if (false):// show itinerary type
                    echo $this->loadTemplate('itinerarytype');
                endif;


                $iItineraryTypeID = (int) $item->itinerarytype_id;

                $rowcount = 1;
            else:
                if (!empty($this->lead_items) && $this->flagleading === 1 && $this->flagintro === 1) :
                    $this->flagleading = 0;
                    $this->flagintro = 0;
                    $rowcount = (((int) $key - 1) % ((int) $this->end_columns + ($this->merge_column - 1))) + 1;
                else:
                    $rowcount = 0;
                endif;
                ?>
            <?php endif; ?>

            <?php
            if ($rowcount === 1) :
                ?>
                <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : empty($this->end_medialayoutelement) ? '-fluid' : ''); ?>">
                    <div class="row">
                        <div class="col-12">
                            <?php if (!empty($this->end_medialayoutelement)): ?>
                                <div class="mx-auto <?php echo $this->end_medialayoutelement; ?>">
                                <?php endif; ?>
                                <div class="items-row cols-<?php echo (int) $this->end_columns; ?> <?php echo 'row-' . $row; ?>  row">
                                <?php endif; ?>

                                <?php $this->item = &$item; ?>
                                <div class="d-none d-lg-block col-12 col-lg-<?php echo (round(12 / $this->end_columns)) * $this->merge_column; ?>">
                                    <?php echo $this->loadTemplate('itemBackgroundOverflowScreen'); ?>
                                </div>
                                <div class="d-flex d-lg-none col-12 col-lg-<?php echo (round(12 / $this->end_columns)) * $this->merge_column; ?>">
                                    <?php echo $this->loadTemplate('itemoverflowscreen'); ?>
                                </div>
                                <?php $counter++; ?>
                            </div>
                            <?php // -- end col --     ?>
                            <?php //if (($rowcount == $this->end_columns) or ( $counter == $endcount)) :  ?>
                            <?php if ($counter == $endcount) : ?>
                            </div>
                            <?php if (!empty($this->end_medialayoutelement)): ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($this->link_items) || ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1))) : ?>
    <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
        <div class="row">
            <div class="col-12">
                <?php if (!empty($this->link_items)) : ?>
                    <div class="items-more">
                        <?php echo $this->loadTemplate('links'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
                    <div class="pagination">

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
    </div>
<?php endif; ?>
</div>