<?php

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
        $this->conf = new stdClass();
        $this->modules = array();
        $this->moduleOrder = array();
        $this->errors = array();
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

class ModelClass {
}



main();


function main() {
    global $ctx;
    
    prepare();
    
    addFile("ctl/_hookBefore.php");
    
    $ctlName = preg_replace_callback('/\w+$/', 'capitalizeReplace', Elems::$elems->page);
    $ctlFile = "ctl/$ctlName.php";
    $r = addfile($ctlFile);
    
    addFile("ctl/_hookPreRender.php");
    
    if ($ctx->elems->page != null) {
        array_push($ctx->elems->styles, $ctx->elems->page);
        array_push($ctx->elems->scripts, $ctx->elems->page);
        $content = 'pages/' . $ctx->elems->page . '.php';
        ob_start();
        if (!addfile($content)) {
            addfile('pages/error404.php');
        }
        $ctx->elems->contentResult = ob_get_clean();
        
        ob_start();
        require('layouts/' . $ctx->elems->layout . '.html');
        $rendered = ob_get_clean();
        echo $rendered;
    }

    addFile("ctl/_hookAfter.php");
    
    destroyModules();
}

function capitalizeReplace($m) {
    return ucfirst($m[0]);
}

function prepare() {
    global $model, $ctx;
    
    Elems::$elems = new Elems();
    $model = new ModelClass();
    
    module('Context');
    $ctx = new Context();
    
    addFile('conf.php');
    addFile('cust_conf.php');
    
    Elems::$elems->path = preg_replace('/^(.*\/)[^\/]*$/', '$1', $_SERVER['PHP_SELF']);
    
    $page = isset($_GET['page']) ? $_GET['page'] : 'main';
    $page = preg_replace('/[^a-z0-9\_]/', '', $page);
    $page = str_replace('_', '/', $page);
    
    Elems::$elems->page = $page;
    
}


function destroyModules() {
    
    for ($i = sizeof(Elems::$elems->moduleOrder) - 1; $i >= 0; $i --) {
        $moduleClass = Elems::$elems->modules[Elems::$elems->moduleOrder[$i]];
        if (method_exists($moduleClass, 'onModuleDestroy')) {
            call_user_func("$moduleClass::onModuleDestroy");
        }
    }
}


function addfile($name) {
    global $model, $ctx;
    if (!file_exists($name)) {
        return false;
    }
    include($name);
    return true;
}


function url($name) {
    $path = Elems::$elems->path;
    $rewrite = Elems::$elems->conf->modrewrite;
    $res = $rewrite ? "{$path}index/$name" : "{$path}index.php?page=$name";
    
    $numArgs = func_num_args();
    if ($numArgs == 3) {
        $args = func_get_args();
        if ($rewrite) {
            $pname = $args[1];
            if ($pname != 'param') {
                $res .= "/{$args[1]}_{$args[2]}";
            } else {
                $res .= "/{$args[2]}";
            }
        } else {
            $res .= "&{$args[1]}={$args[2]}";
        }
    } else if ($numArgs > 3) {
        $i = 1;
        $args = func_get_args();
        $query = array();
        while ($i < $numArgs - 1) {
            if ($args[$i] !== null && $args[$i + 1] !== null) {
                array_push($query, $args[$i] . "=" . $args[$i + 1]);
            }
            $i += 2;
        }
        $res .= ($rewrite ? '?' : '&') . implode('&', $query);
    }
    return $res;
}


function aurl($url) {
    return Elems::$elems->path . $url;
}


function module($name) {
    if (isset(Elems::$elems->modules[$name])) {
        return;
    }
    $className = preg_replace('/.*\/(.*)/', '$1', $name);
    if (class_exists($className, false) || interface_exists($className, false)) {
        Elems::$elems->addError("Module class redefinition: $name $className");
    }
    require "module/$name.php";
    if (!class_exists($className, false) && !interface_exists($className, false)) {
        Elems::$elems->addError("Module failed to define class: $name $className");
    }
    Elems::$elems->modules[$name] = $className;
    array_push(Elems::$elems->moduleOrder, $name);
}


?>
