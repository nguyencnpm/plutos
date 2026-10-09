<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2017 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

JLog::add('The layout standard.ListProducts.info_block.block is deprecated, use standard.ListProducts.info_block instead.', JLog::WARNING, 'deprecated');
echo JLayoutHelper::render('standard.info_block', $displayData);
