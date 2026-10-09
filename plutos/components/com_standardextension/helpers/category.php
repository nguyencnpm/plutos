<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standardextension
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Standardextension Component Category Tree
 *
 * @since  1.6
 */
class StandardextensionCategories extends JCategories {

    /**
     * Class constructor
     *
     * @param   array  $options  Array of options
     *
     * @since   1.7.0
     */
    public function __construct($options = array()) {
        $options['table'] = '#__standardextension_content';
        $options['extension'] = 'com_standardextension';

        parent::__construct($options);
    }

}
