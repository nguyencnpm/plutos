<?php
defined('_JEXEC') or die;
?>
<div class="col-auto px-0">
    <button type="button" class="btn col-auto px-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="<?php echo JURI::root(false); ?>/images/icon/icon-search.png" />
    </button>
    <div class="search-box dropdown-menu dropdown-menu-right radius-0 pt-3">
        <div class="col-12">
            <form class="searchForm<?php echo $class_sfx; ?>" name="searchForm" action="<?php echo JRoute::_('index.php?option=com_standardextension&view=searchresults'); ?>" method="post">
                <div class="input-group">
                    <?php echo $form->getInput('search'); ?>
                    <div class="input-group-prepend">
                        <button type="submit" value="search" class="btn using-btn-blue w-100 rounded">
                            <?php echo "Tìm kiếm";?>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="option" value="com_standardextension" />
                <input type='hidden' name='view' value='searchresults'/>
            </form>
        </div>

    </div>
</div>