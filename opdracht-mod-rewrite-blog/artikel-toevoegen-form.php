<?php

session_start();

$message = "";

if(isset($_SESSION['notification'])) {
    $message = $_SESSION['notification'];
    unset($_SESSION['notification']);
}


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artikel toevoegen</title>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
   
   <h1>Artikel toevoegen</h1>
   
   <a href="artikel-overzicht.php">Terug naar overzicht</a>
   
   <?php if($message != "") : ?>
   <p><?= $message ?></p>
   <?php endif ?>
   
   <form action="artikel-toevoegen.php" method="post">
       
       <div>
           <label for="titel">Titel:</label>
           <input type="text" name="titel" id="titel" required>
       </div>
       
       <div>
           <label for="artikel">Artikel:</label>
           <textarea name="artikel" id="artikel" required></textarea>
       </div>
       
       <div>
           <label for="kernwoorden">Kernwoorden <br><span>(Invullen gescheiden door komma: woord1,woord2,...)</span>:</label>
           <input type="text" name="kernwoorden" id="kernwoorden">
       </div>
       
       <div>
           <label for="datum">Datum:</label>
           <input type="date" name="datum" id="datum" required>
       </div>
       
       <input type="submit" name="submit" value="Verzenden">
       
       
   </form>    
</body>
</html>