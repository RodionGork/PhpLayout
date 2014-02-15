<?php

$model->secret = 31415926;

$error = $ctx->usersDao->lastError();
if ($error) {
    $ctx->elems->addError($error);
}

$model->users = $ctx->usersDao->find();
