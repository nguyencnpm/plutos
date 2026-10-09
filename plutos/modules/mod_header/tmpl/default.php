<?php
/**
 * @package     giaiphapcongnghethongtin.Site
 * author       Binh Nguyen
 * @subpackage  mod_header
 */
defined('_JEXEC') or die;
?>
<div class="col-12">
    <div class="<?php echo $class_sfx; ?>">
        <?php if ($isRenderModuleMarqueeEnabled): ?>
            <div class="<?php echo $cMarquee ?>">
                <?php
                $marqueeAttribs['style'] = 'marquee';
                $marqueeAttribs['headerLevel'] = 3;
                foreach ($moduleMarquee as $marquee) :
                    echo JModuleHelper::renderModule($marquee, $marqueeAttribs);
                endforeach;
                ?>
            </div>
        <?php endif; ?>
        <?php if ($isRenderModuleShareEnabled): ?>
            <div class="<?php echo $cShare ?>">
                <?php
                $shareAttribs['style'] = 'share';
                $shareAttribs['headerLevel'] = 3;
                foreach ($moduleShare as $share) :
                    echo JModuleHelper::renderModule($share, $shareAttribs);
                endforeach;
                ?>
            </div>
        <?php endif; ?>
        <?php if ($isRenderModuleCartEnabled): ?>
            <div class="<?php echo $cCart ?>">
                <?php
                $cartAttribs['style'] = 'cart';
                $cartAttribs['headerLevel'] = 3;
                foreach ($moduleCart as $cart) :
                    echo JModuleHelper::renderModule($cart, $cartAttribs);
                endforeach;
                ?>
            </div>
        <?php endif; ?>
        <?php if ($isRenderModuleLanguageEnabled): ?>
            <div class="<?php echo $cLanguage ?>">
                <?php
                $languageAttribs['style'] = 'language';
                $languageAttribs['headerLevel'] = 3;
                foreach ($moduleLanguage as $language) :
                    echo JModuleHelper::renderModule($language, $languageAttribs);
                endforeach;
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>