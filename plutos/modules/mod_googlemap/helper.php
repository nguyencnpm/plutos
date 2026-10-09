<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_googlemap
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class modgooglemapHelper {

    public static function fetchHead($params, $module) {
        /* $doc = JFactory::getDocument();
          $language = JFactory::getLanguage();
          $mapApi = '//maps.google.com/maps/api/js?language=' . $language->getTag();
          if ($params->get('api_key')) {
          $mapApi .= '&key=' . $params->get('api_key');
          }
          $doc->addScript($mapApi);
         * 
         */
    }

    public static function getParams($id) {
        if (isset($id) && ($id > 0)) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('params')
                    ->from('#__modules')
                    ->where("id={$id}");
            $db->setQuery($query);
            $array = $db->loadAssoc();
            $fields = json_decode($array['params']);
            $marker = $fields->marker;
            $marker_en = json_encode($marker);
            $fields->marker = $marker_en;
        } else {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('params')
                    ->from('#__modules')
                    ->where('module="mod_googlemap"');
            $db->setQuery($query);
            $array = $db->loadAssoc();
            $fields = json_decode($array['params']);
            $marker = $fields->marker;
            $marker_en = json_encode($marker);
            $fields->marker = $marker_en;
        }
        return $fields;
    }

}
