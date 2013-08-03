<?php
$ctx->elems->title = 'About us';
?>

It is all about my web-site.
<br/>
Secret: <?= $model->secret ?>
<br/>

<?php
foreach ($model->users as $user) {
    echo "<div>id = {$user->id}, name = {$user->name}";
}
?>

