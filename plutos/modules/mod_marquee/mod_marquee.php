<?php

defined('_JEXEC') or die;

use Joomla\CMS\Environment\Browser;

$version = new JVersion;
$versionText = $version->getShortVersion();
$number_version = (int) str_replace(".", "", $versionText);
if (version_compare(JVERSION, '3.0', 'ge')) {
    if ($number_version < 380) {
        if (!class_exists('JBrowser')) {
            jimport('joomla.environment.browser');
        }
        $browser = JBrowser::getInstance();
    } else {
        if (!class_exists('Browser')) {
            \JLoader::import('joomla.environment.browser');
        }
        $browser = Browser::getInstance();
    }
} else {
    if (!class_exists('Browser')) {
        \JLoader::import('joomla.environment.browser');
    }
    $browser = Browser::getInstance();
}
// Include the syndicate functions only once
// Include the latest functions only once
JLoader::register('modMarquee_nowHelper', __DIR__ . '/helper.php');
$list = modMarquee_nowHelper::getList($params);
$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');
//modMarquee_nowHelper::renderMarquee($params, $list);
require JModuleHelper::getLayoutPath('mod_marquee', $params->get('layout', 'default'));
?>