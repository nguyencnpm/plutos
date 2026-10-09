<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_itineraries_itinerary_types
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<ul class="itinerary-types-module<?php echo $class_sfx; ?> mod-list">
    <?php require JModuleHelper::getLayoutPath('mod_itineraries_itinerary_types', $params->get('layout', 'default') . '_items'); ?>
</ul>
