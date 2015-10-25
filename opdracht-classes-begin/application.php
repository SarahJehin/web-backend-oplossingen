<?php

$number1 = 150;
$number2 = 100;
$className = "Percent";

//http://php.net/manual/en/language.oop5.autoload.php
function __autoload ( $className ){
    include "classes/".$className.".php";
}

$percent = new Percent($number1, $number2);

/*$percentType 	= 	gettype( $percent );
echo $percentType;*/

$percent_absolute =  $percent->absolute;
//echo $percent_absolute;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application</title>
</head>
<body>
    
    <p>Hoeveel percent is <?= $number1 ?> van <?= $number2 ?></p>
    
    <table>
        <tr>
            <td>Absoluut</td>
            <td><?= $percent->absolute ?></td>
        </tr>
        
        <tr>
            <td>Relatief</td>
            <td><?= $percent->relative ?></td>
        </tr>
        
        <tr>
            <td>Geheel getal</td>
            <td><?= $percent->hundred ?>%</td>
        </tr>
        
        <tr>
            <td>Nominaal</td>
            <td><?= $percent->nominal ?></td>
        </tr>
    </table>
    
</body>
</html>