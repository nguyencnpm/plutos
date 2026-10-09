<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLog::add('The layout standardextension.content.info_block.block is deprecated, use standardextension.content.info_block instead.', JLog::WARNING, 'deprecated');
echo JLayoutHelper::render('standardextension.content.info_block', $displayData);
