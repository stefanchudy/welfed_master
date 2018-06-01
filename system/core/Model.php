<?php

namespace System;

/**
 * Description of Model
 * @return \System\Model
 * @author martin
 */
class Model extends \Utility\MainUtility {

    public $language = NULL;
//    private $settings = NULL;

    /**
     * @var \System\DB_settings
     */
    protected $db_settings = NULL;

    /**
     *
     * @var \System\DB 
     */
    protected $db = NULL;

    /**
     *
     * @var \System\PageInput
     */
    protected $input = NULL;

    public function __construct($common) {
        foreach ($common as $name => $method) {
            $this->$name = $method;
        }

        $this->language = \System\Language::getInstance();
        $this->language->init($this->path->language);

        if (method_exists($this, 'init')) {
            $this->init();
        }
    }

}
