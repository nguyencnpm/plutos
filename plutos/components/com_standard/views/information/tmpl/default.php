<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
//$params = $this->item->params;
//$images = json_decode($this->item->images);
$user = JFactory::getUser();
//$info = $params->get('info_block_position', 0);
// Check if associations are implemented. If they are, define the parameter.
// $assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));
//JHtml::_('behavior.caption');

$pageHeader = "page-header";
$headerLevel = "1";
?>
<div class="col-12">
    <div class="<?php echo "item-page" . $this->pageclass_sfx; ?> contact-page">
        <meta itemprop="inLanguage" content="<?php echo JFactory::getConfig()->get('language'); ?>" />
        <?php if ($this->params->get('show_page_heading')) : ?>
            <div class="<?php echo $pageHeader; ?>">
                <h<?php echo $headerLevel; ?> class="<?php echo $this->params->get('pageclass_heading'); ?>"> 
                    <?php if ((int) $headerLevel == 1): ?>
                        <i class="<?php echo $this->params->get('menu-anchor_css'); ?>" aria-hidden="true"></i> 
                    <?php endif; ?>
                    <?php echo $this->escape($this->params->get('page_heading')); ?> 
                </h<?php echo $headerLevel; ?>>
                <?php if ($this->params->get('show_page_masthead')): ?>
                    <div class="masthead">&nbsp;</div>
                <?php endif; ?>
            </div>
            <?php
            $pageHeader = "subheading";
            $headerLevel = "2"; // set item_title 
            ?>
        <?php endif; ?>

        <div class="row">
            <?php
            $class_information_booking = "post d-flex col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 order-md-2 mb-4";
            $class_form = "post d-flex col-12 col-sm-12 col-md-6 col-lg-7 col-xl-8 cols-text order-md-1 mb-4";
            ?>
            <div class="<?php echo $class_information_booking; ?>">
                <div class="w-100 d-flex flex-column bg-info-booking rounded box-shadow">
                    <h3 class="title-cart px-3 py-2 rounded-top using-bg-yellow"><?php echo JText::_("COM_STANDARD_CART")?></h3>
                    <?php echo $this->loadTemplate('info'); ?>
                </div>
            </div>

            <div class="<?php echo $class_form; ?>">
                <div class="flex-fill bg-info-form box-shadow">
                    <?php echo $this->loadTemplate('cartfields'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

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