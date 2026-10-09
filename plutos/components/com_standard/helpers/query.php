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
 * Standard Component Query Helper
 *
 * @since  1.5
 */
class StandardHelperQuery {

    /**
     * Translate an order code to a field for primary category ordering.
     *
     * @param   string  $orderby  The ordering code.
     *
     * @return  string  The SQL field(s) to order by.
     *
     * @since   1.5
     */
    public static function orderbyPrimary($orderby) {
        switch ($orderby) {
            case 'alpha' :
                $orderby = 'c.path, ';
                break;

            case 'ralpha' :
                $orderby = 'c.path DESC, ';
                break;

            case 'order' :
                $orderby = 'c.lft, ';
                break;

            default :
                $orderby = '';
                break;
        }

        return $orderby;
    }

    /**
     * Translate an order code to a field for secondary category ordering.
     *
     * @param   string  $orderby    The ordering code.
     * @param   string  $orderDate  The ordering code for the date.
     *
     * @return  string  The SQL field(s) to order by.
     *
     * @since   1.5
     */
    public static function orderbySecondary($orderby, $orderDate = 'created') {
        $queryDate = self::getQueryDate($orderDate);

        switch ($orderby) {
            case 'date' :
                $orderby = $queryDate;
                break;

            case 'rdate' :
                $orderby = $queryDate . ' DESC ';
                break;

            case 'alpha' :
                $orderby = 'p.title';
                break;

            case 'ralpha' :
                $orderby = 'p.title DESC';
                break;

            case 'hits' :
                $orderby = 'p.hits DESC';
                break;

            case 'rhits' :
                $orderby = 'p.hits';
                break;

            case 'order' :
                $orderby = 'p.ordering';
                break;

            case 'author' :
                $orderby = 'author';
                break;

            case 'rauthor' :
                $orderby = 'author DESC';
                break;

            case 'front' :
                $orderby = 'p.featured DESC, fp.ordering, ' . $queryDate . ' DESC ';
                break;

            case 'random' :
                $orderby = JFactory::getDbo()->getQuery(true)->Rand();
                break;

            case 'vote' :
                $orderby = 'p.id DESC ';
                if (JPluginHelper::isEnabled('content', 'vote')) {
                    $orderby = 'rating_count DESC ';
                }
                break;

            case 'rvote' :
                $orderby = 'p.id ASC ';
                if (JPluginHelper::isEnabled('content', 'vote')) {
                    $orderby = 'rating_count ASC ';
                }
                break;

            case 'rank' :
                $orderby = 'p.id DESC ';
                if (JPluginHelper::isEnabled('content', 'vote')) {
                    $orderby = 'rating DESC ';
                }
                break;

            case 'rrank' :
                $orderby = 'p.id ASC ';
                if (JPluginHelper::isEnabled('content', 'vote')) {
                    $orderby = 'rating ASC ';
                }
                break;

            default :
                $orderby = 'p.ordering';
                break;
        }

        return $orderby;
    }

    /**
     * Translate an order code to a field for primary category ordering.
     *
     * @param   string  $orderDate  The ordering code.
     *
     * @return  string  The SQL field(s) to order by.
     *
     * @since   1.6
     */
    public static function getQueryDate($orderDate) {
        $db = JFactory::getDbo();

        switch ($orderDate) {
            case 'modified' :
                $queryDate = ' CASE WHEN p.modified = ' . $db->quote($db->getNullDate()) . ' THEN p.created ELSE p.modified END';
                break;

            // Use created if publish_up is not set
            case 'published' :
                $queryDate = ' CASE WHEN p.publish_up = ' . $db->quote($db->getNullDate()) . ' THEN p.created ELSE p.publish_up END ';
                break;

            case 'created' :
            default :
                $queryDate = ' p.created ';
                break;
        }

        return $queryDate;
    }

    /**
     * Get join information for the voting query.
     *
     * @param   \Joomla\Registry\Registry  $params  An options object for the product.
     *
     * @return  array  A named array with "select" and "join" keys.
     * 
     * @since   1.5
     */
    public static function buildVotingQuery($params = null) {
        if (!$params) {
            $params = JComponentHelper::getParams('com_standard');
        }

        $voting = $params->get('show_vote');

        if ($voting) {
            // Calculate voting count
            $select = ' , ROUND(v.rating_sum / v.rating_count) AS rating, v.rating_count';
            $join = ' LEFT JOIN #__content_rating AS v ON p.id = v.content_id';
        } else {
            $select = '';
            $join = '';
        }

        return array('select' => $select, 'join' => $join);
    }

