<?php

module('auth/Auth');

class BasicAuth extends Auth {
    
    // data should be password
    function login($username, $data) {
        if ($username != 'admin' || $data != 'secret') {
            return false;
        }
        return parent::login($username, $data);
    }
    
    function check($role) {
        return parent::check($role) && $role == 'admin';
    }

}

?>

