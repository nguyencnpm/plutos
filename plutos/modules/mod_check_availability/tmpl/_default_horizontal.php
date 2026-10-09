<?php
defined('_JEXEC') or die;
?>
<div class="row">
    <div class="<?php echo $cGroupLeft; ?>">
        <form target="<?php echo $params->get('linktarget'); ?>" class="searchForm form-validate needs-validation form-vertical" novalidate name="searchForm" action="<?php //echo JRoute::_('index.php?option=com_standard&view=SelectProducts');      ?>" method="post">
            <div class="row using-xl-h-100 py-xl-2"><?php // case xl ?>
                <div class="<?php echo $cGroupLeftRoute; ?> pr-xl-0">
                    <?php // echo $form->getControlGroup('tour_id'); ?>
                    <div class="row using-xl-h-100 mb-3 mb-xl-0">
                        <div class="control-label col-12 col-xl-3 using-xl-h-100 d-flex align-items-center justify-content-xl-end"><?php echo $form->getLabel('tour_id'); ?></div>
                        <div class="controls col-12 col-xl-9 px-xl-0"><?php echo $form->getInput('tour_id'); ?></div>
                    </div>
                </div>
                <div class="<?php echo $cGroupLeftDeparture; ?>">
                    <div class="row">
                        <div class="col-6">
                            <?php // echo $form->getControlGroup('contact_checkin'); ?>
                            <div class="row using-xl-h-100 mb-3 mb-xl-0">
                                <div class="control-label col-12 col-xl-6 pr-xl-0 using-xl-h-100 d-flex align-items-center justify-content-xl-end"><?php echo $form->getLabel('contact_checkin'); ?></div>
                                <div class="controls col-12 col-xl-6 pr-xl-0"><?php echo $form->getInput('contact_checkin'); ?></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <?php // echo $form->getControlGroup('contact_adult'); ?>
                            <div class="row using-xl-h-100 mb-3 mb-xl-0">
                                <div class="control-label col-12 col-xl-6 pr-xl-0 using-xl-h-100 d-flex align-items-center justify-content-xl-end"><?php echo $form->getLabel('contact_adult'); ?></div>
                                <div class="controls col-12 col-xl-6 pr-xl-0"><?php echo $form->getInput('contact_adult'); ?></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <?php //echo $form->getControlGroup('contact_children'); ?>
                            <div class="row using-xl-h-100 mb-3 mb-xl-0">
                                <div class="control-label col-12 col-xl-6 pr-xl-0 using-xl-h-100 d-flex align-items-center justify-content-xl-end"><?php echo $form->getLabel('contact_children'); ?></div>
                                <div class="controls col-12 col-xl-6 pr-xl-0"><?php echo $form->getInput('contact_children'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="option" value="com_standard" />
            <input type='hidden' name='task' value='selectproduct.getRedirectToItemRequest'/>
            <input type='hidden' name='check' value='checkavailability'/>
            <?php echo JHtml::_('form.token'); ?>
        </form>
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
            <div class="<?php echo $cGroupRightSearch; ?> using-lg-h-100 w-100 d-flex align-items-end text-center">
                <div class="control-group using-xl-h-100 w-100 mb-3 mb-xl-0"><?php // using-lg-h-100  mb-lg-0      ?>
                    <button value="search" class="btn btn-availability using-btn-yellow radius-0 border-0 text-uppercase check-availability page-loading-progress-click using-xl-h-100 using-lg-w-100"><?php // using-lg-h-100       ?>
                        <?php
                        if (!empty($params->get('button_text'))):
                            echo $params->get('button_text');
                        else:
                            echo JText::_('JSEARCH_FILTER_SUBMIT');
                        endif;
                        ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>