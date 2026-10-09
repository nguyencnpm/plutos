<?php

defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_standard/models', 'StandardModel');

class ModSubscribeHelper {

    /**
     * Display the subscribe button as an image.
     *
     * @param   string  $button_text  The alt text for the button.
     *
     * @return  string  The HTML for the image.
     *
     * @since   1.5
     */
    public static function getSubscribeImage($button_text) {
        return JHtml::_('image', 'subscribeButton.gif', $button_text, null, true, true);
    }

    /**
     * Proxy for getModel.
     */

    public static function getForm() {
        // Get an instance of the generic products model
        $model = JModelLegacy::getInstance('Contact', 'StandardModel', array('ignore_request' => true));
        // Retrieve Standard
        $form = $model->getForm(array(), true, 'subscribe');
        if (empty($form)) {
            return false;
        }
        return $form;
    }

}
