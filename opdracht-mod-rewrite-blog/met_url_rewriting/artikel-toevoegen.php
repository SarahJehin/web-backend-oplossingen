<?php

session_start();


function __autoload ( $className ){
    include "classes/".$className.".php";
}

$arrURL = explode("/", $_SERVER['REQUEST_URI']);
$base_name = $arrURL[0]."/".$arrURL[1]."/".$arrURL[2]."/";

//hier komt data van artikel toevoegen form toe
if(isset($_POST["submit"])) {
    $titel = $_POST["titel"];
    $artikel_text = $_POST["artikel"];
    $kernwoorden = $_POST["kernwoorden"];
    //datum wordt blijkbaar automatisch geconverteerd naar yyyy-mm-dd
    $datum = $_POST["datum"];
    
    //echo($titel." ".$artikel." ".$kernwoorden." ".$datum);
    
    $artikel = new Artikel();
    //$artikel->insertArtikel($titel, $artikel, $kernwoorden, $datum);
    //echo($artikel->insertArtikel($titel, $artikel, $kernwoorden, $datum));
    //$artikel->getArtikelByYear("2015");
    //$artikel->getArtikelByKernwoord("haar");
    
    $insert_ok = $artikel->insertArtikel($titel, $artikel_text, $kernwoorden, $datum);
    
    echo($insert_ok);
    
    if($insert_ok) {
        $_SESSION['notification'] = "Artikel werd succesvol toegevoegd!";
        header("Location: $base_name");
    }
    else {
        $location = $base_name."toevoegen";
        $_SESSION['notification'] = "Er ging iets mis. Probeer opnieuw.";
        header("Location: $location");
    }
}



?>