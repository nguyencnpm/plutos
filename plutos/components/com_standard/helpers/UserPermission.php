<?php

/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2019 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class UserPermission {

    public static function getUserPermissions() {
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('ta.title, ta.alias, ta.credit, ta.limit_products')
                ->from('#__standard_agents AS ta')
                ->join('LEFT', '#__standard_agent_user_map AS map ON map.agent_id = ta.id')
                ->where('map.user_id=' . (int) $user->id);

        // Setup the query
        $db->setQuery($query);
        return $db->loadObject();
    }

}
