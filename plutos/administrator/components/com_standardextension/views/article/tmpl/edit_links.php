<?php
/**
 * @package     Giaiphapcongnghethongtin.Administrator
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="control-group well">
    <h3><?php echo JText::_('COM_STANDARDEXTENSION_LINKING_OPTIONS');?></h3>
    <?php foreach ($this->form->getGroup('links') as $field) : ?>
        <?php echo $field->renderField(); ?>
    <?php endforeach; ?>
</div>