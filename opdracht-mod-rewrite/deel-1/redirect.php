<?php


//basename(__FILE__) geeft de naam van het huidige bestand 
$baseName = '/' . basename(__FILE__) . '/';  // redirect.php

//__FILE__ geeft heel het pad inclusief het huidige bestand
$file = __FILE__; // C:\Users\Sarah\Documents\Sarah\MCT2\Web Back End\web-backend\oplossingen\opdracht-mod-rewrite\deel-1\redirect.php

//met preg_replace(pattern, replacement, string) ga je hier de naam van het huidige bestand van het path halen
$root = preg_replace($baseName, '', __FILE__); // C:\Users\Sarah\Documents\Sarah\MCT2\Web Back End\web-backend\oplossingen\opdracht-mod-rewrite\deel-1\

//bovenstaande root heb je nodig om de htaccess file op te halen
$htaccess = file_get_contents($root .'/.htaccess');


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing mod rewrite - deel 1</title>
</head>
<body>
    
    <h1>Het redirect bestand.</h1>
    
    
    
    <div>
        <?= var_dump($baseName) ?>
    </div>
    
    <div>
        <?= var_dump($root) ?>
    </div>
    
    <div>
        <?= var_dump($htaccess) ?>
    </div>
    
    <div>
        <?= var_dump($file) ?>
    </div>
    
</body>
</html>