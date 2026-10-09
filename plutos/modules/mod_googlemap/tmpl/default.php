<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_googlemap
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$sublayout = "_apikey";
if (!empty($sUsingMode)):
    $sublayout = $sUsingMode;
endif;

?>
<div class="map<?php echo $class_sfx; ?>">
    <?php require JModuleHelper::getLayoutPath('mod_googlemap', $sublayout); ?>
    <?php if (!empty($content_map)): ?>
        <div class="content-map mb-3">
            <?php echo $content_map; ?>
        </div>
    <?php endif; ?>
</div>