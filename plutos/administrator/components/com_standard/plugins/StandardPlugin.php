<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 * @author Binh Nguyen
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

abstract class StandardPlugin extends JPlugin {

    /**
     * onCheckAutomaticSelected
     * Checks how many plugins are available. If only one, the user will not have the choice. Enter edit_xxx page
     * The plugin must check first if it is the correct type
     *
     * @author Binh Nguyen
     * @param Cart cart: the cart object
     * @return null if no plugin was found, 0 if more then one plugin was found,  xxx_id if only one plugin is found
     *
     */
    function onCheckAutomaticSelected(Cart $cart, array $cart_prices = array(), &$methodCounter = 0) {

        $pluginmethod_id = 0;

        $nbMethod = $this->getSelectable($cart, $pluginmethod_id, $cart_prices);
        $methodCounter += $nbMethod;

        if ($nbMethod == NULL) {
            return NULL;
        } else {
            if ($nbMethod == 1) {
                return $pluginmethod_id;
            } else {
                return 0;
            }
        }
    }

}
