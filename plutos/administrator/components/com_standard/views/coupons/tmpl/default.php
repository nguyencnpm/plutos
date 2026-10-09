<?php
/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
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
$saveOrder = $listOrder == 'cp.ordering';
$columns = 11;

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
    $saveOrderingUrl = 'index.php?option=com_standard&task=coupons.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'couponList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=coupons'); ?>" method="post" name="adminForm" id="adminForm">
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
                <table class="table table-striped" id="couponList">
                    <thead>
                        <tr>
                            <th width="1%" class="nowrap center hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', '', 'cp.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                            </th>
                            <th width="1%" class="center">
                                <?php echo JHtml::_('grid.checkall'); ?>
                            </th>
                            <th width="1%" style="min-width:55px" class="nowrap center">
                                <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'cp.state', $listDirn, $listOrder); ?>
                            </th>
                            <th>
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_CODE', 'cp.code', $listDirn, $listOrder); ?>
                            </th>
                            <th class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_COUPON_TYPE', 'ct.title', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JAUTHOR', 'cp.created_by', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_HEADING_DATE_' . strtoupper($orderingColumn), 'cp.' . $orderingColumn, $listDirn, $listOrder); ?>
                            </th>

                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'cp.id', $listDirn, $listOrder); ?>
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
                            $ordering = ($listOrder == 'cp.ordering');
                            $canEdit = $user->authorise('core.edit', 'com_standard.coupon.' . $item->id);
                            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                            $canEditOwn = $user->authorise('core.edit.own', 'com_standard.coupon.' . $item->id) && $item->created_by == $userId;
                            $canChange = $user->authorise('core.edit.state', 'com_standard.coupon.' . $item->id) && $canCheckin;
                            ?>
                            <tr class="row<?php echo $i % 2; ?>">
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
                                        <?php echo JHtml::_('jgrid.published', $item->state, $i, 'coupons.', $canChange, 'cb'); ?>
                                        <?php
                                        // Create dropdown items and render the dropdown list.
                                        if ($canChange) {
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'coupons');
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'coupons');
                                            echo JHtml::_('actionsdropdown.render', $this->escape($item->code));
                                        }
                                        ?>
                                    </div>
                                </td>

                                <td class="has-context">
                                    <div class="pull-left nowrap">
                                        <?php if ($item->checked_out) : ?>
                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'coupons.', $canCheckin); ?>
                                        <?php endif; ?>
                                        <?php //if ($item->language == '*'): ?>
                                        <?php //$language = JText::alt('JALL', 'language'); ?>
                                        <?php //else: ?>
                                        <?php //$language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                        <?php //endif; ?>
                                        <?php if ($canEdit || $canEditOwn) : ?>
                                            <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=coupon.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                                <?php echo strtoupper($this->escape($item->code)); ?>
                                            </a>
                                        <?php else : ?>
                                            <span title=""><?php echo strtoupper($this->escape($item->code)); ?></span>
                                        <?php endif; ?>
                                        <p class="nowrap">
                                            <b><?php echo JText::_('COM_STANDARD_COUPONS_USED'); ?>: </b><span><?php echo (int) $item->used > 0 ? $this->escape($item->used) : " - "; ?></span>
                                        </p>
                                    </div>
                                </td>

                                <td class="hidden-phone">
                                    <?php echo $this->escape($item->couponstype_title); ?>
                                    <p class="nowrap">
                                        <b><?php echo JText::_('COM_STANDARD_COUPONS_TYPES_PREFIX'); ?>: </b><span><?php echo empty($item->couponstype_prefix) ? " - " : strtoupper($this->escape($item->couponstype_prefix)); ?></span>
                                    </p>
                                </td>

                                <td class="small hidden-phone">
                                    <?php if ($item->created_by_alias) : ?>
                                        <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by); ?>" title="<?php //echo JText::_('JAUTHOR');        ?>">
                                            <?php echo $this->escape($item->author_name); ?></a>
                                        <div class="small"><?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->created_by_alias)); ?></div>
                                    <?php else : ?>
                                        <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by); ?>" title="<?php //echo JText::_('JAUTHOR');        ?>">
                                            <?php echo $this->escape($item->author_name); ?></a>
                                    <?php endif; ?>
                                </td>

                                <td class="nowrap small hidden-phone">
                                    <?php
                                    $date = $item->{$orderingColumn};
                                    echo $date > 0 ? JHtml::_('date', $date, JText::_('DATE_FORMAT_LC4')) : '-';
                                    ?>
                                </td>

                                <td class="hidden-phone">
                                    <?php echo (int) $item->id; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php echo $this->pagination->getListFooter(); ?>

            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
