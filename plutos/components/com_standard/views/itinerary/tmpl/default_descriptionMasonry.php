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
if (isset($this->item->description_column) && $this->item->description_column > 0):
    $columnIntro = (int) $this->item->description_column;
endif;

$cColumns = "d-flex col-12 col-lg-" . round(12 / $columnIntro);

$oDescriptions = json_decode($this->item->descriptions);
?>
<div class="items-row row masonry-grid-system">
    <!-- add extra container element for Masonry -->
    <div class="grid">
        <!-- add sizing element for columnWidth -->
        <div class="grid-sizer <?php echo $cColumns; ?>"></div>
        <?php foreach ($oDescriptions as $key => $oDesc) : ?>
            <?php $aData = array(); ?>
            <?php if ((int) $oDesc->description_status > 0): ?>
                <div class="grid-item <?php echo $cColumns; ?>">
                    <?php
                    $this->itemdescription = $oDesc;
                    echo $this->loadTemplate('itemDescription');
                    ?>
                    <?php // -- end item --  ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

