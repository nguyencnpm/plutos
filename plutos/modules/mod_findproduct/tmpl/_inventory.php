<?php
defined('_JEXEC') or die;
?>
<div class="row">
    <div class="<?php echo $cGroupLeft; ?>">
        <form class="searchForm" name="searchForm" action="<?php echo JRoute::_('index.php?option=com_standard&view=inventory'); ?>" method="post">
            <div class="row">
                <div class="<?php echo $cGroupLeftRoute; ?> mb-3">
                    <?php echo $form->getControlGroup('route_id'); ?>
                </div>
                <div class="<?php echo $cGroupLeftDeparture; ?> mb-3">
                    <?php echo $form->getControlGroup('departure_day'); ?>
                </div>
            </div>
            <input type="hidden" name="option" value="com_standard" />
            <input type='hidden' name='view' value='inventory'/>
            <input type='hidden' name='search' value='inventory'/>
        </form>
    </div>
    <div class="<?php echo $cGroupRight; ?> mb-3">
        <div class="form-group">
            <div class="label-search">
                <div class="progress d-none">
                    <div class="progress-bar progress-bar-danger" data-values="100">0</div>
                </div>
            </div>
            <button value="search" class="btn btn-info btn-info--override w-100 findproduct page-loading-progress-click no-radius">
                <span class="icon-search"></span>
                <?php echo JText::_('CHECK_INVENTORY_SUBMIT'); ?>
            </button>
        </div>
    </div>
</div>