<?php
defined('_JEXEC') or die;
?>
<div class="row">
    <div class="<?php echo $cGroupLeft; ?>">
        <form class="searchForm" name="searchForm" action="<?php echo JRoute::_('index.php?option=com_standard&view=ListProducts'); ?>" method="post">
            <div class="row">
                <div class="<?php echo $cGroupLeftRoute; ?>">
                    <?php echo $form->getControlGroup('search'); ?>
                </div>
            </div>
            <input type="hidden" name="option" value="com_standard" />
            <input type='hidden' name='view' value='ListProducts'/>
            <input type='hidden' name='search' value='search'/>
        </form>
    </div>
    <div class="<?php echo $cGroupRight; ?>">
        <div class="row">
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
            <div class="<?php echo $cGroupRightSearch; ?>">
                <div class="form-group">
                    <div class="label-search">
                        <div class="progress d-none">
                            <div class="progress-bar progress-bar-danger" data-values="100">0</div>
                        </div>
                    </div>
                    <button value="search" class="btn btn-info btn-info--override w-100 filterproduct page-loading-progress-click no-radius">
                        <span class="icon-search"></span>
                        <?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>