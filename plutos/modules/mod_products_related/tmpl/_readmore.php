<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_product_itineraries
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<a class="btn learnmore-no-bg radius-0 mb-3" href="<?php echo $item->link; ?>" itemprop="url">
    <?php
    if (empty($params->get('readmore_linktext'))):
        echo JText::_('COM_STANDARD_LEARN_MORE');
    else:
        echo $params->get('readmore_linktext');
    endif;
    ?>
</a>
