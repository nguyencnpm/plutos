<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

?>
<div class="itinerary-types<?php echo $this->pageclass_sfx; ?>">
    <?php
    echo JLayoutHelper::render('standard.product.ItineraryTypes_default', $this);
    echo $this->loadTemplate('items');
    ?>
</div>
