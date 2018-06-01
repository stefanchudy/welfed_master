<?php

namespace System;

class DB_settings {

    private static $instance = Null;
    private $config = null;
    private $db = null;
    private static $_settings = null;

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
     * @return \System\DB_settings
     */

    public static function getInstance() {
        if (self::$instance === NULL) {
            $instance = new self();
            $instance->init();
            self::$instance = $instance;
        }
        return self::$instance;
    }

    public function init() {
        if ($this->db === null) {
            $this->db = \System\DB::getInstance();
        }
        if ($this->config === null) {
            $this->config = \System\Config::getInstance();
        }
    }

    public function get($key, $default_value = null) {
        $settings = $this->_getSettings();
        return isset($settings[$key]) ? $settings[$key] : $default_value;
    }

    public function set($array = Array()) {
        if ($settings_table = $this->_getSettingTable()) {
            if (is_array($array) && (count($array) != 0)) {
                foreach ($array as $key => $value) {
                    if ($this->get($key) != $value) {
                        if (!is_array($value)) {
                            $save = $this->db->escape($value);
                        } else {
                            $save = $this->db->escape(serialize($value));
                        }
                        $this->db->query('DELETE FROM `' . $settings_table . '` WHERE `key`="' . $key . '"');
                        $this->db->query('INSERT INTO `' . $settings_table . '` (`key`,`value`) VALUES ("' . $this->db->escape($key) . '", "' . $save . '")');

                        self::$_settings[$key] = $value;                        
                    }
                }
            }
        }
    }

    private function _getSettings() {
        if (self::$_settings === null) {
            $settings = Array();
            if ($settings_table = $this->_getSettingTable()) {
                $table = $this->db->query('SELECT * FROM `' . $settings_table . '`');
                foreach ($table->rows as $row) {
                    if (@unserialize($row['value'])) {
                        $settings[$row['key']] = unserialize($row['value']);
                    } else {
                        $settings[$row['key']] = $row['value'];
                    }
                }
            }
            self::$_settings = $settings;
        }
        return self::$_settings;
    }

    private function _getSettingTable() {
        return isset($this->config->db['settings_table']) ? $this->config->db['settings_table'] : null;
    }

}
