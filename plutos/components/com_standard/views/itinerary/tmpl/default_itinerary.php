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
$dataTableHTMLColumns = 2;
$columns = 2;
$oItinerary = json_decode($this->item->itinerary);
$flag = 0;
$collapseIn = "";
?>
<div class="itinerary w-100" id="accordion-itinerary"> 
    <?php foreach ($oItinerary as $key => $oIti) : ?>
        <?php $aData = array(); ?>
        <?php if ((int) $oIti->itinerary_status > 0): ?>
            <?php
            $collapseIn = $flag == 0 ? "in" : "";
            $faIcon = $flag == 0 ? "fa-caret-up" : "fa-caret-down"; // "fa-minus" : "fa-plus";
            $eActive = $flag == 0 ? "is-active" : "deeper";
            $aData = StandardHelperQuery::getDataTableHTML($oIti->itinerary, $dataTableHTMLColumns);
            ?>
            <div class="accordion__item <?php echo $eActive; ?>">
                <div class="accordion-more" role="button" data-toggle="collapse"> <?php //  more{$key % 2}  ?>
                    <div class="row">
                        <div class="col-12 text-center">
                            <a class="view-more" data-toggle="collapse" href="#<?php echo $key; ?>">
                                <div><?php echo $oIti->title; ?></div>
                                <i class="fa <?php echo $faIcon; ?> fa-2" aria-hidden="true"></i>
                                <div class="clearfix"></div>
                            </a>
                        </div> 
                    </div>
                </div>
                <div class="collapse <?php echo $collapseIn; ?>" id="<?php echo $key; ?>" role="tabpanel">
                    <?php foreach ($aData as $kData => $aValue) : ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="item-content timing"><?php echo $aValue[0]; ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="item-content"><?php echo $aValue[1]; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $flag = 1; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

