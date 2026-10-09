<?php

/**
 * @package     Giaiphapcongnghethongtin.vn.Plugin
 * @subpackage  system.facebooklivechat
 * @author      Binh Nguyen
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

class PlgSystemFacebooklivechat extends JPlugin {

    public function onAfterRender() {
        $app = JFactory::getApplication();
        if (!$app->isSite()) {
            return;
        }
        $page_id = $this->params->get('page_id', '');
        $loggedin = $this->params->def('logged_in_greeting');
        $loggedout = $this->params->def('logged_out_greeting');
        $strDreeting = " logged_in_greeting='$loggedin' logged_out_greeting='$loggedout' ";
        if($this->params->get('is_greeting')):
            $strDreeting = " ";
        endif;
        
        $page_color = $this->params->get('page_color');

        $isLanguage = $this->params->get('isLanguage', 0);
        $LanguageTag = "en_US";
        if (JLanguageMultilang::isEnabled() && $isLanguage):
            $LanguageTag = str_replace("-", "_",  str_replace("en-GB", "en_US", JFactory::getLanguage()->getTag()));
        endif;

        $facebooklivechat_code = "
            
            <div id='fb-root'></div>
      
            <script>
                window.fbAsyncInit = function() {
                    FB.init({
                      xfbml            : true,
                      version          : 'v8.0'
                    });
                };

                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = 'https://connect.facebook.net/$LanguageTag/sdk/xfbml.customerchat.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            
            <div class='fb-customerchat'
                attribution=setup_tool
                page_id='$page_id'
                $strDreeting
                theme_color=\"{$page_color}\">
            </div>
        ";

        $html = JResponse::getBody();
        $htmlSetBody = preg_replace("/<\/body>/", "\n\n" . $facebooklivechat_code . "\n\n</body>", $html);
        JResponse::setBody($htmlSetBody);
        return true;
    }

}

?>
