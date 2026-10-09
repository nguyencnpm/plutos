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
$saveOrder = $listOrder == 'ctg.ordering';
$columns = 11;

if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_standard&task=contractgroups.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'contractgroupList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$component = "com_standard";
$section = "contractrates";
$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=contractgroups'); ?>" method="post" name="adminForm" id="adminForm">
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
                <table class="table table-striped" id="contractgroupList">
                    <thead>
                        <tr>
                            <th width="1%" class="nowrap center hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', '', 'ctg.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                            </th>
                            <th width="1%" class="center">
                                <?php echo JHtml::_('grid.checkall'); ?>
                            </th>
                            <th width="1%" style="min-width:55px" class="nowrap center">
                                <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'ctg.state', $listDirn, $listOrder); ?>
                            </th>
                            <th>
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_HEADING_CONTRACT_GROUP_TITLE', 'ctg.title', $listDirn, $listOrder); ?>
                            </th>
                            <th class="hidden-phone">
                                <?php echo JText::_('COM_STANDARD_CONTRACT_RATES'); ?>
                            </th>
                            <th class="hidden-phone">
                                <?php echo JText::_('COM_STANDARD_USERS_HEADING_GROUPS'); ?>
                            </th>
                            <?php
                            if (isset($this->items[0]) && property_exists($this->items[0], 'count_published')) :
                                $columns++;
                                ?>
                                <th width="1%" class="nowrap center hidden-phone hidden-tablet">
                                    <span class="icon-publish hasTooltip" aria-hidden="true" title="<?php echo JText::_('COM_STANDARD_COUNT_PUBLISHED_CONTRACTS'); ?>"><span class="element-invisible"><?php echo JText::_('COM_STANDARD_COUNT_PUBLISHED_CONTRACTS'); ?></span></span>
                                </th>
                            <?php endif; ?>
                            <?php
                            if (isset($this->items[0]) && property_exists($this->items[0], 'count_unpublished')) :
                                $columns++;
                                ?>
                                <th width="1%" class="nowrap center hidden-phone hidden-tablet">
                                    <span class="icon-unpublish hasTooltip" aria-hidden="true" title="<?php echo JText::_('COM_STANDARD_COUNT_UNPUBLISHED_CONTRACTS'); ?>"><span class="element-invisible"><?php echo JText::_('COM_STANDARD_COUNT_UNPUBLISHED_CONTRACTS'); ?></span></span>
                                </th>
                            <?php endif; ?>
                            <?php
                            if (isset($this->items[0]) && property_exists($this->items[0], 'count_archived')) :
                                $columns++;
                                ?>
                                <th width="1%" class="nowrap center hidden-phone hidden-tablet">
                                    <span class="icon-archive hasTooltip" aria-hidden="true" title="<?php echo JText::_('COM_STANDARD_COUNT_ARCHIVED_CONTRACTS'); ?>"><span class="element-invisible"><?php echo JText::_('COM_STANDARD_COUNT_ARCHIVED_CONTRACTS'); ?></span></span>
                                </th>
                            <?php endif; ?>
                            <?php
                            if (isset($this->items[0]) && property_exists($this->items[0], 'count_trashed')) :
                                $columns++;
                                ?>
                                <th width="1%" class="nowrap center hidden-phone hidden-tablet">
                                    <span class="icon-trash hasTooltip" aria-hidden="true" title="<?php echo JText::_('COM_STANDARD_COUNT_TRASHED_CONTRACTS'); ?>"><span class="element-invisible"><?php echo JText::_('COM_STANDARD_COUNT_TRASHED_CONTRACTS'); ?></span></span>
                                </th>
                            <?php endif; ?>
                            <!--
                            <th width="10%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JAUTHOR', 'ctg.created_by', $listDirn, $listOrder); ?>
                            </th>
                            -->
                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
                            </th>
                            <!--
                            <th width="10%" class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'JDATE', 'ctg.created', $listDirn, $listOrder); ?>
                            </th>
                            -->
                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'ctg.id', $listDirn, $listOrder); ?>
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
                            $ordering = ($listOrder == 'ctg.ordering');
                            $canEdit = $user->authorise('core.edit', 'com_standard.contractgroup.' . $item->id);
                            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                            $canEditOwn = $user->authorise('core.edit.own', 'com_standard.contractgroup.' . $item->id) && $item->created_by == $userId;
                            $canChange = $user->authorise('core.edit.state', 'com_standard.contractgroup.' . $item->id) && $canCheckin;
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
                                        <?php echo JHtml::_('jgrid.published', $item->state, $i, 'contractgroups.', $canChange, 'cb'); //, $item->publish_up, $item->publish_down ?>

                                        <?php
                                        // Create dropdown items and render the dropdown list.
                                        if ($canChange) {
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'contractgroups');
                                            JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'contractgroups');
                                            echo JHtml::_('actionsdropdown.render', $this->escape($item->title));
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td class="has-context">
                                    <div class="pull-left">
                                        <?php if ($item->checked_out) : ?>
                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'contractgroups.', $canCheckin); ?>
                                        <?php endif; ?>
                                        <?php if ($item->language == '*'): ?>
                                            <?php $language = JText::alt('JALL', 'language'); ?>
                                        <?php else: ?>
                                            <?php $language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                        <?php endif; ?>
                                        <?php if ($canEdit || $canEditOwn) : ?>
                                            <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=contractgroup.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                                <?php echo $this->escape($item->title); ?>
                                            </a>
                                        <?php else : ?>
                                            <span title="<?php echo $this->escape($item->title); ?>"><?php echo $this->escape($item->title); ?></span>
                                        <?php endif; ?>
                                        <div class="small break-word">
                                            <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
                                            <?php //echo "<b>" . JText::_('JGLOBAL_USERNAME') . ": </b>" . $this->escape($item->username); ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden-phone">
                                    <div class="small">
                                        <strong>
                                            <?php
                                            if (empty($item->list_contract_detail)) {
                                                echo ' - ';
                                            } else {
                                                $contract_id = 0;
                                                $count_contractPeriod = 0;
                                                $count_contract = 0;
                                                $count_break = 2;
                                                foreach ($item->list_contract_detail as $j => $contract_detail) {
                                                    if ($contract_detail['contract_id'] != $contract_id) {

                                                        $title_products = "<b>" . JText::_("COM_STANDARD_CATEGORY") . ":</b> " . $contract_detail['category_title'];
                                                        $data_content = htmlspecialchars("<b>" . JText::_('COM_STANDARD_PRODUCTS') . ":</b> <br />" . $contract_detail['listproduct'], ENT_COMPAT, 'UTF-8');

                                                        echo "<div> "
                                                        . "<b>" . JText::_('COM_STANDARD_CONTRACT_RATE_NAME') . "</b>: "
                                                        . "<span data-placement=\"right\" class=\"hasPopover text-success\" title=\"{$title_products}\" data-content=\"{$data_content}\">" . $contract_detail['contract_title'] . " <i class=\"icon-info-circle\"></i> </span> "
                                                        . "</div>";
                                                        $sCode = empty($contract_detail['code']) ? " - " : strtoupper($this->escape($contract_detail['code']));
                                                        echo "<div class=\"nowrap\"><b>" . JText::_('COM_STANDARD_CODE') . "</b>: <span class=\"text-info\">{$sCode}</span></div>";

                                                        $contract_id = $contract_detail['contract_id'];
                                                        $count_contractPeriod = 0;
                                                        $count_contract++;
                                                    }
                                                    echo "<div>";
                                                    echo "<span class=\"muted\">┊&nbsp;</span>";
                                                    echo JLayoutHelper::render('joomla.html.treeprefix', array('level' => 2));
                                                    echo '<span class="text-danger-price">'
                                                    . $this->currency->getFormatCurrency((float) $contract_detail['price'], $contract_detail['contract_currency_id'])
                                                    . '</span>'
                                                    . '&nbsp; / &nbsp;' . $contract_detail['start_date'] . '&nbsp;'
                                                    . '<span class="text-success">' . JText::_('to') . '</span>&nbsp;'
                                                    . $contract_detail['expiry_date'];
                                                    echo "</div>";

                                                    ++$count_contractPeriod;

                                                    if ($count_contractPeriod >= $count_break || $count_contract >= $count_break):
                                                        ?>
                                                        <a class="hasTooltip nowrap" href="#contractModal_<?php echo $item->id; ?>" role="button" class="btn btn-link" data-toggle="modal" title="<?php echo JText::_('COM_STANDARD_CONTRACT_VIEW') . ": " . JText::_('Details'); ?>">
                                                            <span class="icon-list"></span> 
                                                            <?php echo JText::_('COM_STANDARD_CONTRACT_DETAIL_POPS_UP'); ?>
                                                        </a>

                                                        <?php
                                                        $icon_title = "<span class=\"icon-list\"></span>";
                                                        $title = JText::plural($item->count_published > 1 ? 'COM_STANDARD_N_CONTRACT' : 'COM_STANDARD_N_CONTRACT_1', $item->count_published);
                                                        $urlSelect = JRoute::_('index.php?option=com_standard&view=contractrates&tmpl=component&layout=modal&filter[contractgroup_id]=' . (int) $item->id);
                                                        $footer = '<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">'
                                                                . JText::_('JTOOLBAR_CLOSE') .
                                                                '</button>';

                                                        echo JHtml::_(
                                                                'bootstrap.renderModal'
                                                                , 'contractModal_' . (int) $item->id
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

                                                        break;
                                                    endif;
                                                }
                                            }
                                            ?>
                                        </strong>
                                    </div>
                                </td>
                                <td class="hidden-phone">
                                    <?php if (empty($item->user_groups)) : ?>
                                        <?php echo ' - '; ?>
                                    <?php else : ?>
                                        <?php if (substr_count($item->user_groups['usergroup_names'], "\n") > 1) : ?>
                                            <span class="hasTooltip" title="<?php echo JHtml::_('tooltipText', JText::_('COM_STANDARD_HEADING_GROUPS'), nl2br($item->user_groups['usergroup_names']), 0); ?>"><?php echo JText::_('COM_STANDARD_USERS_MULTIPLE_GROUPS'); ?></span>
                                        <?php else : ?>
                                            <?php echo nl2br($item->user_groups['usergroup_names']); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>


                                <?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_published')) : ?>
                                    <td class="center btns hidden-phone hidden-tablet">
                                        <a class="badge <?php if ($item->count_published > 0) echo 'badge-success'; ?>" title="<?php echo JText::_('COM_STANDARD_COUNT_PUBLISHED_CONTRACTS'); ?>" href="<?php echo JRoute::_('index.php?option=' . $component . ($section ? '&view=' . $section : '') . '&filter[contractgroup_id]=' . (int) $item->id . '&filter[published]=1'); ?>">
                                            <?php echo $item->count_published; ?>
                                        </a>
                                    </td>
                                <?php endif; ?>
                                <?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_unpublished')) : ?>
                                    <td class="center btns hidden-phone hidden-tablet">
                                        <a class="badge <?php if ($item->count_unpublished > 0) echo 'badge-important'; ?>" title="<?php echo JText::_('COM_STANDARD_COUNT_UNPUBLISHED_CONTRACTS'); ?>" href="<?php echo JRoute::_('index.php?option=' . $component . ($section ? '&view=' . $section : '') . '&filter[contractgroup_id]=' . (int) $item->id . '&filter[published]=0'); ?>">
                                            <?php echo $item->count_unpublished; ?>
                                        </a>
                                    </td>
                                <?php endif; ?>
                                <?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_archived')) : ?>
                                    <td class="center btns hidden-phone hidden-tablet">
                                        <a class="badge <?php if ($item->count_archived > 0) echo 'badge-info'; ?>" title="<?php echo JText::_('COM_STANDARD_COUNT_ARCHIVED_CONTRACTS'); ?>" href="<?php echo JRoute::_('index.php?option=' . $component . ($section ? '&view=' . $section : '') . '&filter[contractgroup_id]=' . (int) $item->id . '&filter[published]=2'); ?>">
                                            <?php echo $item->count_archived; ?>
                                        </a>
                                    </td>
                                <?php endif; ?>
                                <?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_trashed')) : ?>
                                    <td class="center btns hidden-phone hidden-tablet">
                                        <a class="badge <?php if ($item->count_trashed > 0) echo 'badge-inverse'; ?>" title="<?php echo JText::_('COM_STANDARD_COUNT_TRASHED_CONTRACTS'); ?>" href="<?php echo JRoute::_('index.php?option=' . $component . ($section ? '&view=' . $section : '') . '&filter[contractgroup_id]=' . (int) $item->id . '&filter[published]=-2'); ?>">
                                            <?php echo $item->count_trashed; ?>
                                        </a>
                                    </td>
                                <?php endif; ?>


                                <!--
                                <td class="small hidden-phone">
                                <?php //if ($item->created_by_alias) : ?>
                                        <a class="hasTooltip" href="<?php //echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by);     ?>" title="<?php //echo JText::_('JAUTHOR');     ?>">
                                <?php //echo $this->escape($item->author_name); ?></a>
                                        <div class="small"><?php //echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->created_by_alias));     ?></div>
                                <?php //else : ?>
                                        <a class="hasTooltip" href="<?php //echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by);     ?>" title="<?php //echo JText::_('JAUTHOR');     ?>">
                                <?php //echo $this->escape($item->author_name); ?></a>
                                <?php //endif; ?>
                                </td>
                                -->
                                <td class="small hidden-phone">
                                    <?php if ($item->language == '*'): ?>
                                        <?php echo JText::alt('JALL', 'language'); ?>
                                    <?php else: ?>
                                        <?php echo $item->language_title ? JHtml::_('image', 'mod_languages/' . $item->language_image . '.gif', $item->language_title, array('title' => $item->language_title), true) . '&nbsp;' . $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                    <?php endif; ?>
                                </td>
                                <!--
                                <td class="nowrap small hidden-phone">
                                <?php //echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC4')); ?>
                                </td>
                                -->
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
