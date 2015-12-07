<?php

session_start();

$message_exists = false;

if(isset($_COOKIE["login"])) {
    header("Location: dashboard.php");
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
    
    <style>
        
        body {
            font-family: "Calibri", sans-serif;
        }
        
        h1 {
            border-bottom: 1px #ccc solid;
        }

        .messages {
            background-color: #fcc;
            color: #d55;
            border-radius: 5px;
        }
        
        .messages p {
            padding: 2px 5px;
        }
        
        form label {
            display: block;
        }
        
        input[type="submit"] {
            margin-top: 20px;
        }
        
        p a {
            color: inherit;
        }
        
        p a:hover {
            text-decoration: none;
        }
        
    </style>
</head>
<body>
   
   <h1>Inloggen</h1>
   
   
   <?php if($message_exists) : ?>
    <div class="messages">
        <p><?php echo($message) ?></p>
    </div>
    <?php endif; ?>
   
   <form action="login-process.php" method="post">
       
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
   
   <p>Nog geen account? Maak er eentje aan op de <a href="registratie-form.php">registratiepagina</a>.</p>
    
</body>
</html>






