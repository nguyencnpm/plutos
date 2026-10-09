<?php
/**
 * author       Binh Nguyen! Project
 * @package     Giaiphapcongnghethongtin.Site
 * @subpackage  com_standard
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params = $this->item->params;
$images = json_decode($this->item->images);
$videos = (array) json_decode($this->item->videos);

$urls = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user = JFactory::getUser();
$info = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));
// JHtml::_('behavior.caption');
$cFakePageHeading = " fake-page-heading";
$pageHeader = "page-header";
$headerLevel = "1";
$isItemPage = true;
$isItemMasthead = true;

$class_item_media = "post d-flex col-12 col-lg-6 pr-lg-0";
$class_item_text = "post d-flex col-12 col-lg-6 pl-lg-0";
$cItemText = "featurette item-text flex-fill text-justify-center featurette-bg-icon-medium-left-bottom";
?>
<?php // echo $this->pageclass_sfx;     ?>
<div class="item-page<?php echo $cFakePageHeading; ?>"> 
    <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
        <div class="row">
            <div class="col-12">
                <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
                <?php if ($this->params->get('show_page_heading') && !$isItemPage) : ?>
                    <div class="<?php echo $pageHeader; ?>">
                        <h<?php echo $headerLevel; ?> class="<?php echo $this->params->get('pageclass_heading'); ?>"> 
                            <?php if ((int) $headerLevel == 1): ?>
                                <i class="<?php echo $this->params->get('menu-anchor_css'); ?>" aria-hidden="true"></i> 
                            <?php endif; ?>
                            <?php echo $this->escape($this->params->get('page_heading')); ?> 
                        </h<?php echo $headerLevel; ?>>
                        <?php if ($this->params->get('show_page_masthead')): ?>
                            <div class="masthead">&nbsp;</div>
                        <?php endif; ?>
                    </div>
                    <?php
                    $pageHeader = "subheading";
                    $headerLevel = "2"; // set item_title 
                    ?>
                <?php endif; ?>

                <?php
                if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative) {
                    echo $this->item->pagination;
                }
                ?>

                <?php // Todo Not that elegant would be nice to group the params  ?>
                <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date') || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam);
                ?>

                <?php if (!$useDefList && $this->print) : ?>
                    <div id="pop-print" class="btn hidden-print">
                        <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
                    </div>
                    <div class="clearfix"> </div>
                <?php endif; ?>
                <div class="title-and-rate">
                    <?php if ($params->get('show_title')) : ?>
                        <div class="<?php echo $pageHeader; ?>">
                            <?php if ($params->get('show_title')) : ?>
                                <h<?php echo $headerLevel; ?> class="<?php echo $this->params->get('pageclass_subheading'); ?>">
                                    <?php echo $this->escape($this->item->title); ?>
                                </h<?php echo $headerLevel; ?>>
                                <?php if (($this->params->get('show_item_title_masthead') || $isItemMasthead) && ((float) $this->item->price) > 0): ?>
                                    <div class="item-title-masthead">&nbsp;</div>
                                <?php endif; ?>

                            <?php endif; ?>
                            <?php if ($this->item->state == 0) : ?>
                                <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
                            <?php endif; ?>
                            <?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
                                <span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
                            <?php endif; ?>
                            <?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate()) : ?>
                                <span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    if ($params->get('show_price') || $params->get('show_call_price') || $params->get('show_call_hotline')) :
                        echo JLayoutHelper::render('standard.rate', array('item' => $this->item, 'params' => $params, 'sublayout' => 'pairrate', 'class' => ''));
                    endif;
                    ?>
                </div>

                <?php if (!$this->print) : ?>
                    <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
                        <?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if ($useDefList) : ?>
                        <div id="pop-print" class="btn hidden-print">
                            <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php // Content is generated by content plugin event "onContentAfterTitle"  ?>
                <?php echo $this->item->event->afterDisplayTitle; ?>

                <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
                    <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block  ?>
                    <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
                <?php endif; ?>

                <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
                    <?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>

                    <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
                <?php endif; ?>

                <?php // Content is generated by content plugin event "onContentBeforeDisplay"  ?>
                <?php echo $this->item->event->beforeDisplayContent; ?>

                <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position))) || (empty($urls->urls_position) && (!$params->get('urls_position')))) :
                    ?>
                    <?php echo $this->loadTemplate('links'); ?>
                <?php endif; ?>
                <?php if ($params->get('access-view')) : ?>

                    <div class="row mb-5">
                        <?php if (isset($videos[0]->url) && !empty($videos[0]->url)) : ?>
                            <?php $imgfloat = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro; ?>
                            <div class="<?php echo $class_item_media; ?> pull-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?>">
                                <?php echo JLayoutHelper::render('standard.media', array('item' => $this->item, 'sublayout' => 'popupVideo')); ?>
                            </div>
                        <?php else: ?>
                            <?php
                            $class_item_text = "post d-flex col-12";
                            $cItemText = "featurette p-3 text-justify-center";
                            ?>
                        <?php endif; ?>
                        <div class="<?php echo $class_item_text; ?>">
                            <div class="<?php echo $cItemText; ?>">
                                <?php $oVideos = (array) json_decode($this->item->videos); ?>
                                <?php if (isset($oVideos[0]->urltext) && !empty($oVideos[0]->urltext)): ?>
                                    <div class="item-header">
                                        <h2 class="item-title">  <?php echo $oVideos[0]->urltext; ?> </h2>
                                    </div>
                                <?php endif; ?>
                                <div class="description px-lg-5 mb-3">
                                    <?php if (isset($oVideos[0]->description) && !empty($oVideos[0]->description)): ?>
                                        <?php echo $oVideos[0]->description; ?>
                                    <?php else: ?>

                                        <?php
                                        if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative) :
                                            echo $this->item->pagination;
                                        endif;
                                        ?>
                                        <?php
                                        if (isset($this->item->toc)) :
                                            echo $this->item->toc;
                                        endif;
                                        ?>
                                        <div itemprop="articleBody">
                                            <?php echo $this->item->text; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php // --- Book now ---?>
                                <div class="more row justify-content-center">
                                    <?php if ($this->isLinkRedirect): ?>
                                        <?php
                                        if (isset($this->aLinkRedirect) && !empty((array) $this->aLinkRedirect)):
                                            $link = $this->aLinkRedirect->url;
                                            echo '<div class="col-auto mb-3">';
                                            echo JLayoutHelper::render('standard.redirect', array('item' => $this->aLinkRedirect, 'params' => $params, 'link' => $link, 'sublayout' => '', 'class' => 'readmore ' . $this->aLinkRedirect->url_class_sfx));
                                            echo '</div>';
                                        endif;

                                        if (isset($this->aLinkARedirect) && !empty((array) $this->aLinkARedirect)):
                                            $link = $this->aLinkARedirect->url;
                                            echo '<div class="col-auto mb-3">';
                                            echo JLayoutHelper::render('standard.redirect', array('item' => $this->aLinkARedirect, 'params' => $params, 'link' => $link, 'sublayout' => '', 'class' => 'readmore ' . $this->aLinkARedirect->url_class_sfx));
                                            echo '</div>';
                                        endif;
                                        ?>
                                    <?php else: ?>
                                        <?php
                                        $link = "#section-scrolling-form"; //JRoute::_(StandardHelperRoute::getItineraryRoute($this->item->slug, $this->item->itinerarytype_id, $this->item->language));
                                        echo '<div class="col-auto">';
                                        echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'itinerary', 'class' => ''));
                                        echo '</div>';
                                        ?>
                                    <?php endif; ?>
                                </div>
                                <?php // --- /.Book now ---  ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    // --- itinerary --- 
                    $itinerary = (array) json_decode($this->item->itinerary);
                    ?>
                    <?php if (!empty($this->item->itinerary) && isset($itinerary[0]->itinerary) && !empty($itinerary[0]->itinerary)): ?>
                        <?php $cLayoutElement = isset($this->item->itinerary_layoutelement) ? $this->item->itinerary_layoutelement . " mx-auto " : ""; ?>
                        <div class="<?php echo $cLayoutElement; ?>">
                            <?php if (!empty($this->item->itinerary_title)): ?>
                                <h3 class="module-header-font-size font-eb-garamond-medium text-uppercase text-center using-text-green mb-4"><?php echo $this->item->itinerary_title; ?></h3>
                            <?php endif; ?>
                            <?php
                            $sDisplaytype = $this->aDisplayType[$this->item->itinerary_displaytype_id];
                            switch ($sDisplaytype) {
                                case 'gridworks':
                                    echo $this->loadTemplate('itineraryGridworks');
                                    break;
                                case 'masonry':
                                default:
                                    echo $this->loadTemplate('itineraryMasonry');
                                    break;
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php // --- /.itinerary --- ?>
                </div>
            </div>
        </div>

        <?php // --- Gallery ---   ?>
        <?php if (isset($this->item->galleries)): ?>
            <?php echo $this->loadTemplate('galleries'); ?>
        <?php endif; ?>
        <?php // --- /.Gallery --- ?>

        <?php
        // --- descriptions --- 
        $descriptions = (array) json_decode($this->item->descriptions)
        ?>
        <?php if (!empty($this->item->descriptions) && isset($descriptions[0]->description) && !empty($descriptions[0]->description)): ?>
            <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 more mb-5">
                        <?php // --- Book now ---  ?>
                        <?php
                        $link = "#section-scrolling-form"; //JRoute::_(StandardHelperRoute::getItineraryRoute($this->item->slug, $this->item->itinerarytype_id, $this->item->language));
                        ?>
                        <?php echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'itinerary', 'class' => 'w-100 mb-3')); ?>
                        <?php // --- /.Book now ---?>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php
                        $sDisplaytype = $this->aDisplayType[$this->item->displaytype_id];
                        switch ($sDisplaytype) {
                            case 'gridworks':
                                echo $this->loadTemplate('descriptionGridworks');
                                break;
                            case 'masonry':
                            default:
                                echo $this->loadTemplate('descriptionMasonry');
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php // --- /.descriptions --- ?>

        <?php if ($this->isForm): ?>
            <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">        
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 more mb-5">
                        <?php // --- Book now ---  ?>
                        <?php
                        $link = "#section-scrolling-form"; //JRoute::_(StandardHelperRoute::getItineraryRoute($this->item->slug, $this->item->itinerarytype_id, $this->item->language));
                        ?>
                        <?php echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'itinerary', 'class' => 'w-100')); ?>
                        <?php // --- /.Book now ---?>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                
                <?php if ($this->isLoadPageLocation): ?>
                    <div class="row"><div class="col-12 load-page-location"></div></div>
                <?php endif; ?>
                    
                <div class="row">
                    <div class="col-12">
                        <div id="section-scrolling-form" class="<?php echo $this->params->get('formclass_sfx'); ?>">
                            <?php // --- form ---   ?>
                            <?php echo $this->loadTemplate('form'); ?>
                            <?php // --- /.form --- ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 more mb-5">
                        <?php // --- Book now ---  ?>
                        <?php
                        $link = "#section-scrolling-form"; //JRoute::_(StandardHelperRoute::getItineraryRoute($this->item->slug, $this->item->itinerarytype_id, $this->item->language));
                        ?>
                        <?php echo JLayoutHelper::render('standard.booking', array('item' => $this->item, 'params' => $params, 'link' => $link, 'sublayout' => 'itinerary', 'class' => 'w-100 mb-3')); ?>
                        <?php // --- /.Book now ---?>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        <?php endif; ?>
        <div class="container<?php echo ($this->templateParams->get('fluidContainer') ? '-fluid' : ''); ?>">
            <div class="row">
                <div class="col-12">
                    <?php if ($info == 1 || $info == 2) : ?>
                        <?php if ($useDefList) : ?>
                            <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
                            <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
                        <?php endif; ?>
                        <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
                            <?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
                            <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php
                    if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative) :
                        echo $this->item->pagination;
                        ?>
                    <?php endif; ?>
                    <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) : ?>
                        <?php echo $this->loadTemplate('links'); ?>
                    <?php endif; ?>
                    <?php // Optional teaser intro text for guests ?>
                <?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
                    <?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
                    <?php echo JHtml::_('content.prepare', $this->item->introtext); ?>
                    <?php // Optional link to let them register to see the whole article. ?>
                    <?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
                        <?php $menu = JFactory::getApplication()->getMenu(); ?>
                        <?php $active = $menu->getActive(); ?>
                        <?php $itemId = $active->id; ?>
                        <?php $link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
                        <?php $link->setVar('return', base64_encode(ContentHelperRoute::getItineraryRoute($this->item->slug, $this->item->itinerarytype_id, $this->item->language))); ?>
                        <p class="readmore">
                            <a href="<?php echo $link; ?>" class="register">
                                <?php $attribs = json_decode($this->item->attribs); ?>
                                <?php
                                if ($attribs->alternative_readmore == null) :
                                    echo JText::_('COM_STANDARD_REGISTER_TO_READ_MORE');
                                elseif ($readmore = $attribs->alternative_readmore) :
                                    echo $readmore;
                                    if ($params->get('show_readmore_title', 0) != 0) :
                                        echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
                                    endif;
                                elseif ($params->get('show_readmore_title', 0) == 0) :
                                    echo JText::sprintf('COM_STANDARD_READ_MORE_TITLE');
                                else :
                                    echo JText::_('COM_STANDARD_READ_MORE');
                                    echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
                                endif;
                                ?>
                            </a>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php
                if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
                    echo $this->item->pagination;
                    ?>
                <?php endif; ?>
                <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
                <?php echo $this->item->event->afterDisplayContent; ?>
            </div>
        </div>
    </div>

</div>