<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$pageHeader = "page-header";
$headerLevel = "1";
?>
<div class="col-12">
    <div class="contact-page<?php echo $this->pageclass_sfx; ?>">
        <?php if ($this->params->get('show_page_heading')) : ?>
            <div class="<?php echo $pageHeader; ?>">
                <h<?php echo $headerLevel; ?> class="<?php echo $this->params->get('pageclass_heading'); ?>"> 
                    <span class="<?php echo $this->params->get('menu-anchor_css'); ?>"></span> <?php echo $this->escape($this->params->get('page_heading')); ?> 
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
        <div class="row">
            <div class="<?php echo $this->cContactForm; ?>">
                <?php // bg-info-form box-shadow ?>
                <div class="flex-fill mb-3">
                    <?php echo $this->loadTemplate('form'); ?>
                </div>
            </div>
            <?php if ($this->isRenderModuleEnabled): ?>
                <div class="<?php echo $this->cRenderModule; ?>">
                    <?php // bg-info-contact box-shadow ?>
                    <div class="flex-fill mb-3">
                        <?php echo $this->loadTemplate('rendermodule'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>