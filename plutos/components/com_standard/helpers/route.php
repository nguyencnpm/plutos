<?php

/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Standard Component Route Helper.
 *
 * @since  1.5
 */
abstract class StandardHelperRoute extends JHelperRoute {

    /**
     * @var    array  Holds the reverse lookup
     * @since  3.1
     */
    protected static $lookup;

    /**
     * @var    string  Option for the extension (such as com_content)
     * @since  3.1
     */
    protected $extension;

    /**
     * @var    string  Value of the primary key in the content type table
     * @since  3.1
     */
    protected $id;

    /**
     * @var    string  Name of the view for the url
     * @since  3.1
     */
    protected $view;

    /**
     * Get the product route.
     *
     * @param   integer  $id        The route of the content item.
     * @param   integer  $catid     The category ID.
     * @param   integer  $language  The language code.
     * @param   string   $layout    The layout value.
     *
     * @return  string  The product route.
     *
     * @since   1.5
     */
    public static function getProductRoute($id, $catid = 0, $language = 0, $layout = null) {
        /*
          // Create a fallback link in case we can't find the component router
          $router = new JHelperRoute;
          list($contentItemAlias, $contentItemId) = explode(':', $id, 2);
          return $router->getRoute($contentItemId, $contentItemAlias, $link = '', $language, $catid);
         */
        $extension = 'com_standard';
        $name = ucfirst(substr_replace($extension, '', 0, 4));

        $needles = array(
            'product' => array((string) $id)
        );
        // Create the link
        $link = 'index.php?option=com_standard&view=product&id=' . $id;

        if ((int) $catid > 1) {
            $categories = \JCategories::getInstance($name);

            if ($categories) {
                $category = $categories->get((int) $catid);

                if ($category) {
                    $needles['category'] = array_reverse($category->getPath());
                    $needles['categories'] = $needles['category'];
                    $link .= '&catid=' . $catid;
                }
            }
        }

        if ($language && $language !== '*' && JLanguageMultilang::isEnabled()) {
            $link .= '&lang=' . $language;
            $needles['language'] = $language;
        }

        if ($layout) {
            $link .= '&layout=' . $layout;
        }

        if ($item = self::_findItem($needles)) {
            $link .= '&Itemid=' . $item;
        }

        return $link;
    }

    /**
     * Get the category route.
     *
     * @param   integer  $catid     The category ID.
     * @param   integer  $language  The language code.
     * @param   string   $layout    The layout value.
     *
     * @return  string  The article route.
     *
     * @since   1.5
     */
    public static function getCategoryRoute($catid, $language = 0, $layout = null) {
        if ($catid instanceof JCategoryNode) {
            $id = $catid->id;
        } else {
            $id = (int) $catid;
        }

        if ($id < 1) {
            return '';
        }

        $link = 'index.php?option=com_standard&view=category&id=' . $id;

        if ($language && $language !== '*' && JLanguageMultilang::isEnabled()) {
            $link .= '&lang=' . $language;
        }

        if ($layout) {
            $link .= '&layout=' . $layout;
        }

        return $link;
    }

    /**
     * Get the form route.
     *
     * @param   integer  $id  The form ID.
     *
     * @return  string  The product route.
     *
     * @since   1.5
     */
    public static function getFormRoute($id) {
        return 'index.php?option=com_standard&task=product.edit&a_id=' . (int) $id;
    }

    /**
     * Get the Itinerary Type route.
     *
     * @param   integer  $itinerarytype_id     The Itinerary Type ID.
     * @param   integer  $language  The language code.
     * @param   string   $layout    The layout value.
     *
     * @return  string  The product route.
     *
     * @since   1.5
     */
    public static function getItineraryTypeRoute($itinerarytype_id, $language = 0, $layout = null) {
        if ($itinerarytype_id instanceof JCategoryNode) {
            $id = $itinerarytype_id->id;
        } else {
            $id = (int) $itinerarytype_id;
        }

        if ($id < 1) {
            return '';
        }

        $link = 'index.php?option=com_standard&view=itinerarytype&id=' . $id;

        if ($language && $language !== '*' && JLanguageMultilang::isEnabled()) {
            $link .= '&lang=' . $language;
        }

        if ($layout) {
            $link .= '&layout=' . $layout;
        }

        return $link;
    }

