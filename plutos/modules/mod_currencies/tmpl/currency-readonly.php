<?php
defined('_JEXEC') or die;

?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php if ($params->get('display_label')): ?>
                <label class="label-currency"><?php echo empty($params->get('label')) ? JText::_('MOD_CURRENCIES_CURRENCY') : $params->get('label'); ?>:</label>
            <?php endif; ?>
            <select class="form-control custom-select d-block w-100" name="currency_id">
                <?php foreach ($list as $key => $value) : ?>
                    <?php if ((int) $currency_id == (int) $value->id): ?>
                        <option value="<?php echo $value->id; ?>" selected="true"><?php echo $value->$field_using_mode; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->$field_using_mode; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>