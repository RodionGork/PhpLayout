<?php

module('sys/ProtoContext');

class Context extends ProtoContext {

    protected function getAuth() {
        module('auth/BasicAuth');
        return new BasicAuth();
    }
    
    protected function getUsersDao() {
        module('dao/MysqlDao');
        return new MysqlDao('users');
    }

}

?>
