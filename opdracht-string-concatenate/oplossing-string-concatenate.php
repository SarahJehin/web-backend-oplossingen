<?php

$voornaam    = "Sarah";
$familienaam = "Jehin";

$volledigeNaam        = $voornaam." ".$familienaam;
$aantal_karakters     = strlen($volledigeNaam);

?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Oplossing string concateneren</title>
</head>
<body>
   
   <p><?= $voornaam ?> samengevoegd met <?= $familienaam ?> wordt <?= $volledigeNaam ?></p>
   <p>Aantal karakters van het samengevoegde is <?= $aantal_karakters ?></p>
    
</body>
</html>