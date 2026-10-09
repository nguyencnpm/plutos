<?php

defined('_JEXEC') or die;

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
class StandardControllerRegistrations extends JControllerAdmin {

    /**
     * The context for persistent state.
     *
     * @var    string
     * @since  1.6
     */
    protected $context = 'com_standard.registrations';

    public function getModel($name = 'Registration', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }

    public function display($cachable = false, $urlparams = array()) {
        // Get the document object.
        $vName = 'registrations';
        // Get and render the view.
        if ($view = $this->getView($vName, 'raw')) {

            // Get the model for the view.
            /** @var StandardControllerRegistrations $model */
            $model = $this->getModel($vName);

            // Load the filter state.
            $app = JFactory::getApplication();

            $model->setState('filter.search', $app->getUserState($this->context . '.filter.search'));
            $model->setState('filter.registrationDate', $app->getUserState($this->context . '.filter.registrationDate'));
            $model->setState('filter.status', $app->getUserState($this->context . '.filter.status'));
            
            $model->setState('list.limit', 0);
            $model->setState('list.start', 0);

            $form = $this->input->get('jform', array(), 'array');

            $model->setState('basename', $form['basename']);
            $model->setState('compressed', $form['compressed']);

            // Create one year cookies.
            $cookieLifeTime = time() + 365 * 86400;
            $cookieDomain = $app->get('cookie_domain', '');
            $cookiePath = $app->get('cookie_path', '/');
            $isHttpsForced = $app->isHttpsForced();

            $app->input->cookie->set(
                    JApplicationHelper::getHash($this->context . '.basename')
                    , $form['basename']
                    , $cookieLifeTime
                    , $cookiePath
                    , $cookieDomain
                    , $isHttpsForced
                    , true
            );

            $app->input->cookie->set(
                    JApplicationHelper::getHash($this->context . '.compressed')
                    , $form['compressed']
                    , $cookieLifeTime
                    , $cookiePath
                    , $cookieDomain
                    , $isHttpsForced
                    , true
            );

            // Push the model into the view (as default).
            $view->setModel($model, true);

            // Push document object into the view.
            $view->document = JFactory::getDocument();

            $view->display();
        }

        return $this;
    }

}
