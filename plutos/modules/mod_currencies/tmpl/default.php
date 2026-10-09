<?php
defined('_JEXEC') or die;

//$uri = JFactory::getURI();
$uri = JUri::getInstance();
$request = JRequest::get();

$route_id = $app->getUserState('com_standard.search.filter.route_id', '');
$departure_day = $app->getUserState('com_standard.search.filter.departure_day', '');

?>
<form name="formCurrency" action="<?php echo $uri->toString(); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php if ($params->get('display_label')): ?>
                    <label class="label-currency">
                        <?php echo empty($params->get('label')) ? JText::_('MOD_CURRENCIES_CURRENCY') : $params->get('label'); ?>
                    </label>
                <?php endif; ?>
                <select class="form-control currency custom-select d-block w-100 page-loading-progress-change" name="currency_id" <?php echo $params->get('button') ? "" : "onchange=\"this.form.submit();\"" ?>>
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
    <?php if ($params->get('button')): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input class="button" type="submit" name="change_currencies" value="<?php echo jtext::_('MOD_CURRENCIES_CHANGE_CURRENCIES') ?>" />
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php
    switch ($request['view']) {
        case "information":
            ?>

            <?php
            break;

        case "SelectProducts":
            ?>
            <input type='hidden' name='search' value='<?php echo empty($request['search']) ? "" : $request['search']; ?>'/>
            <?php
            break;
        default:
            break;
    }
    ?>
    <input type='hidden' name='route_id' value='<?php echo $route_id; ?>'/>
    <input type='hidden' name='departure_day' value='<?php echo $departure_day; ?>'/>
    <input type="hidden" name="option" value='<?php echo $request['option']; ?>'/>
    <input type='hidden' name='view' value='<?php echo $request['view']; ?>'/>
    <?php echo JHtml::_('form.token'); ?>
</form>