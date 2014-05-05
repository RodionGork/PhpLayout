<?php

namespace module\sys;

class Elems {
    
    public static $elems;
    
    public $layout;
    public $styles;
    public $scripts;
    public $page;
    public $path;
    public $conf;
    public $modules;
    public $moduleOrder;
    public $errors;
    
    function __construct() {
        $this->layout = 'default';
        $this->styles = array('common');
        $this->scripts = array('common');
        $this->conf = new \stdClass();
        $this->modules = array();
        $this->moduleOrder = array();
        $this->errors = array();
        self::$elems = $this;
    }
    
    function get($field, $default = '') {
        if (isset($this->$field)) {
            return $this->$field;
        }
        return $default;
    }
    
    function addError($e) {
        array_push($this->errors, $e);
    }
}

