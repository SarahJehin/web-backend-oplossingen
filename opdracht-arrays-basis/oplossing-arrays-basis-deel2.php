<?php

$numbers            = array(1, 2, 3, 4, 5);
$numbers_multiplied = array_product($numbers); /*http://www.tutorialspoint.com/php/php_function_array_product.htm*/
$numbers_odd        = array();
$numbers2           = array(5, 4, 3, 2, 1);
$numbers_sum        = array();

foreach($numbers as $value) {
    if($value%2 != 0) {
        $numbers_odd[] = $value;
    }
}

for($index_arr1 = 0; $index_arr1 < count($numbers); $index_arr1++) {
    for($index_arr2 = 0; $index_arr2 < count($numbers); $index_arr2++) {
        if($index_arr1 == $index_arr2) {
            //som
            $numbers_sum[] = $numbers[$index_arr1] + $numbers2[$index_arr2];
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing arrays basis deel 2</title>
</head>
<body>
   
   <p>Multiplication of numbers 1 to 5 = <?= $numbers_multiplied ?></p>
   <p>Oneven nummers van de array: <?= var_dump($numbers_odd) ?></p>
   <p>Som van de getallen met zelfde index: <?= var_dump($numbers_sum) ?></p>
    
</body>
</html>
