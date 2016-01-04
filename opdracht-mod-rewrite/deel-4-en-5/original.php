<?php

$user = "";
$role = "";

if(isset($_GET["user"])) {
    $user = $_GET["user"];
}
if(isset($_GET["role"])) {
    $role = $_GET["role"];
}

$login = array();
$login["role"] = $role;
$login["user"] = $user;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing mod rewrite - deel 2 + 3</title>
</head>
<body>
    
    <h1>Het originele bestand.</h1>
    
    
    <div>
        <?= var_dump($login) ?>
    </div>
    
</body>
</html>