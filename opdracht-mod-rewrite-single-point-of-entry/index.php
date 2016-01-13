<?php


function __autoload ( $className ){
    include "classes/".$className.".php";
}

//var_dump($_GET);

$classname = $_GET["controller"];

$classname = ucfirst($classname);

$controller = new $classname();

//$controller->test();
/*
$controller->overview();
$controller->insert();
$controller->delete();
$controller->update();
*/


$method = $_GET["method"];


$controller->$method();


?>