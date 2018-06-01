<?php

namespace Utility;

/**
 * Holds all the important paths within the application
 *
 * @author martin
 */
class Paths {

    private static $instance = NULL;

    /**
     * Description : Root folder<br>
     * The root folder of the application
     * 
     * @property string $root <b color="blue">Description : </b><br>Root folder<br><br>
     * The root folder of the application
     * 
     * @var $string
     * 
     */
    public static $root = '';

    /**
     * Description : System folder<br>
     * Contains the Core, Lib and Util sub-folders
     * 
     * @property string $system <b color="blue">Description : </b><br>System folder<br><br>
     * Contains the Core, Lib and Util sub-folders
     * 
     * @var $string
     */
    public static $system = '';

    /**
     * Description : Core folder<br>
     * Contains all the core classes
     * 
     * @property string $core <b color="blue">Description : </b><br>Core classes folder<br><br>
     * Contains all the core classes
     *  
     * @var $string
     */
    public static $core = '';

    /**
     * Description : Libraries folder<br>
     * Contains the external libraries used by the applications
     * 
     * @property string $lib <b color="blue">Description : </b><br>Libraries folder<br><br>
     * Contains the external libraries used by the applications
     * 
     * @var $string
     */
    public static $lib = '';

    /**
     * Description : Utility folder<br>
     * Contains the utility classes, used by all objects for common operations, like redirect, upload files, etc.
     * 
     * @property string $util <b color="blue">Description : </b><br>Utility folder<br><br>
     * Contains the utility classes, used by all objects for common operations, like redirect, upload files, etc.
     * 
     * @var $string
     */
    public static $util = '';

    /**
     * Description : Pages folder<br>
     * Contains the custom made content like application configuration, controllers, models, view.     
     * 
     * @property string $pages <b color="blue">Description : </b><br>Pages folder<br><br>
     * Contains the custom made content like application configuration, controllers, models, view.     
     * 
     * @var $string
     */
    public static $pages = '';

    /**
     * Description : Applicaition config<br>
     * Contains the configuration files called by the \System\Config->whatever
     * Each file should return array of data
     * 
     * @property string $config <b color="blue">Description : </b><br>Apprication config folder<br><br>
     * Contains the configuration files called by the <b color="blue">\System\Config->whatever</b>. Each file should return array of data.
     * 
     * @var $string
     */
    public static $config = '';

    /**
     * Description : Class Extension folder<br>
     * Here you can extend the controller, user, model and HTML classes with custom methods/variables required by the speciffic application.
     * 
     * @property string $extend <b color="blue">Description : </b><br>Class Extension folder<br><br>
     * Here you can extend the controller, user, model and HTML classes with custom methods/variables required by the speciffic application.
     * 
     * @var $string
     */
    public static $extend = '';

    /**
     * Description : The WWW folder.<br>
     * This folder contains the site front, including the images, javascript, styles and etc.<br><br>
     * <b color="red">WARNING : </b>Do not put sensitive data/scripts inside. This folder should be the only visible to the client from the entire application.
     * 
     * @property string $www <b color="blue">Description : </b><br>The www folder.<br><br>
     * This folder contains the site front, including the images, javascript, styles and etc.<br><br> <b color="red">WARNING : </b>Do not put sensitive data/scripts inside. This folder should be the only visible to the client from the entire application.
     * 
     * @var $string
     */
    public static $www = '';

    /**
     * Description : Controllers folder<br>
     * Here is the place to make your controllers for each page.
     * 
     * @property string $controllers <b color="blue">Description : </b><br>Controllers folder<br><br>
     * Here is the place to make your controllers for each page.
     * 
     * @var $string
     */
    public static $controllers = '';

    /**
     * Description : Languages folder<br><br>
     * If the multilanguage support is turned on here should be placed the files containing the ML content.
     * Each file should be named after the language (like "EN.php", "GR.php", "FR.php") and contain 
     * <br><br><b>return Array('word1'=>'word1', 'word2'=>'word2')</b>;
     * 
     * @property string $language <b color="blue">Description : </b><br>Languages folder<br><br>
     * If the multilanguage support is turned on here should be placed the files containing the ML content. Each file should be named after the language (like "EN.php", "GR.php", "FR.php") and contain<br><b>return Array('word1'=>'word1', 'word2'=>'word2')</b><br>
     * 
     * @var $string
     */
    public static $language = '';

