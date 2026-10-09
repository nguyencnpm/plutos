<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_googlemap
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="map-key mb-3">
    <script type="text/javascript">
        var gmap_module_id = <?php echo $module->id; ?>;
        var gmap_module_ids = gmap_module_ids || [];
        gmap_module_ids.push(gmap_module_id);
        var cords = cords || [];
        cords[gmap_module_id] = cords[gmap_module_id] || <?php echo $fields->marker; ?>;
        var zoom = zoom || [];
        zoom[gmap_module_id] = zoom[gmap_module_id] || <?php echo (isset($fields->zoom) ? $fields->zoom : '10'); ?>;
        var mapType = mapType || [];
        mapType[gmap_module_id] = mapType[gmap_module_id] || <?php echo (isset($fields->type) ? $fields->type : 'google.maps.MapTypeId.ROADMAP'); ?>;
    </script>
    <script type="text/javascript" src="modules/mod_googlemap/js/map.js"></script>

    <div class="gp-google-map" style="max-width: <?php echo (isset($fields->width) ? is_numeric($fields->width) ? $fields->width . "px" : $fields->width : 600 . "px"); ?>;height: <?php echo (isset($fields->height) ? is_numeric($fields->height) ? $fields->height . "px" : $fields->height : 400 . "px"); ?>;margin-left: <?php echo isset($fields->margin) ? $fields->margin : "none"; ?>;margin-right: <?php echo isset($fields->margin) ? $fields->margin : "none"; ?>;">
        <div id="map-canvas<?php
        if ($module->id !== null) {
            echo $module->id;
        };
        ?>" class="gp-map"></div>
    </div>
</div>
<?php if (!empty($content_map)): ?>
    <div class="content-map mb-3">
        <?php echo $content_map; ?>
    </div>
<?php endif; ?>