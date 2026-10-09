<?php
defined('JPATH_BASE') or die;
$oImages = json_decode($displayData->plans_image);
$data = array();
$tooltip = "hover percent polaroid animated";
if (isset($oImages)):
    foreach ($oImages as $oImage) :
        if (empty($oImage->images->image_big)):
            continue;
        endif;
        $data[] = $oImage;
    endforeach;
endif;
?>
<?php if (sizeof($data) > 0): ?>
    <?php
    $cMedialayoutelement = isset($displayData->plans_medialayoutelement) ? $displayData->plans_medialayoutelement : "";
    $column = 2;
    ?>
    <div class="<?php echo $cMedialayoutelement; ?> mx-auto text-center mb-5">
        <div class="row">
            <div class="col-12">
                <div class="item-header">
                    <h2 class="item-title cut-string-multiple-lines"><?php echo JText::_("COM_STANDARD_DECKPLAN"); ?></h2>
                </div>
            </div>
        </div>
        <div class="items-row row">
            <?php foreach ($data as $key => $item) : ?>
                <?php
                $caption = htmlspecialchars(empty($item->plans_image_caption) ? $displayData->title : $item->plans_image_caption);
                $alt = htmlspecialchars(empty($item->plans_image_alt) ? $displayData->title : $item->plans_image_alt, ENT_COMPAT, 'UTF-8');
                ?>
                <?php $rowcount = ((int) $key % (int) $column) + 1; ?>
                <div class="d-flex col-12 col-lg-<?php echo round(12 / $column); ?>">
                    <div class="item flex-fill mb-4 column-<?php echo $rowcount; ?>">
                        <img class="<?php echo $tooltip; ?>"src="<?php echo JURI::base() . htmlspecialchars($item->images->image_big); ?>"alt="<?php echo $alt; ?>">
                        <?php if (!empty($item->plans_image_title)): ?>
                            <h4 class="subtitle"><?php echo htmlspecialchars($item->plans_image_title); ?></h4>
                        <?php endif; ?>
                    </div>
                    <?php // -- end item --  ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>