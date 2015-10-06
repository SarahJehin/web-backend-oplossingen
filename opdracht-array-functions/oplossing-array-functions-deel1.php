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


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing array functions deel 1</title>
</head>
<body>
   
   <p>Aantal dieren in de array = <?= $aantal_items ?></p>
   <p>Het gezochte dier: "<?= $te_zoeken_dier ?>" is <?= $boodschap ?> in de lijst.</p>
   
    
</body>
</html>
