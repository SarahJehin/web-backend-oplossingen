<?php 

session_start();


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing sessions p1: Registratie</title>
    
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
        
        div input.focus {
            outline: #52acf8 1px solid;
        }
            
    </style>
    
    
</head>
<body>
   
   <h1>Registratiegegevens</h1>
   
   <form action="oplossing-sessions-p2.php" method="post">
      
       <div>
           <label for="email">E-mail: </label>
           <input <?php if(isset($_GET["change"])) {if($_GET["change"] == "email") {echo "autofocus";}} ?> type="email" id="email" name="email" value="<?php if(isset($_SESSION["email"])) {echo $_SESSION["email"];} ?>">
       </div>
       
       <div>
           <label for="nickname">Nickname: </label>
           <input <?php if(isset($_GET["change"])) {if($_GET["change"] == "nickname") {echo "autofocus";}} ?> type="text" id="nickname" name="nickname" value="<?php if(isset($_SESSION["nickname"])) {echo $_SESSION["nickname"];} ?>">
       </div>
       
       <div>
           <input type="submit" name="next1" value="Volgende">
       </div>
       
   </form>
    
</body>
</html>

