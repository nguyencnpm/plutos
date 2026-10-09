<?php

/**
 * @package     Giaiphapcongnghethongtin.vn.Plugin
 * @subpackage  Content.socialsharing
 * @author      Binh Nguyen
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the helper functions only once
JLoader::register('PluginImageHelper', __DIR__ . '/helpers/image.php');

/**
 * Socialsharing plugin class.
 *
 * @since  1.5
 */
class PlgContentSocialsharing extends JPlugin {

    /**
     * @var JParameter $params.
     *
     * @access public.
     */
    var $params = null;

    /**
     * @var stdClass store Plugin Information
     *
     * @access public
     */
    var $plugin;

    /**
     * var $string $__output store html output.
     *
     * @access private
     */
    var $__output = null;

    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments, NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param	object	$subject The object to observe
     * @param	object 	$params  The object to observe
     */
    public function __construct(&$subject, $params = null) {
        if (!$subject):
            return;
        endif;

        parent::__construct($subject, $params);

        $this->plugin = JPluginHelper::getPlugin('content', 'socialsharing');

        $this->params = new JRegistry();
        $this->params->loadString($this->plugin->params);
    }

    /**
     * check valid showing addthis service.
     *
     * @param JParameter $params.
     * @param stdClass $article.
     * @return boolean.
     */
    protected function isValidShowing($context, $params, $article, $mode) {
        $checked = false;
        if ($context != 'com_standard.product' && !$this->isDetailPage()) {
            return;
        }
        if ($mode != 'auto') {
            return true;
        }
        $source = $params->get('source', 'com_content');
               
        switch ($source) {
            case 'com_content':
                $checked = $this->checkCatids($params, $article, 'mode-auto-category');
                break;

            case 'com_standard':
                $checked = $this->checkCatids($params, $article, 'mode-automatic-standardcatsid');
                break;
            case 'com_standardextension':
                $checked = $this->checkCatids($params, $article, 'mode-automatic-category');
                break;

            case 'both':
            default:
                if ($context == 'com_content.article' || $context == 'com_content.featured' || $context == 'com_content.category') {
                    $checked = $this->checkCatids($params, $article, 'mode-auto-category');
                }
                if ($context == 'com_standard.product' || $context == 'com_standard.item') {
                    $checked = $this->checkCatids($params, $article, 'mode-automatic-standardcatsid');
                }
                if ($context == 'com_standardextension.article' || $context == 'com_standardextension.item' || $context == 'com_standardextension.featured' || $context == 'com_standardextension.category') {
                    $checked = $this->checkCatids($params, $article, 'mode-automatic-category');
                }
                break;
        }
        return $checked;
    }

    /**
     *
     * Detect page detail for disqus
     * @return boolean
     */
    protected function isDetailPage() {
        $option = JRequest::getVar('option');
        $view = JRequest::getVar('view');
        //if its a detail page
        if (($option == 'com_standard' && $view == 'product') || ($option == 'com_content' && $view == 'article') || ($option == 'com_standardextension' && $view == 'article')) {
            return true;
        }
        return false;
    }

    /**
     * Check categories id
     * */
    protected function checkCatids($params, $article, $key) {
        if ($params->get($key, '') == '') {
            return;
        }
        $categories = $params->get($key);

        if (!is_array($categories)) {
            $categories = split(',', $params->get($key));
        } else {
            if ($categories[0] == '') {
                return true;
            }
        }
        if (!empty($categories)) {
            if (isset($article->catid)) {
                return in_array($article->catid, $categories);
            }
        }
    }

    /**
     * only render button some postions such as TOP, BOTTOM, CUSTOM LOCATION.
     */
    public function onContentPrepare($context, &$article, &$params, $limitstart = 0) {
        $isComStandard = (strpos($context, 'com_standard') !== false);
        if ($this->params->get('mode') == 'auto'):
            if ($this->params->get('location') == 'BeforeContent'):
                $text = $this->render($this->params, $context, $article);
                $article->text = $text . $article->text;
            endif;

            if ($this->params->get('location') == 'AfterContent'):
                $text = $this->render($this->params, $context, $article);
                $article->text = $article->text . $text;
            endif;

            return true;

        elseif ($this->params->get('mode') == 'manual') :
            $this->render($this->params, $context, $article);
            return true;
        else: // Turn Off
            if (isset($article->text)):
                echo $article->text = $this->removeConfigString($article->text);
                return true;
            endif;
        endif;
    }

    /**
     * Only render button at postion after content.
     * @param string $context
     * @param object $article
     * @param object $params
     * @param int $page
     * @return string text of content
     */
    public function onContentAfterDisplay($context, &$article, &$params, $limitstart = 0) {
        if ($this->params->get('location') == 'onContentAfterDisplay' && $this->params->get('mode') == 'auto') {
            $text = $this->render($this->params, $context, $article);
            return $text;
        }
    }

