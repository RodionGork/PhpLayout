<?php

namespace module\sys;

class Util {
    
    private $sessionStarted;
    
    function sessionPut($key, $value) {
        $this->sessionPrepare();
        $_SESSION[$key] = $value;
    }
    
    function sessionDel($key) {
        $this->sessionPrepare();
        unset($_SESSION[$key]);
    }
    
    function sessionGet($key) {
        $this->sessionPrepare();
        if (!isset($_SESSION[$key])) {
            return null;
        }
        return $_SESSION[$key];
    }
    
    private function sessionPrepare() {
        if (!$this->sessionStarted) {
            ini_set('session.gc_maxlifetime', 5400);
            session_start();
            $this->sessionStarted = true;
        }
    }
    
    function flash($msg = null) {
        if ($msg !== null) {
            $this->sessionPut('__flash_msg', $msg);
        } else {
            $res = $this->sessionGet('__flash_msg');
            $this->sessionDel('__flash_msg');
            return $res;
        }
    }
    
    function fullUrl($url, $prefix = 'http://') {
        if (strpos($url, '/') === false) {
            $url = url($url);
        }
        return $prefix . $_SERVER['HTTP_HOST'] . $url;
    }
    
    function sendGetRequest($url, $timeout = 3) {
        $context = stream_context_create(array('http' => array('timeout' => $timeout)));
        return file_get_contents($url, false, $context);
    }
    
    function sendPostRequest($url, $data, $timeout = 3) {
        $context = stream_context_create(array('http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded",
            'method' => 'POST',
            'content' => !is_string($data) ? http_build_query($data) : $data,
            'timeout' => $timeout
        )));
        return file_get_contents($url, false, $context);
    }
    
    function redirect($url) {
        if (strpos($url, '/') === false) {
            $url = url($url);
        }
        header("Location: $url");
        $this->changePage(null);
    }
    
    function paramGet($name) {
        if (!isset($_GET[$name])) {
            return null;
        }
        return $this->paramProcess($_GET[$name]);
    }
    
    function paramPost($name) {
        if (!isset($_POST[$name])) {
            return null;
        }
        return $this->paramProcess($_POST[$name]);
    }

    private function paramProcess($p) {
        if (is_array($p)) {
            return $p;
        }
        return $this->stripSlashes($p);
    }
    
    function fragment($name) {
        $name = str_replace('_', '/', $name);
        if (!addfile('fragments/' . $name . '.html')) {
            echo '??? FRAGMENT: ' . $name . ' ???';
        }
    }
    
    function changePage($name) {
        $this->ctx->elems->page = str_replace('_', '/', $name);
    }
    
    function plainOutput($data, $type = 'text/plain') {
        $this->changePage(null);
        header("Content-Type: $type");
        echo $data;
    }
    
    private function stripSlashes($s) {
        if (get_magic_quotes_gpc()) {
            $s = stripslashes($s);
        }
        return $s;
    }
    
}
