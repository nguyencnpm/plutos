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

<?php if (!empty($this->related)) : ?>
    <?php if ($this->layoutType): ?>
        <?php
        $cCarouselItem = "carousel-multiple-item carousel-item";
        $cCarouselItem .= (int) $this->params->get('related_xs_num_columns') > 0 ? ' col-' . round(12 / (int) $this->params->get('related_xs_num_columns')) : ' col-12';
        $cCarouselItem .= (int) $this->params->get('related_sm_num_columns') > 0 ? ' col-sm-' . round(12 / (int) $this->params->get('related_sm_num_columns')) : ' col-sm-12';
        $cCarouselItem .= (int) $this->params->get('related_md_num_columns') > 0 ? ' col-md-' . round(12 / (int) $this->params->get('related_md_num_columns')) : ' col-md-12';
        $cCarouselItem .= (int) $this->params->get('related_lg_num_columns') > 0 ? ' col-lg-' . round(12 / (int) $this->params->get('related_lg_num_columns')) : ' col-lg-12';
        $cCarouselItem .= (int) $this->params->get('related_xl_num_columns') > 0 ? ' col-xl-' . round(12 / (int) $this->params->get('related_xl_num_columns')) : ' col-xl-12';
        
        $uniqid = "related";
        $keyCarousel = 'carousel-multiple-items-' . $uniqid;
        $cCarousel = "carousel-multiple-items carousel mb-5";
        // $cCarouselItem = "carousel-multiple-item carousel-item col-12 col-sm-6 col-md-4 col-lg-3";
        $cImg = "img-fluid mx-auto d-block";

        $flag = 0;
        $slides = "";
        $cActive = "";
        $countSlider = $introcount;

        $autoplay = 1;
        $interval = $autoplay == 1 ? "" : " data-interval=\"false\" ";

        if ($countSlider > 1) {
            $cCarousel .= " touch-swipe slide "; //   . $params->get('effect')
        }
        ?>
        <div id="<?php echo $keyCarousel; ?>" class="row <?php echo $cCarousel; ?>" data-ride="carousel" <?php echo $interval; ?>>
            <div class="carousel-inner w-100 mx-auto d-flex" role="listbox">
                <?php foreach ($this->related as $key => &$item) : ?>
                    <?php
                    $cActive = $flag === 0 ? "active" : "";

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
                    /*
                      $dispatcher->trigger('onContentPrepare', array('com_standard.category', &$item, &$item->params, 0));

                      // Old plugins: Use processed text as introtext
                      $item->introtext = $item->text;

                      $results = $dispatcher->trigger('onContentAfterTitle', array('com_standard.category', &$item, &$item->params, 0));
                      $item->event->afterDisplayTitle = trim(implode("\n", $results));

                      $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_standard.category', &$item, &$item->params, 0));
                      $item->event->beforeDisplayContent = trim(implode("\n", $results));

                      $results = $dispatcher->trigger('onContentAfterDisplay', array('com_standard.category', &$item, &$item->params, 0));
                      $item->event->afterDisplayContent = trim(implode("\n", $results));
                     */
                    ?>
                    <div class="<?php echo $cCarouselItem; ?> <?php echo $cActive; ?>">
                        <div class="item d-flex flex-fill rounded border border-color-item mb-4 box-shadow">
                            <?php
                            $this->item = &$item;
                            echo $this->loadTemplate($this->relatedLayout);
                            ?>
                        </div>
                    </div>
                    <?php $flag = 1; ?>
                <?php endforeach; ?>  
            </div>
            <?php // --- co thoi gian viet js xu ly cho nay --- ?>
            <?php if ($countSlider > 3): ?>
                <a class="carousel-control-prev" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="prev">
                    <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo JText::_('Previous') ?></span>
                </a>
                <a class="carousel-control-next" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="next">
                    <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo JText::_('Next') ?></span>
                </a>
            <?php elseif ($countSlider > 2): ?>
                <a class="carousel-control-prev d-lg-none" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="prev">
                    <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo JText::_('Previous') ?></span>
                </a>
                <a class="carousel-control-next d-lg-none" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="next">
                    <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo JText::_('Next') ?></span>
                </a>
            <?php elseif ($countSlider > 1): ?>
                <a class="carousel-control-prev d-md-none" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="prev">
                    <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo JText::_('Previous') ?></span>
                </a>
                <a class="carousel-control-next d-md-none" href="#<?php echo $keyCarousel; ?>" role="button" data-slide="next">
                    <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo JText::_('Next') ?></span>
                </a>
            <?php endif; ?>
            <?php // --- /.co thoi gian viet js xu ly cho nay ---  ?>
        </div><!-- end row -->
    <?php else: ?>
        <div class="row items-row">
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
                /*
                  $dispatcher->trigger('onContentPrepare', array('com_standard.category', &$item, &$item->params, 0));

                  // Old plugins: Use processed text as introtext
                  $item->introtext = $item->text;

                  $results = $dispatcher->trigger('onContentAfterTitle', array('com_standard.category', &$item, &$item->params, 0));
                  $item->event->afterDisplayTitle = trim(implode("\n", $results));

                  $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_standard.category', &$item, &$item->params, 0));
                  $item->event->beforeDisplayContent = trim(implode("\n", $results));

                  $results = $dispatcher->trigger('onContentAfterDisplay', array('com_standard.category', &$item, &$item->params, 0));
                  $item->event->afterDisplayContent = trim(implode("\n", $results));
                 */
                ?>

                <div class="d-flex <?php echo $item->state == 0 ? ' system-unpublished' : null; ?> col-<?php echo round((12 / $this->xsColumns)); ?> col-sm-<?php echo round((12 / $this->smColumns)); ?>  col-md-<?php echo round((12 / $this->mdColumns)); ?> col-lg-<?php echo round((12 / $this->lgColumns)); ?> col-xl-<?php echo round((12 / $this->xlColumns)); ?>">
                    <div class="item d-sm-flex flex-fill rounded border border-color-item mb-4 box-shadow">
                        <?php
                        $this->item = &$item;
                        echo $this->loadTemplate($this->relatedLayout);
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>  
        </div><!-- end row -->
    <?php endif; ?>

<?php endif; ?>
