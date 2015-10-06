<?php

$getal = 6;
$dag = "een onbestaande dag";

if($getal == 1) {
    $dag = "maandag";
}

if($getal == 2) {
    $dag = "dinsdag";
}

if($getal == 3) {
    $dag = "woensdag";
}

if($getal == 4) {
    $dag = "donderdag";
}

if($getal == 5) {
    $dag = "vrijdag";
}

if($getal == 6) {
    $dag = "zaterdag";
}

if($getal == 7) {
    $dag = "zondag";
}

$dag_caps              = strtoupper($dag);
$big_A                 = "A";
$small_a               = "a";
$dag_caps_no_a         = str_replace($big_A, $small_a, $dag_caps);
$laatste_a             = strrpos($dag_caps, $big_A);
$dag_caps_no_last_a    = substr_replace($dag_caps, $small_a, $laatste_a, 1); /* http://stackoverflow.com/questions/3994300/php-function-to-replace-a-ith-position-character */


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing conditional 1</title>
</head>
<body>
   
   <p>Het getal is <?= $getal ?>, dus het is <?= $dag ?></p>
   <p>Of in hoofdletters: <?= $dag_caps ?></p>
   <p>Of nog wat specialer: <?= $dag_caps_no_a ?></p>
   <p>Extra speciaal: <?= $dag_caps_no_last_a ?></p>
    
</body>
</html>


