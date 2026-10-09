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
// --- ---
$delimiter = " - ";
// --- ---
$sValueStart = "";
$sValueEnd = "";
if (!empty($value)):
    $aTempValue = explode($delimiter, htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
    $sValueStart = isset($aTempValue[0]) ? trim($aTempValue[0]) : '';
    $sValueEnd = isset($aTempValue[1]) ? trim($aTempValue[1]) : '';
endif;

$hintStart = "";
$hintEnd = "";
if (!empty($hint)):
    $aTempHint = explode($delimiter, htmlspecialchars($hint, ENT_COMPAT, 'UTF-8'));
    $hintStart = isset($aTempHint[0]) ? 'placeholder="' . trim($aTempHint[0]) . '"' : '';
    $hintEnd = isset($aTempHint[1]) ? 'placeholder="' . trim($aTempHint[1]) . '"' : '';
endif;
$pattern = "#jform|\[|\]#";
$replacement = "";
$sTempName = preg_replace($pattern, $replacement, $name);
$nameStart = "jform[{$sTempName}_start]";
$nameEnd = "jform[{$sTempName}_end]";
?>
<div class="field-daterangepickercustom">
    <div class="row">
        <div class="col-12 pr-1">
            <div class="input-group daterange-custom mb-3">
                <input type="text" id="<?php echo $id . '_start'; ?>" name="<?php echo $nameStart; ?>" 
                       value="<?php echo $sValueStart; ?>" <?php echo $attributes; ?>
                       <?php echo $hintStart; ?> data-alt-value="<?php echo $sValueStart; ?>" autocomplete="off" >
                <div class="input-group-prepend">
                    <label for="<?php echo $id . '_start'; ?>" class="input-group-text">
                        <i class="fa fa-calendar fa-calendar-color" aria-hidden="true"></i>
                    </label>
                </div>
            </div>
        </div>
        <div class="d-none">
            <div class="input-group daterange-custom mb-3">
                <input type="text" id="<?php echo $id . '_end'; ?>" name="<?php echo $nameEnd; ?>" 
                       value="<?php echo $sValueEnd; ?>" <?php echo $attributes; ?>
                       <?php echo $hintEnd; ?> data-alt-value="<?php echo $sValueEnd; ?>" autocomplete="off" >
                <div class="input-group-prepend">
                    <label for="<?php echo $id . '_end'; ?>" class="input-group-text">
                        <i class="fa fa-calendar fa-calendar-color" aria-hidden="true"></i>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>