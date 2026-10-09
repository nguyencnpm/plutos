<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Standard Component Information Model
 *
 * @since  1.5
 */
class StandardModelInformation extends JModelForm {

    /**
     * Model context string.
     *
     * @var        string
     */
    protected $_context = 'com_standard.information';

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
        $aFormPost = $app->input->post->get('jform', array(), 'array');
        // Load state from the request.
        $pk = $app->input->getInt('id');
        $this->setState('information.id', $pk);

        $offset = $app->input->getUInt('limitstart');
        $this->setState('list.offset', $offset);

        if (isset($aFormPost['shipmentmethod_id'])):
            $app->setUserState($this->_context . '.filter.shipmentmethod_id', $aFormPost['shipmentmethod_id']);
        endif;
        $iShipmentMethodId = $app->getUserStateFromRequest($this->_context . '.filter.shipmentmethod_id', 'filter_shipmentmethod_id', 0);
        $this->setState($this->_context . '.filter.shipmentmethod_id', $iShipmentMethodId);
        // Load the parameters.
        $params = $app->getParams();
        $this->setState('params', $params);

        // TODO: Tune these values based on other permissions.
        $user = JFactory::getUser();

        if ((!$user->authorise('core.edit.state', 'com_standard')) && (!$user->authorise('core.edit', 'com_standard'))) {
            $this->setState('filter.published', 1);
            $this->setState('filter.archived', 2);
        }

        $this->setState('filter.language', JLanguageMultilang::isEnabled());
    }

    /**
     * Method to get the information form.
     * The base form is loaded from XML and then an event is fired
     *
     * @param   array    $data      An optional array of data for the form to interrogate.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  JForm  A JForm object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = $this->loadForm('com_standard.information', 'contact', array('control' => 'jform', 'load_data' => true));
        if (empty($form)) {
            return false;
        }

        // Set Value the form
        $form->setValue('shipmentmethod_id', 0, $this->getState($this->_context . '.filter.shipmentmethod_id'));
        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  array    The default data is an empty array.
     *
     * @since   1.6.2
     */
    protected function loadFormData() {
        $data = (array) JFactory::getApplication()->getUserState('com_standard.information.data', array());

        if (empty($data['language']) && JLanguageMultilang::isEnabled()) {
            $data['language'] = JFactory::getLanguage()->getTag();
        }

        $this->preprocessData('com_standard.information', $data);

        return $data;
    }

    /**
     * Method to get information data.
     *
     * @param   integer  $pk  The id of the information.
     *
     * @return  object|boolean|JException  Menu item data object on success, boolean false or JException instance on error
     */
    public function getItem($pk = null) {

        $user = JFactory::getUser();

        $pk = (!empty($pk)) ? $pk : (int) $this->getState('information.id');
        if (!isset($this->_item[$pk])) {
            try {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                        ->select(
                        $this->getState(
                                'item.select', 'p.id, p.asset_id, p.title, p.alias, p.introtext, p.fulltext'
                                . ', p.price, p.in_stock, p.ordered'
                                . ', p.currency_id, p.calculation_id, p.promotion_id, p.catid, p.state'
                                . ', p.images, p.attribs'
                                . ', p.metakey, p.metadesc, p.metadata, p.language, p.xreference'
                        )
                );
                $query->from('#__standard_products AS p')
                        ->where('p.id = ' . (int) $pk);

                // Join on category table.
                $query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access')
                        ->innerJoin('#__standard_categories AS c on c.id = p.catid')
                        ->where('c.published > 0');

                // Join over the manufacturer.
                $query->select('GROUP_CONCAT(m.id SEPARATOR ", ") as manufacturer_ids, GROUP_CONCAT(m.title SEPARATOR ", ") as manufacturer_title')
                        ->join('LEFT', '#__standard_product_manufacturer_map AS map ON map.product_id = p.id')
                        ->join('LEFT', '#__standard_manufacturers AS m ON m.id = map.manufacturer_id and m.state in(1)')
                        ->group('p.id');

                // Join on user table.
                $query->select('u.name AS author')
                        ->join('LEFT', '#__users AS u on u.id = p.created_by');

                // Filter by language
                if ($this->getState('filter.language')) {
                    $query->where('p.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
                }

                // Join over the categories to get parent category titles
                $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
                        ->join('LEFT', '#__standard_categories as parent ON parent.id = c.parent_id');

                // Filter by published state.
                $published = $this->getState('filter.published');
                $archived = $this->getState('filter.archived');

                if (is_numeric($published)) {
                    $query->where('(p.state = ' . (int) $published . ' OR p.state =' . (int) $archived . ')');
                }

                $db->setQuery($query);

                $data = $db->loadObject();

                if (empty($data)) {
                    return JError::raiseError(404, JText::_('COM_STANDARD_ERROR_PRODUCT_NOT_FOUND'));
                }

                // Check for published state if filter set.
                if ((is_numeric($published) || is_numeric($archived)) && (($data->state != $published) && ($data->state != $archived))) {
                    return JError::raiseError(404, JText::_('COM_STANDARD_ERROR_PRODUCT_NOT_FOUND'));
                }

                // Convert parameter fields to objects.
                $registry = new Registry($data->attribs);

                $data->params = clone $this->getState('params');
                $data->params->merge($registry);

                $data->metadata = new Registry($data->metadata);

                $this->_item[$pk] = $data;
            } catch (Exception $e) {
                if ($e->getCode() == 404) {
                    // Need to go thru the error handler to allow Redirect to work.
                    JError::raiseError(404, $e->getMessage());
                } else {
                    $this->setError($e);
                    $this->_item[$pk] = false;
                }
            }
        }

        return $this->_item[$pk];
    }

}
