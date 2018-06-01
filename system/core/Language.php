<?php

namespace System;

/**
 * Description of Language
 * @author martin
 */
class Language extends \Utility\MainUtility {

    Private Static $instance = Null;
    public $current = Null;
    public $defaultLanguage = Null;
    private $input = Null;
    public $settings = Null;
    public $path = Null;

    /**
     *
     * @var \Utility\Paths
     */
    private $paths = NULL;
    private $words = Array();
    private $words_default = Array();
    private $_words = Array();
    private $_words_default = Array();

    public function debug($data, $exit = TRUE) {
        echo '<pre>' . print_r($data, TRUE) . '</pre>';
        if ($exit) {
            exit();
        }
    }

    private function __construct() {
        
    }

    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function init() {
        $this->paths = \Utility\Paths::getInstance();
        $this->path = $this->paths->language;
        $this->config = \System\Config::getInstance();
        $this->input = \System\PageInput::getInstance();
        
        if (count($this->config->language) != 0) {
            $this->defaultLanguage = $this->config->language['default'];
            if (!isset($this->input->session['lang'])) {
                $this->change($this->defaultLanguage);
            }
            $this->current = $this->input->session['lang'];
            if (isset($this->input->get['lang'])) {
                $this->current = mb_strtoupper($this->input->get['lang']);
            }
            if (isset($this->config->language['languages'][$this->current])) {
                $this->settings = $this->config->language['languages'][$this->current];
            } else {
                $this->settings = $this->config->language['languages'][$this->defaultLanguage];
            }
            if ($this->path) {
                if (!file_exists($this->path)) {
                    mkdir($this->path);
                }
                $folder = $this->path . $this->current . DIRECTORY_SEPARATOR;
                $folder_default = $this->path . $this->defaultLanguage . DIRECTORY_SEPARATOR;
                if (!file_exists($folder_default)) {
                    mkdir($folder_default);
                }
                if (!file_exists($folder)) {
                    mkdir($folder);
                }
                $this->load_common();
            }
        }
        if (isset($this->input->post['system_language'])) {
            $this->change($this->input->post['system_language']);
            unset($_POST['system_language']);
        }
    }

    public function load($_file) {
        $folder = $this->path . $this->current . DIRECTORY_SEPARATOR;
        $file = str_replace('/', DIRECTORY_SEPARATOR, $_file);
        $folder_default = $this->path . $this->defaultLanguage . DIRECTORY_SEPARATOR;

        if (file_exists($folder . $file . '.php')) {

            $this->words = include $folder . $file . '.php';
        }
        if (file_exists($folder_default . $file . '.php')) {
            $this->words_default = include $folder_default . $file . '.php';
        }
        //$this->debug($this);
    }

    public function load_common() {
        $file = '_common';
        $folder = $this->path . $this->current . DIRECTORY_SEPARATOR;
        $folder_default = $this->path . $this->defaultLanguage . DIRECTORY_SEPARATOR;
        if (file_exists($folder . $file . '.php')) {
            $this->_words = include $folder . $file . '.php';
        }
        if (file_exists($folder_default . $file . '.php')) {
            $this->_words_default = include $folder_default . $file . '.php';
        }
    }

    public function get($key, $default = FALSE) {
        $result = '';
        $words = array_merge($this->_words, $this->words);
        $words_default = array_merge($this->_words_default, $this->words_default);
        if (isset($words[$key]) && (!$default)) {
            $result = $words[$key];
        } else {
            if (isset($words_default[$key])) {
                $result = $words_default[$key];
            } else {
                $result = '$' . $key;
            }
        }
        return $result;
    }

    public function getList() {
        $result = array();
        if (count($this->config->language) != 0) {
            foreach ($this->config->language['languages'] as $key => $value) {
                $result[] = $key;
            }
        }
        return $result;
    }

    public function change($lang) {
        $_SESSION['lang'] = $lang;
        $this->current = $lang;
    }

}
