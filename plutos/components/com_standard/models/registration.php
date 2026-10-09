<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2018 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

class StandardModelRegistration extends JModelForm {

    /**
     * Model context string.
     *
     * @var        string
     */
    protected $context = 'com_standard.registration';

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since   1.6
     *
     * @return void
     */
    protected function populateState() {
        $app = JFactory::getApplication('site');

        // Load the parameters. Merge Global and Menu Item params into new object
        $params = $app->getParams();
        $menuParams = new Registry;
        if ($menu = $app->getMenu()->getActive()) {
            $menuParams->loadString($menu->params);
        }

        $mergedParams = clone $menuParams;
        $mergedParams->merge($params);

        $this->setState('params', $mergedParams);
    }

    public function getForm($data = array(), $loadData = true, $sForm = 'registration') {
        // Get the form.
        $form = $this->loadForm('com_standard.registration', $sForm, array('control' => 'jform', 'load_data' => true));

        if (empty($form)) {
            return false;
        }
        return $form;
    }
    
    /**
     * Method to get a form object.
     *
     * @param   string   $name     The name of the form.
     * @param   string   $source   The form source. Can be XML string if file flag is set to false.
     * @param   array    $options  Optional array of options for the form creation.
     * @param   boolean  $clear    Optional argument to force load a new form.
     * @param   string   $xpath    An optional xpath to search for the fields.
     *
     * @return  \JForm|boolean  \JForm object on success, false on error.
     *
     * @see     \JForm
     * @since   1.6
     */
    protected function loadForm($name, $source = null, $options = array(), $clear = false, $xpath = false) {
        // Handle the optional arguments.
        $options['control'] = ArrayHelper::getValue((array) $options, 'control', false);

        // Create a signature hash. But make sure, that loading the data does not create a new instance
        $sigoptions = $options;

        if (isset($sigoptions['load_data'])) {
            unset($sigoptions['load_data']);
        }

        $hash = md5($source . serialize($sigoptions));

        // Check if we can use a previously loaded form.
        if (!$clear && isset($this->_forms[$hash])) {
            return $this->_forms[$hash];
        }
        // ---- Binh Nguyen override --- 
        // $sPathComponent: fix in case: module call getForm ('Joomla\CMS\Form\Form::getInstance() could not load file' )
        // Get the form.
        $sPathComponent = JPATH_SITE . '/components/com_standard';//JPATH_COMPONENT;
        
        \JForm::addFormPath($sPathComponent . '/models/forms');
        \JForm::addFieldPath($sPathComponent . '/models/fields');
        \JForm::addFormPath($sPathComponent . '/model/form');
        \JForm::addFieldPath($sPathComponent . '/model/field');
        // ---- /.Binh Nguyen override ----
        try {
            $form = \JForm::getInstance($name, $source, $options, false, $xpath);

            if (isset($options['load_data']) && $options['load_data']) {
                // Get the data for the form.
                $data = $this->loadFormData();
            } else {
                $data = array();
            }

            // Allow for additional modification of the form, and events to be triggered.
            // We pass the data because plugins may require it.
            $this->preprocessForm($form, $data);

            // Load the data into the form after the plugins have operated.
            $form->bind($data);
        } catch (\Exception $e) {
            $this->setError($e->getMessage());

            return false;
        }

        // Store the form for later.
        $this->_forms[$hash] = $form;

        return $form;
    }

}
