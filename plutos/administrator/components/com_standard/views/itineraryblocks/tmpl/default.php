<?php
/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$app = JFactory::getApplication();
$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'p.ordering';
$columns = 11;

$includes = "";
$params = JComponentHelper::getParams('com_standard');
if (!empty($params->get('isPriceHasVatTax'))):
    $includes = "_Has_Tax";
endif;

if (strpos($listOrder, 'publish_up') !== false) {
    $orderingColumn = 'publish_up';
} elseif (strpos($listOrder, 'publish_down') !== false) {
    $orderingColumn = 'publish_down';
} elseif (strpos($listOrder, 'modified') !== false) {
    $orderingColumn = 'modified';
} else {
    $orderingColumn = 'created';
}

if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_standard&task=productblocks.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'productList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=productblocks'); ?>" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)) : ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
        <?php else : ?>
            <div id="j-main-container">
            <?php endif; ?>
            <?php
            // Search tools bar
            echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
            ?>
            <?php if (empty($this->items)) : ?>
                <div class="alert alert-no-items">
                    <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                </div>
            <?php else : ?>
                <table class="table table-striped" id="productList">
                    <thead>
                        <tr>
                            <th width="1%" class="nowrap center hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', '', 'p.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                            </th>
                            <th width="1%" class="center">
                                <?php echo JHtml::_('grid.checkall'); ?>
                            </th>
                            <th width="1%" style="min-width:55px" class="nowrap center">
                                <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'p.state', $listDirn, $listOrder); ?>
                            </th>
                            <th>
                                <?php echo JHtml::_('searchtools.sort', 'JGLOBAL_TITLE', 'p.title', $listDirn, $listOrder); ?>
                            </th>
                            <th class="hidden-phone">
                                <?php echo JText::_('COM_STANDARD_FIELDSET_PRODUCT_BLOCK'); ?>
                            </th>
                            <th width="10%" class="hidden-phone">
                                <?php echo JText::_('COM_STANDARD_HEADING_IMAGE'); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_BASE_PRICE' . strtoupper($includes), 'p.price', $listDirn, $listOrder); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_SALES_PRICE', 'p.payable_amount', $listDirn, $listOrder); ?>
                            </th>
                            <!--
                            <th width="10%" class="nowrap hidden-phone">
                                <?php //echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'p.access', $listDirn, $listOrder); ?>
                            </th>
                            -->
                            <?php if ($assoc) : ?>
                                <?php $columns++; ?>
                                <th width="5%" class="nowrap hidden-phone">
                                    <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_HEADING_ASSOCIATION', 'association', $listDirn, $listOrder); ?>
                                </th>
                            <?php endif; ?>
                            <!--    
                            <th width="10%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JAUTHOR', 'p.created_by', $listDirn, $listOrder); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder);  ?>
                            </th>
                            -->
                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_HEADING_DATE_' . strtoupper($orderingColumn), 'p.' . $orderingColumn, $listDirn, $listOrder); ?>
                            </th>

                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGLOBAL_HITS', 'p.hits', $listDirn, $listOrder); ?>
                            </th>
                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'p.id', $listDirn, $listOrder); ?>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo $columns; ?>"> </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($this->items as $i => $item) :
                            $item->max_ordering = 0;
                            $ordering = ($listOrder == 'p.ordering');
                            $canCreate = $user->authorise('core.create', 'com_standard.category.' . $item->catid);
                            $canEdit = $user->authorise('core.edit', 'com_standard.product.' . $item->id);
                            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                            $canEditOwn = $user->authorise('core.edit.own', 'com_standard.product.' . $item->id) && $item->created_by == $userId;
                            $canChange = $user->authorise('core.edit.state', 'com_standard.product.' . $item->id) && $canCheckin;
                            // ---- De lam sau in case Admin ----
                            //$this->calculatedPrices = $this->calculator->getProductPrices($item);
                            // Convert the images field to an array.
                            $registry = new Registry($item->images);
                            $item->images = $registry->toArray();
                            ?>
                            <tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->catid; ?>">
                                <td class="order nowrap center hidden-phone">
                                    <?php
                                    $iconClass = '';
                                    if (!$canChange) {
                                        $iconClass = ' inactive';
                                    } elseif (!$saveOrder) {
                                        $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
                                    }
                                    ?>
                                    <span class="sortable-handler<?php echo $iconClass ?>">
                                        <span class="icon-menu"></span>
                                    </span>
                                    <?php if ($canChange && $saveOrder) : ?>
                                        <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
                                    <?php endif; ?>
                                </td>
                                <td class="center">
                                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                                </td>
                                <td class="center">
                                    <div class="btn-group">
                                        <?php echo JHtml::_('jgrid.published', $item->state, $i, 'productblocks.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
                                        <?php echo JHtml::_('standardadministrator.featured', $item->featured, $i, $canChange); ?>
                                        <?php
                                        // Create dropdown items and render the dropdown list.
                                        if ($canChange) {
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'productblocks');
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'productblocks');
                                            echo JHtml::_('actionsdropdown.render', $this->escape($item->title));
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td class="has-context">
                                    <div class="pull-left break-word">
                                        <?php if ($item->checked_out) : ?>
                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'productblocks.', $canCheckin); ?>
                                        <?php endif; ?>
                                        <?php if ($item->language == '*'): ?>
                                            <?php $language = JText::alt('JALL', 'language'); ?>
                                        <?php else: ?>
                                            <?php $language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                        <?php endif; ?>
                                        <?php if ($canEdit || $canEditOwn) : ?>
                                            <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=product.edit&return=productblocks&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                                <?php echo $this->escape($item->title); ?></a>
                                        <?php else : ?>
                                            <span title="<?php echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"><?php echo $this->escape($item->title); ?></span>
                                        <?php endif; ?>
                                        <div class="small">
                                            <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
                                        </div>
                                        <div class="small">
                                            <?php echo "<b>" . JText::_('JCATEGORY') . ": </b>" . $this->escape($item->category_title); ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="nowrap hidden-phone">
                                    <?php if (!empty($item->period_block) && (int) $item->block_in_date === 1): ?>
                                        <?php
                                        $days = json_decode($item->period_block);
                                        $sDateLeading = "";
                                        $sDateIntro = "";
                                        $count_period = 0;
                                        $count_break = 2;
                                        $delimiter = " - ";
                                        foreach ($days as $d => $blockDate) :
                                            if (empty($blockDate)):
                                                continue;
                                            endif;
                                            $count_period ++;
                                            $sTextTo = '<span class="text-success">&nbsp;' . JText::_('to') . '&nbsp;</span>&nbsp;';
                                                   
                                            $adateTemp = explode($delimiter, trim($blockDate));
                                            $start = JHtml::_('date', trim($adateTemp[0]), 'Y-m-d');
                                            $expiry = JHtml::_('date', trim($adateTemp[1]), 'Y-m-d');
                                            
                                            $sBlockDate = $start . $sTextTo .$expiry;
                                            
                                            if ($count_period <= $count_break):
                                                $sDateLeading .= "<div class=\"small\"><strong><span class=\"muted\">┊&nbsp;</span> " . JLayoutHelper::render('joomla.html.treeprefix', array('level' => 2)) . $sBlockDate . "</strong></div>";
                                            else:
                                                $sDateIntro .= "<div class=\"small\"><strong><span class=\"muted\">┊&nbsp;</span> " . JLayoutHelper::render('joomla.html.treeprefix', array('level' => 2)) . $sBlockDate . "</strong></div>";
                                            endif;
                                        endforeach;
                                        ?>

                                        <?php if ($count_period > 0): ?>
                                            <div>
                                                <span class="badge badge-warning" > <?php echo $count_period; ?> </span>
                                                <?php echo $count_period > 1 ? JText::_('Periods') : JText::_('Period'); ?>: 
                                            </div>

                                            <?php echo $sDateLeading; ?>

                                            <?php if ($count_period > $count_break): ?>
                                                <a class="hasTooltip nowrap" href="#blockProductDateModal_<?php echo $item->id; ?>" role="button" class="btn btn-link" data-toggle="modal" title="<?php echo JText::_('COM_STANDARD_VIEW') . ": " . JText::_('Details'); ?>">
                                                    <span class="icon-list"></span> 
                                                    <?php echo JText::_('COM_STANDARD_DETAIL_POPS_UP'); ?>
                                                </a>

                                                <?php
                                                $icon_title = "<span class=\"icon-list\"></span>";
                                                $text = $count_period > 1 ? JText::_('Periods') : JText::_('Period');
                                                $title = JText::_('Display') . "&nbsp;{$count_period}&nbsp;{$text}";
                                                $urlSelect = JRoute::_('index.php?option=com_standard&view=product&tmpl=component&layout=modal_productblock&id=' . $item->id);
                                                //$modalBody = "<div style=\"text-align: left; width: auto; height: auto; padding: 15px;\">{$sDateLeading} {$sDateIntro}</div>";

                                                $footer = '<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">'
                                                        . JText::_('JTOOLBAR_CLOSE') .
                                                        '</button>';

                                                echo JHtml::_(
                                                        'bootstrap.renderModal'
                                                        , 'blockProductDateModal_' . (int) $item->id
                                                        , array(
                                                            'title' => $title
                                                            , 'url' => $urlSelect
                                                            , 'height' => '400px'
                                                            , 'width' => '800px'
                                                            , 'keyboard' => true
                                                            , 'closeButton' => true
                                                            , 'footer' => $footer
                                                        )
                                                );
                                                ?>
                                            <?php endif; ?>

                                        <?php else: ?>
                                            <?php echo ' - '; ?>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <?php echo ' - '; ?>
                                    <?php endif; ?>

                                </td>
                                <td class="hidden-phone">
                                    <?php if (!empty($item->images['image_tiny'])): ?>
                                        <img class="thumbnail" src="<?php echo JURI::root(FALSE) . $item->images['image_tiny']; ?>">
                                    <?php else: ?>
                                        <?php echo " - "; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="hidden-phone text-danger">
                                    <b>
                                        <?php
                                        if (((float) $item->price) > 0):
                                            $display_currency_id = (int) $item->currency_id;
                                            $price = $this->currency->convertCurrency($item->price, (int) $item->currency_id, $display_currency_id);
                                            echo $this->currency->getFormattedCurrency($price);
                                        else:
                                            echo ' - ';
                                        endif;
                                        ?>
                                    </b>
                                </td>
                                <td class="hidden-phone text-danger-price">
                                    <b>
                                        <?php
                                        if (((float) $item->price) > 0):
                                            echo ' - ';
                                        else:
                                            echo ' - ';
                                        endif;
                                        ?>
                                    </b>
                                </td>
                                <!--
                                <td class="small hidden-phone">
                                    <?php // echo $this->escape($item->access_level); ?>
                                </td>
                                -->
                                <?php if ($assoc) : ?>
                                    <td class="hidden-phone">
                                        <?php if ($item->association) : ?>
                                            <?php echo JHtml::_('standardadministrator.association', $item->id); ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                                <!--
                                <td class="small hidden-phone">
                                <?php //if ($item->created_by_alias) :    ?>
                                        <a class="hasTooltip" href="<?php //echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by);             ?>" title="<?php //echo JText::_('JAUTHOR');             ?>">
                                <?php //echo $this->escape($item->author_name);   ?></a>
                                        <div class="small"><?php //echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->created_by_alias));             ?></div>
                                <?php //else :   ?>
                                        <a class="hasTooltip" href="<?php //echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by);             ?>" title="<?php //echo JText::_('JAUTHOR');             ?>">
                                <?php //echo $this->escape($item->author_name);    ?></a>
                                <?php //endif;   ?>
                                </td>
                                <td class="small hidden-phone">
                                <?php //if ($item->language == '*'):     ?>
                                <?php //echo JText::alt('JALL', 'language');    ?>
                                <?php //else:   ?>
                                <?php //echo $item->language_title ? JHtml::_('image', 'mod_languages/' . $item->language_image . '.gif', $item->language_title, array('title' => $item->language_title), true) . '&nbsp;' . $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                <?php //endif; ?>
                                </td>
                                -->
                                <td class="nowrap small hidden-phone">
                                    <?php
                                    $date = $item->{$orderingColumn};
                                    echo $date > 0 ? JHtml::_('date', $date, JText::_('DATE_FORMAT_LC4')) : '-';
                                    ?>
                                </td>
                                <td class="hidden-phone center">
                                    <span class="badge badge-info">
                                        <?php echo (int) $item->hits; ?>
                                    </span>
                                </td>
                                <td class="hidden-phone">
                                    <?php echo (int) $item->id; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php // Load the batch processing form.      ?>
                <?php
                if ($user->authorise('core.create', 'com_standard') && $user->authorise('core.edit', 'com_standard') && $user->authorise('core.edit.state', 'com_standard')) :
                    ?>
                    <?php
                    echo JHtml::_(
                            'bootstrap.renderModal', 'collapseModal', array(
                        'title' => JText::_('COM_STANDARD_BATCH_OPTIONS'),
                        'footer' => $this->loadTemplate('batch_footer')
                            ), $this->loadTemplate('batch_body')
                    );
                    ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php echo $this->pagination->getListFooter(); ?>

            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
