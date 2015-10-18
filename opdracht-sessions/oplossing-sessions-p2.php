<?php 


session_start(); //moet je op elke pagina doen

if(isset($_GET["session"])) {
    if($_GET["session"] == "delete") {
        session_destroy();
        header("Location: oplossing-sessions-p2.php");
    }
}



if(isset($_POST["next1"])) {
    
    //echo "yes";
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["nickname"] = $_POST["nickname"];
    //echo $_SESSION["email"] = $_POST["email"];
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing sessions p2: Adres</title>
    
    <style>
        body {
            font-family: "Calibri", sans-serif;
        }
        
        div label {
            display: block;
        }
        
        div input[type="submit"] {
            margin-top: 20px;
        }
            
    </style>
    
    
</head>
<body>
   
   <h1>Registratiegegevens</h1>
   
   <ul>
       <li>Email: <?php if(isset($_SESSION["email"])) {echo $_SESSION["email"];} ?></li>
       <li>Nickname: <?php if(isset($_SESSION["nickname"])) {echo $_SESSION["nickname"];} ?></li>
   </ul>
   
   
   <h1>Adres</h1>
   
   <form action="oplossing-sessions-p3.php" method="post">
      
       <div>
           <label for="street">Straat: </label>
           <input <?php if(isset($_GET["change"])) {if($_GET["change"] == "street") {echo "autofocus";}} ?> type="text" id="street" name="street" value="<?php if(isset($_SESSION["street"])){echo $_SESSION["street"];} ?>">
       </div>
       
       <div>
           <label for="nbr">Nummer: </label>
           <input <?php if(isset($_GET["change"])) {if($_GET["change"] == "nbr") {echo "autofocus";}} ?> type="number" id="nbr" name="nbr" value="<?php if(isset($_SESSION["nbr"])){echo $_SESSION["nbr"];} ?>">
       </div>
       
       <div>
           <label for="city">Gemeente: </label>
           <input <?php if(isset($_GET["change"])) {if($_GET["change"] == "city") {echo "autofocus";}} ?> type="text" id="city" name="city" value="<?php if(isset($_SESSION["city"])){echo $_SESSION["city"];} ?>">
       </div>
       
       <div>
           <label for="postal">Postcode: </label>
           <input <?php if(isset($_GET["change"])) {if($_GET["change"] == "postal") {echo "autofocus";}} ?> type="number" id="postal" name="postal" value="<?php if(isset($_SESSION["postal"])){echo $_SESSION["postal"];} ?>">
       </div>
       
       <div>
           <input type="submit" name="next2" value="Volgende">
       </div>
       
   </form>
   
   <a href="oplossing-sessions-p2.php?session=delete">Delete session variables</a>
    
</body>
</html>

