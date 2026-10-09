<?php
defined('_JEXEC') or die;

// Initialise rela
// ted data.
$catid = 1;
// JHtml::_('script', 'jui/treeselectmenu.jquery.min.js', false, true);

$app = JFactory::getApplication();

$app->setUserState('this_itemId', $this->item->id);
$app->setUserState('routerate_arr_route_' . $this->item->id . '_' . $this->item->catid, $this->item->route_ids);

$app->setUserState('productrate_arr_productcategory_' . $this->item->id . '_' . $this->item->catid, $this->item->product_ids);
?>
<fieldset class="form-vertical">
    <div class="row-fluid">
        <div class="span12"><?php echo $this->form->getControlGroup('contractgroup_id'); ?></div>
    </div>
    <hr class="hr-condensed" />
    <div class="row-fluid">
        <div class="span12"><?php echo $this->form->getControlGroup('catid'); ?></div>
    </div>
    
    <div class="row-fluid">
        <div class="span12">
            <div class="form-inline">
                <span class="small">
                    <?php echo JText::_('COM_STANDARD_LABEL_SELECT'); ?>:
                    <a href="javascript://" id="treeCheckAllRoute"><?php echo JText::_('JALL'); ?></a>,
                    <a href="javascript://" id="treeUncheckAllRoute"><?php echo JText::_('JNONE'); ?></a>
                </span>
            </div>
            <div class="clearfix"></div>
            <div id="routes"></div>
        </div>
    </div>

    <div class="row-fluid text-warning">
        <div class="span12">
            <div class="form-inline">
                <span class="small">
                    <?php echo JText::_('COM_STANDARD_LABEL_SELECT'); ?>:
                    <a href="javascript://" id="treeCheckAllProduct"><?php echo JText::_('JALL'); ?></a>,
                    <a href="javascript://" id="treeUncheckAllProduct"><?php echo JText::_('JNONE'); ?></a>
                </span>
            </div>
            <div class="clearfix"></div>
            <div id="productcategories"></div>
        </div>
    </div>
</fieldset>
