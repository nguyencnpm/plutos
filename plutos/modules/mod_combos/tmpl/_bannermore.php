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

<?php if ((!empty($oBanners->linktype) && !empty($sUrlBannerText)) || (!empty($oBanners->linkatype) && !empty($sUrlBannerTextA))): ?>
    <div class="more row justify-content-center">
        <?php if (!empty($oBanners->linktype) && !empty($sUrlBannerText)): ?>
            <div class="<?php echo $params->get('layout_button') === 'vertical' ? "col-12" : "col-12 col-sm-6" ?>">
                <?php if (isset($oBanners) && isset($oBanners->paymenttype_id)): ?>
                    <?php if (!empty($oBanners->paymenttype_id) && (int) $oBanners->paymenttype_id === 1): ?>
                        <form target="<?php echo $oBanners->linktarget; ?>" action="<?php echo $sBannerUrlsLink; ?>" method="post">
                            <?php $sDataIds = $uniqid . '-sUrlBannerText-' . $item->id; ?>
                            <button data-ids="<?php echo $sDataIds; ?>" 
                                    class="loading-progress-circle btn radius-0 mb-3  w-100 text-uppercase <?php echo!empty(trim($oBanners->url_class_sfx)) ? $oBanners->url_class_sfx : "using-btn-yellow"; ?>"
                                    type="submit">
                                <i class="fa fa-spinner fa-pulse processing display-none display-processing<?php echo $sDataIds; ?>"></i>
                                <?php echo $sUrlBannerText; ?>
                            </button>
                            <input type="hidden" name="jform[tour_id]" value="<?php echo $item->id; ?>" />
                            <input type="hidden" name="option" value="com_standard" />
                            <input type='hidden' name='check' value='itinerary'/>
                            <?php echo JHtml::_('form.token'); ?>
                        </form>
                    <?php else: ?>
                        <a class="btn radius-0 mb-3  w-100 <?php echo!empty(trim($oBanners->url_class_sfx)) ? $oBanners->url_class_sfx : "using-btn-yellow"; ?>" href="<?php echo $sBannerUrlsLink; ?>" target="<?php echo $oBanners->linktarget; ?>" itemprop="url"> <?php echo $sUrlBannerText; ?></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn radius-0 mb-3  w-100 <?php echo!empty(trim($oBanners->url_class_sfx)) ? $oBanners->url_class_sfx : "using-btn-yellow"; ?>" href="<?php echo $sBannerUrlsLink; ?>" target="<?php echo $oBanners->linktarget; ?>" itemprop="url"> <?php echo $sUrlBannerText; ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php // ----  ---- ?>
        <?php if (!empty($oBanners->linkatype) && !empty($sUrlBannerTextA)): ?>
            <div class="<?php echo $params->get('layout_button') === 'vertical' ? "col-12" : "col-12 col-sm-6" ?>">
                <?php if (isset($oBanners) && isset($oBanners->paymentatype_id)): ?>
                    <?php if (!empty($oBanners->paymentatype_id) && (int) $oBanners->paymentatype_id === 1): ?>
                        <form target="<?php echo $oBanners->linkatarget; ?>" action="<?php echo $sBannerUrlsLinkA; ?>" method="post">
                            <?php $sDataIds = $uniqid . '-sUrlBannerTextA-' . $item->id; ?>
                            <button data-ids="<?php echo $sDataIds; ?>" 
                                    class="loading-progress-circle btn radius-0 mb-3  w-100 text-uppercase <?php echo!empty(trim($oBanners->urla_class_sfx)) ? $oBanners->urla_class_sfx : " featurette-learnmore-no-bg"; ?>"
                                    type="submit">
                                <i class="fa fa-spinner fa-pulse processing display-none display-processing<?php echo $sDataIds; ?>"></i>
                                <?php echo $sUrlBannerTextA; ?>
                            </button>
                            <input type="hidden" name="jform[tour_id]" value="<?php echo $item->id; ?>" />
                            <input type="hidden" name="option" value="com_standard" />
                            <input type='hidden' name='check' value='itinerary'/>
                            <?php echo JHtml::_('form.token'); ?>
                        </form>
                    <?php else: ?>
                        <a class="btn radius-0 mb-3  w-100  <?php echo!empty(trim($oBanners->urla_class_sfx)) ? $oBanners->urla_class_sfx : " featurette-learnmore-no-bg"; ?>" href="<?php echo $sBannerUrlsLinkA; ?>" target="<?php echo $oBanners->linkatarget; ?>" itemprop="url"> <?php echo $sUrlBannerTextA; ?></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn radius-0 mb-3  w-100  <?php echo!empty(trim($oBanners->urla_class_sfx)) ? $oBanners->urla_class_sfx : " featurette-learnmore-no-bg"; ?>" href="<?php echo $sBannerUrlsLinkA; ?>" target="<?php echo $oBanners->linkatarget; ?>" itemprop="url"> <?php echo $sUrlBannerTextA; ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
