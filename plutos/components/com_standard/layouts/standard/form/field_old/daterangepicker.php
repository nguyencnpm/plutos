<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

use Joomla\Utilities\ArrayHelper;

extract($displayData);

// Get some system objects.
$document = JFactory::getDocument();

$inputvalue = '';

// Build the attributes array.
$attributes = array();

empty($size) ? null : $attributes['size'] = $size;
empty($maxlength) ? null : $attributes['maxlength'] = ' maxlength="' . $maxLength . '"';
empty($class) ? null : $attributes['class'] = $class;
!$readonly ? null : $attributes['readonly'] = 'readonly';
!$disabled ? null : $attributes['disabled'] = 'disabled';
empty($onchange) ? null : $attributes['onchange'] = $onchange;

if ($required) {
    $attributes['required'] = '';
    $attributes['aria-required'] = 'true';
}

if (!isset($value)) {
    $value = '';
}

$readonly = isset($attributes['readonly']) && $attributes['readonly'] == 'readonly';
$disabled = isset($attributes['disabled']) && $attributes['disabled'] == 'disabled';

if (is_array($attributes)) {
    $attributes = ArrayHelper::toString($attributes);
}
?>
<div class="field-daterangepicker">
    <div class="input-group daterange">
        <input type="text" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo htmlspecialchars($value, ENT_COMPAT, 'UTF-8'); ?>" <?php echo $attributes; ?>
               <?php echo!empty($hint) ? 'placeholder="' . htmlspecialchars($hint, ENT_COMPAT, 'UTF-8') . '"' : ''; ?> data-alt-value="<?php echo htmlspecialchars($value, ENT_COMPAT, 'UTF-8'); ?>" autocomplete="off"/>
        <div class="input-group-prepend">
            <label for="<?php echo $id; ?>" class="input-group-text">
                <i class="fa fa-calendar fa-calendar-color" aria-hidden="true"></i>
            </label>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
