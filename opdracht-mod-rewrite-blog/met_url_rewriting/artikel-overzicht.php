<?php

session_start();

function __autoload ( $className ){
    include "classes/".$className.".php";
}

$message = "";


if(isset($_SESSION['notification'])) {
    $message = $_SESSION['notification'];
    unset($_SESSION['notification']);
}

//alle artikels gaan ophalen
$artikel = new Artikel();

//array voor artikels in te steken:
$arrArtikels = array();

$arrArtikels = $artikel->getAllArtikels();

//echo($_SERVER['REQUEST_URI']);

$arrURL = explode("/", $_SERVER['REQUEST_URI']);
$base_name = $arrURL[0]."/".$arrURL[1]."/".$arrURL[2]."/";

//echo($base_name);
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artikels overzicht</title>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
    
    <!-- zoek form -->
    <form method="get" action="<?= $base_name ?>zoeken" class="zoeken_kernwoord">
        <label for="kernwoord">Zoeken in artikels:</label>
        <input type="text" name="kernwoord" id="kernwoord">
        <input type="submit" name="submit_kernwoord" value="Zoeken">
    </form>
    
    <form method="get" action="<?= $base_name ?>zoeken" class="zoeken_datum">
        <label for="datum">Zoeken op datum:</label>
        <select id="datum" name="datum">
            <option value="2010">2010</option>
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
        </select>
        <input type="submit" name="submit_datum" value="Zoeken">
    </form>
    
    
    <h1>Artikels overzicht</h1>
    
    <a href="<?= $base_name ?>toevoegen">Artikel toevoegen</a>
    
    <?php if($message != "") : ?>
    <p><?= $message ?></p>
    <?php endif ?>
    
    
    <?php foreach($arrArtikels as $row) : ?>
       <article>
           <h3><?= $row["Titel"] ?> | <?= $row["Datum"] ?></h3>
           <p><?= $row["Artikel"] ?></p>
           <p>Keywords: <?= $row["Kernwoorden"] ?></p>
       </article>
    <?php endforeach ?>
    
    
    
    
    
    
</body>
</html>


