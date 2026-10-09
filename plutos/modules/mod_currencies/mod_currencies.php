<?php

defined('_JEXEC') or die;
// Include the search functions only once
JLoader::register('ModCurrenciesHelper', __DIR__ . '/helper.php');

$lang = JFactory::getLanguage();
$app = JFactory::getApplication();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

$field_using_mode = $params->get('using_mode');

if (!class_exists('CurrencyHelper')) {
    JLoader::register('CurrencyHelper', JPATH_ADMINISTRATOR . '/components/com_standard/helpers/currency.php');
}
$currencyDisplay = CurrencyHelper::getInstance();
$currency_id = $app->getUserStateFromRequest('currency_id', 'currency_id', $currencyDisplay->_currency_id);
$list = ModCurrenciesHelper::getList();
require JModuleHelper::getLayoutPath('mod_currencies', $params->get('layout', 'default'));

