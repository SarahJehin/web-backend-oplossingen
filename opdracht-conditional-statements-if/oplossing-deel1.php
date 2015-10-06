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



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing conditional 1</title>
</head>
<body>
   
   <p>Het getal is <?= $getal ?>, dus het is <?= $dag ?></p>
    
</body>
</html>


