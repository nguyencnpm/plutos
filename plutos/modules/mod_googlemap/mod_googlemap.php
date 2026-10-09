<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_googlemap
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the weblinks functions only once
require_once __DIR__ . '/helper.php';

//Parameters
$uniqid = $module->id;
$class_sfx = htmlspecialchars($params->get('class_sfx'), ENT_COMPAT, 'UTF-8');
// 
$sUsingMode = htmlspecialchars($params->get('using_mode'), ENT_COMPAT, 'UTF-8');
$width = $params->get('width', 600);
$height = $params->get('height', 300);

$map_type = $params->get('map_type', 'ROADMAP');
$zoom = $params->get('zoom', 8);

$content_map = $params->get("content_map", "");

if ($sUsingMode == '_apikey'):
    $fields = ModGooglemapHelper::getParams($module->id);

    /*
      $lat = $params->get('lat');
      $lng = $params->get('lng');
     */

    /*
      $address_map = $params->get("address_map", "");
      $content_map = $params->get("content_map", "");
      $doc = JFactory::getDocument();
     */

    //$doc->addScript('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyD5C-nMrGv04RmdGyVpbWVLHLYN9ISW3_A'); //Add map api script
    //$doc->addStyledeclaration("#googlemap {margin:0;padding:0;height:" . $height . "px}"); //Add inline stlesheet
    $language = JFactory::getLanguage();
    $mapApi = 'https://maps.googleapis.com/maps/api/js?language=' . $language->getTag() . '&v=3.exp&sensor=false';
    // $mapApi = '//maps.google.com/maps/api/js?language=' . $language->getTag();
    if ($params->get('api_key')) {
        $mapApi .= '&key=' . $params->get('api_key');
    }
    // $doc->addScript($mapApi);
    ?>
    <script src="<?php echo $mapApi; ?>"></script>
    <?php //$doc->addStyledeclaration("#map-canvas" . $uniqid . " {margin:0;padding:0;height:" . $height . "}"); //Add inline stlesheet ?>
    <?php else: ?>
    <?php ?>
<?php endif; ?>
<?php require JModuleHelper::getLayoutPath('mod_googlemap', $params->get('layout', 'default')); ?>