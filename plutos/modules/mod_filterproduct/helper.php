<?php

defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_standard/models', 'StandardModel');

class ModFilterproductHelper {

    /**
     * Display the search button as an image.
     *
     * @param   string  $button_text  The alt text for the button.
     *
     * @return  string  The HTML for the image.
     *
     * @since   1.5
     */
    public static function getFilterproductImage($button_text) {
        return JHtml::_('image', 'searchButton.gif', $button_text, null, true, true);
    }

    /**
     * Proxy for getModel.
     */
    /*
    public static function getModel($name = 'Routes', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_standard/models');
        JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_standard/tables');
        $getModel = JModelLegacy::getInstance($name, $prefix, $config);
        return $getModel;
    }

    public static function getList() {
        // Get the model.
        $model = self::getModel();
        $model->setState("list.ordering", "r.ordering");
        $model->setState("list.direction", "desc");
        $items = $model->getItems();
        return $items;
    }
    */
    public static function getForm() {
        // Get an instance of the generic products model
        $model = JModelLegacy::getInstance('Search', 'StandardModel', array('ignore_request' => true));
         // Retrieve Standard
        $form = $model->getForm(array(), true, 'SearchProducts');

        if (empty($form)) {
            return false;
        }
        return $form;
    }

}
