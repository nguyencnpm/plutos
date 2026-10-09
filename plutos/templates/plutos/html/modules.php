<?php
defined('_JEXEC') or die;

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg. To render a module mod_test in the submenu style, you would use the following include:
 * <jdoc:include type="module" name="test" style="submenu" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */
/*
 * Module chrome for rendering the module in a submenu
 */
function modChrome_no($module, &$params, &$attribs) {
    if ($module->content) {
        echo $module->content;
    }
}

function modChrome_header($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' col-' . $bootstrapSize : '';

    // class icon
    $anchorCss = $params->get('anchor_css', '');
    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <<?php echo $headerTag; ?> <?php echo $headerClass; ?>>
            <?php if (!empty($anchorCss)): ?>
                <i class="<?php echo $anchorCss; ?>" aria-hidden="true"></i> 
            <?php endif; ?>
            <?php echo $module->title; ?>
            </<?php echo $headerTag; ?>>
        <?php endif; ?>
        <div class="content"><?php echo $module->content; ?></div>
        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}

function modChrome_differencesfull($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' col-' . $bootstrapSize : '';

    // class icon
    $anchorCss = $params->get('anchor_css', '');
    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="row moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <div class="col-12">
                <<?php echo $headerTag; ?> <?php echo $headerClass; ?>>
                <?php if (!empty($anchorCss)): ?>
                    <i class="<?php echo $anchorCss; ?>" aria-hidden="true"></i> 
                <?php endif; ?>
                <?php echo $module->title; ?>
                </<?php echo $headerTag; ?>>
            </div>
        <?php endif; ?>
        <div class="col-12 content"><?php echo $module->content; ?></div>
        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}

function modChrome_differences($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' col-' . $bootstrapSize : '';

    // class icon
    $anchorCss = $params->get('anchor_css', '');
    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <<?php echo $headerTag; ?> <?php echo $headerClass; ?>>
            <?php if (!empty($anchorCss)): ?>
                <i class="<?php echo $anchorCss; ?>" aria-hidden="true"></i> 
            <?php endif; ?>
            <?php echo $module->title; ?>
            </<?php echo $headerTag; ?>>
        <?php endif; ?>
        <div class="content"><?php echo $module->content; ?></div>
        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}

function modChrome_standard($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' col-' . $bootstrapSize : '';

    // class icon
    $anchorCss = $params->get('anchor_css', '');
    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <<?php echo $headerTag; ?> <?php echo $headerClass; ?>>
            <?php if (!empty($anchorCss)): ?>
                <i class="<?php echo $anchorCss; ?>" aria-hidden="true"></i> 
            <?php endif; ?>
            <?php echo $module->title; ?>
            </<?php echo $headerTag; ?>>
        <?php endif; ?>
        <div class="content"><?php echo $module->content; ?></div>
        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}

function modChrome_well($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $headerClass = htmlspecialchars($params->get('header_class', 'page-header'), ENT_COMPAT, 'UTF-8');

    if ($module->content) {
        echo '<' . $moduleTag . ' class="well ' . htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass . '">';

        if ($module->showtitle) {
            echo '<' . $headerTag . ' class="' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
        }

        echo $module->content;
        echo '</' . $moduleTag . '>';
    }
}

function modChrome_gpStandard($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';

    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    //$headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8'); ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <<?php echo $headerTag; ?>> 
            <i class="<?php echo $headerClass; ?>" aria-hidden="true"></i> 
            <?php echo $module->title; ?> 
            </<?php echo $headerTag; ?>>
        <?php endif; ?>
        <div class="module-content">
            <?php echo $module->content; ?>
        </div>
        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}

function modChrome_victoria($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';

    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo $moduleClass; ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <i class="<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8'); ?>"></i> <<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
        <?php endif; ?>

        <?php echo $module->content; ?>

        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}

function modChrome_gpLine($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' col-' . $bootstrapSize : '';

    // class icon
    $anchorCss = $params->get('anchor_css', '');
    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) {
        ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">
        <?php if ($module->showtitle) : ?> 
            <<?php echo $headerTag; ?> class="<?php echo $headerClass; ?>">
            <div class="title-line">
                <?php if (!empty($anchorCss)): ?>
                    <i class="<?php echo $anchorCss; ?>" aria-hidden="true"></i> 
                <?php endif; ?>
                <?php echo $module->title; ?>
            </div>
            <div class="clearfix"></div>
            <div class="pull-left line_start"></div>
            <div class="pull-right line_end"></div>
            </<?php echo $headerTag; ?>>
        <?php endif; ?> 
        <div class="content"><?php echo $module->content; ?></div>
        </<?php echo $moduleTag; ?>>
        <?php
    }
}

