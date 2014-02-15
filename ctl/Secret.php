<?php

if(!$ctx->auth->checkWith403('admin')) {
    return;
}
