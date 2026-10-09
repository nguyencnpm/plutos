<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

$params = $displayData['params'];
$item = $displayData['item'];
$sClass = isset($displayData['class']) ? $displayData['class'] : "";
$target = isset($item->linktarget) ? $item->linktarget : "";
?>

<a target="<?php echo $target; ?>" class="<?php echo $sClass; ?>" href="<?php echo $displayData['link']; ?>" itemprop="url">
    <?php echo $item->urltext ?>
</a>
