<?php
defined('_JEXEC') or die;

$dataSource = "[{}]";
$dataTemp = array();

if (!empty($this->item->period_block)):
    foreach ($this->item->period_block as $key => $value) :
        $arrTemp = explode(" - ", $value);
        $OjbstartDate = new JDate($arrTemp[0] . ' -1 month');
        $startDate = $OjbstartDate->format('Y,m,d');
        $OjbendDate = new JDate($arrTemp[1] . ' -1 month');
        $endDate = $OjbendDate->format('Y,m,d');

        $dataTemp[$key]['id'] = $key;
        $dataTemp[$key]['name'] = $this->escape($this->item->title);
        $dataTemp[$key]['location'] = strtoupper($this->item->code);
        $dataTemp[$key]['startDate'] = "+new Date(" . $startDate . ")+";
        $dataTemp[$key]['endDate'] = "+new Date(" . $endDate . ")+";
    endforeach;
    $dataSource = str_replace("+\"", "", str_replace("\"+", "", json_encode($dataTemp)));
endif;
?>

<div class="container-popup">
    <div id="calendar" class="calendar">
        <div class="calendar-header panel panel-default"></div>
    </div>
</div>
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" id="currentYear" value="<?php echo JFactory::getDate()->format('Y'); ?>" />
<?php echo JHtml::_('form.token'); ?>

<script type="text/javascript">
    function editEvent(event) {
        jQuery('#event-modal input[name="event-index"]').val(event ? event.id : '');
        jQuery('#event-modal input[name="event-name"]').val(event ? event.name : '');
        jQuery('#event-modal input[name="event-location"]').val(event ? event.location : '');
        jQuery('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
        jQuery('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
        jQuery('#event-modal').modal();
    }

    function deleteEvent(event) {
        var dataSource = jQuery('#calendar').data('calendar').getDataSource();

        for (var i in dataSource) {
            if (dataSource[i].id == event.id) {
                dataSource.splice(i, 1);
                break;
            }
        }

        jQuery('#calendar').data('calendar').setDataSource(dataSource);
    }

    function saveEvent() {
        var event = {
            id: jQuery('#event-modal input[name="event-index"]').val(),
            name: jQuery('#event-modal input[name="event-name"]').val(),
            location: jQuery('#event-modal input[name="event-location"]').val(),
            startDate: jQuery('#event-modal input[name="event-start-date"]').datepicker('getDate'),
            endDate: jQuery('#event-modal input[name="event-end-date"]').datepicker('getDate')
        }

        var dataSource = jQuery('#calendar').data('calendar').getDataSource();

        if (event.id) {
            for (var i in dataSource) {
                if (dataSource[i].id == event.id) {
                    dataSource[i].name = event.name;
                    dataSource[i].location = event.location;
                    dataSource[i].startDate = event.startDate;
                    dataSource[i].endDate = event.endDate;
                }
            }
        } else
        {
            var newId = 0;
            for (var i in dataSource) {
                if (dataSource[i].id > newId) {
                    newId = dataSource[i].id;
                }
            }

            newId++;
            event.id = newId;

            dataSource.push(event);
        }

        jQuery('#calendar').data('calendar').setDataSource(dataSource);
        jQuery('#event-modal').modal('hide');
    }

    jQuery(function () {
        //var currentYear = new Date().getFullYear();
        var currentYear = document.getElementById("currentYear").value;
        
        jQuery('#calendar').calendar({
            enableContextMenu: true,
            enableRangeSelection: true,
            contextMenuItems: [
                {
                    text: 'Update',
                    click: editEvent
                },
                {
                    text: 'Delete',
                    click: deleteEvent
                }
            ],
            selectRange: function (e) {
                editEvent({startDate: e.startDate, endDate: e.endDate});
            },
            mouseOnDay: function (e) {
                if (e.events.length > 0) {
                    var content = '';

                    for (var i in e.events) {
                        content += '<div class="event-tooltip-content">'
                                + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                + '<div class="event-location">' + e.events[i].location + '</div>'
                                + '</div>';
                    }

                    jQuery(e.element).popover({
                        trigger: 'manual',
                        container: 'body',
                        html: true,
                        content: content
                    });

                    jQuery(e.element).popover('show');
                }
            },
            mouseOutDay: function (e) {
                if (e.events.length > 0) {
                    jQuery(e.element).popover('hide');
                }
            },
            dayContextMenu: function (e) {
                jQuery(e.element).popover('hide');
            },
            dataSource: <?php echo $dataSource; ?>
        });

        jQuery('#save-event').click(function () {
            saveEvent();
        });
    });
</script>