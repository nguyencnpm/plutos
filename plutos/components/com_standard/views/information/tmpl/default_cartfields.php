<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<h4><?php echo JText::_('COM_STANDARD_CONTACT_US_REQUEST_BELOW') ?></h4>
<p class="star">*<?php echo JText::_('COM_STANDARD_CONTACT_US_REQUIRED_FIELD') ?></p>

<form id="informationForm" class="needs-validation informationForm" novalidate method="post" name="information" action="<?php echo JRoute::_('index.php?option=com_standard&view=confirm'); ?>">
    <div class="row">
        <div class="col-12 mb-3">
            <?php echo $this->form->getLabel('contact_fullName'); ?>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                </div>
                <?php echo $this->form->getInput('contact_fullName'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6 mb-3">
            <?php echo $this->form->getControlGroup('contact_gender'); ?>
        </div>
        <div class="col-12 col-lg-6 mb-3">
            <?php echo $this->form->getControlGroup('contact_birthday'); ?>
        </div>
    </div>

    <div class="mb-3">
        <?php echo $this->form->getLabel('contact_email'); ?>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
            </div>
            <?php echo $this->form->getInput('contact_email'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6 mb-3">
            <?php echo $this->form->getLabel('contact_phone'); ?>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                </div>
                <?php echo $this->form->getInput('contact_phone'); ?>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-3">
            <?php echo $this->form->getLabel('contact_fax'); ?>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-fax" aria-hidden="true"></i></span>
                </div>
                <?php echo $this->form->getInput('contact_fax'); ?>
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
    <div class="using-max-width mx-auto">
        <div class="mb-3 align-center captcha-submit--center">
            <button class="btn using-btn-danger color-white text-uppercase w-100 <?php echo count($this->cart->products) > 0 ? '' : 'disabled'; ?>" type="submit">
                <i class="processing display-none display-processing fa fa-spinner fa-pulse"></i>
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                <?php echo JText::_('COM_STANDARD_SEND'); ?>
            </button>
        </div>
    </div>
    <input type='hidden' name='task' value='payment.reserve'/>
    <input type='hidden' name='option' value='com_standard'/>
    <input type='hidden' name='view' value='confirm'/>
    <?php echo JHtml::_('form.token'); ?>
</form>
