<?php

$aantal_seconden    = 221108521;
$aantal_minuten     = round($aantal_seconden/60);
$aantal_uren        = round($aantal_minuten/60);
$aantal_dagen       = round($aantal_uren/24);
$aantal_weken       = round($aantal_dagen/7);
$aantal_maanden     = round($aantal_weken/4);
$aantal_jaren       = round($aantal_maanden/12);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing if-else statement deel2</title>
</head>
<body>
   
   <p>Het gegeven aantal seconden: <?php echo $aantal_seconden ?> is gelijk aan:</p>
   <ul>
       <li>Seconden: <?= $aantal_seconden ?></li>
       <li>Minuten: <?= $aantal_minuten ?></li>
       <li>Uren: <?= $aantal_uren ?></li>
       <li>Dagen: <?= $aantal_dagen ?></li>
       <li>Weken: <?= $aantal_weken ?></li>
       <li>Maanden: <?= $aantal_maanden ?></li>
       <li>Jaren: <?= $aantal_jaren ?></li>
   </ul>
   <p>*met normale afronding naar boven en naar onder</p>
    
</body>
</html>
