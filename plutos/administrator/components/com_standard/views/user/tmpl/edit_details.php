<?php
defined('_JEXEC') or die;
?>
<?php foreach ($this->form->getFieldset('user_details') as $field) : ?>
    <div class="control-group">
        <div class="control-label">
            <?php echo $field->label; ?>
        </div>
        <div class="controls">
            <?php if ($field->fieldname == 'password') : ?>
                <input type="password" style="display:none"> <!-- Disables autocomplete -->
            <?php endif; ?>
            <?php echo $field->input; ?>
        </div>
    </div>
<?php endforeach; ?>
