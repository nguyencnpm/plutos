<?php
defined('_JEXEC') or die;

class ModCurrenciesHelper {
    
     /**
     * Proxy for getModel.
     */
    public static function getModel($name = 'Currencies', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_standard/models');
        JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_standard/tables');
        $getModel = JModelLegacy::getInstance($name, $prefix, $config);
        return $getModel;
    }

    public static function getList() {
        $comParams = JComponentHelper::getParams('com_standard');
        $listCurrency = $comParams->get('vendor_accepted_currencies');
        // Get the model.
        $model = self::getModel('Currencies');
        $model->setState("filter.published", 1);
        $model->setState("filter.currency_id", $listCurrency);
        $model->setState("list.ordering", "crc.ordering");
        $model->setState("list.direction", "desc");
        
        return $model->getItems();
    }
}

