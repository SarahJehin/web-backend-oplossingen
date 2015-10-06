<!-- Sarah Jehin -->

<?php

$number     = 0;
$numbers    = array();


while($number < 100) {
    $numbers[] = $number;
    $number++;
}

$numbers_as_string = implode(", ", $numbers); //http://php.net/manual/en/function.implode.php

//deelbaar zijn door 3 én groter zijn dan 40 mààr kleiner zijn dan 80.

$number2 = 0;
$numbers_special = array();

while($number2 < 100) {
    if($number2 % 3 == 0 && $number2 > 40 && $number2 < 80) {
        $numbers_special[] = $number2;
    }
    $number2++;
}

$numbers_special_as_string = implode(", ", $numbers_special);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing: While looping deel 1</title>
</head>
<body>
   
   <p>Nummers van 1 tot 100: <?= $numbers_as_string ?></p>
   <p>Nummers die deelbaar zijn door 3 én groter zijn dan 40 mààr kleiner zijn dan 80.: <?= $numbers_special_as_string ?></p>
    
</body>
</html>

