<?php

session_start();

//de message session terug leegmaken, zodat er geen foute messages in kunnen blijven staan
unset($_SESSION["message"]);
unset($_SESSION["message_type"]); 

$show_content = false;

if(isset($_COOKIE["login"])){
    //de cookie gaan uiteenhalen
    $arrCookie = explode(",", $_COOKIE["login"]);
    $email = $arrCookie[0];
    $hashed_email = $arrCookie[1];
    
    //gaan controleren of het e-mail adres hetzelfde is al het gesalte, gehashet e-mailadres:
    try {
        //connectie met database aanmaken:
        $db = new PDO('mysql:host=localhost;dbname=opdracht-file-upload', 'root', '');
        
        $query_check_email = "SELECT * FROM `users` WHERE email = :email";
        
        $statement_check_email = $db->prepare($query_check_email);
        
        $statement_check_email->bindValue(":email", $email);
        
        $statement_check_email->execute();
        
        $arrResults = array();
        
        while( $row = $statement_check_email->fetch(PDO::FETCH_ASSOC) )
        {
            //elke rij toevoegen aan de array
            $arrResults[]	=	$row;
        }
        //salt van geselecteerde e-mail adres gaan ophalen
        $salt = $arrResults[0]["salt"];
        $hashed_salted_email = hash("sha512", $email . $salt);
        
        //gaan checken of het hashed_email van de cookie overeen komt met het hashed_salted_email samengesteld op basis van de database
        if($hashed_email == $hashed_salted_email) {
            //alles ok --> inhoud mag getoond worden
            $show_content = true;
        }
        else {
            //unset cookie (veilige manier) //want er is waarschijnlijk met de cookie geknoeid
            setcookie ("login", "", 1);
            setcookie ("login", false);
            unset($_COOKIE["login"]);
        }
        
        
    }
    catch( PDOException $e )
    {
        echo('Er ging iets mis: ' . $e->getMessage());
    }
    
}
else {
    //als de cookie niet geset is, moet je redirecten naar de login pagina en een message meegeven
    $_SESSION["message"] = "U moet eerst inloggen.";
    header("Location: fu-login-form.php");
}


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link type="text/css" href="style.css" rel="stylesheet">
    <style>
        

        
    </style>
</head>
<body>
   
   <?php if($show_content) : ?>
   
   <nav>
       <ul>
           <li><a href="fu-dashboard.php">Terug naar dashboard</a></li>
           <li>Ingelogd als <?= $email ?></li>
           <li><a href="fu-logout.php">Uitloggen</a></li>
       </ul>
   </nav>
   
   <h1>Dashboard</h1>
   
   <div class="links">
       <ul>
           <li><a href="#">Artikels (nog niet beschikbaar)</a></li>
           <li><a href="gegevens-wijzigen-form.php">Gegevens wijzigen</a></li>
       </ul>
   </div>
   
   <?php endif; ?>
   
    
</body>
</html>






