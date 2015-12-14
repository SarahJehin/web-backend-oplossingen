<?php

session_start();

$email = "";
$password = "";
$message_exists = false;

if(isset($_COOKIE["login"])) {
    header("Location: fu-dashboard.php");
}

//gaan checken of er al een e-mail en paswoord in de session staan, indien ja, gaat hun value in de tekstvelden geprint worden
if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
}
if(isset($_SESSION["password"])) {
    $password = $_SESSION["password"];
}

if(isset($_SESSION["message"]) && isset($_SESSION["message_type"])) {
    if($_SESSION["message_type"] == "registratie_message") {
        $message_exists = true;
        $message = $_SESSION["message"];
    }
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registratie form (File upload)</title>
    <link type="text/css" href="style.css" rel="stylesheet">
</head>
<body>
    
    <h1>Registreren</h1>
    
    <?php if($message_exists) : ?>
    <div class="messages">
        <p><?php echo($message) ?></p>
    </div>
    <?php endif; ?>
    
    
    <form method="post" action="fu-registratie-process.php">
        
        <div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?= $email ?>">
        </div>
        
        <div>
            <label for="password">Paswoord:</label>
            <input type="text" id="password" name="password" value="<?= $password ?>">
            <input type="submit" id="generate_password" name="generate_password" value="Genereer paswoord">
        </div>
        
        <input type="submit" name="submit" value="Registreer">
        
    </form>
    
    
    
</body>
</html>






