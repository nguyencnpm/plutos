<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="flex-fill">
    <?php echo $this->loadTemplate('pricelist'); ?>
</div>
<div class="support p-3 rounded-bottom"> 
    <div class="phone-title">
        <i class="fa fa-phone" aria-hidden="true"></i>
        <?php echo JText::_('COM_STANDARD_SUPPORT_NUMBER'); ?>
    </div>
    <div class="phone">
        <?php echo $this->params->get('hotline_phone'); ?>
    </div>
</div>