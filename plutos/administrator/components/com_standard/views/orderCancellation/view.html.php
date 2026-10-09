<?php

/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * View class for a list of order cancellation.
 *
 * @since  1.6
 */
// [name component]<View>[name view]
class StandardViewOrderCancellation extends JViewLegacy {

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null) {
        if ($this->getLayout() !== 'modal' || $this->getLayout() !== 'cancel') {
            StandardHelper::addSubmenu('orderCancellation'); //PATH: [name component]-> Helper->file[[name component].php] :: <class>[name component]<Helper>
        }

        $this->items = $this->get('Items');
        $this->state = $this->get('State');

        parent::display($tpl);
    }

}
?>

