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
$saveOrder = $listOrder == 'r.ordering';
$columns = 12;

if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_standard&task=registrations.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'registrationList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=registrations'); ?>" method="post" name="adminForm" id="adminForm">
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
                <table class="table table-striped" id="registrationList">
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
                                <?php echo JHtml::_('searchtools.sort', 'HEADING_REGISTRATION_PERSONAL', 'r.fullName', $listDirn, $listOrder); ?>
                            </th>


                            <th>
                                <?php echo JHtml::_('searchtools.sort', 'HEADING_REGISTRATION_BUSINESS', 'r.companyName', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'HEADING_REGISTRATION_DATE', 'r.created', $listDirn, $listOrder); ?>
                            </th>

                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_ORDER_DEVICES', 'r.device', $listDirn, $listOrder); ?>
                            </th>

                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'r.id', $listDirn, $listOrder); ?>
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
                            $ordering = ($listOrder == 'r.ordering');
                            //$canCreate = $user->authorr.ise('core.create', 'com_standard.category.' . $item->catid);
                            $canEdit = $user->authorise('core.edit', 'com_standard.registration.' . $item->id);
                            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                            $canEditOwn = $user->authorise('core.edit.own', 'com_standard.registration.' . $item->id) && $item->created_by == $userId;
                            $canChange = $user->authorise('core.edit.state', 'com_standard.registration.' . $item->id) && $canCheckin;

                            $contactPhone = empty($item->phone) ? $item->mobile : $item->phone;
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
                                        <?php echo JHtml::_('standardadministrator.status', $item->state, $i, $canChange, 'registrations'); ?>

                                        <?php
                                        // Create dropdown items and render the dropdown list.
                                        if ($canChange) {
                                            if ((int) $item->state === 2) {
                                                JHtml::_('actionsdropdown.addCustomItem', JText::_('COM_STANDARD_TOGGLE_UNARCHIVE'), 'unarchive', 'cb' . $i, 'registrations.unarchive');
                                            } else {
                                                JHtml::_('actionsdropdown.addCustomItem', JText::_('COM_STANDARD_TOGGLE_ARCHIVE'), 'archive', 'cb' . $i, 'registrations.archive');
                                            }
                                            if ((int) $item->state === -2) {
                                                JHtml::_('actionsdropdown.addCustomItem', JText::_('COM_STANDARD_TOGGLE_UNTRASH'), 'publish', 'cb' . $i, 'registrations.untrash');
                                            } else {
                                                JHtml::_('actionsdropdown.addCustomItem', JText::_('COM_STANDARD_TOGGLE_TRASH'), 'trash', 'cb' . $i, 'registrations.trash');
                                            }

                                            echo JHtml::_('actionsdropdown.render', $this->escape($item->fullName));
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td class="has-context">
                                    <div class="pull-left break-word">
                                        <div class="nowrap guest">
                                            <?php if ($item->checked_out) : ?>
                                                <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'registrations.', $canCheckin); ?>
                                            <?php endif; ?>
                                            <?php if ($item->language == '*'): ?>
                                                <?php $language = JText::alt('JALL', 'language'); ?>
                                            <?php else: ?>
                                                <?php $language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                            <?php endif; ?>
                                            <?php if ($canEdit || $canEditOwn) : ?>
                                                <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=registration.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>: <?php echo JText::_('HEADING_ORDERS_GUEST_NAME'); ?>">
                                                    <?php echo $this->escape($item->fullName); ?>
                                                </a>
                                            <?php else : ?>
                                                <span class="hasTooltip" title="<?php echo JText::_('HEADING_ORDERS_GUEST_NAME'); ?>"><?php echo $this->escape($item->fullName); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="email">
                                            <b><?php echo JText::_('HEADING_ORDERS_PHONE_NUMBER'); ?>: </b>
                                            <span class="hasTooltip" title="<?php echo JText::_('HEADING_ORDERS_PHONE_NUMBER'); ?>"><?php echo $contactPhone; ?></span>
                                        </div>
                                        <div class="email">
                                            <b><?php echo JText::_('HEADING_ORDERS_EMAIL'); ?>: </b>
                                            <span class="hasTooltip" title="<?php echo JText::_('HEADING_ORDERS_EMAIL'); ?>"><?php echo $this->escape($item->email); ?></span>
                                        </div>
                                        <div class="position">
                                            <b><?php echo JText::_('HEADING_POSITION'); ?>: </b>
                                            <span class="hasTooltip" title="<?php echo JText::_('HEADING_POSITION'); ?>"><?php echo $this->escape($item->position); ?></span>
                                        </div>
                                        <?php if($item->referrerphonenumber):?>
                                            <div class="referrerphonenumber">
                                                <b><?php echo JText::_('HEADING_REFERRERPHONENUMBER'); ?>: </b>
                                                <span class="hasTooltip" title="<?php echo JText::_('HEADING_REFERRERPHONENUMBER'); ?>"><?php echo $this->escape($item->referrerphonenumber); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="has-context">
                                    <div class="nowrap company-name">
                                        <?php if ($item->checked_out) : ?>
                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'registrations.', $canCheckin); ?>
                                        <?php endif; ?>
                                        <?php if ($item->language == '*'): ?>
                                            <?php $language = JText::alt('JALL', 'language'); ?>
                                        <?php else: ?>
                                            <?php $language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                        <?php endif; ?>
                                        <?php if ($canEdit || $canEditOwn) : ?>
                                            <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=registration.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?> : <?php echo JText::_('HEADING_REGISTRATION_COMPANY_NAME'); ?>">
                                                <?php echo $this->escape($item->companyName); ?>
                                            </a>
                                        <?php else : ?>
                                            <span class="hasTooltip" title="<?php echo JText::_('HEADING_REGISTRATION_COMPANY_NAME'); ?>"><?php echo $this->escape($item->companyName); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($item->rentalCode)): ?>
                                        <div class="rental-code">
                                            <b><?php echo JText::_('HEADING_RENTALCODE'); ?>: </b>
                                            <?php echo $this->escape($item->rentalCode); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($item->city)): ?>
                                        <div class="city">
                                            <b><?php echo JText::_('HEADING_CITY'); ?>: </b>
                                            <?php echo $this->escape($item->city); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($item->nation)): ?>
                                        <div class="nation">
                                            <b><?php echo JText::_('HEADING_NATION'); ?>: </b>
                                            <?php echo $this->escape($item->nation); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($item->address)): ?>
                                        <div class="address">
                                            <b><?php echo JText::_('HEADING_ADDRESS'); ?>: </b>
                                            <?php echo $this->escape($item->address); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($item->typeOfBusiness)): ?>
                                        <div class="type-business">
                                            <b><?php echo JText::_('HEADING_TYPEOFBUSINESS'); ?>: </b>
                                            <?php echo $this->escape($item->typeOfBusiness); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($item->revenueLevel)): ?>
                                        <div class="revenue-level">
                                            <b><?php echo JText::_('HEADING_REVENUELEVEL'); ?>: </b>
                                            <?php echo $this->escape($item->revenueLevel); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($item->fbWebsite)): ?>
                                        <div class="fb-website">
                                            <b><?php echo JText::_('HEADING_FBWEBSITE'); ?>: </b>
                                            <?php echo $this->escape($item->fbWebsite); ?>
                                        </div>
                                    <?php endif; ?>

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