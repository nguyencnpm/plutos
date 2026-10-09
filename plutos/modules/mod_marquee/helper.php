<?php

defined('_JEXEC') or die('Restricted access');

class modMarquee_nowHelper {

    public static function getList(&$params) {
        $items = null;
        /*
          $app = JFactory::getApplication();
          $db = JFactory::getDbo();
          $query = "

          "
          ;

          $db->setQuery($query);
          $items = $db->loadObjectList();
         */
        return $items;
    }

    public static function renderMarquee(&$params, &$list = null) {
        $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
        require JModuleHelper::getLayoutPath('mod_marquee', $params->get('layout', 'default'));
    }

}
