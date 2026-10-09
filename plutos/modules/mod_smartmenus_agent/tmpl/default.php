<?php
/**
 * @author      Binh Nguyen! Project
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_smartmenus_agent
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>

<div class="menus-agent<?php echo $class_sfx; ?>  navbar-nav navbar-items mr-auto mx-sub-start-end-0 d-flex justify-content-end w-100">
    <div class="row">
        <div class="nav-item col-md-auto px-0 d-none d-sm-block">
            <a class="reset nav-item-link" href="" data-toggle="modal" data-target="#account" ><?php echo JText::_("MOD_SMARTMENUS_AGENT_NAV_REGISTRATION") ?></a>
        </div>
        <div class="nav-item col-auto px-0">
            <a class="nav-item-link" href="" data-toggle="modal" data-target="#logIn"><?php echo JText::_('MOD_SMARTMENUS_AGENT_NAV_LOGIN'); ?></a>
        </div>
        <div class="nav-item col-auto px-0 switchboard">
            <a class="hotline nav-item-link" href="tel:<?php echo JText::_('MOD_SMARTMENUS_AGENT_NAV_PHONE'); ?>"> <i class="fa fa-phone" aria-hidden="true"></i> <?php echo JText::_('MOD_SMARTMENUS_AGENT_NAV_PHONE'); ?></a>
        </div>
    </div>
</div>