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
$saveOrder = $listOrder == 'o.ordering';
$columns = 12;

if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_standard&task=orders.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'orderList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=orders'); ?>" method="post" name="adminForm" id="adminForm">
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
                <table class="table table-striped" id="orderList">
                    <thead>
                        <tr>
                            <th width="1%" class="nowrap center hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', '', 'o.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                            </th>
                            <th width="1%" class="center">
                                <?php echo JHtml::_('grid.checkall'); ?>
                            </th>
                            <th width="1%" style="min-width:55px" class="nowrap center">
                                <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'o.state', $listDirn, $listOrder); ?>
                            </th>
                            <th>
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_NUMBER', 'o.number', $listDirn, $listOrder); ?>
                            </th>
                            <!--
                            <th class="nowrap hidden-phone">
                            <?php // echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_VENDOR', 'vendor', $listDirn, $listOrder); ?>
                            </th>
                            
                            <th class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_PAYMENT_METHOD', 'paymentmethod', $listDirn, $listOrder); ?>
                            </th>
                            <th class="nowrap hidden-phone">
                            <?php //echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_SHIPMENT', 'shipmentmethod', $listDirn, $listOrder); ?>
                            </th>
                            -->
                            <th class="hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_HEADING_TOTAL', 'o.total', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_DATE', 'o.created', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_LAST_MODIFIED', 'o.modified', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_DEVICES', 'o.device', $listDirn, $listOrder); ?>
                            </th>

                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'o.id', $listDirn, $listOrder); ?>
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
                            $ordering = ($listOrder == 'o.ordering');
                            //$canCreate = $user->authorise('core.create', 'com_standard.category.' . $item->catid);
                            $canEdit = $user->authorise('core.edit', 'com_standard.order.' . $item->id);
                            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                            $canEditOwn = $user->authorise('core.edit.own', 'com_standard.order.' . $item->id) && $item->created_by == $userId;
                            $canChange = $user->authorise('core.edit.state', 'com_standard.order.' . $item->id) && $canCheckin;

                            //$this->calculator->getProductPrices($item);
                            // === Amount ===
                            $aCuruncyHostory = array();
                            $display_amount = 0;
                            $display_amountFormat = '';
                            $iCurrB = 0;
                            if (empty($item->total) || intval($item->total) == 0) {
                                $display_amountFormat = ' - ';
                            } else {
                                if (!empty($item->currency_history)):
                                    foreach (json_decode($item->currency_history) as $item_curuncy):
                                        $aCuruncyHostory[$item_curuncy->id] = $item_curuncy;
                                    endforeach;
                                endif;
                                if ($this->iCurrencyDisplay == ""):
                                    $display_amount = $item->total;
                                    $iCurrB = $item->payment_currency_id;
                                    $display_amountFormat = CurrencyHelper::displayFormattedCurrency($item->total, $aCuruncyHostory[$item->payment_currency_id]);
                                else:
                                    $oCurrA = new stdClass();
                                    $oCurrA->id = $item->payment_currency_id;
                                    $oCurrA->exchange_rate = $item->payment_currency_rate;

                                    $oStyleCurrB = isset($aCuruncyHostory[$this->iCurrencyDisplay]) ? $aCuruncyHostory[$this->iCurrencyDisplay] : $aCuruncyHostory[$item->payment_currency_id];
                                    $iCurrB = isset($aCuruncyHostory[$this->iCurrencyDisplay]) ? $this->iCurrencyDisplay : $item->payment_currency_id;

                                    $display_amount = CurrencyHelper::convert($item->total, $oCurrA, $oStyleCurrB);
                                    $display_amountFormat = CurrencyHelper::displayFormattedCurrency($display_amount, $oStyleCurrB);
                                endif;
                            }
                            // === /.Amount ===
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
                                        <?php echo JHtml::_('standardadministrator.status', $item->state, $i, $canChange); ?>

                                        <?php
                                        // Create dropdown items and render the dropdown list.
                                        if ($canChange) {
                                            if ((int) $item->state === 2) {
                                                JHtml::_('actionsdropdown.addCustomItem', JText::_('COM_STANDARD_TOGGLE_UNARCHIVE'), 'unarchive', 'cb' . $i, 'orders.unarchive');
                                            } else {
                                                JHtml::_('actionsdropdown.addCustomItem', JText::_('COM_STANDARD_TOGGLE_ARCHIVE'), 'archive', 'cb' . $i, 'orders.archive');
                                            }
                                            if ((int) $item->state === -2) {
                                                JHtml::_('actionsdropdown.addCustomItem', JText::_('COM_STANDARD_TOGGLE_UNTRASH'), 'publish', 'cb' . $i, 'orders.untrash');
                                            } else {
                                                JHtml::_('actionsdropdown.addCustomItem', JText::_('COM_STANDARD_TOGGLE_TRASH'), 'trash', 'cb' . $i, 'orders.trash');
                                            }

                                            echo JHtml::_('actionsdropdown.render', $this->escape($item->number));
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td class="has-context">
                                    <div class="pull-left break-word">
                                        <?php if ($item->checked_out) : ?>
                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'orders.', $canCheckin); ?>
                                        <?php endif; ?>
                                        <?php if ($item->language == '*'): ?>
                                            <?php $language = JText::alt('JALL', 'language'); ?>
                                        <?php else: ?>
                                            <?php $language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                        <?php endif; ?>
                                        <?php if ($canEdit || $canEditOwn) : ?>
                                            <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=order.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                                <?php echo $this->escape($item->number); ?></a>
                                            <?php else : ?>
                                            <span title=""><?php echo $this->escape($item->number); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <!--
                               <td class="small hidden-phone">
                                <?php // echo $this->escape($item->vendor_title);  ?>
                               </td>
                              
                               <td class="small hidden-phone">
                                   - <?php //echo $this->escape($item->paymentmethod_id);            ?>
                               </td>
                               <td class="small hidden-phone">
                                   - <?php //echo $this->escape($item->shipmentmethod_id);            ?>
                               </td>
                                -->
                                <td class="hidden-phone">
                                    <div class="nowrap text-danger-price"><?php echo $display_amountFormat; ?></div>
                                </td>

                                <td class="nowrap small hidden-phone">
                                    <?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC5')); ?>
                                </td>
                                <td class="nowrap small hidden-phone">
                                    <?php
                                    $date = intval($item->modified);
                                    echo $date > 0 ? JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC6')) : '-';
                                    ?>
                                </td>

                                <td class="hidden-phone">
                                    <div class="nowrap">
                                        <?php echo $this->escape($item->device); ?>
                                    </div>
                                    <div class="small">
                                        <b><?php echo JText::_('COM_STANDARD_BROWSER') . ": " ?></b>
                                        <?php echo $this->escape($item->browser); ?>
                                    </div>
                                    <div class="small nowrap">
                                        <b><?php echo JText::_('COM_STANDARD_ORDER_IP_ADDRESS') . ": " ?></b>
                                        <?php echo $this->escape($item->ip_address); ?>
                                    </div>
                                </td>
                                <td class="hidden-phone">
                                    <?php echo (int) $item->id; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php // Load the batch processing form.    ?>
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
<?php echo $this->loadTemplate('download'); ?>