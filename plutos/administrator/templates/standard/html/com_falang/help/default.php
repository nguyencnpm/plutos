<?php

// No direct access to this file
defined('_JEXEC') or die;

if (!empty( $this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
    <div class="alert alert-info">
        <?php echo JText::_('Multilingual content manager');?>
    </div>
</div>
<?php else : ?>
    <div id="j-main-container"></div>
<?php endif;?>
