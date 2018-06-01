<?php

namespace System;

/**
 * Description of MainController
 * @return /System/MainController
 * @author martin
 */
class MainController extends \Utility\MainUtility {

    protected $common = null;
    protected $path = null;
    protected $config = null;
    protected $input = NULL;

    /**
     * @var \System\DB_settings
     */
    protected $db_settings = NULL;

    /**
     * @var \System\DB
     */
    protected $db = NULL;

    /**
     * @var \System\User
     */
    protected $user = NULL;
    protected $pageData = Array();
    protected $site_name = '';
    protected $short_name = '';
    protected $errors = Array();

    /**
     *
     * @var \System\Html
     */
    protected $html = NULL;

    /**
     * \Utility\Validator object
     *
     * @var \Utility\Validator
     */
    protected $validator = NULL;

    function __construct($common) {
        $this->common = $common;

        $this->validator = new \Utility\Validator;

        foreach ($this->common as $name => $method) {
            $this->$name = $method;
        }
        $this->html = new \System\Html();
        if ($this->user && $this->user->logged) {
            $this->html->setUser($this->user->logged);
        }
        $this->language = \System\Language::getInstance();
        $this->language->init($this->path->language);

        $this->site_name = ($this->config->main['site_name'] != '') ? $this->config->main['site_name'] : 'My site';
        $this->short_name = ($this->config->main['short_name'] != '') ? $this->config->main['short_name'] : 'My site';

        $this->controller_startup();

        if (method_exists($this, 'init')) {
            $this->init();
        }
    }

    private function controller_startup() {
        $path = $this->path->extend;
        if (file_exists($path) && is_dir($path) && file_exists($path . 'controller_startup.php')) {
            require_once $path . 'controller_startup.php';
        }
    }

    public function renderPage($template, $data = NULL) {

        $this->html->setErrors($this->errors);

        $this->html->render((($data === NULL) ? $this->pageData : $data), $template);
    }

    public function renderWidget($template, $data = NULL) {
        return $this->html->render((($data === NULL) ? $this->pageData : $data), $template, TRUE);
    }

    public function loadModel($model) {
        $folder = $this->path->models;
        if (file_exists($folder) && is_readable($folder) && is_dir($folder)) {
            $file = $folder . DIRECTORY_SEPARATOR . $model . '.php';
            if (file_exists($file) && is_readable($file) && is_file($file)) {
                $model_name = 'model_' . $model;
                if (!method_exists($this, $model_name)) {
                    include $file;
                    $this->$model_name = new $model_name($this->common);
                    return $this->$model_name;
                }
            }
        }
    }

    public function getSiteName() {
        return $this->site_name;
    }

    public function getSiteShortName() {
        return $this->short_name;
    }

}
