<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

//JHtml::_('behavior.keepalive');
//JHtml::_('behavior.formvalidator');
?>
<form id="contactForm" class="form-validate needs-validation form-vertical" novalidate action="<?php echo JRoute::_('index.php?option=com_standard&view=confirm'); ?>" method="post">
    <div class="mb-3">
        <?php echo $this->form->getLabel('contact_fullName'); ?>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
            </div>
            <?php echo $this->form->getInput('contact_fullName'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <?php echo $this->form->getLabel('contact_email'); ?>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                </div>
                <?php echo $this->form->getInput('contact_email'); ?>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-3">
            <?php echo $this->form->getLabel('contact_phone'); ?>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                </div>
                <?php echo $this->form->getInput('contact_phone'); ?>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <?php echo $this->form->getControlGroup('contact_message'); ?>
    </div>

    <?php if ($this->captchaEnabled): ?>
        <div class="mb-3 captcha captcha--center">
            <?php echo $this->form->getInput('captcha'); ?>
            <div class="invalid-feedback"><?php echo JText::_('CONTACT_DATA_ERROR'); ?></div>
        </div>
    <?php endif; ?>

    <div class="mb-3 align-center captcha-submit--center">
        <button class="btn btn-info btn-override" type="submit">
            <i class="processing display-none display-processing fa fa-spinner fa-pulse"></i>
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
            <?php echo JText::_('COM_STANDARD_SEND'); ?>
        </button>
    </div>

    <input type='hidden' name='task' value="payment.contact"/>
    <input type='hidden' name='option' value='com_standard'/>
    <?php echo JHtml::_('form.token'); ?>
</form>