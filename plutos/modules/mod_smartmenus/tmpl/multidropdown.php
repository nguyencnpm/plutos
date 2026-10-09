<?php
/**
 * @author      Binh Nguyen! Project
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_smartmenus
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use nav instead
?>
<ul class="navbar-nav mr-auto <?php echo $class_sfx; ?> <?php echo $justify_content; ?> <?php echo $direction; ?>"<?php echo $id; ?>>
    <?php
    foreach ($list as $i => &$item) {
        $class = 'item-' . $item->id;
        if ($item->level == 1) {
            $class .= ' nav-item';
        } elseif ($item->level > 1) {
            // $class .= ' dropdown-item';
        }

        if ($item->id == $default_id) {
            $class .= ' default';
        }

        if ($item->id == $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') == $active_id)) {
            $class .= ' current';
        }

        if (in_array($item->id, $path)) {
            $class .= ' active';
        } elseif ($item->type === 'alias') {
            $aliasToId = $item->params->get('aliasoptions');

            if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
                $class .= ' active';
            } elseif (in_array($aliasToId, $path)) {
                $class .= ' alias-parent-active';
            }
        }

        if ($item->type === 'separator') {
            $class .= ' divider';
        }

        if ($item->deeper) {
            $class .= ' deeper';
        }
        /*
          if ($item->parent) {
          $class .= ' parent';
          }
         */
        if ($item->parent) {//Binh Nguyen modify
            if ($item->level == 1) {
                $class .= ' parent dropdown';
            } elseif ($item->level > 1) {
                if (!$end || ($end && $item->level < $end)) {//Binh Nguyen modify
                    $class .= ' parent dropdown dropdown-submenu';
                }
            } else {
                $class .= ' parent';
            }
        }
        echo '<li class="' . $class . '">';

        switch ($item->type) :
            case 'separator':
            case 'component':
            case 'heading':
            case 'url':
                require JModuleHelper::getLayoutPath('mod_smartmenus', 'multidropdown_' . $item->type);
                break;

            default:
                require JModuleHelper::getLayoutPath('mod_smartmenus', 'multidropdown_url');
                break;
        endswitch;

        // The next item is deeper.
        if ($item->deeper) {
            echo '<ul class="nav-child unstyled small dropdown-menu">';
        }
        // The next item is shallower.
        elseif ($item->shallower) {
            echo '</li>';
            echo str_repeat('</ul></li>', $item->level_diff);
            /*
              // Binh Nguyen Modify
              if ($item->level > 1) {
              echo str_repeat('</ul><li role="separator" class="divider"></li></li>', $item->level_diff); // Binh Nguyen add
              } else {
              echo str_repeat('</ul></li>', $item->level_diff);
              }
             */
        }
        // The next item is on the same level.
        else {
            echo '</li>';
            /*
              // Binh Nguyen Modify
              if ($item->level > 1) {
              echo '<li role="separator" class="divider"></li></li>'; // Binh Nguyen add
              } else {
              echo '</li>';
              }
             */
        }
    }
    ?>
</ul>
