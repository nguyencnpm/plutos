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
    <div class="row">
        <div class="col-12 col-sm-6">
            <?php echo $this->form->getControlGroup('contact_fullName'); ?>
        </div>
        <div class="col-12 col-sm-6">
            <?php echo $this->form->getControlGroup('contact_phone'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6">
            <?php echo $this->form->getControlGroup('contact_email'); ?>
        </div>
        <div class="col-12 col-sm-6">
            <?php echo $this->form->getControlGroup('contact_country_id'); ?>
        </div>
    </div>

    <?php //echo $this->form->getControlGroup('tour_id'); ?>
    <?php echo $this->form->getControlGroup('contact_subject'); ?>
    <?php echo $this->form->getControlGroup('contact_message'); ?>

    <?php if ($this->captchaEnabled): ?>
        <div class="mb-3 captcha captcha--center">
            <?php echo $this->form->getInput('captcha'); ?>
            <div class="invalid-feedback"><?php echo JText::_('CONTACT_DATA_ERROR'); ?></div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 mb-3 pt-2 align-center captcha-submit--center">
            <button class="btn using-btn-danger radius-0 border-0 text-uppercase px-3 w-100" type="submit">
                <i class="processing display-none display-processing fa fa-spinner fa-pulse"></i>
                <?php echo JText::_('COM_STANDARD_SUBMIT_YOUR_REQUEST'); ?>
            </button>
        </div>
        <div class="col-md-2"></div>
    </div>

    <input type='hidden' name='jform[layout]' value='contact'/>
    <input type='hidden' name='jform[confirm_page_type_id]' value='1'/>
    <input type='hidden' name='task' value="payment.contact"/>
    <input type='hidden' name='option' value='com_standard'/>
    <?php echo JHtml::_('form.token'); ?>
</form>

<script type="text/javascript" language="javascript">
    function onReCaptchaSuccess() {
        $('.captcha .invalid-feedback').css({
            'display': 'none'
        });
        $('.was-validated .captcha .required.g-recaptcha').css({
            'border': '1px solid #28a745'
        });
        $('.g-recaptcha').removeClass('error');
    }

    function  onReCaptchaExpired() {

    }

    function onReCaptchaError() {

    }
</script>