<?php

namespace module\auth;

use module\dao\CrudDao;

class DaoAuth extends Auth {
    
    private $userDao;
    private $roleDao;
    
    function __construct(CrudDao $userDao, CrudDao $roleDao) {
        $this->userDao = $userDao;
        $this->roleDao = $roleDao;
    }
    
    function login($username, $password) {
        $username = preg_replace("/[\\'\\;]/", '', $username);
        $record = $this->userDao->findFirst("username = '$username'");
        if ($record === false || $record->password != $password) {
            return false;
        }
        return parent::login($record->id, null);
    }
    
    function check($role) {
        $userid = $this->loggedUser();
        if ($userid === null) {
            return false;
        }
        return $this->roleDao->findFirst("userid = $userid and role = '$role'") !== false;
    }
    
}

