<?php 


session_start();

if(isset($_GET["session"])) {
    if($_GET["session"] == "delete") {
        session_destroy();
        //echo "redirecting";
        
    }
    header("Location: oplossing-sessions-p3.php");
}



if(isset($_POST["next2"])) {
    
    //echo "yes";
    $_SESSION["street"] = $_POST["street"];
    $_SESSION["nbr"] = $_POST["nbr"];
    $_SESSION["city"] = $_POST["city"];
    $_SESSION["postal"] = $_POST["postal"];
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing sessions p3: Overzicht</title>
    
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
   
   <h1>Overzichtspagina</h1>
   
   <ul>
       <li>Email: <?php if(isset($_SESSION["email"])) {echo$_SESSION["email"];} ?> <a href="oplossing-sessions-p1.php?change=email">Wijzig</a></li> 
       <li>Nickname: <?php if(isset($_SESSION["nickname"])) {echo $_SESSION["nickname"];} ?> <a href="oplossing-sessions-p1.php?change=nickname">Wijzig</a></li> 
       <li>Straat: <?php if(isset($_SESSION["street"])) {echo $_SESSION["street"];} ?> <a href="oplossing-sessions-p2.php?change=street">Wijzig</a></li>
       <li>Nummer: <?php if(isset($_SESSION["nbr"])) {echo $_SESSION["nbr"];} ?> <a href="oplossing-sessions-p2.php?change=nbr">Wijzig</a></li> 
       <li>Gemeente: <?php if(isset($_SESSION["city"])) {echo $_SESSION["city"];} ?> <a href="oplossing-sessions-p2.php?change=city">Wijzig</a></li> 
       <li>Postcode: <?php if(isset($_SESSION["postal"])) {echo $_SESSION["postal"];} ?>  <a href="oplossing-sessions-p2.php?change=postal">Wijzig</a></li> 
   </ul>
   
   
   <!--<a href="oplossing-sessions-p2.php?session=delete">Delete session variables</a>-->
    
</body>
</html>

