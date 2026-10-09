<?php

if (!defined("_SMARTYLOADER")) {
    define("_SMARTYLOADER", 1);
}
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

class MainSmarty {

    //put your code here
    private static $_smarty = null;

    static function getSmarty() {

        if (is_null(self::$_smarty)) {
            require(dirname(__FILE__) . DS . 'Smarty.class.php');
            self::$_smarty = new Smarty();
            //spl_autoload_register('__autoload');
            self::configSmarty(self::$_smarty);
            self::$_smarty->setCompileDir(JPATH_SITE . DS . 'tmp');
            self::$_smarty->setConfigDir(dirname(__FILE__) . DS . 'configs');
            self::$_smarty->setCacheDir(JPATH_SITE . DS . 'cache');
            self::$_smarty->setTemplateDir(JPATH_SITE . DS . 'templates-smarty');
        }
        return self::$_smarty;
    }

    static function configSmarty($smarty) {
        $smarty->debugging = true;
        $smarty->caching = false;
        $smarty->cache_lifetime = 120;
    }

}
