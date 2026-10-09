<?php
defined('_JEXEC') or die;
?>
<div class="clearfix"></div>
<div class="page-header">
    <div class="pull-right form-inline">
        <div class="btn-group">
            <button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
            <button class="btn" data-calendar-nav="today">Today</button>
            <button class="btn btn-primary" data-calendar-nav="next">Next >></button>
        </div>
        <div class="btn-group">
            <button class="btn btn-warning" data-calendar-view="year">Year</button>
            <button class="btn btn-warning active" data-calendar-view="month">Month</button>
            <button class="btn btn-warning" data-calendar-view="week">Week</button>
            <button class="btn btn-warning" data-calendar-view="day">Day</button>
        </div>
    </div>
    <h3></h3>
    <small>
        <span class="badge badge-inverse">&nbsp;</span> <?php echo JText::_('In the past') ?> &nbsp;&nbsp;
        <span class="badge badge-warning">&nbsp;</span> <?php echo JText::_('Today and tomorrow') ?>&nbsp;&nbsp;
        <span class="badge badge-info">&nbsp;</span> <?php echo JText::_('Future day') ?>&nbsp;&nbsp;
        <span class="badge badge-important">&nbsp;</span> <?php echo JText::_('Unavailable') ?>
        <span class="badge badge-success">&nbsp;</span> <?php echo JText::_('Available') ?>
    </small>
    <div class="clearfix">&nbsp;</div>
</div>
<div class="clearfix"></div>
<div class="modal hide fade" id="events-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Event</h3>
    </div>
    <div class="modal-body" style="height: 400px">
    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn">Close</a>
    </div>
</div>
