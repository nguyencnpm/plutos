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

// Depends on jQuery UI
JHtml::_('jquery.ui', array('core', 'sortable'));

$this->configFieldsets = array('editorConfig');
$this->hiddenFieldsets = array('basic-limited');
$this->ignore_fieldsets = array('jmetadata', 'item_associations');

// Create shortcut to parameters.
$params = $this->state->get('params');

$app = JFactory::getApplication();
$input = $app->input;

$assoc = JLanguageAssociations::isEnabled();

// This checks if the config options have ever been saved. If they haven't they will fall back to the original settings.
$this->params = $params = json_decode($params);
$editoroptions = isset($params->show_publishing_options);

if (!$editoroptions) {
    $params->show_publishing_options = '1';
    $params->show_itinerary_options = '1';
    $params->show_urls_images_backend = '0';
    $params->show_urls_images_frontend = '0';
}

// Check if the itinerary uses configuration settings besides global. If so, use them.
if (isset($this->item->attribs['show_publishing_options']) && $this->item->attribs['show_publishing_options'] != '') {
    $params->show_publishing_options = $this->item->attribs['show_publishing_options'];
}

if (isset($this->item->attribs['show_itinerary_options']) && $this->item->attribs['show_itinerary_options'] != '') {
    $params->show_itinerary_options = $this->item->attribs['show_itinerary_options'];
}

if (isset($this->item->attribs['show_urls_images_frontend']) && $this->item->attribs['show_urls_images_frontend'] != '') {
    $params->show_urls_images_frontend = $this->item->attribs['show_urls_images_frontend'];
}

if (isset($this->item->attribs['show_urls_images_backend']) && $this->item->attribs['show_urls_images_backend'] != '') {
    $params->show_urls_images_backend = $this->item->attribs['show_urls_images_backend'];
}
// ' . $this->form->getField('itinerarytext')->save() . '
JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "itinerary.cancel" || document.formvalidator.isValid(document.getElementById("item-form")))
		{
			jQuery("#permissions-sliders select").attr("disabled", "disabled");
			
			Joomla.submitform(task, document.getElementById("item-form"));

			if (task !== "itinerary.apply")
			{
				window.parent.jQuery("#itineraryEdit' . (int) $this->item->id . 'Modal").modal("hide");
			}
		}
	};
');

// In case of modal
$isModal = $input->get('layout') == 'modal' ? true : false;
$layout = $isModal ? 'modal' : 'edit';
$tmpl = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate" enctype="multipart/form-data">

    <?php //echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
    <?php echo JLayoutHelper::render('standard.edit.subtitle', $this); ?>
    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_STANDARD_ITINERARY_INFORMATION')); ?>
        <div class="row-fluid">
            <div class="span8">
                <?php echo $this->loadTemplate('information'); ?>
            </div>
            <div class="span4">
                <?php echo JLayoutHelper::render('standard.edit.global', $this); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'descriptions', JText::_('COM_STANDARD_FIELDSET_DESCRIPTIONS')); ?>
        <div class="row-fluid form-horizontal-desktop">
            <div class="span12">
                <?php echo $this->loadTemplate('descriptions'); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php //echo JHtml::_('bootstrap.addTab', 'myTab', 'itineraryblock', JText::_('COM_STANDARD_FIELDSET_ITINERARY_BLOCK')); ?>
        <?php //echo $this->loadTemplate('itineraryblock'); ?>
        <?php //echo JHtml::_('bootstrap.endTab'); ?>

        <?php // Do not show the images and links options if the edit form is configured not to.  ?>
        <?php if ($params->show_urls_images_backend == 1) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'images', JText::_('COM_STANDARD_FIELDSET_URLS_AND_IMAGES')); ?>
            <div class="row-fluid form-horizontal-desktop">
                <div class="span12">
                    <?php echo $this->loadTemplate('images'); ?>
                </div>
            </div>
            <hr />
            <div class="row-fluid form-horizontal-desktop">
                <div class="span12">
                    <?php echo $this->loadTemplate('banners'); ?>
                </div>
            </div>
            <hr />
            <div class="row-fluid form-horizontal-desktop">
                <div class="span6">
                    <?php echo $this->loadTemplate('links'); ?>
                </div>
                <div class="span6">
                    <?php foreach ($this->form->getGroup('urls') as $field) : ?>
                        <?php echo $field->renderField(); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'gallery', JText::_('COM_STANDARD_FIELDSET_GALLERY')); ?>
        <div class="row-fluid form-horizontal-desktop">
            <div class="span12">
                <?php echo $this->loadTemplate('gallery'); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'video', JText::_('COM_STANDARD_FIELDSET_VIDEO')); ?>
        <div class="row-fluid form-horizontal-desktop">
            <div class="span9">
                <?php echo $this->loadTemplate('video'); ?>
            </div>
            <div class="span3 form-vertical">
                <?php echo $this->loadTemplate('overview'); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'itinerary', JText::_('COM_STANDARD_FIELDSET_ITINERARY')); ?>
        <div class="row-fluid form-horizontal-desktop">
            <div class="span12">
                <?php echo $this->loadTemplate('itinerary'); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php //$this->show_options = $params->show_itinerary_options; ?>
        <?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

        <?php // Do not show the publishing options if the edit form is configured not to. ?>
        <?php if ($params->show_publishing_options == 1) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('COM_STANDARD_FIELDSET_PUBLISHING')); ?>
            <div class="row-fluid form-horizontal-desktop">
                <div class="span6">
                    <?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
                </div>
                <div class="span6">
                    <?php echo JLayoutHelper::render('joomla.edit.metadata', $this); ?>
                </div>
            </div>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>


        <?php if (!$isModal && $assoc) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'associations', JText::_('JGLOBAL_FIELDSET_ASSOCIATIONS')); ?>
            <?php echo $this->loadTemplate('associations'); ?>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php elseif ($isModal && $assoc) : ?>
            <div class="hidden"><?php echo $this->loadTemplate('associations'); ?></div>
        <?php endif; ?>

        <?php if ($this->canDo->get('core.admin')) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'editor', JText::_('COM_STANDARD_SLIDER_EDITOR_CONFIG')); ?>
            <?php echo $this->form->renderFieldset('editorConfig'); ?>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>

        <?php if ($this->canDo->get('core.admin')) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('COM_STANDARD_FIELDSET_RULES')); ?>
            <?php echo $this->form->getInput('rules'); ?>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
