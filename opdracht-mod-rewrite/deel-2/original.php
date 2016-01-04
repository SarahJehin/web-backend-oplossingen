<?php

$user = "";

if(isset($_GET["user"])) {
    $user = $_GET["user"];
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing mod rewrite - deel 2 + 3</title>
</head>
<body>
    
    <h1>Het originele bestand.</h1>
    
    <p>User is :</p>
    
    <div>
        <?= $user ?>
    </div>
    
</body>
</html>