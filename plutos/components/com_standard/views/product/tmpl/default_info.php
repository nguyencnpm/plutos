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
?>
<div class="row">
    <?php
    $class_item_image = "post d-flex col-12 col-sm-6 col-md-5 col-lg-4 mb-3";
    $class_item_text = "post d-flex col-12 col-sm-6 col-md-7 col-lg-8 mb-3";
    ?>
    <?php if (isset($images->image_screen) && !empty($images->image_screen)) : ?>
        <?php $imgfloat = empty($images->float_fulltext) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
        <div class="<?php echo $class_item_image; ?> pull-<?php echo htmlspecialchars($imgfloat); ?> ">
            <?php 
            // echo JLayoutHelper::render('standard.full_image', $this->item); 
            echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => 'galleryChild'));
            ?>
        </div>
    <?php else: ?>
        <?php $class_item_text = "post col-12 mb-3"; ?>
    <?php endif; ?>
    <div class="<?php echo $class_item_text; ?>">
        <div class="col-text flex-fill mb-4">
            <?php
            if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative) :
                echo $this->item->pagination;
            endif;
            ?>
            <?php
            if (isset($this->item->toc)) :
                echo $this->item->toc;
            endif;
            ?>
            <?php //echo $this->item->text; ?>
            <div class="row"> 
                <div class="col-12">
                    <?php echo $this->item->introtext; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php if ($params->get('show_manufacturer') || ($params->get('show_price') || $params->get('show_call_price') || $params->get('show_call_hotline'))) : ?>
                        <div class="info-group-vertical mb-3">
                            <?php if ($params->get('show_manufacturer')) : ?>
                                <p>
                                    <i class="fa fa-building-o text-info" aria-hidden="true"></i> 
                                    <?php echo JText::_('COM_STANDARD_MANUFACTURER') . ': '; ?>
                                    <?php echo empty($this->item->manufacturer_title) ? " - " : $this->item->manufacturer_title; ?>
                                </p>
                            <?php endif; ?>
                            <?php
                            if ($params->get('show_price') || $params->get('show_call_price') || $params->get('show_call_hotline')) :
                                echo JLayoutHelper::render('standard.price', array('item' => $this->item, 'params' => $params));
                            endif;
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    if ($params->get('show_payment_methods')) :
                        echo JLayoutHelper::render('standard.payment_methods', array('item' => $this->item, 'params' => $params, 'step' => 2));
                    endif;
                    ?>
                </div>
            </div>

            <?php if ($info == 1 || $info == 2) : ?>
                <?php if ($useDefList) : ?>
                    <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
                    <?php //echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
                <?php endif; ?>
                <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
                    <?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
                    <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php
            if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative) :
                echo $this->item->pagination;
                ?>
            <?php endif; ?>
            <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) : ?>
                <?php echo $this->loadTemplate('links'); ?>
            <?php endif; ?>
            <?php // Optional teaser intro text for guests ?>
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-12">
        <?php echo $this->item->fulltext; ?>
    </div>
</div>

<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position))) || (empty($urls->urls_position) && (!$params->get('urls_position')))) :
    ?>
    <?php echo $this->loadTemplate('links'); ?>
<?php endif; ?>