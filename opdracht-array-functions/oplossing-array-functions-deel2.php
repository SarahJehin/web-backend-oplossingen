<!-- Sarah Jehin -->

<?php

$animals            = array("Dingo", "Tasmaanse duivel", "Koala", "Kangoeroe", "Kookaburra");
$aantal_items       = count($animals);
$te_zoeken_dier     = "Kookaburra";
$boodschap          = "";

if(in_array($te_zoeken_dier, $animals)) {
    $boodschap = "gevonden";
}
else {
    $boodschap = "niet gevonden";
}

//deel 2
$sorted_animals = $animals;
sort($sorted_animals);

$zoogdieren = array("olifant", "giraf", "neushoorn");
$arrays_samen = array_merge($animals, $zoogdieren);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing array functions deel 2</title>
</head>
<body>
   
   <p>Aantal dieren in de array = <?= $aantal_items ?></p>
   <p>Het gezochte dier: "<?= $te_zoeken_dier ?>" is <?= $boodschap ?> in de lijst.</p>
   
   <h3>Deel 2</h3>
   
   <p>
   Gesorteerde lijst:
   <?php foreach($sorted_animals as $value) { echo $value.", ";} ?>
   </p>
   
   <p>
       2 arrays samen = <?= var_dump($arrays_samen) ?>
   </p>
   
    
</body>
</html>
