<h3>Greetings</h3>

<?php
if ($model->logged) {
?>
<p>You logged in successfully, thank you!</p>
<?php
} else {
?>
<p>Please enter your credentials:</p>
<form method="post" action="<?=url('login')?>">
<input name="username" type="text" placeholder="your name"/>
<br/>
<input name="password" type="password" placeholder="password"/>
<br/>
<input type="submit" value="Submit"/>
</form>
<?php
}
?>

