<?php

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
?>
<?php echo JHtml::_('access.usergroups', 'jform[groups]', $this->groups, true); ?>
