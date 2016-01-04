<?php

$base_name = $_SERVER['REQUEST_URI'];
$base_name = strtok($base_name, '?');

//echo($base_name);


function __autoload ( $className ){
    include "classes/".$className.".php";
}

$titel = "";
$artikel_zoeken = new Artikel();
$resultaten = array();

$no_results = false;
$no_results_text = "Sorry er werden geen resultaten gevonden....";

if(isset($_GET["submit_kernwoord"])) {
    $base_name = $base_name."/kernwoord/".$_GET["kernwoord"];
    //echo($base_name);
    header("Location: $base_name");
}

if(isset($_GET["submit_datum"])) {
    $base_name = $base_name."/datum/".$_GET["datum"];
    echo($base_name);
    header("Location: $base_name");
}

if(isset($_GET["kernwoord"])) {
    $resultaten = $artikel_zoeken->getArtikelByWoord($_GET["kernwoord"]);
    $titel = "Artikels die het woord '".$_GET["kernwoord"]."' bevatten.";
}

if(isset($_GET["datum"])) {
    $resultaten = $artikel_zoeken->getArtikelByYear($_GET["datum"]);
    $titel = "Artikels van het jaar ".$_GET["datum"].".";
}


if(count($resultaten) == 0) {
    $no_results = true;
}

$arrURL = explode("/", $_SERVER['REQUEST_URI']);
$base_name_overzicht = $arrURL[0]."/".$arrURL[1]."/".$arrURL[2]."/";

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zoekresultaten</title>
    <link href="<?= $base_name_overzicht ?>/style.css" type="text/css" rel="stylesheet">
</head>
<body>
    
    <a href="<?= $base_name_overzicht ?>">Terug naar overzicht</a>
    
    <form method="get" action="<?= $base_name_overzicht ?>zoeken" class="zoeken_kernwoord">
        <label for="kernwoord">Zoeken in artikels:</label>
        <input type="text" name="kernwoord" id="kernwoord">
        <input type="submit" name="submit_kernwoord" value="Zoeken">
    </form>
    
    <form method="get" action="<?= $base_name_overzicht ?>zoeken" class="zoeken_datum">
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
    
    <h1><?= $titel ?></h1>
    
    <?php foreach($resultaten as $row) : ?>
       <article>
           <h3><?= $row["Titel"] ?> | <?= $row["Datum"] ?></h3>
           <p><?= $row["Artikel"] ?></p>
           <p>Keywords: <?= $row["Kernwoorden"] ?></p>
       </article>
    <?php endforeach ?>
    
    <?php if($no_results) : ?>
    <p><?= $no_results_text ?></p>
    <?php endif ?>
    
</body>
</html>








