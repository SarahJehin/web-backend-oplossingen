<?php

$textFile = file_get_contents("cookies2.txt"); //http://php.net/manual/en/function.file-get-contents.php
$textFileArray = explode(",", $textFile); //http://php.net/manual/en/function.explode.php

/*echo $textFileArray[0];
echo $textFileArray[1];*/
//echo(count($textFileArray));
//var_dump($textFileArray);

$errorVisible = false;
$loggedIn = false;
$name = "";


if(isset($_POST["submit"])) {
    //echo $_POST["remember"]; //if checked --> value is on
    for($index = 0; $index < count($textFileArray); $index++) {
        //echo $index;
        if($_POST["username"] == $textFileArray[$index] && $_POST["password"] == $textFileArray[($index+1)]) {
            $loggedIn = true;
            //echo "username and password okay";
            //break;
            if(isset($_POST["remember"])) {
                if($_POST["remember"] == "on") {
                    setcookie("myCookie", $_POST["username"], time()+60*60*24*30); //cookie aanmaken die na 30 minuten vervalt
                    header("location: oplossing-cookies-deel4.php");
                }
            }
            else {
                setcookie("myCookie", $_POST["username"]); //cookie aanmaken die op het einde van de sessie vervalt
                header("location: oplossing-cookies-deel4.php");
            }
        
        }
        
    }
    //print error message (door een p aan te maken in html die eerst op display: none staat, pas als je hierin komt, wordt het display: block
    //echo "error";
    $errorVisible = true;
    
}


if(isset($_GET["logoutCookie"])) {
    
    if($_GET["logoutCookie"] == "delete") {
        setcookie("myCookie", $_POST["username"], time()-3600); // tijd in het verleden zetten om cookie te verwijderen
        $loggedIn = false;
        $errorVisible = false;
        header("location: oplossing-cookies-deel4.php"); //zodat je geen error krijgt
    }
}

if(isset($_COOKIE["myCookie"])) {
    $loggedIn = true;
    $name = ucfirst($_COOKIE["myCookie"]); //ucfirst sets the first letter of a string to uppercase --> so to set "jan" to "Jan"
    //echo $name;
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing cookies deel 4</title>
    
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
        
        div:nth-child(3) {
            margin-top: 10px;
        }
        
        input[type="checkbox"] {
            float: left;
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
   
    <form action="oplossing-cookies-deel4.php" method="post">
        
        <div>
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" value="">
        </div>
        
        <div>
            <label for="password">Paswoord:</label>
            <input type="password" id="password" name="password" value="">
        </div>
        
        <div>
            <input type="checkbox" id="remember" name="remember"> <label for="remember">Mij onthouden</label>
        </div>
        
        <div>
            <input type="submit" name="submit" value="Verzenden">
        </div>
        
    </form>
    
    <?php else : ?>
    
    <h1>Dashboard</h1>
    
    <p>Hallo <?= $name ?>, fijn dat je er weer bij bent!</p>
    
    <a href="oplossing-cookies-deel4.php?logoutCookie=delete">Uitloggen</a>
    
    <?php endif ?>
    
    
    
    
    
    
</body>
</html>