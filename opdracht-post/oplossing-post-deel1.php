<?php

$password = "incorrect";
$username = "Sarah";
$message = "";

if(isset($_POST["submit"])) {
    //controleren of de naam en het paswoord overeen komen en boodschap navenant tonen:
    if($_POST["username"] == $username && $_POST["password"] == $password){
        $message =  "Welkom";
    }
    else {
        $message = "Er ging iets mis bij het inloggen, probeer opnieuw";
    }
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing post deel 1</title>
</head>
<body>
  
   <h1>Inloggen</h1>
   
   <form action="oplossing-post-deel1.php" method="post">
       
       <div>
           <label for="username">gebruikersnaam</label>
           <input type="text" name="username" id="username">
       </div>
       
       <div>
           <label for="password">paswoord</label>
           <input type="password" name="password" id="password">
       </div>
       
       <div>
           <input type="submit" name="submit" value="Verzenden">
       </div>
       
       
   </form>
   
   <p><?= $message ?></p>
    
</body>
</html>


