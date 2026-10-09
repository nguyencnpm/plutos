<?php

/**
 * @package     Giaiphapcongnghethongtin.vn.Plugin
 * @subpackage  Content.socialsharing
 * @author      Binh Nguyen
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');

class JFormFieldAddthis extends JFormField {
    /*
     * Category nam
     * @access	protected
     * @var     string
     */

    var $type = 'Addthis';

    function getInput() {
        $value = $this->value ? $this->value : (string) $this->element['default'];
        ob_start();
        require_once(dirname(__FILE__) . '/addthis/layout.php');
        $string = ob_get_contents();
        ob_end_clean();

        //$string = '<input class="color" value="' . $value . '" name="' . $this->name . '" >';

        return $string;
    }

}

?>