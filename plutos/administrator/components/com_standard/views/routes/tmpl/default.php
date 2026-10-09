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
$saveOrder = $listOrder == 'r.ordering';
$columns = 8;

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
    $saveOrderingUrl = 'index.php?option=com_standard&task=routes.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'routeList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=routes'); ?>" method="post" name="adminForm" id="adminForm">
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
                <table class="table table-striped" id="routeList">
                    <thead>
                        <tr>
                            <th width="1%" class="nowrap center hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', '', 'r.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                            </th>
                            <th width="1%" class="center">
                                <?php echo JHtml::_('grid.checkall'); ?>
                            </th>
                            <th width="1%" style="min-width:55px" class="nowrap center">
                                <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'r.state', $listDirn, $listOrder); ?>
                            </th>
                            <th>
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ROUTE_NAME', 'from', $listDirn, $listOrder); ?>
                            </th>

                            <th width="5%" class="hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_FIELD_DEPARTURE_DAY', 'r.departure_day', $listDirn, $listOrder); ?>
                            </th>

                            <th width="5%" class="hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ROUTE_CODE', 'r.code', $listDirn, $listOrder); ?>
                            </th>

                            <th width="5%" class="hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ROUTE_DEPARTURE_TIME', 'r.departure_time', $listDirn, $listOrder); ?>
                            </th>

                            <th width="5%" class="hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ROUTE_ARRIVAL_TIME', 'r.arrival_time', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JAUTHOR', 'r.created_by', $listDirn, $listOrder); ?>
                            </th>

                            <th width="5%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_HEADING_DATE_' . strtoupper($orderingColumn), 'r.' . $orderingColumn, $listDirn, $listOrder); ?>
                            </th>
                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'r.id', $listDirn, $listOrder); ?>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="alert-warning">
                            <td colspan="<?php echo $columns; ?>"> </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($this->items as $i => $item) :
                            $cDay = " text-success ";
                            if ($item->departure_day == 0):
                                $cDay = " text-danger ";
                            elseif ($item->departure_day == 6):
                                $cDay = "  text-warning ";
                            endif;
                            $item->max_ordering = 0;
                            $ordering = ($listOrder == 'r.ordering');
                            $canEdit = $user->authorise('core.edit', 'com_standard.route.' . $item->id);
                            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                            $canEditOwn = $user->authorise('core.edit.own', 'com_standard.route.' . $item->id) && $item->created_by == $userId;
                            $canChange = $user->authorise('core.edit.state', 'com_standard.route.' . $item->id) && $canCheckin;
                            /*
                              $nameRoute = $this->escape($item->from_title);
                              $nameRoute .= "<span class=\"text-success\"> " . JText::_('To') . " </span>";
                              $nameRoute .= $this->escape($item->to_title);
                             */
                            $nameRoute = $this->escape($item->title);
                            ?>
                            <tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->id; ?>">
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
                                        <?php echo JHtml::_('jgrid.published', $item->state, $i, 'routes.', $canChange, 'cb'); ?>
                                        <?php
                                        // Create dropdown items and render the dropdown list.
                                        if ($canChange) {
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'routes');
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'routes');
                                            echo JHtml::_('actionsdropdown.render', $nameRoute);
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td class="has-context">
                                    <div class="pull-left break-word">
                                        <?php if ($item->checked_out) : ?>
                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'routes.', $canCheckin); ?>
                                        <?php endif; ?>
                                        <?php if ($item->language == '*'): ?>
                                            <?php $language = JText::alt('JALL', 'language'); ?>
                                        <?php else: ?>
                                            <?php $language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                        <?php endif; ?>
                                        <?php if ($canEdit || $canEditOwn) : ?>
                                            <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=route.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                                <?php echo $nameRoute; ?></a>
                                        <?php else : ?>
                                            <span title="<?php echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"><?php echo $nameRoute; ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($this->escape($item->alias))): ?>
                                            <span class="small break-word">
                                                <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
                                            </span>
                                        <?php endif; ?>
                                        <div class="small">
                                            <?php echo "<b>" . JText::_('JCATEGORY') . ': </b>' . $this->escape($item->category_title); ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="nowrap hidden-phone">
                                    <div class="<?php echo $cDay; ?>">
                                        <?php
                                        if ($item->departure_day >= 0 && $item->departure_day <= 6):
                                            echo $this->oDay->dayToString($item->departure_day);
                                        else:
                                            echo ' - ';
                                        endif;
                                        ?>
                                    </div>

                                    <div>
                                        <?php
                                        echo '<b>' . JText::_('COM_STANDARD_FIELD_NUMBER_OF_DAYS') . ': </b>';
                                        echo empty($item->number_days) ? " - " : "<span class=\"text-danger\"> " . $this->escape($item->number_days) . "</span>";
                                        ?>
                                    </div>
                                </td>

                                <td class="nowrap hidden-phone">
                                    <?php echo empty($item->code) ? " - " : $this->escape(strtoupper($item->code)); ?>
                                </td>

                                <td class="nowrap hidden-phone">
                                    <?php echo date(JText::_('COM_STANDARD_TIME_FORMAT_LC5'), strtotime($item->departure_time)); ?>
                                    <?php //echo JHtml::_('date', $item->departure_time, JText::_('COM_STANDARD_TIME_FORMAT_LC5')); ?>
                                </td>

                                <td class="nowrap hidden-phone">
                                    <?php echo date(JText::_('COM_STANDARD_TIME_FORMAT_LC5'), strtotime($item->arrival_time)); ?>
                                    <?php //echo JHtml::_('date', $item->arrival_time, JText::_('COM_STANDARD_TIME_FORMAT_LC5')); ?>
                                </td>

                                <td class="small hidden-phone">
                                    <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by); ?>" title="<?php echo JText::_('JAUTHOR'); ?>">
                                        <?php echo $this->escape($item->author_name); ?>
                                    </a>
                                </td>

                                <td class="small hidden-phone">
                                    <?php if ($item->language == '*'): ?>
                                        <?php echo JText::alt('JALL', 'language'); ?>
                                    <?php else: ?>
                                        <?php echo $item->language_title ? JHtml::_('image', 'mod_languages/' . $item->language_image . '.gif', $item->language_title, array('title' => $item->language_title), true) . '&nbsp;' . $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
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
