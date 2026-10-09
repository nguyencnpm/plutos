<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>

<?php
$columnIntro = 1;
if (isset($this->item->itinerary_column) && $this->item->itinerary_column > 0):
    $columnIntro = (int) $this->item->itinerary_column;
endif;

$oItinerary = json_decode($this->item->itinerary);
?>
<div class="items-row row">
    <?php foreach ($oItinerary as $key => $oIti) : ?>
        <?php $aData = array(); ?>
        <?php if ((int) $oIti->itinerary_status > 0): ?>
            <div class="d-flex col-12 col-lg-<?php echo round(12 / $columnIntro); ?>">
                <?php
                $this->itemitinerary = $oIti;
                echo $this->loadTemplate('itemItinerary');
                ?>
                <?php // -- end item --  ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

