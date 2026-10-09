<?php
/**
 * @package     Giaiphapcongnghethongtin.vn.Plugin
 * @subpackage  Content.socialsharing
 * @author      Binh Nguyen
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
/**
 * Socialsharing Plugin is a module using for Display icons for your online social networking sites.
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
$string = '';
$imageURL = '';
$config = new stdClass();

$config->addthis_pub = $this->params->get('system-addthis-account', 'giaiphapcongnghethongtin');
$config->ui_header_color = '#' . $this->params->get('header_color', '888888');
$config->ui_header_background = '#' . $this->params->get('system-addthis-header_background', '999999');
$config->ui_cobrand = $this->params->get('system-addthis-brand_name', 'giaiphapcongnghethongtin.vn');

$system_addthis_services_exclude = $this->params->get('system-addthis-services_exclude') ? explode(',', $this->params->get('system-addthis-services_exclude')) : array();
// detect language code, check swiching language with joomfish

$language_code = $this->params->get('or_language_code') != '' ? $this->params->get('or_language_code') : $this->params->get('system-addthis-language_code', 'en');
// if set auto chang language.
if ($language_code == 'auto') {
    $lg = JFactory::getLanguage();
    $lang = $lg->get('tag', 'en-GB');
    $tmp = explode('-', $lang);
    $language_code = $tmp[0];
}

$config->ui_language = $language_code;
// if using custom apps socical
if ($this->params->get('system-addthis-services_exclude'))
    $config->services_exclude = $this->params->get('system-addthis-services_exclude');
if ($this->params->get('system-addthis-services_compact'))
    $config->services_compact = $this->params->get('system-addthis-services_compact');
if ($this->params->get('system-addthis-services_expanded'))
    $config->services_expanded = $this->params->get('system-addthis-services_expanded');
// offset position.
if ($this->params->get('system-addthis-vertical_offset'))
    $config->ui_offset_top = $this->params->get('system-addthis-vertical_offset');
if ($this->params->get('system-addthis-horizontal_offset'))
    $config->ui_offset_left = $this->params->get('system-addthis-horizontal_offset');

$config->data_track_addressbar = false;
$config->data_track_clickback = false;


// image button
if (!$this->params->get('used_custom_button')) {
    $imgLanguageCode = 'en';
    $systemaddthisbutton = $this->params->get('system-addthis-button', 'lg-share');
    switch ($systemaddthisbutton) {

        case 'tb22':
            $string .= '<div class="addthis_toolbox addthis_default_style " addthis:url="' . JURI::current() . '">';
            if (!(isset($system_addthis_services_exclude) && in_array('facebook_like', $system_addthis_services_exclude))) {
                $string .= '<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>';
            }
            if (!(isset($system_addthis_services_exclude) && in_array('twitter', $system_addthis_services_exclude))) {
                $string .= '<a class="addthis_button_tweet"></a>';
            }
            if (!(isset($system_addthis_services_exclude) && in_array('pinterest', $system_addthis_services_exclude))) {
                $string .= '<a class="addthis_button_pinterest_pinit"></a>';
            }
            $string .= '<a class="addthis_counter addthis_pill_style"></a></div>';
            break;
        case 'tb15':
            // <!-- AddThis Button BEGIN -->
            $string .= '
                <div class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="' . JURI::current() . '">
                    <a class="addthis_button_preferred_1"></a>
                    <a class="addthis_button_preferred_2"></a>
                    <a class="addthis_button_preferred_3"></a>
                    <a class="addthis_button_preferred_4"></a>
                    <a class="addthis_button_compact"></a>
                    <a class="addthis_counter addthis_bubble_style"></a>
                </div>
            ';
            // <!-- AddThis Button END -->
            break;
        case 'tb14':
            // <!-- AddThis Button BEGIN -->
            $string .= '
                <div class="addthis_toolbox addthis_default_style " addthis:url="' . JURI::current() . '">
                    <a class="addthis_button_preferred_1"></a>
                    <a class="addthis_button_preferred_2"></a>
                    <a class="addthis_button_preferred_3"></a>
                    <a class="addthis_button_preferred_4"></a>
                    <a class="addthis_button_compact"></a>
                    <a class="addthis_counter addthis_bubble_style"></a>
                </div>
            ';
            // <!-- AddThis Button END -->
            break;
        case 'bn3':
            // <!-- AddThis Button BEGIN -->
            $string .= '
                <a addthis:url="' . JURI::current() . '" class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=' . $this->params->get('system-addthis-account', 'giaiphapcongnghethongtin') . '"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>
            ';
            // <!-- AddThis Button END -->
            break;
        case 'tb19':
            // <!-- AddThis Button BEGIN -->
            $string .= '<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;top:50px;" addthis:url="' . JURI::current() . '">';
            if (!(isset($system_addthis_services_exclude) && in_array('facebook_like', $system_addthis_services_exclude))) {
                $string .= '<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>';
            }
            if (!(isset($system_addthis_services_exclude) && in_array('twitter', $system_addthis_services_exclude))) {
                $string .= '<a class="addthis_button_tweet" tw:count="vertical"></a>';
            }
            if (!(isset($system_addthis_services_exclude) && in_array('google_plusone', $system_addthis_services_exclude))) {
                $string .= '<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>';
            }
            $string .= '<a class="addthis_counter"></a></div>';
            // <!-- AddThis Button END -->
            break;
        case 'tb20':
            // <!-- AddThis Button BEGIN -->
            $string .= '
                <div class="addthis_toolbox addthis_floating_style addthis_32x32_style" style="left:50px;top:50px;" addthis:url="' . JURI::current() . '">
                    <a class="addthis_button_preferred_1"></a>
                    <a class="addthis_button_preferred_2"></a>
                    <a class="addthis_button_preferred_3"></a>
                    <a class="addthis_button_preferred_4"></a>
                    <a class="addthis_button_compact"></a>
                </div>
            ';
            // <!-- AddThis Button END -->
            break;
        case 'tb21':
            // <!-- AddThis Button BEGIN -->
            $string .= '
                <div class="addthis_toolbox addthis_floating_style addthis_16x16_style" style="left:50px;top:50px;" addthis:url="' . JURI::current() . '">
                    <a class="addthis_button_preferred_1"></a>
                    <a class="addthis_button_preferred_2"></a>
                    <a class="addthis_button_preferred_3"></a>
                    <a class="addthis_button_preferred_4"></a>
                    <a class="addthis_button_compact"></a>
                </div>
            ';
            // <!-- AddThis Button END -->
            break;
        default:

            if ($this->params->get('system-addthis-button', 'lg-share') != 'sm-plus') {
                if (($this->params->get('system-addthis-button', 'lg-share') == 'lg-share') || ($this->params->get('system-addthis-button', 'lg-share') == 'sm-share')) {
                    $imgLanguageCode = $language_code;
                }

                $imageURL = 'http://s7.addthis.com/static/btn/' . $this->params->get('system-addthis-button', 'lg-share') . '-' . $imgLanguageCode . '.gif';
            } else {
                $imageURL = 'http://s7.addthis.com/static/btn/sm-plus.gif';
            }
            $string .= '<a href="http://www.addthis.com/bookmark.php" onmouseover="return addthis_open(this, \'\', \'[URL]\', \'[TITLE]\')" onmouseout="addthis_close()" onclick="return addthis_sendto()">';
            if ($this->params->get('system-addthis-button') != 'none') {
                if (!empty($imageURL)) {
                    $string .= '<img src="' . $imageURL . '"  border="0" alt="" /> ';
                }
            }
            $string .= '</a>';
            break;
    }
} else {
    $imageURL = $this->params->get('custom_button');
    $class_suffix = $this->params->get('class_sfx') ? ' class="' . $this->params->get('class_sfx') . '"' : '';
    $string .= '<a href="http://www.addthis.com/bookmark.php" onmouseover="return addthis_open(this, \'\', \'[URL]\', \'[TITLE]\')" onmouseout="addthis_close()" onclick="return addthis_sendto()">';
    $string .= '<img' . $class_suffix . ' src="' . $imageURL . '"  border="0" alt="" /> ';
    $string .= $this->params->get('widget_text') . '</a>';
}

$string .= '
    <script type="text/javascript">var addthis_config = ' . json_encode($config) . ';</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=' . $this->params->get('system-addthis-account', 'giaiphapcongnghethongtin') . '"></script>
';
$string .= '
    <script type="text/javascript">
        var addthis_reload = function(){
            if (window.addthis) {
                window.addthis = null;
                window._adr = null;
                window._atc = null;
                window._atd = null;
                window._ate = null;
                window._atr = null;
                window._atw = null;
                jQuery("#at20mc").remove();
            }
            jQuery.getScript("//s7.addthis.com/js/300/addthis_widget.js#pubid=' . $this->params->get('system-addthis-account', 'giaiphapcongnghethongtin') . '");
        }
    </script>
';
echo $string;
