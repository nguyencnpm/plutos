<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_product_itineraries
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

?>

<?php if ((!empty($oImages->linktype) && !empty($sUrlImageText)) || (!empty($oImages->linkatype) && !empty($sUrlImageTextA))): ?>
    <div class="more row justify-content-center">
        <?php if (!empty($oImages->linktype) && !empty($sUrlImageText)): ?>
            <div class="<?php echo $params->get('layout_button') === 'vertical' ? "col-12" : "col-12 col-sm-6" ?>">
                <?php if (isset($oImages) && isset($oImages->paymenttype_id)): ?>
                    <?php if (!empty($oImages->paymenttype_id) && (int) $oImages->paymenttype_id === 1): ?>
                        <form target="<?php echo $oImages->linktarget; ?>" action="<?php echo $sImageUrlsLink; ?>" method="post">
                            <?php $sDataIds = $uniqid . '-sUrlImageText-' . $item->id; ?>
                            <button data-ids="<?php echo $sDataIds; ?>" 
                                    class="loading-progress-circle btn radius-0 mb-3  w-100 text-uppercase <?php echo!empty(trim($oImages->url_class_sfx)) ? $oImages->url_class_sfx : "using-btn-yellow"; ?>"
                                    type="submit">
                                <i class="fa fa-spinner fa-pulse processing display-none display-processing<?php echo $sDataIds; ?>"></i>
                                <?php echo $sUrlImageText; ?>
                            </button>
                            <input type="hidden" name="jform[tour_id]" value="<?php echo $item->id; ?>" />
                            <input type="hidden" name="option" value="com_standard" />
                            <input type='hidden' name='check' value='itinerary'/>
                            <?php echo JHtml::_('form.token'); ?>
                        </form>
                    <?php else: ?>
                        <a class="btn radius-0 mb-3  w-100 <?php echo!empty(trim($oImages->url_class_sfx)) ? $oImages->url_class_sfx : "using-btn-yellow"; ?>" href="<?php echo $sImageUrlsLink; ?>" target="<?php echo $oImages->linktarget; ?>" itemprop="url"> <?php echo $sUrlImageText; ?></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn radius-0 mb-3  w-100 <?php echo!empty(trim($oImages->url_class_sfx)) ? $oImages->url_class_sfx : "using-btn-yellow"; ?>" href="<?php echo $sImageUrlsLink; ?>" target="<?php echo $oImages->linktarget; ?>" itemprop="url"> <?php echo $sUrlImageText; ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php // ----  ---- ?>
        <?php if (!empty($oImages->linkatype) && !empty($sUrlImageTextA)): ?>
            <div class="<?php echo $params->get('layout_button') === 'vertical' ? "col-12" : "col-12 col-sm-6" ?>">
                <?php if (isset($oImages) && isset($oImages->paymentatype_id)): ?>
                    <?php if (!empty($oImages->paymentatype_id) && (int) $oImages->paymentatype_id === 1): ?>
                        <form target="<?php echo $oImages->linkatarget; ?>" action="<?php echo $sImageUrlsLinkA; ?>" method="post">
                            <?php $sDataIds = $uniqid . '-sUrlImageTextA-' . $item->id; ?>
                            <button data-ids="<?php echo $sDataIds; ?>" 
                                    class="loading-progress-circle btn radius-0 mb-3  w-100 text-uppercase <?php echo!empty(trim($oImages->urla_class_sfx)) ? $oImages->urla_class_sfx : " featurette-learnmore-no-bg"; ?>"
                                    type="submit">
                                <i class="fa fa-spinner fa-pulse processing display-none display-processing<?php echo $sDataIds; ?>"></i>
                                <?php echo $sUrlImageTextA; ?>
                            </button>
                            <input type="hidden" name="jform[tour_id]" value="<?php echo $item->id; ?>" />
                            <input type="hidden" name="option" value="com_standard" />
                            <input type='hidden' name='check' value='itinerary'/>
                            <?php echo JHtml::_('form.token'); ?>
                        </form>
                    <?php else: ?>
                        <a class="btn radius-0 mb-3  w-100  <?php echo!empty(trim($oImages->urla_class_sfx)) ? $oImages->urla_class_sfx : " featurette-learnmore-no-bg"; ?>" href="<?php echo $sImageUrlsLinkA; ?>" target="<?php echo $oImages->linkatarget; ?>" itemprop="url"> <?php echo $sUrlImageTextA; ?></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn radius-0 mb-3  w-100  <?php echo!empty(trim($oImages->urla_class_sfx)) ? $oImages->urla_class_sfx : " featurette-learnmore-no-bg"; ?>" href="<?php echo $sImageUrlsLinkA; ?>" target="<?php echo $oImages->linkatarget; ?>" itemprop="url"> <?php echo $sUrlImageTextA; ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
