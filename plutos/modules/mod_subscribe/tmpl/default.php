<?php
defined('_JEXEC') or die;
?>
<div class="subscribe<?php echo $class_sfx; ?>">
    <form id="<?php echo $keyform; ?>" data-keyform="<?php echo $keyform; ?>" target="<?php echo $params->get('linktarget'); ?>" class="subscribeForm form-validate needs-validation form-vertical" novalidate name="subscribeForm" action="<?php echo JRoute::_('index.php?option=com_standard&view=confirm'); ?>" method="post">
        <?php if (isset($form) && !empty($form)): ?>
            <div class="row">
                <div class="col-12 control-label-hidden"><?php echo $form->getControlGroup('subscribe_email'); ?></div>
            </div>
        <?php endif; ?>
        <input type='hidden' name='jform[layout]' value='subscribe'/>
        <input type='hidden' name='jform[confirm_page_type_id]' value='13'/>
        <input type="hidden" name="option" value="com_standard" />
        <input type='hidden' name='task' value='payment.subscribe'/>
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>