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
$class = isset($displayData['class']) ? $displayData['class'] : " mb-3";
$attributes = isset($displayData['attributes']) ? $displayData['attributes'] : "";
?>

<a class="btn booknow <?php echo $class; ?>" href="#<?php echo $displayData['link']; ?>" itemprop="url" <?php echo $attributes; ?>>
    <?php
    echo JText::_('COM_STANDARD_BOOK_NOW');
    ?>
</a>