function modChrome_menuLeft($module, &$params, &$attribs) {
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if (!empty($module->content)) :
        ?>
        <div class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle) : ?> 
                <h<?php echo $headerLevel; ?> class="<?php echo htmlspecialchars($params->get('header_class')); ?>">
                    <div class="title"><?php echo $module->title; ?></div>
                </h<?php echo $headerLevel; ?>>
            <?php endif; ?> 
            
            <?php if (htmlspecialchars($params->get('subtitle'))) : ?> 
                <div class="subtitle<?php echo htmlspecialchars($params->get('subtitle_class')); ?>"><?php echo htmlspecialchars($params->get('subtitle')); ?></div>
            <?php endif; ?> 
                
            <div class="clearfix blue">
                <div class="pull-left line_start"></div>
                <div class="pull-right line_end"></div>
            </div>
            <div class="content">
                <?php echo $module->content; ?>
            </div>
        </div>
        <?php
    endif;
}

function modChrome_gpLineArrow($module, &$params, &$attribs) {
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if (!empty($module->content)) :
        ?>
        <div class="moduletable_gpLineArrow <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle) : ?> 
                <h<?php echo $headerLevel; ?> class="<?php echo htmlspecialchars($params->get('header_class')); ?>">
                    <div class="title-fa"><?php echo $module->title; ?></div>
                    <span class="fa fa-caret-down"></span>
                </h<?php echo $headerLevel; ?>>
            <?php endif; ?> 
            <div class="content"><?php echo $module->content; ?></div>
        </div>
        <?php
    endif;
}

function modChrome_gpBackgroundBootstrap($module, &$params, &$attribs) {
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if (!empty($module->content)) {
        ?>
        <div class="moduletable_background <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle) : ?> 
                <h<?php echo $headerLevel; ?> class="<?php echo htmlspecialchars($params->get('header_class')); ?>">
                    <div class="title-fa"><?php echo $module->title; ?></div>
                    <span class="fa fa-caret-down"></span>
                </h<?php echo $headerLevel; ?>>
            <?php endif; ?> 
            <div class="content"><?php echo $module->content; ?></div>
        </div>
        <?php
    }
}

function modChrome_gpStandardPage($module, &$params, &$attribs) {
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if (!empty($module->content)) :
        ?>
        <div class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle) { ?> <div class="<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>"><h<?php echo $headerLevel; ?> class="<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>"><span><?php echo $module->title; ?></span></h<?php echo $headerLevel; ?>></div><?php }; ?> 
            <?php echo $module->content; ?>
        </div>
        <?php
    endif;
}

function modChrome_gpLineBackground($module, &$params, &$attribs) {
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if (!empty($module->content)) :
        ?>
        <div class="moduletable_gpLineBackground <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <div class="panel panel-<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> polaroid">
                <div class="panel-heading">
                    <?php if ($module->showtitle) : ?> 
                        <h<?php echo $headerLevel; ?>  style="background: none;">
                            <div class="panel-title"><?php echo $module->title; ?></div>
                        </h<?php echo $headerLevel; ?>>
                    <?php endif; ?> 
                </div>
                <hr class="margin-0 bg-<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>"/>
                <div class="panel-body"><?php echo $module->content; ?></div>
            </div>
        </div>
        <?php
    endif;
}

function modChrome_contacts($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';

    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <<?php echo $headerTag; ?>>
            <?php if (!empty($headerClass)): ?>
                <i class="<?php echo $headerClass; ?>" aria-hidden="true"></i> 
            <?php endif; ?>
            <?php echo $module->title; ?>
            </<?php echo $headerTag; ?>>
        <?php endif; ?>
        <div class="content"><?php echo $module->content; ?></div>
        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}

function modChrome_footer($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' col-' . $bootstrapSize : '';

    // class icon
    $anchorCss = $params->get('anchor_css', '');
    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="row moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <div class="col-12">
                <<?php echo $headerTag; ?> <?php echo $headerClass; ?>>
                <?php if (!empty($anchorCss)): ?>
                    <i class="<?php echo $anchorCss; ?>" aria-hidden="true"></i> 
                <?php endif; ?>
                <?php echo $module->title; ?>
                </<?php echo $headerTag; ?>>
            </div>
        <?php endif; ?>
        <div class="col-12 content"><?php echo $module->content; ?></div>
        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}

function modChrome_menuFooter($module, &$params, &$attribs) {
    $moduleTag = $params->get('module_tag', 'div');
    $headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
    $bootstrapSize = (int) $params->get('bootstrap_size', 0);
    $moduleClass = $bootstrapSize != 0 ? ' col-' . $bootstrapSize : '';

    // class icon
    $anchorCss = $params->get('anchor_css', '');
    // Temporarily store header class in variable
    $headerClass = $params->get('header_class');
    $headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

    if (!empty($module->content)) :
        ?>
        <<?php echo $moduleTag; ?> class="row moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">

        <?php if ((bool) $module->showtitle) : ?>
            <div class="col-12">
                <<?php echo $headerTag; ?> <?php echo $headerClass; ?>>
                <?php if (!empty($anchorCss)): ?>
                    <i class="<?php echo $anchorCss; ?>" aria-hidden="true"></i> 
                <?php endif; ?>
                <?php echo $module->title; ?>
                </<?php echo $headerTag; ?>>
            </div>
        <?php endif; ?>
        
        <div class="col-12 content"><?php echo $module->content; ?></div>
        
        </<?php echo $moduleTag; ?>>

        <?php
    endif;
}