<?php

$jaartal = 200;
$schrikkeljaar = false;
$antwoord = "";

if(($jaartal%4 == 0 && $jaartal%100 != 0) || $jaartal%400 == 0) {
    $schrikkeljaar = true;
}
if($schrikkeljaar) {
    $antwoord = "ja";
}
else {
    $antwoord = "nee";
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing if-else statement</title>
</head>
<body>
   
   <p>Is <?= $jaartal ?> een schrikkeljaar? <?= $antwoord ?></p>
    
</body>
</html>

