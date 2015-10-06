<!-- Sarah Jehin -->

<?php

$numbers        = array(8, 7, 8, 7, 3, 2, 1, 2, 4);
$unique_numbers = array_unique($numbers);
$sorted_array   = $unique_numbers;
arsort($sorted_array);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing array functions deel 3</title>
</head>
<body>
   
    <p>Oorspronkelijke array: <?= var_dump($numbers) ?></p>
    <p>Zonder duplicaten array: <?= var_dump($unique_numbers) ?></p>
    <p>Gesorteerde array (hoog naar laag): <?= var_dump($sorted_array) ?></p>
    
</body>
</html>
