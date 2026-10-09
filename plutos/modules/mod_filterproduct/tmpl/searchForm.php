<?php
defined('_JEXEC') or die;
?>
<form class="searchForm<?php echo $class_sfx; ?>" name="searchForm" action="<?php echo JRoute::_('index.php?option=com_standard&view=ListProducts'); ?>" method="post">
    <div class="input-group">
        <?php echo $form->getInput('search'); ?>
        <div class="input-group-prepend">
            <button type="submit" value="search" class="btn btn-info btn-info--override w-100 filterproduct page-loading-progress-click no-radius">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <input type="hidden" name="option" value="com_standard" />
    <input type='hidden' name='view' value='ListProducts'/>
    <input type='hidden' name='search' value='search'/>
</form>



