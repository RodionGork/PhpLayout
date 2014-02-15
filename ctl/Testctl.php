<?php

$names = array('Europe', 'Asia', 'America', 'Africa', 'Australia');
$colors = array('blue', 'yellow', 'red', 'black', 'green');

$model->lands = array();

for ($i = 0; $i < sizeof($names); $i++) {
    $c = new stdClass();
    $c->name = $names[$i];
    $c->color = $colors[$i];
    array_push($model->lands, $c);
}
