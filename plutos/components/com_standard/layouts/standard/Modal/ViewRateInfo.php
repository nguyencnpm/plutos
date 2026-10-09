<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

$params = $displayData['params'];
$item = $displayData['item'];

//echo '<pre>';
//print_r($params);
//exit;
$idModalViewRateInfo = "RateInfo_id" . $item->id . "_catid" . $item->catid . "_cg_" . $item->catid . "_departure_day_" . strtotime($item->allotment_date);
?>
<p class="readmore">
    <!-- Button trigger modal -->
    <a class="viewmore" data-toggle="modal" data-target="#<?php echo $idModalViewRateInfo; ?>">
        <i class="fa fa-plus fa-1" aria-hidden="true"></i>
        <?php echo JText::_('COM_STANDARD_VIEW_RATE'); ?>
    </a>
</p>
<?php // -- Modal -- ?>
<div class="modal fade" id="<?php echo $idModalViewRateInfo; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo JText::_('COM_STANDARD_VIEW_RATE'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $item->introtext . $item->fulltext;?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--override" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
// -- /.Modal -- ?>