    /**
     * Only render button at postion before content.
     * @param string $context
     * @param object $article
     * @param object $params
     * @param int $page
     * @return string text of content
     */
    public function onContentBeforeDisplay($context, &$article, &$params, $limitstart = 0) {
        if ($this->params->get('location') == 'onContentBeforeDisplay' && $this->params->get('mode') == 'auto') {
            $text = $this->render($this->params, $context, $article);
            return $text;
        }
    }

    /**
     * Process content after display
     * @param string $context key type component
     * @param object $article
     * @param object $params
     * @param int $limitstart
     * @return unknown
     */
    public function onContentAfterTitle($context, &$article, &$params, $limitstart = 0) {
        if ($this->params->get('location') == 'onContentAfterTitle' && $this->params->get('mode') == 'auto') {
            $text = $this->render($this->params, $context, $article);
            return $text;
        }
    }

    /* ========== sub function ========== */

    /**
     * processing render service layout.
     */
    protected function onAfterRender() {
        if ($this->__output != null) {
            $body = JResponse::getBody();
            $body = str_replace('</body>', $this->__output . "\n</body>", $body);
            JResponse::setBody($body);
            unset($this->__output);
        }
    }

    /**
     * render button service
     *
     * @param JParameter $params
     * @array stdClass $article
     * @return string.
     */
    protected function render($params, $context, &$article) {
        $overrideLocation = false;
        $mode = $params->get('mode');
        // only show BOOKMARK with content components and article view.
        if (!($this->isValidShowing($context, $params, $article, $mode))) {
            if (isset($article->text)) {
                $article->text = $this->removeConfigString($article->text);
            }
            return;
        }

              
        // get configuration string from Article's content.
        $configs = $this->parserConfigString($article->text);

        // if use "turnoff" mode
        if ($mode == 'turnoff') {
            $article->text = $this->removeConfigString($article->text);
            return '';
        } else if ($mode == 'manual' && ($configs == null || empty($configs))) {
            return '';
        }

        //find "off" mode in a article
        if (isset($configs[0][0])) {
            if (strpos($configs[0][0], "off")) {
                $article->text = $this->removeConfigString($article->text);
                return '';
            } else {
                $overrideLocation = true;
            }
        }

        // load css file
        $system = $params->get('system', 'addthis');

        // get HTML output from system view
        $content_layout = $this->renderLayout($system, compact('system', 'configs'), $article);

        // render a centain layout and this system view
        //

        // it's wapper would be replace by other.
        // 
        // if using override location, this function would be apply for all "display mode" options.
        if ($overrideLocation) {
            //$this->__output = $this->renderLayout('common', compact('content_layout'));
            $wapper = '<div id="socialsharingWapper">' . $content_layout . '</div>';
            $article->text = $this->removeConfigString($article->text, $wapper);

            return '';
        } else {
            return $content_layout;
        }
    }

    // ---------------------------------------

    /**
     * render layout.
     *
     * @param string $layout layout's name.
     * @param array data passed.
     * @return string is HTML.
     */
    protected function renderLayout($layout, $data = array(), $article = null) {

        extract($data);
        // include  processor file to render User inteface
        $pathFile = $this->getLayoutPath($this->plugin, $layout);
        if ($pathFile != '') {
            ob_start();
            require_once ($pathFile);
            $content = ob_get_contents();
            ob_end_clean();

            return $content;
        }
        return '';
    }
    
     /**
     * render layout, allow override layout by owner.
     *
     * @param stdClass $plugin plugin information
     * @param string layout
     * @return string
     */
    protected function getLayoutPath($plugin, $layout = 'default') {
        $app = JFactory::getApplication();
        // Build the template and base path for the layout
        $tPath = JPATH_BASE . '/templates/' . $app->getTemplate() . '/html/' . $plugin->name . '/' . $layout . '.php';
        $bPath = JPATH_BASE . '/plugins/' . $plugin->type . '/' . $plugin->name . '/tmpl/' . $layout . '.php';
        // If the template has a layout override use it
        if (file_exists($tPath)) {
            return $tPath;
        } elseif (file_exists($bPath)) {
            return $bPath;
        }
        return '';
    }

    protected function stylesheet($plugin) {
        $app = JFactory::getApplication();
        JHTML::stylesheet('plugins/' . $plugin->type . '/' . $plugin->name . '/' . 'style.css');
        if (is_file(JPATH_SITE . '/templates/' . $app->getTemplate() . '/css/' . $plugin->name . ".css"))
            JHTML::stylesheet('templates/' . $app->getTemplate() . '/css/' . $plugin->name . ".css");
    }

    /**
     * parser string in the article's content, check having configuration social existed?
     *
     * @param string $text.
     * @return array if having, equal null if not.
     */
    protected function parserConfigString($text) {
        if (preg_match("#{socialsharing(.*)}#s", $text, $matches, PREG_OFFSET_CAPTURE)) {
            return $matches;
        }
        return null;
    }

    /**
     * remove configuration string in the artilce's content.
     *
     * @param string $text.
     * @return boolean
     */
    protected function removeConfigString($text, $string = '') {
        return preg_replace('#{socialsharing[^{}]*}#i', $string, $text);
    }

    /* ========== /.sub function ========== */
}
