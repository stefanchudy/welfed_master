<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace System;

/**
 * Description of PageInput
 * @return \System\PageInput
 * @author martin
 */
class PageInput {

    private static $instance = NULL;

    /**
     * @param string $url The url data
     */
    private static $url = NULL;

    /**
     * @param string $self_url Returns the base URL of the application.
     */
    private static $self_url = NULL;

    /**
     * @param array $get Returns the $_GET superglobal
     */
    private static $get = NULL;

    /**
     * @param array $post Returns the $_POST superglobal
     */
    private static $post = NULL;

    /**
     * @param array $request Returns the $_REQUEST superglobal
     */
    private static $request = NULL;

    /**
     * @param array $session Returns the $_SESSION superglobal
     */
    private static $session = NULL;

    /**
     * @param array $files Returns the uploaded files as array.
     */
    private static $files = NULL;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new \System\PageInput();
        }
        return self::$instance;
    }

    public function __get($name) {
        $_name = strtolower($name);
        $result = Array();
        switch ($_name) {
            case 'url' : {
                    if (isset($_GET['url'])) {
                        $result = $_GET['url'];
                        if (substr($result, -1) == '/') {
                            $result = rtrim($result, '/');
                        }
                    } else {
                        $result = '';
                    }
                    break;
                }
            case 'get' : {
                    $result = $_GET;
                    if (isset($result['url'])) {
                        unset($result['url']);
                    }
                    break;
                }
            case 'post' : {
                    $result = $_POST;
                    break;
                }
            case 'request' : {
                    $result = $_REQUEST;
                    break;
                }
            case 'session' : {
                    $result = $_SESSION;
                    break;
                }
            case 'files' : {
                    $result = $_FILES;
                    break;
                }
            case 'self_url' : {
                    if (isset($_SERVER['HTTPS_HOST'])) {
                        $result = 'https://' . $_SERVER['HTTPS_HOST'];
                    } else {
                        $result = 'http://' . $_SERVER['HTTP_HOST'];
                    }
                    break;
                }
            case 'is_secure' : {
                    $result = (int) (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on'));
                    break;
                }
            case 'is_local' : {
                    $result = (int) ($_SERVER['SERVER_ADDR'] == '127.0.0.1');
                    break;
                }
            case 'https_url' : {
                    $result = 'https://' . $_SERVER['HTTP_HOST'];
                    break;
                }
            case 'remote_addr' : {
                    $result = $_SERVER['REMOTE_ADDR'];
                    break;
                }
            default : break;
        }
        return $result;
    }

}
