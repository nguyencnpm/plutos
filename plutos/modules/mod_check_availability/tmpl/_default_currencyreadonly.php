<?php
defined('_JEXEC') or die;
?>
<form class="searchForm form-validate needs-validation form-vertical" novalidate name="searchForm" action="<?php echo JRoute::_('index.php?option=com_standard&view=SelectProducts'); ?>" method="post">
    <div class="row">
        <div class="<?php echo $cGroupLeft; ?>">
            <div class="row">
                <div class="<?php echo $cGroupLeftRoute; ?>">
                    <?php echo $form->getControlGroup('tour_id'); ?>
                </div>
                <div class="<?php echo $cGroupLeftDeparture; ?>">
                    <div class="row">
                        <div class="col-6">
                            <?php echo $form->getControlGroup('contact_checkin'); ?>
                        </div>
                        <div class="col-3">
                            <?php echo $form->getControlGroup('contact_adult'); ?>
                        </div>
                        <div class="col-3">
                            <?php echo $form->getControlGroup('contact_children'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="option" value="com_standard" />
            <input type='hidden' name='view' value='SelectProducts'/>
            <input type='hidden' name='search' value='search'/>
        </div>
        <div class="<?php echo $cGroupRight; ?>">
            <div class="row h-100">
                <?php if (!empty($modules)): ?>
                    <div class="<?php echo $cGroupRightCurrency; ?>">
                        <?php
                        // this is where you want to load your module position
                        foreach ($modules as $module) {
                            echo JModuleHelper::renderModule($module);
                        }
                        ?>
                    </div>
                <?php endif; ?>
                <div class="<?php echo $cGroupRightSearch; ?> mb-3 h-100 w-100 d-flex align-items-end">
                    <div class="form-group w-100">
                        <button value="search" class="btn using-btn-yellow radius-0 border-0 text-uppercase w-100 check-availability page-loading-progress-click">
                            <?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>