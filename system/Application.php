<?php

namespace System;

class Application {

    private static $instance = Null;
    protected $config = null;
    protected $db = null;
    protected $user = null;
    protected $common = Array();
    protected $mailer = null;

    /**
     * System paths object
     * 
     * @var \Utility\Paths
     */
    protected $path = null;

    public function debug($data, $exit = TRUE) {
        echo '<pre>' . print_r($data, TRUE) . '</pre>';
        if ($exit) {
            exit();
        }
    }

    private function __construct() {
        
    }

    /*
     * 
     * @return \System\Application
     */

    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function run() {
        $this->loadPaths();
        $this->includeUtility();
        $this->includeCoreFiles();

        $this->config = \System\Config::getInstance();
        $this->config->setConfigFolder($this->path->config);
        $this->common['config'] = $this->config;

        $this->setSession();
        $this->input = \System\PageInput::getInstance();
        $this->common['input'] = $this->input;

        $this->setDatabase();
        $this->includeLibraries();

        mb_internal_encoding("UTF-8");

        $this->openPage($this->getRoute());
    }

    private function openPage($page) {
        $folder = $this->path->controllers;
        if (!file_exists($this->path->controllers)) {
            mkdir($this->path->controllers);
        }

        if (is_readable($folder) && is_dir($folder)) {
            $file = $folder . $page . '.php';
            if (file_exists($file) && is_readable($file) && is_file($file)) {
                include $file;
                $this->controller = new \Controller($this->common);
            }
        }
    }

    private function getRoute() {
        $result = '404';
        $url = strtolower($this->input->url);
        //$this->debug($url);
        $routes = $this->config->routes;
        if ($url == '') {
            $result = 'index';
        } else {
            if (isset($routes[$url])) {
                $result = $routes[$url];
            }
        }
        if ($result == '404') {
            foreach ($routes as $key => $value) {
                if (is_array($value)) {
                    if (strpos($url, $key) === 0) {
                        $result = $this->formSeoUrl($value, $url, $key);
                        break;
                    }
                }
            }
        } else {
            if (is_array($result)) {
                $result = $this->formSeoUrl($result, $url, $url);
            }
        }
        return str_replace('\\', DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, $result));
    }

    private function formSeoUrl($params, $url, $base) {
        $result = '404';
        if ($url == $base) {
            $result = $params['page'];
            $this->common['get_hidden'][$params['param']] = 0;
        } else {
            if ($params['table'] !== NULL) {
                $urlData = str_replace($base . '/', '', $url);
                if ($this->db) {
                    $query = 'SELECT `' . $params['index'] . '` FROM `' . $params['table'] . '` WHERE `' . $params['field'] . '`="' . $urlData . '"';
                    $table = $this->db->query($query);
                    if ($table->num_rows == 1) {
                        $result = $params['page'];
                        $this->common['get_hidden'][$params['param']] = $table->rows[0][$params['index']];
                    }
                }
            } else {
                $result = $params['page'];
                $this->common['get_hidden']['id'] = str_replace($base . '/', '', $url);
            }
        }
        return $result;
    }

    private function loadPaths() {
        $utl_path = realpath(getcwd() . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'util' . DIRECTORY_SEPARATOR . 'Paths.php';

        if (file_exists($utl_path)) {
            require_once $utl_path;
        } else {
            die($utl_path . ' missing!');
        }
        $this->path = \Utility\Paths::getInstance();

        $this->common['path'] = $this->path;
    }

    private function includeCoreFiles() {
        include $this->path->core . 'Config.php';
        include $this->path->core . 'MainController.php';
        include $this->path->core . 'PageInput.php';
        include $this->path->core . 'Html.php';
        include $this->path->core . 'DB.php';
        include $this->path->core . 'Model.php';
        include $this->path->core . 'User.php';
        include $this->path->core . 'Alerts.php';
        include $this->path->core . 'Language.php';
        include $this->path->core . 'DB_settings.php';
    }

    private function includeLibraries() {
        $this->loadMailer();
    }

    private function includeUtility() {
        include $this->path->util . 'MainUtility.php';
        include $this->path->util . 'Validator.php';
        include $this->path->util . 'DbQueryResult.php';
        include $this->path->util . 'OrmDataset.php';
        include $this->path->util . 'Messaging.php';
    }

    private function loadMailer() {
        $this->common['mailer'] = null;
        if (count($this->config->mailer) != 0) {
            $mailer_config = $this->config->mailer;
            if (isset($mailer_config['host'], $mailer_config['username'], $mailer_config['password'])) {
                include $this->path->lib . 'PHPMailer-master' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php';
                $this->mailer = new \PHPMailer;

                $this->mailer->isSMTP();
                $this->mailer->SMTPAuth = isset($mailer_config['SMTPAuth']) ? $mailer_config['SMTPAuth'] : 1;
                $this->mailer->Host = $mailer_config['host'];
                $this->mailer->Port = isset($mailer_config['port']) ? $mailer_config['port'] : 587;
                $this->mailer->Username = $mailer_config['username'];
                $this->mailer->Password = $mailer_config['password'];
                $this->mailer->setFrom($mailer_config['username']);
                $this->mailer->addReplyTo($mailer_config['username']);
                $this->mailer->AltBody = isset($mailer_config['altbody']) ? $mailer_config['altbody'] : 'To view the message, please use an HTML compatible email viewer!';

                $this->common['mailer'] = $this->mailer;
            }
        }
    }

    private function setSession() {
        if (count($this->config->cookies) != 0 && isset($this->config->cookies['allow']) && $this->config->cookies['allow']) {
            $expiring = isset($this->config->cookies['expiring']) ? $this->config->cookies['expiring'] : (7 * 24 * 60 * 60);
            session_set_cookie_params($expiring); // cookie expiration in 7days x 24h x 60min x 60 sec
            session_start();
        }
    }

    private function setDatabase() {
        if (count($this->config->db) != 0) {
            if (isset($this->config->db['database']) && isset($this->config->db['user']) && isset($this->config->db['pass']) && isset($this->config->db['host'])) {
                $this->db = \System\DB::getInstance();
                $this->db->connect($this->config->db['host'], $this->config->db['user'], $this->config->db['pass'], $this->config->db['database']);
            }
            if ($this->db->connected) {
                $this->common['db'] = $this->db;

                if (file_exists($this->path->extend) && is_dir($this->path->extend) && file_exists($this->path->extend . 'User.php')) {
                    include $this->path->extend . 'User.php';
                    $this->user = new \System\Extend\UserExtended();
                } else {
                    $this->user = new \System\User;
                }
                $this->common['user'] = $this->user;

                if (isset($this->config->db['settings_table']) && ($this->config->db['settings_table'] != '')) {
                    $this->common['db_settings'] = \System\DB_settings::getInstance();
                    $this->common['db_settings']->init();
                }
            }
        }
    }

}
