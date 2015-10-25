<?php


//$className = "Animal";

function __autoload ( $className ){
    include "classes/".$className.".php";
}


$meeko = new Animal("Meeko", "male", 100);
//om aan zijn naam te kunnen -->  $meeko->getName();  //this will return the name of the animal
$flit = new Animal("Flit", "male", 75);
$marie = new Animal("Marie", "female", 25);

$animals = array($meeko, $flit, $marie);


$marie->changeHealth(30);
$marie->changeHealth(-10);

$simba = new Lion("Simba", "male", 150, "Congo lion");
$scar = new Lion("Scar", "male", 80, "Kenia lion");

$lions = array($simba, $scar);

$zeke = new Zebra("Zeke", "male", 70, "Quagga");
$zana = new Zebra("Zana", "female", 55, "Selous");

$zebras = array($zeke, $zana);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App Animals</title>
    
    <style>
        
        body {
            font-family: "Calibri" sans-serif;
        }
        
    </style>
    
</head>
<body>
   
   <h1>Instanties van de Animal class</h1>
   
   <div>
       <?php foreach($animals as $animal) : ?>
       <p><?= $animal->getName() ?> is van het geslacht <?= $animal->getGender() ?> en heeft momenteel <?= $animal->getHealth() ?> levenspunten. (special move: <?= $animal->doSpecialMove() ?>)</p>
       <?php endforeach ?>
   </div>
   
   <h2>Instanties van de Lion class</h2>
   
   <div>
       <?php foreach($lions as $lion) : ?>
       <p>De speciale move van <?= $lion->getName() ?> (soort: <?= $lion->getSpecies() ?>): <?= $lion->doSpecialMove() ?></p>
       <?php endforeach ?>
   </div>
   
   <h2>Instanties van de Zebra class</h2>
   
   <div>
       <?php foreach($zebras as $zebra) : ?>
       <p>De speciale move van <?= $zebra->getName() ?> (soort: <?= $zebra->getSpecies() ?>): <?= $zebra->doSpecialMove() ?></p>
       <?php endforeach ?>
   </div>
   
    
</body>
</html>

