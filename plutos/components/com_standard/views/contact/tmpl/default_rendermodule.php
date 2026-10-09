<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="render-module">
    <?php
    $attribs['style'] = 'contacts';
    $attribs['headerLevel'] = 3;
    foreach ($this->modulesinfo as $info) :
        echo JModuleHelper::renderModule($info, $attribs);
    endforeach;
    ?>
</div>