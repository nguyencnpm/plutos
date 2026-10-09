<?php
defined('_JEXEC') or die;
$introcount = count($this->form->getFieldset('user_details'));
$columns = 2;
$counter = 0;
$key = 0;
?>
<?php foreach ($this->form->getFieldset('user_details') as $field) : ?>
    <?php $rowcount = ((int) $key % (int) $columns) + 1; ?>
    <?php if ($rowcount === 1) : ?>
        <?php $row = $counter / $columns; ?>
        <div class="row-fluid">
        <?php endif; ?>
        <div class="span<?php echo round(12 / $columns); ?>">
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
            <!-- end item -->
            <?php $counter++; ?>
        </div><!-- end span -->
        <?php if (($rowcount == $columns) or ( $counter == $introcount)) : ?>
        </div><!-- end row -->
    <?php endif; ?>
    <?php $key ++; ?>
<?php endforeach; ?>
