<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$dataTableHTMLColumns = 2;
?>
<?php $aData = StandardHelperQuery::getDataTableHTML($this->itemitinerary->itinerary, $dataTableHTMLColumns); ?>
<?php if (!empty($aData)): ?>
    <div class="item flex-fill mb-4 <?php echo $this->itemitinerary->itinerary_status == 0 ? ' system-unpublished' : null; ?>">
        <h4 class="item-subtitle cut-string-multiple-lines"><?php echo $this->itemitinerary->title; ?></h4>
        <div class="item-subtitle-masthead line-1 mb-1"></div>
        <div class="content tag-p-mtb-0">
            <?php foreach ($aData as $kData => $aValue) : ?>
                <div class="row">
                    <div class="pr-0 col-4 col-xl-3 mb-3 d-flex justify-content-between align-items-start">
                        <div class="item-time font-weight-bold"><?php echo $aValue[0]; ?></div>
                        <div class="">:</div>
                    </div>
                    <div class="col-8 col-xl-9 mb-3">
                        <div class="item-content text-justify-left"><?php echo $aValue[1]; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
