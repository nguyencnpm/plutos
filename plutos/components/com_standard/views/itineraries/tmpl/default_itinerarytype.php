<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="<?php echo $this->item->params->get('layoutelement'); ?> mx-auto text-center mb-5">
    <div class="row">
        <div class="col-12 page-header">
            <h3 class="<?php echo $this->item->params->get('pageclass_subheading'); ?>"><?php echo $this->item->itinerarytype_title; ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php echo $this->item->itinerarytype_description; ?>
        </div>
    </div>
</div>