    /**
     * Get the itinerary route.
     *
     * @param   integer  $id        The route of the content item.
     * @param   integer  $itinerarytype_id     The category ID.
     * @param   integer  $language  The language code.
     * @param   string   $layout    The layout value.
     *
     * @return  string  The itinerary route.
     *
     * @since   1.5
     */
    public static function getItineraryRoute($id, $itinerarytype_id = 0, $language = 0, $layout = null) {
        $extension = 'com_standard';
        $name = ucfirst(substr_replace($extension, '', 0, 4));
        $needles = array(
            'itinerary' => array((string) $id)
        );
        // Create the link
        $link = 'index.php?option=com_standard&view=itinerary&id=' . $id;

        if ((int) $itinerarytype_id > 1) {

            if (!class_exists('StandardItineraryTypes')) {
                JLoader::register('StandardItineraryTypes', JPATH_SITE . '/components/com_standard/helpers/ItineraryType.php');
            }
            $itineraryTypes = StandardItineraryTypes::getInstance($name);
            if ($itineraryTypes) {
                $itineraryType = $itineraryTypes->get((int) $itinerarytype_id);

                if ($itineraryType) {
                    $needles['itinerarytype'] = array_reverse($itineraryType->getPath());
                    $needles['itinerarytypes'] = $needles['itinerarytype'];
                    $link .= '&itinerarytype_id=' . $itinerarytype_id;
                }
            }
        }

        if ($language && $language !== '*' && JLanguageMultilang::isEnabled()) {
            $link .= '&lang=' . $language;
            $needles['language'] = $language;
        }

        if ($layout) {
            $link .= '&layout=' . $layout;
        }

        if ($item = self::_findItem($needles)) {
            $link .= '&Itemid=' . $item;
        }

        return $link;
    }

    /**
     * Method to find the item in the menu structure
     *
     * @param   array  $needles  Array of lookup values
     *
     * @return  mixed
     *
     * @since   3.1
     */
    private static function _findItem($needles = array()) {
        $app = \JFactory::getApplication();
        $menus = $app->getMenu('site');
        $language = isset($needles['language']) ? $needles['language'] : '*';
        /*
          // $this->extension may not be set if coming from a static method, check it
          if ($this->extension === null) {
          $this->extension = $app->input->getCmd('option');
          }
         */
        $extension = null;
        // $this->extension may not be set if coming from a static method, check it
        if ($extension === null) {
            $extension = $app->input->getCmd('option');
        }
        // Prepare the reverse lookup array.
        if (!isset(static::$lookup[$language])) {
            static::$lookup[$language] = array();

            $component = JComponentHelper::getComponent($extension); //$component = ComponentHelper::getComponent($this->extension); 

            $attributes = array('component_id');
            $values = array($component->id);

            if ($language !== '*') {
                $attributes[] = 'language';
                $values[] = array($needles['language'], '*');
            }

            $items = $menus->getItems($attributes, $values);

            foreach ($items as $item) {

                if (isset($item->query) && isset($item->query['view'])) {
                    $view = $item->query['view'];

                    if (!isset(static::$lookup[$language][$view])) {
                        static::$lookup[$language][$view] = array();
                    }

                    if (isset($item->query['id'])) {
                        if (is_array($item->query['id'])) {
                            $item->query['id'] = $item->query['id'][0];
                        }

                        /*
                         * Here it will become a bit tricky
                         * $language != * can override existing entries
                         * $language == * cannot override existing entries
                         */
                        if ($item->language !== '*' || !isset(static::$lookup[$language][$view][$item->query['id']])) {
                            static::$lookup[$language][$view][$item->query['id']] = $item->id;
                        }
                    } elseif ($view == 'itineraries') { // fix temp
                        self::$lookup[$language]['itineraries'][] = $item->id;
                    }
                }
            }
        }

        if ($needles) {
            foreach ($needles as $view => $ids) {
                if (isset(static::$lookup[$language][$view])) {
                    foreach ($ids as $id) {
                        if (isset(static::$lookup[$language][$view][(int) $id])) {
                            return static::$lookup[$language][$view][(int) $id];
                        }
                    }
                }
            }
        }

        $active = $menus->getActive();
        // $this->extension
        if ($active && $active->component === $extension && ($active->language === '*' || !Multilanguage::isEnabled())) {
            if (isset(self::$lookup[$language]['itineraries'][0])):// fix temp
                return self::$lookup[$language]['itineraries'][0];
            else:
                return $active->id;
            endif;
        }

        // If not found, return language specific home link
        $default = $menus->getDefault($language);

        return !empty($default->id) ? $default->id : null;
    }
    
    public static function getLinkMenuItemRoute($linkMenuItem) {
        // Create the link
        $link = $linkMenuItem;

        if ($item = self::_getItem($linkMenuItem)) {
            $link .= '&Itemid=' . $item;
        }
        return $link;
    }

    protected static function _getItem($link) {
        $app = JFactory::getApplication();
        $item = $app->getMenu('site')->getItems('link', $link, true);
        return isset($item->id) ? $item->id : 0;
    }

}
