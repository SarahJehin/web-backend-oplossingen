<?php

session_start();

$message_exists = false;

if(isset($_COOKIE["login"])) {
    header("Location: fu-dashboard.php");
}

if(isset($_SESSION["message"]) && isset($_SESSION["message_type"])) {
    if($_SESSION["message_type"] == "login_message") {
        $message = $_SESSION["message"];
        $message_exists = true;
    }
}

unset($_SESSION["message"]);
unset($_SESSION["message_type"]);


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link type="text/css" href="style.css" rel="stylesheet">
</head>
<body>
   
   <h1>Inloggen</h1>
   
   
   <?php if($message_exists) : ?>
    <div class="messages">
        <p><?php echo($message) ?></p>
    </div>
    <?php endif; ?>
   
   <form action="fu-login-process.php" method="post">
       
       <div>
           <label for="email">E-mail:</label>
           <input type="email" id="email" name="email" value="<?php if(isset($_SESSION["email"])) { echo($_SESSION["email"]); } ?>">
       </div>
       
       <div>
           <label for="password">Paswoord:</label>
           <input type="password" id="password" name="password">
       </div>
       
       <input type="submit" name="submit" value="Inloggen">
       
   </form>
   
   <p>Nog geen account? Maak er eentje aan op de <a href="fu-registratie-form.php">registratiepagina</a>.</p>
    
</body>
</html>






