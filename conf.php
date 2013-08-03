<?php

//ini_set('display_errors', 0);

Elems::$elems->conf->modrewrite = false;

Elems::$elems->conf->mysql = array(
    'host' => '127.0.0.1',
    'port' => '3306',
    'username' => 'root',
    'password' => 'root',
    'db' => 'test',
    'prefix' => 'test_',
    'charset' => 'utf8'
);

?>
