<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$introcount = count($this->related);
$counter = 0;
?>
<div class="related" id="products">
    <?php if (!empty($this->related)) : ?>
        <?php foreach ($this->related as $key => &$item) : ?>
            <?php
            $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

            $item->parent_slug = $item->parent_alias ? ($item->parent_id . ':' . $item->parent_alias) : $item->parent_id;

            // No link for ROOT category
            if ($item->parent_alias === 'root') {
                $item->parent_slug = null;
            }

            $item->catslug = $item->category_alias ? ($item->catid . ':' . $item->category_alias) : $item->catid;
            $item->event = new stdClass;
            $dispatcher = JEventDispatcher::getInstance();

            // Old plugins: Ensure that text property is available
            if (!isset($item->text)) {
                $item->text = $item->introtext;
            }

            $dispatcher->trigger('onContentPrepare', array('com_standard.category', &$item, &$item->params, 0));

            // Old plugins: Use processed text as introtext
            $item->introtext = $item->text;

            $results = $dispatcher->trigger('onContentAfterTitle', array('com_standard.category', &$item, &$item->params, 0));
            $item->event->afterDisplayTitle = trim(implode("\n", $results));

            $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_standard.category', &$item, &$item->params, 0));
            $item->event->beforeDisplayContent = trim(implode("\n", $results));

            $results = $dispatcher->trigger('onContentAfterDisplay', array('com_standard.category', &$item, &$item->params, 0));
            $item->event->afterDisplayContent = trim(implode("\n", $results));
            ?>

            <?php $rowcount = ((int) $key % (int) $this->columns) + 1; ?>
            <?php if ($rowcount === 1) : ?>
                <?php $row = $counter / $this->columns; ?>
                <div class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?> row-fluid clearfix row">
                <?php endif; ?>
                <div class="item d-flex column-<?php echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> col-12 col-sm-<?php echo round((12 / $this->smColumns)); ?>  col-md-<?php echo round((12 / $this->mdColumns)); ?> col-lg-<?php echo round((12 / $this->lgColumns)); ?> col-xl-<?php echo round((12 / $this->xlColumns)); ?>">
                    <div class="d-flex flex-fill rounded border border-color-item mb-4 box-shadow">
                        <?php
                        $this->item = &$item;
                        echo $this->loadTemplate($this->relatedLayout);
                        ?>
                    </div>
                </div>
                <?php $counter++; ?>

                <?php if (($rowcount == $this->columns) or ( $counter == $introcount)) : ?>
                </div><!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
                
        <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
            <div class="pagination navigation">
                <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                    <p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
                <?php endif; ?>
                <?php echo $this->pagination->getPagesLinks(); ?> 
            </div>
        <?php endif; ?>
                
    <?php endif; ?>
</div>