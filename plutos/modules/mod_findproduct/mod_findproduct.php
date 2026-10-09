<?php

defined('_JEXEC') or die;
if (!class_exists('StandardHelperRoute')) {
    JLoader::register('StandardHelperRoute', JPATH_SITE . '/components/com_standard/helpers/route.php');
}
// Include the search functions only once
JLoader::register('ModFindproductHelper', __DIR__ . '/helper.php');
$form = ModFindproductHelper::getForm();

$lang = JFactory::getLanguage();
$app = JFactory::getApplication();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

$today = JFactory::getDate()->format('Y-m-d');
$ojbtoday1day = new JDate($today . ' +1 day');
$today1day = $ojbtoday1day->format('Y-m-d');

// --- Params layout ---
$modules = JModuleHelper::getModules('load-currency');
$sLayoutCurrency = "";

$cGroupLeft = "col-md-10";
$cGroupLeftRoute = "col-md-6 col-lg-7";
$cGroupLeftDeparture = "col-md-6 col-lg-5";

$cGroupRight = "col-md-2";
$cGroupRightCurrency = "col-md-0";
$cGroupRightSearch = "col-md-12";
if (!empty($modules)) {
    $sParamsLoadCurrency = $modules[0]->params;
    $aParamsLoadCurrency = json_decode($sParamsLoadCurrency);
    if (trim($aParamsLoadCurrency->layout) == '_:currency-readonly') {
        $sLayoutCurrency = trim($aParamsLoadCurrency->layout);

        // --- case: load currency readonly ---
        if (!class_exists('CurrencyHelper')) {
            JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
        }
        $currencyDisplay = CurrencyHelper::getInstance();
        $currency_id = $app->getUserStateFromRequest('currency_id', 'currency_id', $currencyDisplay->_currency_id);
        // --- /. case: load currency readonly ---
    }

    $cGroupLeft = "col-lg-8";
    $cGroupLeftRoute = "col-md-6 col-lg-7";
    $cGroupLeftDeparture = "col-md-6 col-lg-5";

    $cGroupRight = "col-lg-4";
    $cGroupRightCurrency = "col-6 col-sm-5 col-md-6";
    $cGroupRightSearch = "col-6 col-sm-7 col-md-6";
}
// --- /. Params layout ---
// $list = ModFindproductHelper::getList();

require JModuleHelper::getLayoutPath('mod_findproduct', $params->get('layout', 'default'));
