<?php

$username = $ctx->util->paramPost('username');
$password = $ctx->util->paramPost('password');

if ($username) {
    $ctx->auth->login($username, $password);
}

$model->logged = $ctx->auth->loggedUser() !== null;

?>
