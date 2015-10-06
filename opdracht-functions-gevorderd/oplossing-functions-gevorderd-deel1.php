<!-- Sarah Jehin -->

<?php

$md5HashKey = "d1fa402db91a7a93c4f414b8278ce073";

function vind_procent_karakters1($karakter, $string) {
    $procent = 0;
    $str_lengte = strlen($string);
    $array_str = str_split($string);
    $counter = 0;
    foreach($array_str as $value) {
        if($karakter == $value) {
            $counter++;
        }
    }
    $procent = 100/$str_lengte*$counter;
    return $procent;
}


function vind_procent_karakters2($karakter) {
    global $md5HashKey;
    $procent = 0;
    $str_lengte = strlen($md5HashKey);
    $array_str = str_split($md5HashKey);
    $counter = 0;
    foreach($array_str as $value) {
        if($karakter == $value) {
            $counter++;
        }
    }
    $procent = 100/$str_lengte*$counter;
    return $procent;
}

function vind_procent_karakters3($karakter) {
    $hash_key = $GLOBALS["md5HashKey"];
    $procent = 0;
    $str_lengte = strlen($hash_key);
    $array_str = str_split($hash_key);
    $counter = 0;
    foreach($array_str as $value) {
        if($karakter == $value) {
            $counter++;
        }
    }
    $procent = 100/$str_lengte*$counter;
    return $procent;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing functions gevorderd deel 1</title>
</head>
<body>
   
   <p>2 komt voor <?= vind_procent_karakters1("2", $md5HashKey) ?>% voor in de string.</p>
   <p>8 komt voor <?= vind_procent_karakters2("8", $md5HashKey) ?>% voor in de string.</p>
   <p>a komt voor <?= vind_procent_karakters3("a", $md5HashKey) ?>% voor in de string.</p>
    
</body>
</html>
