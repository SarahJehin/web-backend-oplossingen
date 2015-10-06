<?php

$dieren     = array("kat", "hond", "paard", "cavia", "slang", "olifant", "kangoeroe", "dingo", "vogelbekdier", "koala");
/*
$dieren[0]  = "kat";
$dieren[1]  = "hond";
$dieren[2]  = "paard";
$dieren[3]  = "cavia";
$dieren[4]  = "slang";
$dieren[5]  = "olifant";
$dieren[6]  = "kangoeroe";
$dieren[7]  = "dingo";
$dieren[8]  = "vogelbekdier";
$dieren[9]  = "koala";
*/

$voertuigen = array("landvoertuigen" => array("jeep", "fiets", "scooter"), "watervoertuigen" => array("jetski", "raft"), "luchtvoertuigen" => array("helicopter", "jet"));


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing array's basis</title>
</head>
<body>
   
   <p>Een dier uit de lijst: <?= $dieren[7] ?></p>
   <p><?= var_dump($voertuigen) ?></p>
    
</body>
</html>
