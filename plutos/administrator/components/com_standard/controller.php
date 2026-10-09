<?php

defined('_JEXEC') or die;

/**
 * Component Controller
 */
//[Name component]<Controller>
class StandardController extends JControllerLegacy {

    /**
     * @var string The default view.
     */
    protected $default_view = 'products';

    /**
     * Method to display a view.
     *
     * @param   boolean  $cachable   If true, the view output will be cached
     * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return  JController This object to support chaining.
     *
     */
    public function display($cachable = false, $urlparams = array()) {

        $view = $this->input->get('view', 'products');
        $layout = $this->input->get('layout', 'products');
        $id = $this->input->getInt('id');

        // Check for edit form.
        if ($view == 'product' && $layout == 'edit' && !$this->checkEditId('com_standard.edit.product', $id)) {
            // Somehow the person just went to the form - we don't allow that.
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect(JRoute::_('index.php?option=com_standard&view=products', false));
            return false;
        }

        return parent::display();
    }

}
