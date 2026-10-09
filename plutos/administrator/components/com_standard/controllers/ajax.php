<?php
defined('_JEXEC') or die;

class StandardControllerAjax extends JControllerAdmin {

    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  The array of possible config values. Optional.
     *
     * @return  JModelLegacy
     *
     * @since   1.6
     */
    public function getModel($name = 'Products', $prefix = 'StandardModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }

    public function ajaxRoute() {
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $input = $app->input;

        $catid = (int) $input->getInt("id");
        $query->select('r.id, r.from_id, r.to_id, r.title, r.subtitle, r.alias, r.code, r.state')
                ->from('#__standard_routes as r');
        // Join over the standard_locations for the locations.
        $query->select('lt_from.title AS from_title')
                ->join('LEFT', '#__standard_locations AS lt_from ON lt_from.id = r.from_id');

        // Join over the standard_locations for the locations.
        $query->select('lt_to.title AS to_title')
                ->join('LEFT', '#__standard_locations AS lt_to ON lt_to.id = r.to_id');

        $query->where('r.catid = ' . $catid);

        $db->setQuery($query);
        //echo nl2br(str_replace('#__', 'brle6_', $query));
        //exit;
        $routes = $db->loadObjectList();
        // ------ set checked input -----
        $this_itemId = (int) $app->getUserState("this_itemId", 0);
        $arr_route_id = array();
        if ($this_itemId > 0) {
            $arr_route_id = $app->getUserState("routerate_arr_route_" . $this_itemId . '_' . $catid, array());
        } else {
            $app->setUserState('routerate_arr_route__' . $catid, null);
        }

        $html_nodata = "";
        $html = "";
        if (!empty($routes)) :
            foreach ($routes as $i => $value) :
                $jform_id = 'jform_route' . $value->id;
                $checked = 0;
                $idvalue = (int) $value->id;

                if (isset($arr_route_id) && is_array($arr_route_id)) {
                    $checked = in_array($value->id, $arr_route_id);
                }
                /*
                  $sTo = JText::_('to');
                  $from_title = ucwords(strtolower($value->from_title));
                  $to_title = ucwords(strtolower($value->to_title));
                 */
                $title = ucwords(strtolower($value->title));
                $subtitle = ucwords(strtolower($value->subtitle));
                $selected = $checked ? ' checked="checked"' : '';
                $html .= "<li>";
                $html .= "<div class=\"treeselect-item pull-left\">";
                $html .= "<input type=\"checkbox\" class=\"pull-left novalidate\" name=\"jform[route_id][]\" id=\"{$jform_id}\" value=\"{$idvalue}\"{$selected}/>";
                $html .= "<label for=\"{$jform_id}\" class=\"pull-left\">";
                //$html .= "{$from_title} <span class=\"text-success\">{$sTo}</span> {$to_title}";
                $html .= "{$title}";
                if (!empty($subtitle)):
                    $html .= "({$subtitle})";
                endif;

                $html .= !empty(trim($value->code)) ? "<span class=\"small\"> (" . JText::_('COM_STANDARD_FIELD_CODE_INFORATE') . ": <strong class=\"text-success\">" . strtoupper($value->code) . "</strong>)</span>" : "";

                if ($value->state == 0) {
                    $html .= " <span class=\"label\">";
                    $html .= JText::_('JUNPUBLISHED');
                    $html .= "</span>";
                }
                if ($value->state == -2) {
                    $html .= " <span class=\"label\">";
                    $html .= JText::_('JTOOLBAR_EMPTY_TRASH');
                    $html .= "</span>";
                }
                $html .= "</label>";
                $html .= "</div>";
                $html .= "<div class=\"clearfix\"></div>";
                $html .= "</li>";
            endforeach;
        else :
            $html_nodata .= "<div id=\"noresultsfound\" style=\"\" class=\"alert alert-no-items\">";
            $html_nodata .= JText::_('JGLOBAL_NO_MATCHING_RESULTS');
            $html_nodata .= "</div>";
        endif;
        //JHtml::_('script', 'jui/treeselectmenu.jquery.min.js', false, true);
        ?>

        <ul class="treeselect route">
            <li>
                <div class="treeselect-item pull-left">
                    <label class="pull-left"><?php echo JText::_('COM_STANDARD_ROUTETYPE'); ?><span class="star">&nbsp;*</span></label>
                </div>
                <div class="clearfix"></div>
            </li>
            <?php echo $html; ?>
        </ul>
        <?php echo $html_nodata; ?>
        <?php
        $app->close();
    }
    
    
    public function ajaxProductCategory() {

        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $input = $app->input;

        $catid = (int) $input->getInt("id");
        $query->select('id, title, alias, code, state')
                ->from($db->qn('#__standard_products'))
                ->where('catid = ' . $catid);
        $db->setQuery($query);
        //echo nl2br(str_replace('#__', 'brle6_', $query));
        //exit;
        $productcategories = $db->loadObjectList();
        // ------ set checked input -----
        $this_itemId = (int) $app->getUserState("this_itemId", 0);
        $arr_product_id = array();
        if ($this_itemId > 0) {
            $arr_product_id = $app->getUserState("productrate_arr_productcategory_" . $this_itemId . '_' . $catid, array());
        } else {
            $app->setUserState('productrate_arr_productcategory__' . $catid, null);
        }

        $html_nodata = "";
        $html = "";
        if (!empty($productcategories)) :
            foreach ($productcategories as $i => $value) :
                $jform_id = 'jform_productcategory' . $value->id;
                $checked = 0;
                $idvalue = (int) $value->id;

                if (isset($arr_product_id) && is_array($arr_product_id)) {
                    $checked = in_array($value->id, $arr_product_id);
                }

                $selected = $checked ? ' checked="checked"' : '';
                $html .= "<li>";
                $html .= "<div class=\"treeselect-item pull-left\">";
                $html .= "<input type=\"checkbox\" class=\"pull-left novalidate\" name=\"jform[product_id][]\" id=\"{$jform_id}\" value=\"{$idvalue}\"{$selected}/>";
                $html .= "<label for=\"{$jform_id}\" class=\"pull-left\">";
                $html .= "{$value->title} ";
                $html .= !empty(trim($value->code)) ? "<span class=\"small\"> (" . JText::_('Code') . ": <strong class=\"text-success\">" . strtoupper($value->code) . "</strong>)</span>" : "";

                if ($value->state == 0) {
                    $html .= " <span class=\"label\">";
                    $html .= JText::_('JUNPUBLISHED');
                    $html .= "</span>";
                }
                if ($value->state == -2) {
                    $html .= " <span class=\"label\">";
                    $html .= JText::_('JTOOLBAR_EMPTY_TRASH');
                    $html .= "</span>";
                }
                $html .= "</label>";
                $html .= "</div>";
                $html .= "<div class=\"clearfix\"></div>";
                $html .= "</li>";
            endforeach;
        else :
            $html_nodata .= "<div id=\"noresultsfound\" style=\"\" class=\"alert alert-no-items\">";
            $html_nodata .= JText::_('JGLOBAL_NO_MATCHING_RESULTS');
            $html_nodata .= "</div>";
        endif;
        //JHtml::_('script', 'jui/treeselectmenu.jquery.min.js', false, true);
        ?>

        <ul class="treeselect product">
            <li>
                <div class="treeselect-item pull-left">
                    <label class="pull-left"><?php echo JText::_('COM_STANDARD_PRODUCTS'); ?><span class="star">&nbsp;*</span></label>
                </div>
                <div class="clearfix"></div>
            </li>
            <?php echo $html; ?>
        </ul>
        <?php echo $html_nodata; ?>
        <?php
        $app->close();
    }

}
