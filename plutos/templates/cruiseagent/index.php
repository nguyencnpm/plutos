<?php
/*
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
 */
defined('_JEXEC') or die;
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
require_once ( JPATH_THEMES . DS . $this->template . '/template_prepocessor.php');
/*
  if (!class_exists('MobileDetect')) {
  jimport('informationtechnology.mobiledetect.mobile_detect');
  }
 */
$tlPath = $this->baseurl . '/templates/' . $this->template;

// Check modules
$showLeftColumn = ($this->countModules('position-3') or $this->countModules('position-4') or $this->countModules('position-5'));
$showRightColumn = ($this->countModules('position-6') or $this->countModules('position-7') or $this->countModules('position-8') or $this->countModules('position-tabs'));

$blockPositionArea = array();
$blockPositionArea["showLeftColumn"] = $showLeftColumn;
$blockPositionArea["showRightColumn"] = $showRightColumn;
$blockPositionArea["widthcolumn_leftright"] = $this->params->get('widthcolumn_leftright', 3);
$blockPositionArea["widthcolumn"] = $this->params->get('widthcolumn', 3);
$blockPositionArea["prefix_extrasmall"] = $this->params->get('prefix_extrasmall', "col-");
$blockPositionArea["prefix_small"] = $this->params->get('prefix_small', "col-sm-");
$blockPositionArea["prefix_medium"] = $this->params->get('prefix_medium', "col-md-");
$blockPositionArea["prefix_large"] = $this->params->get('prefix_large', "col-lg-");
$blockPositionArea["prefix_extralarge"] = $this->params->get('prefix_extralarge', "col-xl-");
$blockPositionArea["slidername"] = 0;

$cMenuType = $this->params->get('menuType');

$sAttributesNavBar = "";
$stickyMenu = $this->params->get('stickyMenu', 0);
if ((int) $stickyMenu && $cMenuType != "fixed-top" && $cMenuType != "fixed-bottom") :
    $sAttributesNavBar = "data-toggle=\"sticky-onscroll\" ";
endif;

$cUseMenus = $this->params->get('useMenus', "");

$slider = $this->params->get('slider', 0);

$navMasthead = $this->params->get('navmasthead', 0);

$cCollapse = "collapse";
$idNavigationBar = "navbarCollapse";
if ((int) $slider) :
    $sAttributesNavigation = "data-toggle=\"offcanvas\"";
    $cCollapse = "offcanvas-collapse";
    $idNavigationBar = "navbarDefault";
else:
    $sAttributesNavigation = "data-toggle=\"{$cCollapse}\" "
            . "data-target=\"#{$idNavigationBar}\" "
            . "aria-controls=\"{$idNavigationBar}\" "
            . "aria-expanded=\"false\" "
            . "aria-label=\"Toggle navigation\"";
endif;

if ($navMasthead):
    $cCollapse .= " nav-masthead";
endif;

ColumnBlock::createBlockContentarea($blockPositionArea, $ClassLeft, $ClassCom, $ClassRight);

//---------------------------- create Block Headers --------------------------------
$newArrHeaders = array();
if (($this->countModules('header-1') or $this->countModules('header-2') or $this->countModules('header-3')or $this->countModules('header-4'))) {
    $arrArrHeaders = array('header-1', 'header-2', 'header-3', 'header-4');
    $newArrHeaders = ColumnBlock::createBlock($this, $arrArrHeaders, $blockPositionArea, $cHeaders);
}

