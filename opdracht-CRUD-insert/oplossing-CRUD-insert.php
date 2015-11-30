<?php

$messageContainer = "";
$insertOKMessage = "";
$showMessage = false;

if(isset($_POST["submit"])) {
    //echo "yay";
    try {

        //connectie maken - instantie van de databse maken, parameters: host, dbname, login, paswoord  (bij paswoord moet er blijkbaar niets staan bij mij)
        $db = new PDO('mysql:host=localhost;dbname=bieren', 'root', '');
        $messageContainer = "Connectie geslaagd";
        
        $brnaam     = $_POST["brnaam"];
        $adres      = $_POST["adres"];
        $gemeente   = $_POST["gemeente"];
        $postcode   = $_POST["postcode"];
        $omzet      = $_POST["omzet"];

        $insertQueryString = 'insert into brouwers
values (null, :brouwernaam, :adres, :postcode, :gemeente, :omzet)';
        //echo $insertQueryString;
        
        //query klaarzetten:
        $statement_insert = $db->prepare($insertQueryString);
        
        //placeholders voorzien om sql injection tegen te gaan
        $statement_insert->bindValue(":brouwernaam", $brnaam);
        $statement_insert->bindValue(":adres", $adres);
        $statement_insert->bindValue(":gemeente", $gemeente);
        $statement_insert->bindValue(":postcode", $postcode);
        $statement_insert->bindValue(":omzet", $omzet);
        
        try {
            $statement_insert->execute();
            //echo "Brouwerij toegevoegd";
            $newId = $db->lastInsertId();
            $insertOKMessage = "Brouwerij succesvol toegevoegd. Het unieke nummer van deze brouwerij is " . $newId;
        }
        
        catch (MySQLException $e) {
            $insertOKMessage = "Er ging iets mis met het toevoegen. Probeer opnieuw." + $e->getMessage();
        }
        
        $showMessage = true;
        
    }

    catch ( PDOException $e )
    {
        $messageContainer	=	'Er ging iets mis: ' . $e->getMessage();
    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing CRUD insert</title>
    
    <style>
        body {
            font-family: "Calibri", sans-serif;
        }
        
        form div {
            margin-bottom: 10px;
        }
        
        form div label {
            display: block;
        }
        
        .message {
            display: none;
        }
        
        .message.active {
            display: block;
        }
        
    </style>
    
</head>
<body>
    
    <h1>Oplossing CRUD insert</h1>
    
    <!--<p><?php echo $messageContainer ?></p>-->

    
    <form method="post" action="oplossing-CRUD-insert.php">
        
        <div>
            <label for="brouwernaam">Brouwernaam:</label>
            <input type="text" id="brouwernaam" name="brnaam">
        </div>
        
        <div>
            <label for="adres">Adres:</label>
            <input type="text" id="adres" name="adres">
        </div>
        
        <div>
            <label for="postcode">Postcode:</label>
            <input type="text" id="postcode" name="postcode">
        </div>
        
        <div>
            <label for="gemeente">Gemeente:</label>
            <input type="text" id="gemeente" name="gemeente">
        </div>
        
        <div>
            <label for="omzet">Omzet:</label>
            <input type="text" id="omzet" name="omzet">
        </div>
        
        <input type="submit" value="Verzenden" name="submit">
        
    </form>
    
    <div class="message <?php if($showMessage) { echo "active";} ?>">
        <p><?= $insertOKMessage ?></p>
    </div>
    
    
</body>
</html>






