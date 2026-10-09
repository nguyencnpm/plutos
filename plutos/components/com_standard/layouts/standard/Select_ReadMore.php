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
?>

<p class="readmore">
    <a class="btn" href="<?php echo $displayData['link']; ?>" itemprop="url">
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
        <?php
        if (!$params->get('access-view')) :
            echo JText::_('COM_STANDARD_REGISTER_TO_READ_MORE');
        elseif ($readmore = $item->alternative_readmore) :
            echo $readmore;
            if ($params->get('show_readmore_title', 0) != 0) :
                echo JHtml::_('string.truncate', $item->product_title, $params->get('readmore_limit'));
            endif;
        elseif ($params->get('show_readmore_title', 0) == 0) :
            echo JText::sprintf('COM_STANDARD_READ_MORE_TITLE');
        else :
            echo JText::_('COM_STANDARD_READ_MORE');
            echo JHtml::_('string.truncate', $item->product_title, $params->get('readmore_limit'));
        endif;
        ?>
    </a>
</p>
