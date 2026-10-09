<?php

/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

use Joomla\CMS\Language\LanguageHelper;

/**
 * Supports a modal itineraryType picker.
 *
 * @since  3.1
 */
class JFormFieldModal_ItineraryType extends JFormField {

    /**
     * The form field type.
     *
     * @var     string
     * @since   1.6
     */
    protected $type = 'Modal_ItineraryType';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.6
     */
    protected function getInput() {
        if ($this->element['extension']) {
            $extension = (string) $this->element['extension'];
        } else {
            $extension = (string) JFactory::getApplication()->input->get('extension', 'com_standard');
        }

        $allowNew = ((string) $this->element['new'] == 'true');
        $allowEdit = ((string) $this->element['edit'] == 'true');
        $allowClear = ((string) $this->element['clear'] != 'false');
        $allowSelect = ((string) $this->element['select'] != 'false');
        $allowPropagate = ((string) $this->element['propagate'] == 'true');

        $languages = LanguageHelper::getContentLanguages(array(0, 1));

        // Load language.
        JFactory::getLanguage()->load('com_standard', JPATH_ADMINISTRATOR);

        // The active itineraryType id field.
        $value = (int) $this->value > 0 ? (int) $this->value : '';

        // Create the modal id.
        $modalId = 'ItineraryType_' . $this->id;

        // Add the modal field script to the document head.
        JHtml::_('jquery.framework');
        JHtml::_('script', 'system/modal-fields.js', array('version' => 'auto', 'relative' => true));

        // Script to proxy the select modal function to the modal-fields.js file.
        if ($allowSelect) {
            static $scriptSelect = null;

            if (is_null($scriptSelect)) {
                $scriptSelect = array();
            }

            if (!isset($scriptSelect[$this->id])) {
                JFactory::getDocument()->addScriptDeclaration("
				function jSelectItineraryType_" . $this->id . "(id, title, object) {
					window.processModalSelect('ItineraryType', '" . $this->id . "', id, title, '', object);
				}
				");

                JText::script('JGLOBAL_ASSOCIATIONS_PROPAGATE_FAILED');

                $scriptSelect[$this->id] = true;
            }
        }

        // Setup variables for display.
        $linkCategories = 'index.php?option=com_standard&amp;view=itineraryTypes&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1'
                . '&amp;extension=' . $extension;
        $linkItineraryType = 'index.php?option=com_standard&amp;view=itineraryType&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1'
                . '&amp;extension=' . $extension;
        $modalTitle = JText::_('COM_STANDARD_ITINERARIES_CHANGE_ITINERARY_TYPE');

        if (isset($this->element['language'])) {
            $linkCategories .= '&amp;forcedLanguage=' . $this->element['language'];
            $linkItineraryType .= '&amp;forcedLanguage=' . $this->element['language'];
            $modalTitle .= ' &#8212; ' . $this->element['label'];
        }

        $urlSelect = $linkCategories . '&amp;function=jSelectItineraryType_' . $this->id;
        $urlEdit = $linkItineraryType . '&amp;task=itineraryType.edit&amp;id=\' + document.getElementById("' . $this->id . '_id").value + \'';
        $urlNew = $linkItineraryType . '&amp;task=itineraryType.add';

        if ($value) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                    ->select($db->quoteName('title'))
                    ->from($db->quoteName('#__standard_itinerary_types'))
                    ->where($db->quoteName('id') . ' = ' . (int) $value);
            $db->setQuery($query);

            try {
                $title = $db->loadResult();
            } catch (RuntimeException $e) {
                JError::raiseWarning(500, $e->getMessage());
            }
        }

        $title = empty($title) ? JText::_('COM_STANDARD_ITINERARIES_SELECT_A_ITINERARY_TYPE') : htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        // The current itineraryType display field.
        $html = '<span class="input-append">';
        $html .= '<input class="input-medium" id="' . $this->id . '_name" type="text" value="' . $title . '" disabled="disabled" size="35" />';

        // Select itineraryType button.
        if ($allowSelect) {
            $html .= '<a'
                    . ' class="btn hasTooltip' . ($value ? ' hidden' : '') . '"'
                    . ' id="' . $this->id . '_select"'
                    . ' data-toggle="modal"'
                    . ' role="button"'
                    . ' href="#ModalSelect' . $modalId . '"'
                    . ' title="' . JHtml::tooltipText('COM_STANDARD_ITINERARIES_CHANGE_ITINERARY_TYPE') . '">'
                    . '<span class="icon-file" aria-hidden="true"></span> ' . JText::_('JSELECT')
                    . '</a>';
        }

        // New itineraryType button.
        if ($allowNew) {
            $html .= '<a'
                    . ' class="btn hasTooltip' . ($value ? ' hidden' : '') . '"'
                    . ' id="' . $this->id . '_new"'
                    . ' data-toggle="modal"'
                    . ' role="button"'
                    . ' href="#ModalNew' . $modalId . '"'
                    . ' title="' . JHtml::tooltipText('COM_STANDARD_ITINERARIES_NEW_ITINERARY_TYPE') . '">'
                    . '<span class="icon-new" aria-hidden="true"></span> ' . JText::_('JACTION_CREATE')
                    . '</a>';
        }

        // Edit itineraryType button.
        if ($allowEdit) {
            $html .= '<a'
                    . ' class="btn hasTooltip' . ($value ? '' : ' hidden') . '"'
                    . ' id="' . $this->id . '_edit"'
                    . ' data-toggle="modal"'
                    . ' role="button"'
                    . ' href="#ModalEdit' . $modalId . '"'
                    . ' title="' . JHtml::tooltipText('COM_STANDARD_ITINERARIES_EDIT_ITINERARY_TYPE') . '">'
                    . '<span class="icon-edit" aria-hidden="true"></span> ' . JText::_('JACTION_EDIT')
                    . '</a>';
        }

        // Clear itineraryType button.
        if ($allowClear) {
            $html .= '<a'
                    . ' class="btn' . ($value ? '' : ' hidden') . '"'
                    . ' id="' . $this->id . '_clear"'
                    . ' href="#"'
                    . ' onclick="window.processModalParent(\'' . $this->id . '\'); return false;">'
                    . '<span class="icon-remove" aria-hidden="true"></span>' . JText::_('JCLEAR')
                    . '</a>';
        }

        // Propagate itineraryType button
        if ($allowPropagate && count($languages) > 2) {
            // Strip off language tag at the end
            $tagLength = (int) strlen($this->element['language']);
            $callbackFunctionStem = substr("jSelectItineraryType_" . $this->id, 0, -$tagLength);

            $html .= '<a'
                    . ' class="btn hasTooltip' . ($value ? '' : ' hidden') . '"'
                    . ' id="' . $this->id . '_propagate"'
                    . ' href="#"'
                    . ' title="' . JHtml::tooltipText('JGLOBAL_ASSOCIATIONS_PROPAGATE_TIP') . '"'
                    . ' onclick="Joomla.propagateAssociation(\'' . $this->id . '\', \'' . $callbackFunctionStem . '\');">'
                    . '<span class="icon-refresh" aria-hidden="true"></span>' . JText::_('JGLOBAL_ASSOCIATIONS_PROPAGATE_BUTTON')
                    . '</a>';
        }

        $html .= '</span>';

        // Select itineraryType modal.
        if ($allowSelect) {
            $html .= JHtml::_(
                            'bootstrap.renderModal', 'ModalSelect' . $modalId, array(
                        'title' => $modalTitle,
                        'url' => $urlSelect,
                        'height' => '400px',
                        'width' => '800px',
                        'bodyHeight' => '70',
                        'modalWidth' => '80',
                        'footer' => '<a role="button" class="btn" data-dismiss="modal" aria-hidden="true">' . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>',
                            )
            );
        }

        // New itineraryType modal.
        if ($allowNew) {
            $html .= JHtml::_(
                            'bootstrap.renderModal', 'ModalNew' . $modalId, array(
                        'title' => JText::_('COM_STANDARD_ITINERARIES_NEW_ITINERARY_TYPE'),
                        'backdrop' => 'static',
                        'keyboard' => false,
                        'closeButton' => false,
                        'url' => $urlNew,
                        'height' => '400px',
                        'width' => '800px',
                        'bodyHeight' => '70',
                        'modalWidth' => '80',
                        'footer' => '<a role="button" class="btn" aria-hidden="true"'
                        . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'add\', \'itineraryType\', \'cancel\', \'item-form\'); return false;">'
                        . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>'
                        . '<a role="button" class="btn btn-primary" aria-hidden="true"'
                        . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'add\', \'itineraryType\', \'save\', \'item-form\'); return false;">'
                        . JText::_('JSAVE') . '</a>'
                        . '<a role="button" class="btn btn-success" aria-hidden="true"'
                        . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'add\', \'itineraryType\', \'apply\', \'item-form\'); return false;">'
                        . JText::_('JAPPLY') . '</a>',
                            )
            );
        }

        // Edit itineraryType modal.
        if ($allowEdit) {
            $html .= JHtml::_(
                            'bootstrap.renderModal', 'ModalEdit' . $modalId, array(
                        'title' => JText::_('COM_STANDARD_ITINERARIES_EDIT_ITINERARY_TYPE'),
                        'backdrop' => 'static',
                        'keyboard' => false,
                        'closeButton' => false,
                        'url' => $urlEdit,
                        'height' => '400px',
                        'width' => '800px',
                        'bodyHeight' => '70',
                        'modalWidth' => '80',
                        'footer' => '<a role="button" class="btn" aria-hidden="true"'
                        . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'edit\', \'itineraryType\', \'cancel\', \'item-form\'); return false;">'
                        . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>'
                        . '<a role="button" class="btn btn-primary" aria-hidden="true"'
                        . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'edit\', \'itineraryType\', \'save\', \'item-form\'); return false;">'
                        . JText::_('JSAVE') . '</a>'
                        . '<a role="button" class="btn btn-success" aria-hidden="true"'
                        . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'edit\', \'itineraryType\', \'apply\', \'item-form\'); return false;">'
                        . JText::_('JAPPLY') . '</a>',
                            )
            );
        }

        // Note: class='required' for client side validation
        $class = $this->required ? ' class="required modal-value"' : '';

        $html .= '<input type="hidden" id="' . $this->id . '_id"' . $class . ' data-required="' . (int) $this->required . '" name="' . $this->name
                . '" data-text="' . htmlspecialchars(JText::_('COM_STANDARD_ITINERARIES_SELECT_A_ITINERARY_TYPE', true), ENT_COMPAT, 'UTF-8') . '" value="' . $value . '" />';

        return $html;
    }

    /**
     * Method to get the field label markup.
     *
     * @return  string  The field label markup.
     *
     * @since   3.7.0
     */
    protected function getLabel() {
        return str_replace($this->id, $this->id . '_id', parent::getLabel());
    }

}
