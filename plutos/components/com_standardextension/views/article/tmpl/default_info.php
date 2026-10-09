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

$videos = (array) json_decode($this->item->videos);
?>
<div class="row">
    <?php
    $class_item_media = "post col-12 mb-3";
    $class_item_image = "post col-12 mb-3";
    $class_item_text = "post col-12 mb-3";
    ?>

    <?php if (isset($videos[0]->url) && !empty($videos[0]->url)) : ?>
        <?php $imgfloat = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro; ?>
        <div class="<?php echo $class_item_media; ?> pull-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?>">
            <?php echo JLayoutHelper::render('standardextension.media', array('item' => $this->item, 'sublayout' => 'video')); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($images->image_screen) && !empty($images->image_screen)) : ?>
        <?php $imgfloat = empty($images->float_fulltext) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
        <div class="<?php echo $class_item_image; ?> pull-<?php echo htmlspecialchars($imgfloat); ?> ">
            <?php
            echo JLayoutHelper::render('standardextension.content.full_image', $this->item);
            // echo JLayoutHelper::render('standardextension.content.media', array('item' => $this->item, 'sublayout' => 'galleryChild'));
            ?>
        </div>
    <?php else: ?>
        <?php $class_item_text = "post col-12 mb-3"; ?>
    <?php endif; ?>
    <div class="<?php echo $class_item_text; ?>">
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
        <div itemprop="articleBody">
            <?php echo $this->item->text; ?>
        </div>

        <?php if ($info == 1 || $info == 2) : ?>
            <?php if ($useDefList) : ?>
                <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
                <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
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
    </div>
</div>



