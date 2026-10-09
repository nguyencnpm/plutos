<?php
/**
 * @copyright   Binh Nguyen.
 */
defined('JPATH_BASE') or die;

$form = $displayData->getForm();

$title = $form->getField('title') ? 'title' : ($form->getField('name') ? 'name' : '');
$subtitle = $form->getField('subtitle') ? 'subtitle' : ($form->getField('name') ? 'name' : '');
$code = $form->getField('code')?'code':'';
?>
<div class="form-inline form-inline-header">
    <?php
    echo $title ? $form->renderField($title) : '';
    echo $form->renderField('alias');
    echo $subtitle ? $form->renderField($subtitle) : '';
    echo $code ? $form->renderField($code) : '';
    ?>
</div>
