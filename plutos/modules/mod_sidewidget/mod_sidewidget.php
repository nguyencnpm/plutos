<?php

defined('_JEXEC') or die;

if (!class_exists('StandardHelperRoute')) {
    JLoader::register('StandardHelperRoute', JPATH_SITE . '/components/com_standard/helpers/route.php');
}
// Include the search functions only once
JLoader::register('ModSidewidgetHelper', __DIR__ . '/helper.php');

$form = ModSidewidgetHelper::getForm();

$lang = JFactory::getLanguage();
$app = JFactory::getApplication();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

/*
$isShowTitle = $params->get('openenquiry', 0);
$button_text = trim($params->get('button_text', JText::_('COM_STANDARD_CONTACT_US_SUBMIT')));

$isShowCloseButton = $params->get('closebutton', 0);
$closebutton_pos = $params->get('closebutton_pos', "");
$closebutton_text = $params->get('closebutton_text', "");
$anchor_css = $params->get('anchor_css', "");
// ==== captcha ====
$captchaEnabled = false;
$captchaSet = $app->get('captcha', '0');
$oCaptcha = new stdClass();

foreach (JPluginHelper::getPlugin('captcha') as $plugin) {
    if ($captchaSet === $plugin->name) {
        $oCaptcha = clone json_decode($plugin->params);
        $captchaEnabled = true;
        //php code
        JPluginHelper::importPlugin('captcha');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onInit', 'jform_captcha');

        break;
    }
}

// ==== /.captcha ====
*/
require JModuleHelper::getLayoutPath('mod_sidewidget', $params->get('layout', 'default'));
?>

