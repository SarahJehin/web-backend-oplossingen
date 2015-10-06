<!-- Sarah Jehin -->

<?php


function bereken_som ($getal1, $getal2) {
    $sum = $getal1 + $getal2;
    return $sum;
}

function vermenigvuldig ($getal1, $getal2) {
    $product = $getal1 * $getal2;
    return $product;
}

function is_even ($getal) {
    if($getal%2 == 0) {
        return true;
    }
    else {
        return false;
    }
}

$som        = bereken_som(5,17);
$product    = vermenigvuldig(2,44);
$even       = is_even(17);
$antwoord   = "oneven";

if($even) {
    $antwoord = "even";
}

// U i t b r e i d i n g

$my_string = "Australia forever!";

function string_to_upper_and_length ($string) {
    $length = strlen($string);
    $upper  = strtoupper($string);
    
    return array($length, $upper);
}

$my_string_length = string_to_upper_and_length($my_string)[0];
$my_string_upper = string_to_upper_and_length($my_string)[1];



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing functions deel 1</title>
</head>
<body>
   
   <p>Som berekenen: <?= $som ?></p>
   <p>Product berekenen: <?= $product ?></p>
   <p>Even getal? Het getal is <?= $antwoord ?></p>
   
   <p>***********************</p>
   
   <p>De string "<?= $my_string ?>" is <?= $my_string_length ?> karakters lang en is <?= $my_string_upper ?> in hoofdletters.</p>
    
</body>
</html>