//---------------------------- create Block utilities --------------------------------
$newArrUtilities = array();
if (($this->countModules('utilities-1') or $this->countModules('utilities-2') or $this->countModules('utilities-3')or $this->countModules('utilities-4'))) {
    $arrArrUtilities = array('utilities-1', 'utilities-2', 'utilities-3', 'utilities-4');
    $newArrUtilities = ColumnBlock::createBlock($this, $arrArrUtilities, $blockPositionArea, $cUtilities);
}
//---------------------------- create Block Top --------------------------------
$newArrModuleTop = array();
if (($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11')or $this->countModules('position-12'))) {
    $arrModuleTop = array('position-9', 'position-10', 'position-11', 'position-12');
    $newArrModuleTop = ColumnBlock::createBlock($this, $arrModuleTop, $blockPositionArea, $ClassTop);
}

//---------------------------- create Block Bottom -----------------------------
$newArrModuleBottom = array();
if (($this->countModules('position-13') or $this->countModules('position-14') or $this->countModules('position-15')or $this->countModules('position-16'))) {
    $arrModuleBottom = array('position-13', 'position-14', 'position-15', 'position-16');
    $newArrModuleBottom = ColumnBlock::createBlock($this, $arrModuleBottom, $blockPositionArea, $ClassBottom);
}

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;
// Detecting Active Variables
/*
  $option = $app->input->getCmd('option', '');
  $view = $app->input->getCmd('view', '');
  $layout = $app->input->getCmd('layout', '');
  $task = $app->input->getCmd('task', '');
  $itemid = $app->input->getCmd('Itemid', '');
 */
$sitename = $app->get('sitename');

// Logo file or site title param
if ($this->params->get('logo')) {
    $logo = '<img src="' . JUri::root() . $this->params->get('logo') . '" alt="' . $sitename . '" />';
} elseif ($this->params->get('sitetitle')) {
    $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
} else {
    $logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}

//$doc->addStyleSheet($this->baseurl . '/templates/system/css/system.css');
//$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.min.css', $type = 'text/css', $media = 'screen,projection');
//$path_font_face = $this->baseurl . '/templates/' . $this->template.'/';//@font-face{font-family:'FontAwesome';src:url("code php")}
// JHtml::_('stylesheet', 'template.min.css', array('version' => 'auto', 'relative' => true));
# unset frameworks
JHtml::_('bootstrap.framework', false);
JHtml::_('jquery.framework', false);
// unset scripts jui
unset($doc->_scripts[$this->baseurl . '/media/jui/js/jquery.min.js']);
unset($doc->_scripts[$this->baseurl . '/media/jui/js/bootstrap.min.js']);
unset($doc->_scripts[$this->baseurl . '/media/jui/js/jquery-noconflict.js']);
unset($doc->_scripts[$this->baseurl . '/media/jui/js/jquery-migrate.min.js']);

// unset scripts MooTools system 
unset($this->_scripts[JURI::root(true) . '/media/system/js/core.js']);
unset($this->_scripts[JURI::root(true) . '/media/system/js/keepalive.js']);
unset($this->_scripts[JURI::root(true) . '/media/system/js/caption.js']);
unset($this->_scripts[JURI::root(true) . '/media/system/js/html5fallback.js']);

// $this->_script['text/javascript'] = preg_replace('%jQuery\(window\).on\(\'load\',\s*function\(\)\s*\{\s*new\s*JCaption\(\'img.caption\'\)\;\s*\}\)\;\s*%', '', $this->_script['text/javascript']);
if (empty($this->_script['text/javascript'])) {
    unset($this->_script['text/javascript']);
}
$viewName = JRequest::getCmd('view');
$doc->setGenerator($sitename);
$nowDate = JFactory::getDate()->toSql();
$sToday = JHtml::_('date', $nowDate, JText::_('DATE_FORMAT_SYSTEM'));
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <jdoc:include type="head" />
    <?php if ($this->params->get('googleFont')) : ?>
        <link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName'); ?>' rel='stylesheet' type='text/css' />
        <style type="text/css">
            h1,h2,h3,h4,h5,h6,.site-title{font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName')); ?>', sans-serif;}
        </style>
    <?php endif; ?>

    <style type="text/css">
<?php echo str_replace("..", $tlPath, file_get_contents(JPATH_ROOT . '/templates/' . $this->template . '/css/template.min.css')); ?> 
    </style>

</head>
<?php // -- Body --  ?>
<body class="bg-site <?php echo empty($cMenuType) ? "body-navbar" : "body-navbar-" . $cMenuType; ?> <?php echo "body-navbar-" . $cCollapse; ?>">
    <input type="hidden" id="today" value="<?php echo $sToday; ?>"/>
    <input type="hidden" id="urlRoot" value="<?php echo JURI::root(false); ?>"/>
    <input type="hidden" id="sLocale" value="<?php echo $this->language; ?>"/>
    <header>
        <?php if ($this->countModules('position-1') || $this->countModules('position-0')) : ?>
            <nav class="navbar navbar-expand-lg <?php echo $cMenuType; ?> <?php echo $cUseMenus; ?>">
                <?php if ((count($newArrHeaders) > 0) || $this->countModules('header') || $this->countModules('share') || $this->countModules('cart') || $this->countModules('language')) : ?>
                    <div class="header-inner">
                        <?php if (count($newArrHeaders) > 0) : ?>
                            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                                <div class="row">
                                    <?php foreach ($newArrHeaders as $key => $val) {
                                        ?>
                                        <div class="<?php echo $cHeaders; ?>" >
                                            <jdoc:include type="modules" name="<?php echo $val; ?>" style="no" />
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->countModules('header')): ?>
                            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                                <div class="row">
                                    <jdoc:include type="modules" name="header" style="no" />
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="bg-navbar <?php //echo 'box-shadow';                  ?>" <?php echo $sAttributesNavBar; ?>>
                    <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-2 col-xl-2">
                                <div class="row">
                                    <div class="col-5 col-sm-4 col-md-3 col-lg-12 <?php echo $this->countModules('utilities-navbar') > 0 ? " controller-utilities" : ""; ?>">
                                        <div class="logo-element">
                                            <a class="brand" href="<?php echo JURI::root(false); ?>" title="<?php echo htmlspecialchars($this->params->get('sitetitle')); ?>">
                                                <?php echo $logo; ?>
                                            </a>
                                        </div>
                                        <?php //if ($this->params->get('sitedescription')) :   ?>
                                        <?php //echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</div>'; ?>
                                        <?php //endif; ?>
                                        <?php if ($this->countModules('utilities-navbar')): ?>  
                                            <div class="utilities-navbar d-none">
                                                <jdoc:include type="modules" name="utilities-navbar" style="no" />
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-7 col-sm-8 col-md-9 col-lg-0 text-right header-inner-brand align-self-center">
                                        <?php if ($this->countModules('hotline')): ?>
                                            <div class="navbar-brand d-lg-none hotline">
                                                <jdoc:include type="modules" name="hotline" style="no" />
                                            </div>
                                        <?php endif; ?>

                                        <button class="hamburger hamburger--collapse navbar-toggler pt-2 pb-2 pl-0 pr-0 border-0" type="button" <?php echo $sAttributesNavigation; ?>>
                                            <?php if (!$this->params->get('isagent')): ?>
                                                <?php // <span class="navbar-toggler-icon"></span>  ?>
                                                <div class="hamburger-box">
                                                    <div class="hamburger-inner"></div>
                                                </div>
                                            <?php else: ?>
                                                <?php $user = JFactory::getUser(); ?>
                                                <b class="fa fa-user-circle-o fa-2x hasTooltip" aria-hidden="true" title="<?php echo $user->name; ?>"></b>
                                            <?php endif; ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10 col-xl-10">     
                                <div class="navbar-collapse <?php echo $cCollapse; ?>" id="<?php echo $idNavigationBar; ?>">
                                    <?php //-- start utilities-Block -- ?>        
                                    <?php if (count($newArrUtilities) > 0) : ?>
                                        <div class="<?php echo $this->countModules('utilities-navbar') > 0 ? "controller-utilities" : ""; ?>">
                                            <div class="row utilities d-none d-lg-block">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <?php foreach ($newArrUtilities as $key => $val) {
                                                            ?>
                                                            <div class="<?php echo $cUtilities; ?>" >
                                                                <jdoc:include type="modules" name="<?php echo $val; ?>" style="no" />
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php //-- /.utilities-Block --?>
                                    <div class="row">
                                        <div class="col-12">
                                            <jdoc:include type="modules" name="position-1" style="no" />
                                            <?php if ($this->countModules('position-0')): ?>
                                                <jdoc:include type="modules" name="position-0" style="no" />
                                            <?php endif; ?>
                                            <?php
                                            /*
                                              <form class="form-inline my-2 my-lg-0">
                                              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                                              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                              </form>
                                             */
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        <?php endif; ?>
        <?php // -- Carousel -- ?>
        <?php if ($this->countModules('slideshow')): ?>
            <div class="polaroid"><jdoc:include type="modules" name="slideshow" style="none" /></div>
        <?php endif; ?>
        <?php // -- / .carousel -- ?>
    </header>

    <?php if ($this->countModules('differences-top')): ?>
        <div class="differences-top">
            <div class="container-fluid">
                <jdoc:include type="modules" name="differences-top" style="differencesfull" headerLevel="3"/>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('featured-top')): ?>
        <div class="featured-top">
            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-12"><jdoc:include type="modules" name="featured-top" style="standard" headerLevel="3"/></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
    <?php if ($viewName === 'product' || $viewName === 'itinerary' || $viewName === 'itineraries'): ?>
        <main role="main">
            <div class="row">
                <div class="col-12"><jdoc:include type="message" /></div>
            </div>
            <jdoc:include type="component" />
            <div class="clearfix"></div>
        </main>
    <?php else: ?>
        <main role="main" class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
            <?php //-- start top-Block -- ?>        
            <?php if (count($newArrModuleTop) > 0) : ?>
                <div class="row">
                    <?php foreach ($newArrModuleTop as $key => $val) {
                        ?>
                        <div class="<?php echo $ClassTop; ?>" >
                            <jdoc:include type="modules" name="<?php echo $val; ?>" style="gpLine" headerLevel="3" />
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
            <?php //-- /.top-Block --?>

            <div class="row">
                <?php if ($showLeftColumn) : ?>
                    <div class="<?php echo $ClassLeft; ?>">
                        <jdoc:include type="modules" name="position-3" style="gpLineArrow" headerLevel="3" />
                        <jdoc:include type="modules" name="position-4" style="gpBackgroundBootstrap" headerLevel="3" />
                        <jdoc:include type="modules" name="position-5" style="gpLineArrow" headerLevel="3" />
                        <div class="clearfix"></div>
                    </div>
                <?php endif; // -- /.end left -- ?>

                <div class="<?php echo $ClassCom; ?>">
                    <?php if ($this->countModules('component-top')): ?>
                        <div class="row">
                            <div class="col-12"><jdoc:include type="modules" name="component-top" style="gpLine" headerLevel="3"/></div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12"><jdoc:include type="message" /></div>
                    </div>
                    <div class="row">
                        <jdoc:include type="component" />
                        <div class="clearfix"></div>
                    </div>
                    <?php if ($this->countModules('component-bottom')): ?>
                        <div class="row">
                            <div class="col-12"><jdoc:include type="modules" name="component-bottom" style="gpLineArrow" headerLevel="3"/></div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($showRightColumn) : ?>
                    <div class="<?php echo $ClassRight; ?>">
                        <jdoc:include type="modules" name="position-6" style="gpLineBackground" headerLevel="3" />
                        <jdoc:include type="modules" name="position-7" style="gpBackgroundBootstrap" headerLevel="3" />
                        <jdoc:include type="modules" name="position-8" style="gpLineArrow" headerLevel="3" />
                        <jdoc:include type="modules" name="position-tabs" style="gpLineArrow" headerLevel="3" />
                        <div class="clearfix"></div>
                    </div>
                <?php endif; // -- /.end right -- ?>
            </div>
            <?php // -- /.row --- ?>
        </main>
        <?php // -- /.container --- ?>
    <?php endif; ?>

    <?php if ($this->countModules('differences-middle-top')): ?>
        <div class="differences-middle-top">
            <div class="container-fluid">
                <jdoc:include type="modules" name="differences-middle-top" style="differences" headerLevel="3"/>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('featured-middle-top')): ?>
        <div class="featured-middle-top">
            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-12"><jdoc:include type="modules" name="featured-middle-top" style="standard" headerLevel="3"/></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('differences-middle')): ?>
        <div class="differences-middle">
            <div class="container-fluid">
                <jdoc:include type="modules" name="differences-middle" style="differences" headerLevel="3"/>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('featured-middle')): ?>
        <div class="featured-middle">
            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-12"><jdoc:include type="modules" name="featured-middle" style="standard" headerLevel="3"/></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('differences-middle-bottom')): ?>
        <div class="differences-middle-bottom">
            <div class="container-fluid">
                <jdoc:include type="modules" name="differences-middle-bottom" style="differences" headerLevel="3"/>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('featured-middle-bottom')): ?>
        <div class="featured-middle-bottom">
            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-12"><jdoc:include type="modules" name="featured-middle-bottom" style="standard" headerLevel="3"/></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>

    <?php if (count($newArrModuleBottom) > 0) : // --- Bottom-Block --- ?>
        <div class="bottom-block">
            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <?php
                    $colTotal = sizeof($newArrModuleBottom);
                    foreach ($newArrModuleBottom as $key => $val) {
                        $classHeight = "";
                        $rowcount = ((int) $key % (int) $colTotal) + 1;
                        if ($rowcount > 1) {
                            $classHeight = " line-height";
                        }
                        $classColumn = " column-" . $rowcount . $classHeight;
                        ?>
                        <div class="<?php echo $ClassBottom . $classColumn; ?>" >
                            <jdoc:include type="modules" name="<?php echo $val; ?>" style="gpLine" headerLevel="3"  />
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php endif; // --- /.Bottom-Block --- ?>
    <?php if ($this->countModules('differences-bottom')): ?>
        <div class="differences-bottom">
            <div class="container-fluid">
                <jdoc:include type="modules" name="differences-bottom" style="differences" headerLevel="3"/>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('featured-bottom')): ?>
        <div class="featured-bottom">
            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-12"><jdoc:include type="modules" name="featured-bottom" style="standard" headerLevel="3"/></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>

    <footer class="footer">
        <?php if ($this->countModules('position-2')): ?>
            <div class="breadcrumbs-bottom">
                <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                    <div class="row">
                        <jdoc:include type="modules" name="position-2" style="none"/>
                    </div>
                    <?php // -- /.Breadcrumbs -- ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
            <jdoc:include type="modules" name="footer" style="footer" />
        </div>
        <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
            <div class="row line-top-3 line-yellow">
                <div class="col-12 text-center mt-3">
                    <div class="clearfix"></div>
                    <p>&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?></p>
                    <?php echo "<p><a href=\"http://www.giaiphapcongnghethongtin.vn\" target=\"_blank\">" . JText::_('TPL_CRUISEAGENT_BY') . "</a>&nbsp; " . JText::_('TPL_CRUISEAGENT_GIAIPHAPCONGNGHETHONGTIN') . "</p>" ?>
                </div>
            </div>
        </div>
    </footer>
    <div class="exception">
        <jdoc:include type="modules" name="confirm-box" style="none" />
        <jdoc:include type="modules" name="debug" style="none" />
        <div id="back-to-top" data-target="#" class="back-to-top <?php echo $this->params->get('tooltip_viewport'); ?>" role="button" title="<?php echo JText::_('TPL_BACK_TO_TOP_TITLE'); ?>">
            <i class="fa fa-chevron-circle-up fa-3x"></i>
        </div>
    </div>
    <?php // -- Bootstrap core JavaScript -- ?>
    <?php // -- Placed at the end of the document so the pages load faster -- ?>
    <!-- <script src="<?php //echo $this->baseurl . '/templates/' . $this->template                       ?>/js/slim/jquery-3.3.1.slim.min.js"></script> -->
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/libs/jquery.min.js" type="text/javascript"></script>

    <?php // crossorigin="anonymous" ?>
    <script>window.jQuery || document.write('<script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/bootstrap/assets/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/bootstrap/assets/vendor/popper.min.js"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/bootstrap/dist/bootstrap.min.js"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/bootstrap/assets/vendor/holder.min.js"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/offcanvas/offcanvas.min.js"></script>
    <?php // ---- confirmation ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/bootstrap/dist/bootstrap-confirmation.min.js"></script>
    <?php // ---- /. confirmation ---- ?>
    <?php if (false): // off bootstrap bundle ?>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/bootstrap/dist/bootstrap.bundle.min.js"></script>
    <?php endif; ?>

    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/bootstrapselect/bootstrap-select.min.js" type="text/javascript"></script>

    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/moment/moment-with-locales.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/datepicker/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/datepicker/datetimepicker/ready.min.js" type="text/javascript"></script>

    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/datepicker/daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/datepicker/daterangepicker/readyCustom.min.js" type="text/javascript"></script>

    <?php // ---- tooltip ---- ?>
    <?php if ($this->params->get('tooltip') > 0): ?>
        <?php $pathToolTipFileJS = $this->baseurl . '/templates/' . $this->template . "/js/tooltip/tooltip-viewport.min.js"; ?>
        <input type="hidden" id="pathToolTipFileJS" value="<?php echo $pathToolTipFileJS; ?>"/>
        <script src="<?php echo $pathToolTipFileJS; ?>" type="text/javascript"></script>
    <?php endif; ?>
    <?php if ($cUseMenus === ""): ?>
        <?php // ---- navigationbar --- ?>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/menu/navigationbar/navbar.min.js"></script>    
    <?php endif; ?>
    <?php // ---- sticky - Popover --- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/menu/sticky/navbar.min.js"></script>

    <?php // ---- Carausel JS ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/owlcarousel/owl_carousel.min.js"></script>
    <?php // ---- owl carousel thumbnails ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/media/owlcarousel/owlcarouselthumbnails.min.js"></script>
    <?php // ---- /.Carausel JS ---- ?>

    <?php // ---- template ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/template.min.js"></script>
    <?php // ---- carousel video ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/media/carousel/carouselvideo.min.js"></script>
    <?php // ---- touch Swipe ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/touchSwipe/jquery.touchSwipe.min.js"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/touchSwipe/Swipe.min.js"></script>
    <?php //  ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/effect/hamburgers/hamburgers.min.js"></script>
    <?php // ==== smart menus ====  ?>
    <?php if ($cUseMenus === "smart-menus"): ?>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/jquery/smartmenus/jquery.smartmenus.min.js"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/addon/smartmenus/jquery.smartmenus.bootstrap.min.js"></script>
    <?php endif; ?>
    <?php // ==== /.smart menus ==== ?>
    <?php // ==== use jquery.min ==== ?>
    <?php // --- cart --- ?>
    <?php $pathCartFileJS = $this->baseurl . '/templates/' . $this->template . "/js/ajax/booking/cart/cart.min.js"; ?>
    <input type="hidden" id="pathCartFileJS" value="<?php echo $pathCartFileJS; ?>"/>
    <script src="<?php echo $pathCartFileJS; ?>"></script>
    <?php if ($this->params->get('addtocart_popup') > 0): ?>
        <?php $pathPricesFileJS = $this->baseurl . '/templates/' . $this->template . "/js/ajax/booking/prices.min.js"; ?>
        <input type="hidden" id="pathPricesFileJS" value="<?php echo $pathPricesFileJS; ?>"/>
        <script src="<?php echo $pathPricesFileJS; ?>"></script>
    <?php endif; ?>
    <?php // --- /.cart - Popover --- ?>

    <?php // --- start pagination: navigation load more --- ?>
    <?php if ($this->params->get('loadmore') > 0): ?>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/infinitescrol/src/callbacks.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/infinitescrol/src/jquery-ias.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/infinitescrol/src/extension/history.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/infinitescrol/src/extension/noneleft.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/infinitescrol/src/extension/paging.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/infinitescrol/src/extension/spinner.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/infinitescrol/src/extension/trigger.min.js" type="text/javascript"></script>
        <?php // --- load more --- ?>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/infinitescrol/load-more.min.js" type="text/javascript"></script>
    <?php endif; ?>
    <?php // --- end pagination: navigation load more --- ?>

    <?php // --- masonry --- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/masonry/masonry.pkgd.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/masonry/ready.min.js" type="text/javascript"></script>
    <?php // --- /.masonry --- ?>
    <?php // ==== /.use jquery.min ====  ?>

    <?php // ---- effect scrolling ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/effect/scrolling/scrolltop.min.js"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/effect/scrolling/section.min.js"></script>

    <?php // ---- Uses jQuery throttle plugin to limit strain on the browser ---- == Resizing == ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/jquery/throttle/jquery.ba-throttle-debounce.min.js" type="text/javascript"></script>
    <?php // ---- /.Uses jQuery throttle plugin to limit strain on the browser ---- == Resizing == ?>

    <?php // ---- back stretch ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/jquery/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/media/backstretch/wow.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/media/backstretch/backstretch.min.js" type="text/javascript"></script>
    <?php // ---- /.back stretch ---- ?>

    <?php // ---- chart ---- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/libs/chart.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/ajax/chart/dashboard.min.js" type="text/javascript"></script>
    <?php // ---- /.chart ---- ?>
    <?php // --- captcha: Google ReCAPTCHA Resizing --- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/captcha/resizing.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/resizing/resizing.min.js" type="text/javascript"></script>
    <?php // --- /.captcha: Google ReCAPTCHA Resizing --- ?>

    <?php // --- Google Analytics --- ?>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template ?>/js/google/GoogleAnalytics.min.js"></script>
    <?php // ==== /.Google Analytics ====  ?>
</body>
</html>