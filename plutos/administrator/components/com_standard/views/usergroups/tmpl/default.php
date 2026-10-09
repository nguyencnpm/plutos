<?php
/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$debugGroups = $this->state->get('params')->get('debugGroups', 1);

JText::script('COM_STANDARD_GROUPS_CONFIRM_DELETE');

JFactory::getDocument()->addScriptDeclaration('
		Joomla.submitbutton = function(task) {
			if (task == "usergroups.delete") {
				var i, cids = document.getElementsByName("cid[]");
				for (i = 0; i < cids.length; i++) {
					if (cids[i].checked && cids[i].parentNode.getAttribute("data-usercount") != 0) {
						if (confirm(Joomla.JText._("COM_STANDARD_GROUPS_CONFIRM_DELETE"))) {
							Joomla.submitform(task);
						}
						return false;
					}
				}
			}

			Joomla.submitform(task);
			return false;
		};
');
$columns = 6;
?>
<form action="<?php echo JRoute::_('index.php?option=com_standard&view=usergroups'); ?>" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)) : ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
        <?php else : ?>
            <div id="j-main-container">
            <?php endif; ?>
            <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('filterButton' => false))); ?>
            <div class="clearfix"> </div>
            <?php if (empty($this->items)) : ?>
                <div class="alert alert-no-items">
                    <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                </div>
            <?php else : ?>
                <table class="table table-striped" id="groupList">
                    <thead>
                        <tr>
                            <th width="1%" class="nowrap">
                                <?php echo JHtml::_('grid.checkall'); ?>
                            </th>
                            <th class="nowrap">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_HEADING_USER_GROUP_TITLE', 'tag.title', $listDirn, $listOrder); ?>
                            </th>
                            <th class="hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_CONTRACT_GROUP', 'contractgroup', $listDirn, $listOrder); ?>
                            </th>
                            <th class="hidden-phone">
                                <?php echo JText::_('COM_STANDARD_CATEGORIES'); ?>
                            </th>
                            <th width="1%" class="nowrap center">
                                <span class="icon-publish hasTooltip" aria-hidden="true" title="<?php echo JText::_('COM_STANDARD_COUNT_ENABLED_TRAVEL_AGENTS'); ?>"></span>
                                <span class="hidden-phone"><?php echo JText::_('COM_STANDARD_COUNT_ENABLED_TRAVEL_AGENTS'); ?></span>
                            </th>
                            <th width="1%" class="nowrap center">
                                <span class="icon-unpublish hasTooltip" aria-hidden="true" title="<?php echo JText::_('COM_STANDARD_COUNT_DISABLED_TRAVEL_AGENTS'); ?>"></span>
                                <span class="hidden-phone"><?php echo JText::_('COM_STANDARD_COUNT_DISABLED_TRAVEL_AGENTS'); ?></span>
                            </th>
                            <th width="1%" class="nowrap hidden-phone">
                                <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'tag.id', $listDirn, $listOrder); ?>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo $columns; ?>">
                                <?php echo $this->pagination->getListFooter(); ?>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($this->items as $i => $item) :
                            $canCreate = $user->authorise('core.create', 'com_users');
                            $canEdit = $user->authorise('core.edit', 'com_users');

                            // If this group is super admin and this user is not super admin, $canEdit is false
                            if (!$user->authorise('core.admin') && JAccess::checkGroup($item->id, 'core.admin')) {
                                $canEdit = false;
                            }
                            $canChange = $user->authorise('core.edit.state', 'com_users');
                            ?>
                            <tr class="row<?php echo $i % 2; ?>">
                                <td class="center" data-usercount="<?php echo $item->user_count; ?>">
                                    <?php if ($canEdit) : ?>
                                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo JLayoutHelper::render('joomla.html.treeprefix', array('level' => $item->level + 1)); ?>
                                    <?php if ($canEdit) : ?>
                                        <a href="<?php echo JRoute::_('index.php?option=com_standard&task=usergroup.edit&id=' . $item->id); ?>">
                                            <?php echo $this->escape($item->title); ?></a>
                                    <?php else : ?>
                                        <?php echo $this->escape($item->title); ?>
                                    <?php endif; ?>
                                    <!--
                                    <div class="small">
                                        <b><?php //echo JText::_('COM_STANDARD_DISCOUNT'); ?>:</b>
                                        <?php
                                        /*
                                        if (empty($item->list_discount)) {
                                            echo ' - ';
                                        } else {
                                            foreach ($item->list_discount as $j => $discount) {
                                                if (strlen($discount['value_mathop'] == 1)) {
                                                    echo '<div class="text-danger-price">' . $this->currency->getFormatCurrency((float) $discount['value'], $discount['currency_id']) . '</span>' . '&nbsp;' . JText::_('mathop') . '&nbsp;<span class="text-danger">' . $discount['value_mathop'] . '</div>';
                                                } else {
                                                    echo '<div class="text-danger-price">' . $this->currency->formatNumber((float) $discount['value']) . '</span>' . '&nbsp;' . JText::_('mathop') . '&nbsp;<span class="text-danger">' . $discount['value_mathop'] . '</div>';
                                                }
                                            }
                                        }
                                        */
                                        ?>
                                    </div>
                                    -->
                                    <?php if ($debugGroups) : ?>
                                        <div class="small">
                                            <a href="<?php echo JRoute::_('index.php?option=com_users&view=debuggroup&group_id=' . (int) $item->id); ?>">
                                                <?php echo JText::_('COM_STANDARD_DEBUG_GROUP'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="hidden-phone">

                                    <p><?php echo $this->escape($item->contractgroup_title); ?></p>
                                    <?php if ($item->count_contractPublished > 0): ?>
                                        <?php $url = JRoute::_('index.php?option=com_standard&view=contractrates&filter[contractgroup_id]=' . (int) $item->contractgroup_id); ?>
                                        <div>
                                            <a class="badge <?php if ($item->count_contractPublished > 0) echo 'badge-success'; ?>" href="<?php echo $url; ?>">
                                                <?php echo $item->count_contractPublished; ?>
                                            </a>
                                            <b> <?php echo JText::_('COM_STANDARD_CONTRACT_RATES'); ?>: </b>
                                        </div>
                                    <?php endif; ?>

                                    <div class="small">
                                        <strong>
                                            <?php
                                            if (empty($item->list_contract_detail)) {
                                                echo ' - ';
                                            } else {
                                                $contractrate_id = 0;
                                                $count_contractPeriod = 0;
                                                $count_contract = 0;
                                                $count_break = 2;
                                                foreach ($item->list_contract_detail as $j => $contract_detail) {
                                                    if ($contract_detail['contractrate_id'] != $contractrate_id) {

                                                        $title_roomtypes = "<b>" . JText::_("COM_STANDARD_CATEGORIES") . ":</b> " . $contract_detail['category_title'];
                                                        $data_content = htmlspecialchars("<b>" . JText::_('COM_STANDARD_PRODUCTS') . ":</b> <br />" . $contract_detail['products'], ENT_COMPAT, 'UTF-8');

                                                        echo "<div> "
                                                        . "<span data-placement=\"right\" class=\"hasPopover text-success\" title=\"{$title_roomtypes}\" data-content=\"{$data_content}\">" . $contract_detail['contract_title'] . " <i class=\"icon-info-circle\"></i> </span> "
                                                        . "</div>";

                                                        $contractrate_id = $contract_detail['contractrate_id'];
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
                                                        $title = JText::plural($item->count_contractPublished > 1 ? 'COM_STANDARD_N_CONTRACT' : 'COM_STANDARD_N_CONTRACT_1', $item->count_contractPublished);
                                                        $urlSelect = JRoute::_('index.php?option=com_standard&view=contractrates&tmpl=component&layout=modal&filter[contractgroup_id]=' . (int) $item->contractgroup_id);
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
                                    <?php if (empty($item->listhotel)) : ?>
                                        <?php echo ' - '; ?>
                                    <?php else : ?>
                                        <?php if (substr_count($item->listhotel, "\n") > 6) : ?>
                                            <span class="hasTooltip" title="<?php echo JHtml::_('tooltipText', JText::_('COM_STANDARD_HEADING_CATEGORIES'), nl2br($item->listhotel), 0); ?>"><?php echo JText::_('COM_STANDARD_USER_GROUPS_MULTIPLE_CATEGORIES'); ?></span>
                                        <?php else : ?>
                                            <?php echo nl2br($item->listhotel); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="center btns">
                                    <a class="badge <?php if ($item->count_enabled > 0) echo 'badge-success'; ?>" href="<?php echo JRoute::_('index.php?option=com_standard&view=users&filter[group_id]=' . (int) $item->id . '&filter[state]=0'); ?>">
                                        <?php echo $item->count_enabled; ?>
                                    </a>
                                </td>
                                <td class="center btns">
                                    <a class="badge <?php if ($item->count_disabled > 0) echo 'badge-important'; ?>" href="<?php echo JRoute::_('index.php?option=com_standard&view=users&filter[group_id]=' . (int) $item->id . '&filter[state]=1'); ?>">
                                        <?php echo $item->count_disabled; ?>
                                    </a>
                                </td>
                                <td class="hidden-phone">
                                    <?php echo (int) $item->id; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
