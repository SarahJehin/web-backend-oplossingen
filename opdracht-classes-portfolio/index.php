<?php

function __autoload ( $className ){
    include "classes/".$className.".php";
}

$headerPath = "html/header.partial.php";
$bodyPath   = "html/body.partial.php";
$footerPath = "html/footer.partial.php";


$htmlPage = new HTMLBuilder($headerPath, $bodyPath, $footerPath);

$htmlPage->buildHeader();
$htmlPage->buildBody();
$htmlPage->buildFooter();

?>