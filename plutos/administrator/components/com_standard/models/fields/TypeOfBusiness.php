<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\Form\Field;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('predefinedlist');

/**
 * Form Field to load a list of states
 *
 * @since  3.2
 */
class TypeOfBusinessField extends \JFormFieldPredefinedList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.2
     */
    public $type = 'TypeOfBusiness';

    /**
     * Available statuses
     *
     * @var  array
     * @since  3.2
     */
    protected $predefinedOptions = array(
        "Đại lý vé máy bay cấp 1"=>"Đại lý vé máy bay cấp 1",
        "Đại lý vé máy bay cấp 2"=>"Đại lý vé máy bay cấp 2",
        "Cộng tác viên"=>"Cộng tác viên",
        "Đại lý du lịch nội địa"=>"Đại lý du lịch nội địa",
        "Đại lý du lịch quốc tế"=>"Đại lý du lịch quốc tế",
        "Đối tác phân phối qua API"=>"Đối tác phân phối qua API",
        "Khách hàng doanh nghiệp"=>"Khách hàng doanh nghiệp",
        "Nhà cung cấp dịch vụ - Khách sạn"=>"Nhà cung cấp dịch vụ - Khách sạn",
        "Nhà cung cấp dịch vụ - Tour"=>"Nhà cung cấp dịch vụ - Tour",
        "Nhà cung cấp dịch vụ - Khác"=>"Nhà cung cấp dịch vụ - Khác",
        "Đối tác khác"=>"Đối tác khác"
    );

}
