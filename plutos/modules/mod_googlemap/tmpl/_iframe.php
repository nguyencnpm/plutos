<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_googlemap
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<iframe class="mb-3"
    src="<?php echo trim($params->get('url')); ?>" frameborder="0" allowfullscreen="<?php echo $params->get('allowfullscreen') > 0 ? true : "" ?>"
    style="
    border:0;
    width: <?php echo is_numeric($width) ? $width . "px" : $width; ?>;
    height: <?php echo is_numeric($height) ? $height . "px" : $height; ?>">
</iframe>
