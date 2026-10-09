<?php
defined('JPATH_BASE') or die;

$form = $displayData->getForm();
$from = $form->getField('from_id') ? 'from_id' : '';
$to = $form->getField('to_id') ? 'to_id' : '';
$alias = $form->getField('alias') ? 'alias' : '';
?>
<div class="form-inline form-inline-header">
    <?php
    echo $from ? $form->renderField($from) : '';
    echo $to ? $form->renderField($to) : '';
    echo $alias ? $form->renderField('alias') : '';
    ?>
</div>
