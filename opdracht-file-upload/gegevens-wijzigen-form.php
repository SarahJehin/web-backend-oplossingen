<?php

session_start();

$show_content = false;
$message_exists = false;

if(isset($_SESSION["message"]) && isset($_SESSION["message_type"])) {
    if($_SESSION["message_type"] == "gegevens_message") {
        $message_exists = true;
        $message = $_SESSION["message"];
    }
}


if(isset($_COOKIE["login"])){
    //de cookie gaan uiteenhalen
    $arrCookie = explode(",", $_COOKIE["login"]);
    $email = $arrCookie[0];
    $hashed_email = $arrCookie[1];
    $show_content = true;
    
    
    
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
        //salt in session gaan steken zodat je ze kan gebruiken op de gegevens-bewerken.php pagina omde cookie ook up te daten
        $_SESSION["salt"] = $salt;
        $hashed_salted_email = hash("sha512", $email . $salt);
        
        //gaan checken of het hashed_email van de cookie overeen komt met het hashed_salted_email samengesteld op basis van de database
        if($hashed_email == $hashed_salted_email) {
            //alles ok --> inhoud mag getoond worden
            $show_content = true;
            $profile_picture = $arrResults[0]["profile_picture"];
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
    <title>Gegevens wijzigen</title>
    <link type="text/css" href="style.css" rel="stylesheet">
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
   
   <h1>Gegevens wijzigen</h1>
   
   <?php if($message_exists) : ?>
       <div class="messages">
           <p><?php echo($message) ?></p>
       </div>
   <?php endif; ?>
   
   <form method="post" action="gegevens-bewerken.php" enctype="multipart/form-data">
       <!-- gegevens op basis van cookie al in input steken -->
       <div>
           <label for="photo">
               Profielfoto (max 2Mb):
               <!-- img moet huidige profielfoto zijn, tenzij er geen ingesteld is en de alt moet ingevuld worden met het e-mailadres-->
               <img src="img/<?php if($profile_picture != "") { echo($profile_picture); } else { echo('nog-niet-beschikbaar.jpg'); } ?>" alt="profielfoto">
           </label>
           <input type="file" id="photo" name="photo">
       </div>
       
       <div>
           <label for="new_email">E-mail:</label>
           <input type="email" id="new_email" name="new_email" value="<?= $email ?>">
       </div>
       
       <input type="submit" name="submit" value="Wijzigen">
       
   </form>
   
   
   <?php endif; ?>
   
    
</body>
</html>


