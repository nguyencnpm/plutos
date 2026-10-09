<?php
defined('_JEXEC') or die;

$twofactormethods = JAuthenticationHelper::getTwoFactorMethods();
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Output as HTML5
$doc->setHtml5(true);

$fullWidth = 1;

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');
// Add Stylesheets
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/styleoffline.min.css');

// Use of Google Font
if ($this->params->get('googleFont')) {
    $doc->addStyleSheet('//fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
    $doc->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
	}");
}

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Logo file or site title param
$sitename = $app->get('sitename');
// logo PC
if ($this->params->get('logoLogin')) {
    $logo = '<img src="' . JUri::root() . $this->params->get('logoLogin') . '" alt="' . $sitename . '" />';
} elseif ($this->params->get('sitetitle')) {
    $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
} else {
    $logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}

// logo Mobile
if ($this->params->get('logoLoginMobile')) {
    $logoMobile = '<img src="' . JUri::root() . $this->params->get('logoLoginMobile') . '" alt="' . $sitename . '" />';
} elseif ($this->params->get('sitetitle')) {
    $logoMobile = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
} else {
    $logoMobile = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');
$usersConfig = JComponentHelper::getParams('com_users');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <jdoc:include type="head" />
<!--[if lt IE 9]><script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script><![endif]-->

</head>
<?php
$isComUsers = FALSE;
// Adjust the context to support modal layouts.
if ($app->input->get('option') == 'com_users' && ($app->input->get('view') == 'remind' || $app->input->get('view') == 'reset')) :
    $isComUsers = TRUE;
endif;
?>
<body class="siteoffline">
    <div class="outer">
        <div class="middle">
            <div class="inner">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row row-bglogin">
                                <?php if (!$isComUsers): ?>
                                    <form action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login">
                                    <?php endif; ?>
                                    <div class="col-md-7 row_bglogo">
                                        <div class="clearfix hidden-xs hidden-sm">&nbsp;</div>
                                        <div class="header-offline">
                                            <?php if (!empty($logo)|| !empty($logoMobile)) : ?>
                                            <div class="row">
                                                <div class="col-md-12 hidden-xs hidden-sm"><h1><?php echo $logo; ?></h1></div>
                                                <div class="col-xs-12 col-sm-12 hidden-md hidden-lg"><h1><?php echo $logoMobile; ?></h1></div>
                                            </div>
                                            
                                            <?php else : ?>
                                                <h1><?php echo htmlspecialchars($app->get('sitename')); ?></h1>
                                            <?php endif; ?>
                                            <?php if ($app->get('offline_image') && file_exists($app->get('offline_image'))) : ?>
                                                <img src="<?php echo $app->get('offline_image'); ?>" alt="<?php echo htmlspecialchars($app->get('sitename')); ?>" />
                                            <?php endif; ?>
                                            <?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) != '') : ?>
                                                <p><?php echo $app->get('offline_message'); ?></p>
                                            <?php elseif ($app->get('display_offline_message', 1) == 2) : ?>
                                                <p><?php echo JText::_('JOFFLINE_MESSAGE'); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>
                                    </div>
                                    <div class="col-md-5">
                                        <?php
                                        // Adjust the context to support modal layouts.
                                        if ($isComUsers) :
                                            ?>
                                            <div class="clearfix">&nbsp;</div>
                                            <jdoc:include type="message" />
                                            <jdoc:include type="component" />
                                        <?php else: ?>
                                            <div class="row hidden-xs hidden-sm">
                                                <div class="col-md-12 text-center" style="margin-bottom: 25px"><h2 class="title-login"><?php echo JText::_("JLOGIN"); ?></h2></div>
                                            </div>
                                            <div class="row inner-message-login">
                                                <div class="col-md-12"><jdoc:include type="message" /></div>
                                            </div>
                                            <fieldset id="loginform" class="loginform">
                                                <div style="margin-bottom: 25px" class="form-group">
                                                    <label class="control-label hidden-xs hidden-sm"><?php echo JText::_('TPL_OFFLINE_EMAIL_LABEL'); ?></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                        <input name="username" tabindex="1" id="username" type="text" class="form-control" placeholder="<?php echo JText::_('TPL_OFFLINE_EMAIL_LABEL'); ?>" autofocus="true" />                                       
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label hidden-xs hidden-sm"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                        <input name="password" id="password" type="password" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" />
                                                    </div>
                                                </div>
                                                <div class="row hidden-xs hidden-sm">
                                                    <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                                                        <?php $class_forgotpassword = "col-xs-6 col-sm-6 col-md-6"; ?>
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <div style="margin-bottom: 25px" class="input-group remember checkbox checkbox-danger-vic">
                                                                    <input id="offline-remember" type="checkbox" name="remember" value="yes"> <label for="offline-remember"><?php echo JText::_('TPL_OFFLINE_REMEMBER_ME'); ?></label> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <?php $class_forgotpassword = "col-xs-12 col-sm-12 col-md-12"; ?>
                                                    <?php endif; ?>
                                                    <div class="<?php echo $class_forgotpassword; ?>">
                                                        <div class="form-group">
                                                            <div style="margin-bottom: 25px" class="input-group pull-right checkbox">
                                                                <a class="forgot-password" href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
                                                                    <?php echo JText::_('TPL_OFFLINE_LOGIN_FORGOT_YOUR_PASSWORD'); ?>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if (count($twofactormethods) > 1) : ?>
                                                    <label for="secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
                                                    <input type="text" name="secretkey" id="secretkey" title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" />
                                                <?php endif; ?>

                                                <div class="row"><!--  hidden-md hidden-lg -->
                                                    <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 25px">
                                                        <input type="submit" name="Submit" class="validateBtn btn btn-vic btn-vic btn-vic btn-lg btn-danger btn-block validate btn-login-offine" value="<?php echo JText::_('JLOGIN'); ?>">
                                                    </div>
                                                </div>
                                                <div class="row hidden-md hidden-lg">
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <div style="margin-bottom: 25px" class="text-center checkbox">
                                                                <a class="forgot-password" href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
                                                                    <?php echo JText::_('TPL_OFFLINE_LOGIN_FORGOT_YOUR_PASSWORD'); ?>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="option" value="com_users" />
                                                <input type="hidden" name="task" value="user.login" />
                                                <input type="hidden" name="return" value="<?php echo base64_encode(JUri::base()); ?>" />
                                                <?php echo JHtml::_('form.token'); ?>
                                            </fieldset>
                                        <?php endif; ?>
                                        <div/>
                                    </div>
                            </div>
                            <?php if (!$isComUsers): ?>
                                <!--                                
                                <div class="col-md-12 hidden-xs hidden-sm">
                                <div class="row">
                                    <div class="col-md-7 row_bglogo"></div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="clearfix">&nbsp;</div>
                                                <input type="submit" name="Submit" class="validateBtn btn btn-vic btn-lg btn-danger btn-block validate btn-login-offine btn-login-desktop" value="<?php echo JText::_('JLOGIN'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                -->
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/javascripts/ajax/jquery.min.js" type="text/javascript"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<script>window.jQuery || document.write('<script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/javascripts/vendor/jquery.min.js"><\/script>')</script>
<!--<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>-->
<script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/javascripts/bootstrap.min.js" type = "text/javascript" ></script>
<!--<script src="../../dist/js/bootstrap.min.js"></script>-->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/javascripts/ie10-viewport-bug-workaround.js" type="text/javascript"></script>
<!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
<!-- offcanvas -->
<!--<script src="<?php //echo $this->baseurl . '/templates/' . $this->template ?>/javascripts/offcanvas.min.js" type="text/javascript" async=""></script>-->
<!--<script src="offcanvas.js"></script>-->
<script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/javascripts/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/javascripts/offline.min.js" type="text/javascript"></script>
<script type="text/javascript">
    /*
     $(document).ready(function () {
     $("#system-message").on("change", function () {
     $('#loginform').removeClass('loginform');
     });
     $("#system-message").trigger("change");
     });
     */
</script>
</body>
</html>
