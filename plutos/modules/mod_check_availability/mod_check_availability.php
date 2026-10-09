<?php

defined('_JEXEC') or die;
if (!class_exists('StandardHelperRoute')) {
    JLoader::register('StandardHelperRoute', JPATH_SITE . '/components/com_standard/helpers/route.php');
}
// Include the search functions only once
JLoader::register('ModCheckavailabilityHelper', __DIR__ . '/helper.php');
$form = ModCheckavailabilityHelper::getForm();

$lang = JFactory::getLanguage();
$app = JFactory::getApplication();
$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');

$today = JFactory::getDate()->format('Y-m-d');
$ojbtoday1day = new JDate($today . ' +1 day');
$today1day = $ojbtoday1day->format('Y-m-d');

// --- Params layout ---
$modules = JModuleHelper::getModules('load-currency');
$sLayoutCurrency = "";

$cGroupLeft = "col-lg-9";
$cGroupLeftRoute = "col-lg-3 col-xl-4";
$cGroupLeftDeparture = "col-lg-9 col-xl-8";

$cGroupRight = "col-lg-3";
$cGroupRightCurrency = "col-lg-0";
$cGroupRightSearch = "col-lg-12";

if (!empty($modules)) {
    $sParamsLoadCurrency = $modules[0]->params;
    $aParamsLoadCurrency = json_decode($sParamsLoadCurrency);
    if (isset($aParamsLoadCurrency->layout)):
        if (trim($aParamsLoadCurrency->layout) == '_:currency-readonly') :
            $sLayoutCurrency = trim($aParamsLoadCurrency->layout);

            // --- case: load currency readonly ---
            if (!class_exists('CurrencyHelper')) {
                JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
            }
            $currencyDisplay = CurrencyHelper::getInstance();
            $currency_id = $app->getUserStateFromRequest('currency_id', 'currency_id', $currencyDisplay->_currency_id);
        // --- /. case: load currency readonly ---
        endif;
    endif;


    $cGroupLeft = "col-lg-8";
    $cGroupLeftRoute = "col-md-6 col-lg-7";
    $cGroupLeftDeparture = "col-md-6 col-lg-5";

    $cGroupRight = "col-lg-4";
    $cGroupRightCurrency = "col-6 col-sm-5 col-md-6";
    $cGroupRightSearch = "col-6 col-sm-7 col-md-6";
}
// --- /. Params layout ---
// $list = ModCheckavailabilityHelper::getList();

require JModuleHelper::getLayoutPath('mod_check_availability', $params->get('layout', 'default'));
