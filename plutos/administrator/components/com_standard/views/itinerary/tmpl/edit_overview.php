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
<div class="well alert-info">
    <?php foreach ($this->form->getGroup('overview') as $field) : ?>
        <?php echo $field->renderField(); ?>
    <?php endforeach; ?>
</div>