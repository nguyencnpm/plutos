<?php
defined('_JEXEC') or die;

$pageHeader = "page-header";
$headerLevel = "1";
$isItemMasthead = FALSE;
?>

<div class="col-12">
    <div class="confirm-request-page text-center <?php echo $this->pageclass_sfx; ?>">
        <meta itemprop="inLanguage" content="<?php echo ($this->item['language'] === '*') ? JFactory::getConfig()->get('language') : $this->item['language']; ?>" />
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

        <?php if (!empty(trim($this->params->get('page_subheading')))) : ?>
            <div class="<?php echo $pageHeader; ?>">
                <h<?php echo $headerLevel; ?> class="<?php echo $this->params->get('pageclass_subheading'); ?>">
                    <?php echo $this->escape($this->params->get('page_subheading')); ?>
                </h<?php echo $headerLevel; ?>>
                <?php if ($this->params->get('show_item_title_masthead') || $isItemMasthead): ?>
                    <div class="item-title-masthead">&nbsp;</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12 mb-3 <?php echo $this->item['status'] == 1 ? 'confirm' : 'error'; ?>">
                <?php if ($this->item['status']): ?>
                    <?php echo JText::_('COM_STANDARD_CONTACT_CONFIRM'); ?>
                <?php else: ?>
                    <?php echo JText::_('COM_STANDARD_CONTACT_ERROR'); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="more row justify-content-center">
                    <div class="col-auto mb-3">
                        <a class="btn using-btn-danger border-0 radius-0 text-uppercase" href="<?php echo JURI::root(false); ?>" itemprop="url">
                            <?php
                            echo JText::_('COM_STANDARD_HOME_PAGE');
                            ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

