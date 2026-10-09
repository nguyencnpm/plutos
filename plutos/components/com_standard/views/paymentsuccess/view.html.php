<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Frontpage View class
 *
 * @since  1.5
 */
class StandardViewPaymentsuccess extends JViewLegacy {

    public function display($tpl = null) {
        $this->params = JRequest::get();
        parent::display($tpl);
    }
}
