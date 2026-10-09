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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params = $this->item->params;
// $images = json_decode($this->item->images);
// $urls = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user = JFactory::getUser();
$info = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));
//JHtml::_('behavior.caption');
$pageHeader = "page-header";
$headerLevel = "1";
$isItemPage = true;
?>
<div class="col-12">
    <div class="item-page<?php echo $this->pageclass_sfx; ?>">
        <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
        <?php if ($this->params->get('show_page_heading') && !$isItemPage) : ?>
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
        if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative) {
            echo $this->item->pagination;
        }
        ?>

        <?php // Todo Not that elegant would be nice to group the params   ?>
        <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date') || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam);
        ?>

        <?php if (!$useDefList && $this->print) : ?>
            <div id="pop-print" class="btn hidden-print">
                <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
            </div>
            <div class="clearfix"> </div>
        <?php endif; ?>
        <?php if ($params->get('show_title') || $params->get('show_author')) : ?>

            <div class="<?php echo $pageHeader; ?>">
                <?php if ($params->get('show_title')) : ?>
                    <h<?php echo $headerLevel; ?> class="<?php echo $this->params->get('pageclass_subheading'); ?>">
                        <?php echo $this->escape($this->item->title); ?>
                        <?php
                        if (!empty(trim($this->item->subtitle))):
                            echo '<br />';
                            echo $this->escape($this->item->subtitle);
                        endif;
                        ?>
                    </h<?php echo $headerLevel; ?>>
                    <?php if ($this->params->get('show_page_masthead')): ?>
                        <div class="masthead">&nbsp;</div>
                    <?php endif; ?>

                <?php endif; ?>
                <?php if ($this->item->state == 0) : ?>
                    <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
                <?php endif; ?>
                <?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
                    <span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
                <?php endif; ?>
                <?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate()) : ?>
                    <span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
                <?php endif; ?>
            </div>

        <?php endif; ?>
        <?php if (!$this->print) : ?>
            <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
                <?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
            <?php endif; ?>
        <?php else : ?>
            <?php if ($useDefList) : ?>
                <div id="pop-print" class="btn hidden-print">
                    <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php // Content is generated by content plugin event "onContentAfterTitle"   ?>
        <?php echo $this->item->event->afterDisplayTitle; ?>

        <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
            <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
            <?php //echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above'));  ?>
        <?php endif; ?>

        <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
            <?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>

            <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
        <?php endif; ?>

        <?php // Content is generated by content plugin event "onContentBeforeDisplay"   ?>
        <?php echo $this->item->event->beforeDisplayContent; ?>

        <?php if ($params->get('access-view')) : ?>

            <?php echo $this->loadTemplate('info'); ?>

        <?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
            <?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
            <?php echo JHtml::_('content.prepare', $this->item->introtext); ?>
            <?php // Optional link to let them register to see the whole product. ?>
            <?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
                <?php $menu = JFactory::getApplication()->getMenu(); ?>
                <?php $active = $menu->getActive(); ?>
                <?php $itemId = $active->id; ?>
                <?php $link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
                <?php $link->setVar('return', base64_encode(StandardHelperRoute::getProductRoute($this->item->slug, $this->item->catid, $this->item->language))); ?>
                <p class="readmore">
                    <a href="<?php echo $link; ?>" class="register">
                        <?php $attribs = json_decode($this->item->attribs); ?>
                        <?php
                        if ($attribs->alternative_readmore == null) :
                            echo JText::_('COM_STANDARD_REGISTER_TO_READ_MORE');
                        elseif ($readmore = $attribs->alternative_readmore) :
                            echo $readmore;
                            if ($params->get('show_readmore_title', 0) != 0) :
                                echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
                            endif;
                        elseif ($params->get('show_readmore_title', 0) == 0) :
                            echo JText::sprintf('COM_STANDARD_READ_MORE_TITLE');
                        else :
                            echo JText::_('COM_STANDARD_READ_MORE');
                            echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
                        endif;
                        ?>
                    </a>
                </p>
            <?php endif; ?>
        <?php endif; ?>
        <?php
        if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
            echo $this->item->pagination;
            ?>
        <?php endif; ?>
        <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
        <?php echo $this->item->event->afterDisplayContent; ?>

        <?php if ($params->get('show_related') && !empty($this->related)) : ?>
            <div class="clearfix">&nbsp;</div>
            <div class="row items-rows">
                <div class="col-12">
                    <div class="related-title"><h3 class="cut-string-multiple-lines text-center text-danger"><?php echo JText::_('COM_STANDARD_FIELD_RELATED'); ?></h3></div>
                    <div class="extranews_separator"></div>
                    <?php echo $this->loadTemplate('related'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>