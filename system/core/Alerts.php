<?php

namespace System;

/**
 * Description of Alerts
 * @return /System/Alerts
 * @author martin
 */
class Alerts {

//    private static $instance = Null;
    private static $notify = Array();
    private static $errors = Array();
    private static $success = Array();

    private function __construct() {
        
    }

//    public static function getInstance() {
//        if (self::$instance == NULL) {
//            self::$instance = new self;
//        }
//        return self::$instance;
//    }

    public static function addError($message) {
        self::$errors[] = $message;
    }

    public static function addNotify($message) {
        self::$notify[] = $message;
    }

    public static function addSuccess($message) {
        self::$success[] = $message;
    }

    public static function getErrors() {
        return self::$errors;
    }

    public static function getNotifications() {
        return self::$notify;
    }

    public static function getSuccess() {
        return self::$success;
    }

}
