<?php
/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
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
$saveOrder = $listOrder == 'se.ordering';
$columns = 4;

if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_standard&task=subscribedemails.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'subscribedemailList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=subscribedemails'); ?>" method="post" name="adminForm" id="adminForm">
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
                <table class="table table-striped" id="subscribedemailList">
                    <thead>
                        <tr>
                            <th rowspan="2">
                                <?php echo JHtml::_('searchtools.sort', 'HEADING_SUBSCRIBED_EMAILS_GUEST', 'se.subscribe_email', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'HEADING_SUBSCRIBED_EMAILS_DATE', 'se.created', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_DEVICES', 'se.device', $listDirn, $listOrder); ?>
                            </th>

                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'se.id', $listDirn, $listOrder); ?>
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
                            ?>
                            <tr class="row<?php echo $i % 2; ?>">
                                <td class="has-context">
                                    <div class="pull-left break-word">
                                        <?php echo $this->escape($item->subscribe_email); ?>
                                    </div>
                                </td>

                                <td class="nowrap small hidden-phone">
                                    <?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC5')); ?>
                                </td>

                                <td class="hidden-phone">
                                    <div class="break-word">
                                        <?php echo $this->escape($item->device); ?>
                                    </div>
                                    <div class="small">
                                        <b><?php echo JText::_('COM_STANDARD_BROWSER') . ": " ?></b><?php echo $this->escape($item->browser); ?>
                                    </div>
                                    <div class="small nowrap">
                                        <b><?php echo JText::_('COM_STANDARD_ORDER_IP_ADDRESS') . ": " ?></b><?php echo $this->escape($item->ip_address); ?>
                                    </div>

                                </td>
                                <td class="hidden-phone">
                                    <?php echo (int) $item->id; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php // Load the batch processing form.     ?>
            <?php endif; ?>

            <?php echo $this->pagination->getListFooter(); ?>

            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
<?php echo $this->loadTemplate('download'); ?>