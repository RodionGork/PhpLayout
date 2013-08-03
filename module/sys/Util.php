<?php

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
            if (session_id() == '') {
                session_start();
            }
            $this->sessionStarted = true;
        }
    }
    
    function redirect($url) {
        header("Location: $url");
    }
    
    function paramGet($name) {
        if (!isset($_GET[$name])) {
            return null;
        }
        return $this->stripSlashes($_GET[$name]);
    }
    
    function paramPost($name) {
        if (!isset($_POST[$name])) {
            return null;
        }
        return $this->stripSlashes($_POST[$name]);
    }
    
    private function stripSlashes($s) {
        if (get_magic_quotes_gpc()) {
            $s = stripslashes($s);
        }
        return $s;
    }
    
}

?>

