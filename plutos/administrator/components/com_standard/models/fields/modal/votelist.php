<?php

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

/**
 * Votelist Field class.
 *
 * @since  3.7.1
 */
class JFormFieldVotelist extends JFormFieldList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.7.1
     */
    protected $type = 'Votelist';

    /**
     * Method to get the field options.
     *
     * @return array The field option objects.
     *
     * @throws \Exception
     *
     * @since  3.7.1
     */
    public function getOptions() {
        // Requires vote plugin enabled
        return JPluginHelper::isEnabled('content', 'vote') ? parent::getOptions() : array();
    }

}
