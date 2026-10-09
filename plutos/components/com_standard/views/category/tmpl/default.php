<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

//JHtml::_('behavior.caption');
?>
<div class="col-12">
    <div class="category-list<?php echo $this->pageclass_sfx; ?>">
        <?php
        $this->subtemplatename = 'products';
        echo JLayoutHelper::render('standard.category_default', $this);
        ?>
    </div>
</div>