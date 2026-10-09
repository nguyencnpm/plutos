<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_standard_footer
 */
defined('_JEXEC') or die;

?>

<div class="row h-100 <?php echo $class_sfx; ?>">
    <?php if ($isLogoFooter): ?>
        <div class="<?php echo $cLogoFooter; ?> mb-4 d-lg-flex align-items-lg-center">
            <img src="<?php echo $renderLogo; ?>" alt="<?php echo $templateParams->get('sitetitlefooter', $sitenameFooter); ?>" />
        </div>
    <?php endif; ?>
    
    <?php if ($isContentFooter): ?>
        <div class="<?php echo $cContentFooter; ?>">
           
            <?php if ($isRenderModuleMenuFooterEnabled): ?>
             
                <div class="row">
                    <div class="<?php echo $cContentMenuFooter; ?>">
                        <?php
                        $shareAttribs['style'] = 'menuFooter';
                        $shareAttribs['headerLevel'] = 3;
                        foreach ($moduleMenuFooter as $menu) :
                            echo JModuleHelper::renderModule($menu, $shareAttribs);
                        endforeach;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
           
            <?php if ($isRenderModuleFooterOneEnabled || $isRenderModuleFooterTwoEnabled): ?>
                <div class="row">
                    <?php if ($isRenderModuleFooterOneEnabled): ?>
                        <div class="<?php echo $cContentFooterOne; ?>">
                            <?php
                            $shareAttribs['style'] = 'footer';
                            $shareAttribs['headerLevel'] = 3;
                            foreach ($moduleFooterOne as $one) :
                                echo JModuleHelper::renderModule($one, $shareAttribs);
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($isRenderModuleFooterTwoEnabled): ?>
                        <div class="<?php echo $cContentFooterTwo; ?>">
                            <?php
                            $shareAttribs['style'] = 'footer';
                            $shareAttribs['headerLevel'] = 3;
                            foreach ($moduleFooterTwo as $two) :
                                echo JModuleHelper::renderModule($two, $shareAttribs);
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($isRenderModuleShareFooterEnabled || $isRenderModulePartnerFooterEnabled): ?>
                <div class="row">
                    <?php if ($isRenderModuleShareFooterEnabled): ?>
                        <div class="<?php echo $cContentShareFooter; ?>">
                            <?php
                            $shareAttribs['style'] = 'footer';
                            $shareAttribs['headerLevel'] = 3;
                            foreach ($moduleShareFooter as $share) :
                                echo JModuleHelper::renderModule($share, $shareAttribs);
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="<?php echo $cContentFakeShareAndPartner; ?>"></div>
                    <?php if ($isRenderModulePartnerFooterEnabled): ?>
                        <div class="<?php echo $cContentPartnerFooter; ?>">
                            <?php
                            $shareAttribs['style'] = 'footer';
                            $shareAttribs['headerLevel'] = 3;
                            foreach ($modulePartnerFooter as $partner) :
                                echo JModuleHelper::renderModule($partner, $shareAttribs);
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>