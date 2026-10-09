<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$oPlans = json_decode($this->item->plans);

//echo '<pre>';
//print_r($this->item);
//echo '</pre>';
//
//echo '<pre>';
//echo '<br /> --------------- ----------------- <br />';
//print_r($oPlans);
//echo '</pre>';
//exit;



$numLeading = $this->item->plans_num_leading;
$columnLeading = $this->item->plans_column_leading > 0 ? $this->item->plans_column_leading : 1;

$numIntro = $this->item->plans_num_intro;
$columnIntro = $this->item->plans_column_intro > 0 ? $this->item->plans_column_intro : 1;

foreach ($oPlans as $i => $plan) :
    if (!$plan->plans_status || (empty($plan->title) && empty($plan->plans))):
        continue;
    endif;
    if ($i < $numLeading) :
        $this->lead_plans[] = $plan;
    else :
        $this->intro_plans[] = $plan;
    endif;
endforeach;

$this->itemplan = new stdClass();
//echo '<pre>';
//print_r($this->item);
//echo '<br /> --------------- ----------------- <br />';
//print_r($oPlans);
//exit;

?>
<?php $cLayoutElement = isset($this->item->plans_layoutelement) ? $this->item->plans_layoutelement . " mx-auto ": ""; ?>
<div class="<?php echo $cLayoutElement; ?>">
    <?php if (isset($this->lead_plans)): ?>
        <?php if (!empty($this->lead_plans)) : ?>
            <div class="items-row row">
                <?php foreach ($this->lead_plans as $key => $item) : ?>
                    <?php $merge_column = (int) $item->merge_column > 1 ? (int) $item->merge_column : 1; ?>
                    <?php $this->rowcount = ((int) $key % ((int) $columnLeading + ($merge_column - 1))) + 1; ?>
                    <div class="d-flex col-12 col-lg-<?php echo (round(12 / $columnLeading)) * $merge_column; ?>">
                        <?php
                        $this->itemplan = $item;
                        echo $this->loadTemplate('itemplan');
                        ?>
                        <?php // -- end item --  ?>
                    </div>
                    <?php // -- end col -- ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($this->intro_plans)): ?>
        <?php if (!empty($this->intro_plans)) : ?>
            <div class="items-row row">
                <?php foreach ($this->intro_plans as $key => $item) : ?>
                    <?php $merge_column = (int) $item->merge_column > 1 ? (int) $item->merge_column : 1; ?>
                    <?php $this->rowcount = ((int) $key % ((int) $columnIntro + ($merge_column - 1))) + 1; ?>
                    <div class="d-flex col-12 col-lg-<?php echo (round(12 / $columnIntro)) * $merge_column; ?>">
                        <?php
                        $this->itemplan = $item;
                        echo $this->loadTemplate('itemplan');
                        ?>
                        <?php // -- end item --  ?>
                    </div>
                    <?php // -- end col -- ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>