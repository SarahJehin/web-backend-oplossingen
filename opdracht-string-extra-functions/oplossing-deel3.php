<?php

$lettertje = "e";
$cijfertje = 3;
$langste_woord = "zandzeepsodemineralenwatersteenstralen";
$langste_woord_replaced = str_replace($lettertje, $cijfertje, $langste_woord);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing deel 3</title>
</head>
<body>
   
   <p>Oorspronkelijk = <?= $langste_woord ?></p>
   <p>Replaced = <?= $langste_woord_replaced ?></p>
    
</body>
</html>