    /**
     * Description : Models folder<br><br>
     * Contains the models of business logic used within the application.<br><br>
     * The models can be loaded by each Controller using the <b>$this->loadModel('model_name')</b> method<br><br>
     * The model methods can be called after loading by <b>$this->model_[model name]->method()</b> in the controllers.
     * 
     * @property string $models <b color="blue">Description : </b><br>Models folder<br><br>
     * Contains the models of business logic used within the application.<br><br>The models can be loaded by each Controller using the <b>$this->loadModel('model_name')</b> method<br><br>The model methods can be called after loading by <b>$this->model_[model name]->method()</b> in the controllers.<br>
     * 
     * @var $string
     */
    public static $models = '';

    /**
     * Description : Views folder<br>
     * Contains the output files (html, json, xml, etc).<br>
     * The controller logic decides which view to be rendered, using the <b>RenderPage($name)</b> or <b>RenderWidget($name)</b> methods
     * 
     * @property string $views <b color="blue">Description : </b><br>Views folder<br><br>
     * Contains the output files (html, json, xml, etc).<br>The controller logic decides which view to be rendered, using the <b>RenderPage($name)</b> or <b>RenderWidget($name)</b> methods
     * 
     * @var $string
     */
    public static $views = '';

    /**
     * Description : Common Views<br>
     * Contains the common output files as page header or page footer, which are used by all files in the application.
     * 
     * @property string $commonView <b color="blue">Description : </b><br>Common Views folder<br><br>
     * Contains the common output files as page header or page footer, which are used by all files in the application.
     * 
     * @var $string
     */
    public static $commonView = '';

    /**
     * Description : Upload folder<br>
     * There go all uploaded files. It is possible to be organized by subfolders.
     * 
     * @property string $upload <b color="blue">Description : </b><br> The uploads folder<br><br>
     * There will go every uploaded file. It is possible to be organized by subfolders.
     * 
     * @var $string
     */
    public static $upload = '';

    private function __construct() {
        //singleton! Constructor denied!
    }

    public static function getInstance() {

        if (self::$instance == NULL) {
            self::loadPaths();

            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __get($name) {
        if (isset(self::$$name)) {
            return self::$$name;
        } else {
            return NULL;
        }
    }

    public function setCommonPath($path) {
        self::$commonView = self::$views . $path . DIRECTORY_SEPARATOR;
    }

    private static function loadPaths() {
        $path = getcwd();

        self::$root = realpath($path . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR;
        self::$system = realpath(self::$root . 'system') . DIRECTORY_SEPARATOR;
        self::$core = realpath(self::$system . 'core') . DIRECTORY_SEPARATOR;
        self::$lib = realpath(self::$system . 'lib') . DIRECTORY_SEPARATOR;
        self::$util = realpath(self::$system . 'util') . DIRECTORY_SEPARATOR;

        self::$pages = realpath(self::$root . 'pages') . DIRECTORY_SEPARATOR;
        self::$config = realpath(self::$pages . 'config') . DIRECTORY_SEPARATOR;
        self::$extend = realpath(self::$config . 'extend') . DIRECTORY_SEPARATOR;

        self::$www = realpath(self::$root . 'public_html') . DIRECTORY_SEPARATOR;
        self::$controllers = self::$pages . 'controller' . DIRECTORY_SEPARATOR;
        self::$language = self::$pages . 'languages' . DIRECTORY_SEPARATOR;
        self::$models = self::$pages . 'model' . DIRECTORY_SEPARATOR;
        self::$views = self::$pages . 'view' . DIRECTORY_SEPARATOR;
        self::$commonView = self::$pages . 'view' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR;
        self::$upload = self::$www . 'upload' . DIRECTORY_SEPARATOR;
    }

}
