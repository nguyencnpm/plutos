<?php
defined('_JEXEC') or die;
?>
<form id="enquiryForm" class="form-vertical enquiryForm" method="post" action="<?php //echo JRoute::_(StandardHelperRoute::getLinkMenuItemRoute('index.php?option=com_standard&view=done')); ?>" <?php //echo $captchaEnabled ? ' onsubmit="return validateFormEnquiry();" ' : ' ' ?>>
    <div class="modal-header">
        <?php if ($isShowCloseButton): ?>
            <a class="btn btn-close close <?php echo!empty($closebutton_pos) ? "close--{$closebutton_pos}" : ""; ?>" data-dismiss="modal" aria-label="Close">
                <?php echo empty(trim($anchor_css)) ? empty(trim($closebutton_text)) ? "<span aria-hidden=\"true\">&times;</span>" : "<span aria-hidden=\"true\">{$closebutton_text}</span>" : "<i class=\"{$anchor_css}\" aria-hidden=\"true\"></i>" ?>
            </a>
        <?php endif; ?>
        <?php if ($isShowTitle): ?>
            <h4 class="modal-title"><?php echo $params->get('openenquiry_title'); ?></h4>
        <?php endif; ?>
    </div>
    <div class="modal-body">
        <div class="form-group"><?php echo $form->getControlGroup('contact_name'); ?></div>

        <div class="row">
            <div class="col-md-6"><div class="form-group"><?php echo $form->getControlGroup('contact_phone'); ?></div></div>
            <div class="col-md-6"><div class="form-group"><?php echo $form->getControlGroup('contact_email'); ?></div></div>
        </div>

        <div class="form-group"><?php echo $form->getControlGroup('contact_flighttypeid'); ?></div>

        <div class="row">
            <div class="col-md-6"><div class="form-group"><?php echo $form->getControlGroup('contact_country_id'); ?></div></div>
            <div class="col-md-6"><div class="form-group"><?php echo $form->getControlGroup('enquiry_datedeparture'); ?></div></div>
        </div>

        <div class="form-group"><?php echo $form->getControlGroup('contact_message'); ?></div>
        <?php if ($captchaEnabled): ?>
            <div class="form-group">
                <div class="col-xs-12 captcha-center">
                    <div id="recaptcha-error" class="msg-error hidden"><?php echo JText::_('CONTACT_DATA_ERROR'); ?></div>
                    <?php echo $form->getInput('captcha'); ?>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="modal-footer">
        <?php // <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> ?>
        <div class="form-group">
            <div class="col-xs-12 captcha-submit">
                <button type="submit" name="flightenquiry" value="flightenquiry" class="btn btn-override btn-primary-override no-percent loading-progress-circle">
                    <i class="fa-progress-enquiry none fa-absolute fa fa-spinner fa-pulse"></i>
                    <?php echo $button_text; ?>
                </button>
            </div>
        </div>
    </div>
    <input type='hidden' name='task' value="payment.enquiry"/>
    <input type='hidden' name='option' value='com_standard'/>
    <?php echo JHtml::_('form.token'); ?>
</form>
<script type="text/javascript" language="javascript">
    function validateFormEnquiry() {
        var captcha_response = grecaptcha.getResponse();
        if (captcha_response.length == 0)
        {
            $('#recaptcha-error').removeClass("hidden");
            $('#jform_captcha').addClass("error");
            $(".fa-progress-contact").addClass("none");
            // Captcha is not Passed
            return false;
        } else
        {
            $('#recaptcha-error').addClass("hidden");
            $('#jform_captcha').removeClass("error");
            // Captcha is Passed
            return true;
        }
    }
    function onReCaptchaSuccess() {
        $(".loading-progress-circle").removeAttr("disabled");
        $('#recaptcha-error').addClass("hidden");
        $('#jform_captcha').removeClass("error");
        //validateFormContactUs();
    }
    function  onReCaptchaExpired() {
        $(".loading-progress-circle").removeAttr("disabled");
    }
    function  onReCaptchaError() {
        $(".loading-progress-circle").removeAttr("disabled");
    }
</script>
