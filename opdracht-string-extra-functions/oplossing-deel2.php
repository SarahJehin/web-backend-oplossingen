<?php

$fruit = "ananas";
$positie_laatste_a = strrpos($fruit, "a");
$fruit_caps = strtoupper($fruit);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing deel 2</title>
</head>
<body>
   
   <p>Ons fruitje is een <?= $fruit ?> en de laatste a bevindt zich op positie <?= $positie_laatste_a ?></p>
   <p><?= $fruit ?> in hoofdletters is <?= $fruit_caps ?></p>
    
</body>
</html>