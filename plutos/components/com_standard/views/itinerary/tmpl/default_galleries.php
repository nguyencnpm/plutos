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
$aGallery = (array) json_decode($this->item->galleries);
//echo '<pre>';
//print_r($this->item);
//exit;
?>
<?php if (sizeof($aGallery)): ?>
    <div class="differences differences-bg-icon-left-bottom mb-5">
        <div class="bg-icon-right-top">
            <div class="<?php echo isset($this->item->gallery_layout) && !empty($this->item->gallery_layout) ? $this->item->gallery_layout : "container-fluid"; ?>">
                <div class="row">
                    <div class="col-12 py-4">
                        <?php $cLayoutElement = isset($this->item->gallery_medialayoutelement) ? $this->item->gallery_medialayoutelement . " mx-auto " : ""; ?>
                        <div class="<?php echo $cLayoutElement; ?>">
                            <?php
                            $layoutMediaDisplayType = 'owlGallerySmallThumbnails';// (isset($this->item->gallery_mediadisplaytype) && !empty($this->item->gallery_mediadisplaytype)) ? $this->item->gallery_mediadisplaytype : "gallery";
                            echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => $layoutMediaDisplayType));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>