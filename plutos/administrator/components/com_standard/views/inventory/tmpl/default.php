<?php
/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

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
$columns = 10;

if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_standard&task=inventory.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'productList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=inventory'); ?>" method="post" name="adminForm" id="adminForm">
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

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_IN_STOCK', 'p.in_stock', $listDirn, $listOrder); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDERED', 'p.ordered', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_COST_PRICE', 'p.price', $listDirn, $listOrder); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_STOCK_VALUE', 'p.payable_amount', $listDirn, $listOrder); ?>
                            </th>
                            <!-- 
                            <th width="10%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'p.access', $listDirn, $listOrder); ?>
                            </th>
                            <?php //if ($assoc) : ?>
                            <?php //$columns++; ?>
                                <th width="5%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'COM_STANDARD_HEADING_ASSOCIATION', 'association', $listDirn, $listOrder); ?>
                                </th>
                            <?php //endif; ?>
                               
                            <th width="10%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JAUTHOR', 'p.created_by', $listDirn, $listOrder); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JDATE', 'p.created', $listDirn, $listOrder); ?>
                            </th>
                            
                            <th width="1%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JGLOBAL_HITS', 'p.hits', $listDirn, $listOrder); ?>
                            </th>
                            -->
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
                            $basePrice = " - ";
                            $product_instock_value = " - ";

                            if (((float) $item->price) > 0):
                                $display_currency_id = (int) $item->currency_id;
                                $price = $this->currency->convertCurrency($item->price, (int) $item->currency_id, $display_currency_id);
                                $basePrice = $this->currency->getFormattedCurrency($price);
                                if ($item->in_stock != 0):
                                    $product_instock_value = $this->currency->priceDisplay($item->price, $display_currency_id, $item->in_stock);
                                endif;
                            endif;

                            // --- To mau ---
                            $classOrdered = "";
                            if ((int) $item->in_stock <= (int) $item->ordered) {
                                $classOrdered = "stock-out";
                                // .table-striped tbody > tr:nth-child(2n+1) > td, .table-striped tbody > tr:nth-child(2n+1) > th{background-color:#f9f9f9}
                            } elseif ((int) $item->in_stock - (int) $item->ordered == 2 || (int) $item->in_stock - (int) $item->ordered == 1) {
                                $classOrdered = "stock-low";
                            } else {
                                $classOrdered = "stock-normal";
                            }
                            // --------------
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
                                        <?php echo JHtml::_('jgrid.published', $item->state, $i, 'inventory.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
                                        <?php echo JHtml::_('standardadministrator.featured', $item->featured, $i, $canChange); ?>
                                        <?php
                                        // Create dropdown items and render the dropdown list.
                                        if ($canChange) {
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'inventory');
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'inventory');
                                            echo JHtml::_('actionsdropdown.render', $this->escape($item->title));
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td class="has-context">
                                    <div class="pull-left break-word">
                                        <?php if ($item->checked_out) : ?>
                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'inventory.', $canCheckin); ?>
                                        <?php endif; ?>
                                        <?php if ($item->language == '*'): ?>
                                            <?php $language = JText::alt('JALL', 'language'); ?>
                                        <?php else: ?>
                                            <?php $language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                        <?php endif; ?>
                                        <?php if ($canEdit || $canEditOwn) : ?>
                                            <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=product.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                                <?php echo $this->escape($item->title); ?></a>
                                        <?php else : ?>
                                            <span title="<?php echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"><?php echo $this->escape($item->title); ?></span>
                                        <?php endif; ?>
                                        <span class="small break-word">
                                            <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
                                        </span>
                                        <div class="small">
                                            <?php echo JText::_('JCATEGORY') . ": " . $this->escape($item->category_title); ?>
                                        </div>
                                    </div>
                                </td>

                                <td class="small hidden-phone <?php echo $classOrdered; ?>">
                                    <?php echo $this->escape($item->in_stock); ?>
                                </td>
                                <td class="small hidden-phone <?php echo $classOrdered; ?>">
                                    <?php echo $this->escape($item->ordered); ?>
                                </td>

                                <td class="hidden-phone text-danger">
                                    <?php echo $this->escape($basePrice); ?>
                                </td>
                                <td class="hidden-phone text-danger-price">
                                    <?php echo $this->escape($product_instock_value); ?>
                                </td>

                                <!--
                                <td class="small hidden-phone">
                                <?php //echo $this->escape($item->access_level); ?>
                                </td>
                                <?php //if ($assoc) : ?>
                                    <td class="hidden-phone">
                                <?php //if ($item->association) : ?>
                                <?php //echo JHtml::_('standardadministrator.association', $item->id); ?>
                                <?php //endif; ?>
                                    </td>
                                <?php //endif; ?>
                                
                                <td class="small hidden-phone">
                                <?php //if ($item->created_by_alias) :  ?>
                                        <a class="hasTooltip" href="<?php //echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by);      ?>" title="<?php //echo JText::_('JAUTHOR');      ?>">
                                <?php //echo $this->escape($item->author_name); ?></a>
                                        <div class="small"><?php //echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->created_by_alias));      ?></div>
                                <?php //else : ?>
                                        <a class="hasTooltip" href="<?php //echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by);      ?>" title="<?php //echo JText::_('JAUTHOR');      ?>">
                                <?php //echo $this->escape($item->author_name); ?></a>
                                <?php //endif;  ?>
                                </td>
                                <td class="small hidden-phone">
                                <?php //if ($item->language == '*'):  ?>
                                <?php //echo JText::alt('JALL', 'language');  ?>
                                <?php //else: ?>
                                <?php //echo $item->language_title ? JHtml::_('image', 'mod_languages/' . $item->language_image . '.gif', $item->language_title, array('title' => $item->language_title), true) . '&nbsp;' . $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                <?php //endif; ?>
                                </td>
                                <td class="nowrap small hidden-phone">
                                <?php //echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC4'));  ?>
                                </td>
                                
                                <td class="hidden-phone">
                                <?php //echo (int) $item->hits; ?>
                                </td>
                                -->
                                <td class="hidden-phone">
                                    <?php echo (int) $item->id; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php // Load the batch processing form.   ?>
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
