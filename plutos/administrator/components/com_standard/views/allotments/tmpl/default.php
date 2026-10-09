<?php
/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
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
$saveOrder = $listOrder == 'a.ordering';
$columns = 13;

if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_standard&task=allotments.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'allotmentList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>

<?php echo $this->loadTemplate('calendar'); ?> 

<form action="<?php echo JRoute::_('index.php?option=com_standard&view=allotments'); ?>" method="post" name="adminForm" id="adminForm" >
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
            <?php if (empty($this->items_json)) : ?>
                <div class="alert alert-no-items">
                    <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                </div>
            <?php else : ?>
                <?php ?>
                <table class="table table-striped" id="allotmentList">
                    <thead>
                        <tr>
                            <th width="1%" class="center">
                                <?php echo JHtml::_('grid.checkall'); ?>
                            </th>
                            <th>
                                <?php echo JHtml::_('searchtools.sort', 'COM_STANDARD_PRODUCT_NAME', 'rt.title', $listDirn, $listOrder); ?>
                                <?php //echo JText::_('COM_STANDARD_ALLOTMENTS_DATE'); ?>
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
                        $day = date('Y-m-d');
                        foreach ($this->items_json as $i => $item) :

                            $item->max_ordering = 0;
                            $ordering = ($listOrder == 'rt.ordering');
                            $canCreate = $user->authorise('core.create', 'com_standard.category.' . $item->catid);
                            $canEdit = $user->authorise('core.edit', 'com_standard.product.' . $item->id);
                            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                            $canEditOwn = $user->authorise('core.edit.own', 'com_standard.product.' . $item->id) && $item->created_by == $userId;
                            $canChange = $user->authorise('core.edit.state', 'com_standard.product.' . $item->id) && $canCheckin;
                            ?>

                            <tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->catid; ?>">
                                <td class="center">
                                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                                </td>
                                <td class="has-context">
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <div class="pull-left break-word">
                                                <?php if ($item->checked_out) : ?>
                                                    <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'products.', $canCheckin); ?>
                                                <?php endif; ?>
                                                <?php if ($canEdit || $canEditOwn) : ?>
                                                    <a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_standard&task=allotmentproduct.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                                        <?php echo $this->escape($item->title); ?>
                                                    </a>
                                                <?php else : ?>
                                                    <span title="<?php echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"><?php echo $this->escape($item->title); ?></span>
                                                <?php endif; ?>
                                                <div class="small">
                                                    <?php echo "<b>" . JText::_('JCATEGORY') . ": </b>" . $this->escape($item->category_title); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span9">
                                            <div id="calendar-allotment<?php echo $i ?>"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <script type="text/javascript">
                            (function($) {

                                "use strict";

                                var options = {
                                    events_source: function() {
                                        return <?php echo json_encode($item->allotment); ?>;
                                    },
                                    view: 'month',
                                    tmpl_path: 'components/com_standard/views/allotments/tmpl/',
                                    tmpl_cache: false,
                                    day: '<?php echo $day; ?>',
                                    onAfterEventsLoad: function(events) {
                                        if (!events) {
                                            return;
                                        }
                                        var list = $('#eventlist');
                                        list.html('');

                                        $.each(events, function(key, val) {
                                            $(document.createElement('li'))
                                                    .html('<a href="' + val.url + '">' + val.title + '</a>')
                                                    .appendTo(list);
                                        });
                                    },
                                    onAfterViewLoad: function(view) {
                                        $('.page-header h3').text(this.getTitle());
                                        $('.btn-group button').removeClass('active');
                                        $('button[data-calendar-view="' + view + '"]').addClass('active');
                                    },
                                    classes: {
                                        months: {
                                            general: 'label'
                                        }
                                    }
                                };

                                var calendar = $('#calendar-allotment<?php echo $i ?>').calendar(options);

                                $('.btn-group button[data-calendar-nav]').each(function() {
                                    var $this = $(this);
                                    $this.click(function() {
                                        calendar.navigate($this.data('calendar-nav'));
                                    });
                                });

                                $('.btn-group button[data-calendar-view]').each(function() {
                                    var $this = $(this);
                                    $this.click(function() {
                                        calendar.view($this.data('calendar-view'));
                                    });
                                });

                                $('#first_day').change(function() {
                                    var value = $(this).val();
                                    value = value.length ? parseInt(value) : null;
                                    calendar.setOptions({first_day: value});
                                    calendar.view();
                                });

                                $('#language').change(function() {
                                    calendar.setLanguage($(this).val());
                                    calendar.view();
                                });

                                $('#events-in-modal').change(function() {
                                    var val = $(this).is(':checked') ? $(this).val() : null;
                                    calendar.setOptions({modal: val});
                                });
                                $('#format-12-hours').change(function() {
                                    var val = $(this).is(':checked') ? true : false;
                                    calendar.setOptions({format12: val});
                                    calendar.view();
                                });
                                $('#show_wbn').change(function() {
                                    var val = $(this).is(':checked') ? true : false;
                                    calendar.setOptions({display_week_numbers: val});
                                    calendar.view();
                                });
                                $('#show_wb').change(function() {
                                    var val = $(this).is(':checked') ? true : false;
                                    calendar.setOptions({weekbox: val});
                                    calendar.view();
                                });
                                $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e) {
                                    //e.preventDefault();
                                    //e.stopPropagation();
                                });
                            }(jQuery));
                        </script>
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
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_standard/assets/js/calendar.js');
?>

