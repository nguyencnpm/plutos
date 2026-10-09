<?php

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_standard/models', 'StandardModel');

/**
 * @author Binh Nguyen
 * 
 * Helper for mod_sidewidget
 *
 * @since  1.6
 */
abstract class ModSidewidgetHelper {
    public static function getForm() {
        // Get an instance of the generic products model
        $model = JModelLegacy::getInstance('Registration', 'StandardModel', array('ignore_request' => true));
         // Retrieve Standard
        $form = $model->getForm();
        if (empty($form)) {
            return false;
        }
        return $form;
    }
    public static function getList(&$params) {
        
    }
}
?>