    /**
     * Method to order the intro products array for ordering
     * down the columns instead of across.
     * The layout always lays the introtext products out across columns.
     * Array is reordered so that, when products are displayed in index order
     * across columns in the layout, the result is that the
     * desired product ordering is achieved down the columns.
     *
     * @param   array    &$products   Array of intro text products
     * @param   integer  $numColumns  Number of columns in the layout
     *
     * @return  array  Reordered array to achieve desired ordering down columns
     *
     * @since   1.6
     */
    public static function orderDownColumns(&$products, $numColumns = 1) {
        $count = count($products);

        // Just return the same array if there is nothing to change
        if ($numColumns == 1 || !is_array($products) || $count <= $numColumns) {
            $return = $products;
        }
        // We need to re-order the intro products array
        else {
            // We need to preserve the original array keys
            $keys = array_keys($products);

            $maxRows = ceil($count / $numColumns);
            $numCells = $maxRows * $numColumns;
            $numEmpty = $numCells - $count;
            $index = array();

            // Calculate number of empty cells in the array
            // Fill in all cells of the array
            // Put -1 in empty cells so we can skip later
            for ($row = 1, $i = 1; $row <= $maxRows; $row++) {
                for ($col = 1; $col <= $numColumns; $col++) {
                    if ($numEmpty > ($numCells - $i)) {
                        // Put -1 in empty cells
                        $index[$row][$col] = -1;
                    } else {
                        // Put in zero as placeholder
                        $index[$row][$col] = 0;
                    }

                    $i++;
                }
            }

            // Layout the products in column order, skipping empty cells
            $i = 0;

            for ($col = 1; ($col <= $numColumns) && ($i < $count); $col++) {
                for ($row = 1; ($row <= $maxRows) && ($i < $count); $row++) {
                    if ($index[$row][$col] != - 1) {
                        $index[$row][$col] = $keys[$i];
                        $i++;
                    }
                }
            }

            // Now read the $index back row by row to get products in right row/col
            // so that they will actually be ordered down the columns (when read by row in the layout)
            $return = array();
            $i = 0;

            for ($row = 1; ($row <= $maxRows) && ($i < $count); $row++) {
                for ($col = 1; ($col <= $numColumns) && ($i < $count); $col++) {
                    $return[$keys[$i]] = $products[$index[$row][$col]];
                    $i++;
                }
            }
        }

        return $return;
    }

    public static function checkBlock($item, $sStartDate, $sExpiryDate) {
        if (!empty($item->product_period_block) && (int) $item->product_block_in_date === 1):
            $productBlock = json_decode($item->product_period_block);
            $iStartDate = strtotime($sStartDate);
            $iExpiryDate = strtotime($sExpiryDate);
            $aTemp = array();
            foreach ($productBlock as $keyItem => $valueItem):
                $aTemp = explode(" - ", $valueItem);
                if ((strtotime($aTemp[0]) <= $iStartDate && $iStartDate <= strtotime($aTemp[1])) || (strtotime($aTemp[0]) <= $iExpiryDate && $iExpiryDate <= strtotime($aTemp[1])) || (strtotime($aTemp[0]) >= $iStartDate && $iExpiryDate >= strtotime($aTemp[1]))):
                    return true;
                endif;
            endforeach;
        endif;

        return false;
    }

    public static function getDataTableHTML($htmlContent, $colTh = 2) {
        $aDataTableDetailHTML = array();
        $oDom = new DOMDocument();
        $oDom->loadHTML('<?xml encoding="UTF-8">' . $htmlContent);

        $header = $oDom->getElementsByTagName('th');
        $detail = $oDom->getElementsByTagName('td');

        if ($header->length > 0):
            //#Get header name of the table
            foreach ($header as $NodeHeader) {
                $aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
            }
            $colTh = count($aDataTableHeaderHTML);
        endif;
        //#Get row data/detail table without header name as key
        $i = 0;
        $j = 0;
        foreach ($detail as $sNodeDetail) {
            $sInner = str_replace("<td>", "", $sNodeDetail->ownerDocument->saveXML($sNodeDetail));
            $sInner = str_replace("</td>", "", $sInner);
            $aDataTableDetailHTML[$j][] = trim($sInner); // trim($sNodeDetail->textContent)
            $i = $i + 1;
            $j = $i % $colTh == 0 ? $j + 1 : $j;
        }
        return $aDataTableDetailHTML;
    }

    public static function getRedirectLink($params) {
        $app = JFactory::getApplication();

        $link = "";
        $linkType = $params->get('link_type');
        $menuID = $params->get('link_menu');
        $itemURL = $params->get('link_url');
        $itemProduct = $params->get('link_product');

        switch ($linkType) {
            case 'menu':

                if (!empty($menuID)) {
                    $menu = $app->getMenu();
                    $menuitem = $menu->getItem($menuID);
                    if ($menuitem)
                        switch ($menuitem->type) {
                            case 'component':
                                $link = JRoute::_($menuitem->link . '&Itemid=' . $menuID);
                                break;
                            case 'url':
                            case 'alias':
                                $link = JRoute::_($menuitem->link);
                                break;
                        }
                }
                break;

            case 'url':

                if (!empty($itemURL)) {
                    $link = JRoute::_($itemURL);
                }
                break;

            case 'product':

                break;
        }
        return $link;
    }

}
