<h3>Page for testing query parameters passing</h3>

<?php

$param = $ctx->util->paramGet('param');

if ($param !== null) {
    echo "Parameter is: '$param'";
} else {
    echo "No parameter passed!";
}

?>


<p>
<a href="<?=url('param', 'param', '314159')?>">Link with parameter</a>
</p>

