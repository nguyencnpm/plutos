<?php

/*
 * Binh Nguyen
 */
defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Environment\Browser;

jimport('informationtechnology.mobiledetect.mobile_detect');
jimport('fof.utils.ip');

class DetectUtils {

    public static function getDetectUtils() {
        $detectUtils = array();

        $version = new JVersion;
        $versionText = $version->getShortVersion();
        $number_version = (int) str_replace(".", "", $versionText);
        if (version_compare(JVERSION, '3.0', 'ge')) {
            if ($number_version < 380) {
                jimport('joomla.environment.browser');
                $browser = JBrowser::getInstance();
            } else {
                \JLoader::import('joomla.environment.browser');
                $browser = Browser::getInstance();
            }
        } else {
            \JLoader::import('joomla.environment.browser');
            $browser = Browser::getInstance();
        }
        $mobile = new MobileDetect();

        // Desktop - default
        $device = JText::_('Desktop');
        // Phone
        if ($mobile->isMobile()) {
            $device = JText::_('Phone');
        }
        // Tablet
        if ($mobile->isTablet()) {
            $device = JText::_('Tablet');
        }

        $detectUtils['ip_address'] = FOFUtilsIp::getIp();
        $detectUtils['device'] = $device; //booking_device
        $detectUtils['browser'] = $browser->getBrowser();

        return $detectUtils;
    }

}
