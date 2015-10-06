<?php

$fruit          = "kokosnoot";
$lengte_fruit   = strlen($fruit);
$locatie_o      = strpos($fruit, "o");



?>



<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Oplossing deel 1</title>
</head>
<body>
   
   <p>Het woordje <?= $fruit ?> telt <?= $lengte_fruit ?> letters en de eerste o bevindt zich op plaats <?= $locatie_o ?></p>
    
</body>
</html>
