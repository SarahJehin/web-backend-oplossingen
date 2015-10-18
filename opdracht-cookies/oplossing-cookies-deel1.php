<?php

$textFile = file_get_contents("cookies.txt"); //http://php.net/manual/en/function.file-get-contents.php
$textFileArray = explode(",", $textFile); //http://php.net/manual/en/function.explode.php

/*echo $textFileArray[0];
echo $textFileArray[1];*/


$errorVisible = false;
$loggedIn = false;


if(isset($_COOKIE["myCookie"])) {
    $loggedIn = true;
}


if(isset($_POST["submit"])) {
    if($_POST["username"] == $textFileArray[0] && $_POST["password"] == $textFileArray[1]) {
        //everything's ok
        //echo "ok";
        $loggedIn = true;
        setcookie("myCookie", $_POST["username"], time()+360); //cookie aanmaken die na 6 minuten vervalt
    }
    else {
        //print error message (door een p aan te maken in html die eerst op display: none staat, pas als je hierin komt, wordt het display: block
        //echo "error";
        $errorVisible = true;
    }
}


if(isset($_GET["logoutCookie"])) {
    
    if($_GET["logoutCookie"] == "delete") {
        setcookie("myCookie", $_POST["username"], time()-3600); // tijd in het verleden zetten om cookie te verwijderen
        $loggedIn = false;
        $errorVisible = false;
        header("location: oplossing-cookies-deel1.php"); //zodat je geen error krijgt
    }
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing cookies deel 1</title>
    
    <style>
        
        body {
            font-family: "Calibri", sans-serif;
        }
        
        h1 {
            border-bottom: 1px #ddd solid;
        }
        
        .error {
            color: #b94a48;
            background-color: #f2dede;
            border: 1px solid #eed3d7;
            padding: 5px;
            border-radius: 5px;
            display: none;
        }
        
        .error.visible {
            display: block;
        }
        
        label {
            display: block;
        }
        
        input[type="submit"] {
            margin-top: 20px;
        }
    
    
    </style>
    
</head>
<body>
  
  <?php if(!$loggedIn) : ?>
   
   <h1>Inloggen</h1>
   
   <p class="error <?php if($errorVisible) {echo "visible";} ?>">Gebruikersnaam en/of paswoord niet correct. Probeer opnieuw.</p>
   
    <form action="oplossing-cookies-deel1.php" method="post">
        
        <div>
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" value="">
        </div>
        
        <div>
            <label for="password">Paswoord:</label>
            <input type="password" id="password" name="password" value="">
        </div>
        
        <div>
            <input type="submit" name="submit" value="Verzenden">
        </div>
        
    </form>
    
    <?php else : ?>
    
    <h1>Dashboard</h1>
    
    <p>U bent ingelogd</p>
    
    <a href="oplossing-cookies-deel1.php?logoutCookie=delete">Uitloggen</a>
    
    <?php endif ?>
    
    
    
    
    
    
</body>
</html>