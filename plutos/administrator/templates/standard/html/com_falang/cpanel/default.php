<?php
// No direct access to this file
defined('_JEXEC') or die;

$params = JComponentHelper::getParams('com_falang');
$downloadid = $params->get('downloadid');
$version = new FalangVersion();
?>
<?php if (!empty($this->sidebar)): ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <div class="alert alert-info">
            <?php echo JText::_('Translation'); ?>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="box box-primary">
                    <div class="box-header with-border" style="height: 150px">
                        <h3 class="box-title"><?php echo JText::_('COM_FALANG_CPANEL_CONFIGURATION'); ?></h3>
                        <div class="body">
                            <?php echo $this->loadTemplate('configuration'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div id="j-main-container">
    </div>
<?php endif; ?>
