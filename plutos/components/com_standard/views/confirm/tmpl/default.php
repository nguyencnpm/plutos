<?php
defined('_JEXEC') or die;
?>
<div class="col-12">
    <div class="confirm-page">
        <meta itemprop="inLanguage" content="<?php echo ($this->item['language'] === '*') ? JFactory::getConfig()->get('language') : $this->item['language']; ?>" />
        <?php
        $app = JFactory::getApplication();
        $app->redirect(JURI::root(false));
        ?>
    </div>
</div>

