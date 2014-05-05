<?php
//Rename or copy this file to cust_conf.php and create your custom configuration

//ini_set('display_errors', 0);

$ctx->elems->conf->modrewrite = false;

$ctx->elems->conf->mysql = array(
    'host' => '127.0.0.1',
    'port' => '3306',
    'username' => 'root',
    'password' => 'root',
    'db' => 'test',
    'prefix' => 'test_',
    'charset' => 'utf8'
);

?>
