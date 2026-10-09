<?php
/**
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Create a shortcut for params.

/*
  $params = $this->params; // &$this->item->params;

  $this->item->params = clone $this->params; // fix temp
 */

$params = &$this->item->params;
$images = json_decode($this->item->product_images);
$canEdit = $this->item->params->get('access-edit');
$info = $this->item->params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));

$columns = (int) $this->columns;
$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$templateParams = $template->params;
$templateParams->get('tooltip_viewport');
$tooltip = $templateParams->get('tooltip_viewport');
?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate()) || ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) :
    ?>
    <div class="system-unpublished">
    <?php endif; ?>
    <div class="row">
        <?php
        $class_item_image = "post d-flex col-12 col-sm-5 col-md-6 col-lg-4 col-xl-3";
        $class_item_text = "post d-flex col-12 col-sm-7 col-md-6 col-lg-8 col-xl-9";
        $cItemText = "item-text flex-fill";
        ?>
        <?php if (isset($images->image_medium) && !empty($images->image_medium)) : ?>
            <?php $imgfloat = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro; ?>
            <div class="<?php echo $class_item_image; ?> pull-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?>">
                <?php echo JLayoutHelper::render('standard.Select_IntroImage', $this->item); ?>
            </div>
        <?php else: ?>
            <?php
            $class_item_text = "post d-flex col-12";
            $cItemText = "pt-2 pr-3 pb-2 pl-3";
            ?>
        <?php endif; ?>

        <div class="<?php echo $class_item_text; ?>">
            <div class="<?php echo $cItemText; ?>">
                <?php //-- show title--   ?>
                <?php echo JLayoutHelper::render('standard.Select_StyleItemTitle', $this->item); ?>
                <?php //-- show title -- ?>
                <?php if ($params->get('show_intro')) : ?>
                    <p>
                        <?php
                        //echo $introtext; 
                        echo $this->item->product_introtext;
                        ?>
                    </p>
                <?php endif; ?>

                <div class="info-group-vertical mb-2">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <?php
                            echo JLayoutHelper::render('standard.Select_Route', array('item' => $this->item, 'params' => $params));
                            ?>
                        </div>

                        <div class="col-12 col-lg-6">
                            <?php
                            if ($params->get('show_price') || $params->get('show_call_price') || $params->get('show_call_hotline')) :
                                echo JLayoutHelper::render('standard.price', array('item' => $this->item, 'params' => $params));
                            endif;
                            ?>

                            <?php
                            if ($params->get('show_payment_methods')) :
                                echo JLayoutHelper::render('standard.payment_methods', array('item' => $this->item, 'params' => $params));
                            endif;
                            ?>
                            <?php
                            if (!empty($this->item->introtext) || !empty($this->item->fulltext)):
                                echo JLayoutHelper::render('standard.Modal.ViewRateInfo', array('item' => $this->item, 'params' => $params));
                            endif;
                            ?>
                        </div>

                    </div>
                </div>
            </div><?php // --- /.Item Text ---          ?>
        </div>
    </div>
    <?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate()) || ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != $this->db->getNullDate() )) :
        ?>
    </div>
<?php endif; ?>
