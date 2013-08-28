<?php

$ctx->auth->logout();

$ctx->util->flash('Logout successful. See you later!');

$ctx->util->redirect('main');

?>
