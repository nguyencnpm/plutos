<?php
defined('_JEXEC') or die;
$isFirefox = 0;
if ($browser->getBrowser() == "firefox" || $browser->getBrowser() == "mozilla") {
    $isFirefox = 1;
}
?>
<div class="marquee<?php echo $class_sfx; ?>">
    <?php
    switch ((int) $params->get('run')) {
        case 0:
            ?>
            <div class="run-stop" align="<?php echo $params->get('align'); ?>" height="<?php echo $params->get('height', '100%'); ?>" width="<?php echo $params->get('width', '100%'); ?>" >
                <?php echo $params->get('description'); ?>
            </div>
            <?php
            break;
        case 1:
        default:
            ?>
            <marquee 
                align="<?php echo $params->get('align'); ?>" 
                behavior="<?php echo $params->get('behavior'); ?>" 
                bgcolor="<?php echo $params->get('bgcolor'); ?>" 
                direction="<?php echo $params->get('direction'); ?>" 
                height="<?php echo $params->get('height', '100%'); ?>" 
                hspace="<?php echo $params->get('hspace'); ?>"  
                width="<?php echo $params->get('width', '100%'); ?>" 
                vspace="<?php echo $params->get('vspace'); ?>" 
                loop="<?php echo $params->get('loop'); ?>" 
                scrolldelay="<?php echo $params->get('scrolldelay'); ?>"  
                scrollamount="<?php echo $params->get('scrollamount'); ?>" 
                <?php if ($isFirefox): ?>
                    onmouseout="javascript:this.setAttribute('scrollamount', <?php echo $params->get('scrollamount'); ?>);"
                    onmouseover="javascript:this.setAttribute('scrollamount', '0');"
                <?php else: ?>
                    onmouseout="this.start();" 
                    onmouseover="this.stop();"
                <?php endif; ?>
                >
                <div class="d-none d-lg-block"><?php echo $params->get('description'); ?></div>
                <div class="d-none d-md-block d-lg-none"><?php echo $params->get('description_tablet'); ?></div>
                <div class="d-md-none"><?php echo $params->get('description_phone'); ?></div>
            </marquee>
            <?php
            break;
    }
    ?>

</div>
