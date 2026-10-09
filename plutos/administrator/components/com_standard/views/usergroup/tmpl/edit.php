<?php
/**
 * @package     giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');


$app = JFactory::getApplication();
$input = $app->input;

JFactory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'usergroup.cancel' || document.formvalidator.isValid(document.getElementById('usergroup-form')))
		{
			Joomla.submitform(task, document.getElementById('usergroup-form'));
		}
	};
");

// In case of modal
$isModal = $input->get('layout') == 'modal' ? true : false;
$layout = $isModal ? 'modal' : 'edit';
$tmpl = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
?>

<form action="<?php echo JRoute::_('index.php?option=com_standard&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="usergroup-form" class="form-validate form-horizontal" enctype="multipart/form-data">
    <fieldset class="adminform">
        <legend><?php echo JText::_('COM_STANDARD_USERGROUP_DETAILS'); ?></legend>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <div class="control-label">
                        <?php echo $this->form->getLabel('title'); ?>
                    </div>
                    <div class="controls">
                        <?php echo $this->form->getInput('title'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php $parent_id = $this->form->getField('parent_id'); ?>
                    <?php if (!$parent_id->hidden) : ?>
                        <div class="control-label">
                            <?php echo $parent_id->label; ?>
                        </div>
                    <?php endif; ?>
                    <div class="controls">
                        <?php echo $parent_id->input; ?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <?php echo $this->form->getControlGroup('contractgroup_id'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <?php echo $this->form->getControlGroup('catid'); ?>
        </div>
    </fieldset>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>
