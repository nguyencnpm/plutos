<?php

/**
 * @package     giaiphapcongnghethongtin.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('JPATH_BASE') or die;

/**
 * Form Field class for the Platform.
 *
 * Provides a pop up date picker linked to a button.
 * Optionally may be filtered to use user's or server's time zone.
 *
 * @since  11.1
 */
class JFormFieldDaterangepicker extends JFormField {

    /**
     * The form field type.
     *
     * @var    string
     * @since  11.1
     */
    protected $type = 'Daterangepicker';

    /**
     * Name of the layout being used to render the field
     *
     * @var    string
     * @since  3.7.0
     */
    protected $layout = 'standard.form.field.daterangepicker';
}
