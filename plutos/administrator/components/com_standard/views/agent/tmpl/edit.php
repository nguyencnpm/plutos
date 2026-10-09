<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select', null, array('disable_search_threshold' => 0));

$this->configFieldsets = array('editorConfig');
$this->hiddenFieldsets = array('basic-limited');
$this->ignore_fieldsets = array('jmetadata', 'item_associations');

// Create shortcut to parameters.
$params = $this->state->get('params');

$app = JFactory::getApplication();
$input = $app->input;

// This checks if the config options have ever been saved. If they haven't they will fall back to the original settings.
$params = json_decode($params);
$editoroptions = isset($params->show_publishing_options);

if (!$editoroptions) {
    $params->show_publishing_options = '1';
    $params->show_agent_options = '1';
    $params->show_urls_images_standard_backend = '0';
    $params->show_urls_images_standard_frontend = '0';
}

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "agent.cancel" || document.formvalidator.isValid(document.getElementById("item-form")))
		{
			jQuery("#permissions-sliders select").attr("disabled", "disabled");
			Joomla.submitform(task, document.getElementById("item-form"));

			if (task !== "agent.apply")
			{
				window.parent.jQuery("#agentEdit' . (int) $this->item->id . 'Modal").modal("hide");
			}
		}
	};
');

// In case of modal
$isModal = $input->get('layout') == 'modal' ? true : false;
$layout = $isModal ? 'modal' : 'edit';
$tmpl = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

    <?php //echo JLayoutHelper::render('standard.edit.user', $this); ?>
    <?php echo JLayoutHelper::render('standard.edit.title_alias', $this); ?>

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_STANDARD_AGENT_DETAILS')); ?>
        <div class="row-fluid">
            <div class="span9">
                <fieldset class="adminform">
                    <?php echo $this->loadTemplate('agentdetails'); ?>
                </fieldset>
            </div>
            <div class="span3">
                <?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php // Do not show the images and links options if the edit form is configured not to.  ?>
        <?php if ($params->show_urls_images_backend == 1) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'images', JText::_('COM_STANDARD_FIELDSET_AVATAR_IMAGES')); ?>
            <div class="row-fluid form-horizontal-desktop">
                <div class="span12">
                    <?php echo $this->form->renderField('images'); ?>
                    <?php foreach ($this->form->getGroup('images') as $field) : ?>
                        <?php echo $field->renderField(); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>

        <?php //$this->show_options = $params->show_agent_options; ?>
        <?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

        <?php // Do not show the publishing options if the edit form is configured not to. ?>
        <?php if ($params->show_publishing_options == 1) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('COM_STANDARD_FIELDSET_PUBLISHING')); ?>
            <div class="row-fluid form-horizontal-desktop">
                <div class="span12">
                    <?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
                </div>
            </div>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
