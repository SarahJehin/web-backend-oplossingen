<?php


session_start();



//bool om te bepalen of de code geldig is:
$isValid = false;


try {
    
    if(isset($_POST["submit"])) {
            
            if(isset($_POST["code"])) {
                
                if(strlen($_POST["code"]) == 8) {
                    $isValid = true;
                }
                else {
                    throw new Exception("VALIDATION-CODE-LENGTH");
                }
            }
            else {
                throw new Exception("SUBMIT-ERROR");
            }
            
    }
    
}
catch ( Exception $e) {
    
    //deze spreekt de exception class aan en vangt de error-code:
    $messageCode = $e->getMessage();
    //een array die de textuele boodschap en het type opvangt
    $message = array();
    //een boolean die standaard op FALSE staat en beslist of er een boodschap in de session geplaatst moet worden
    $createMessage = false;
    
    switch($messageCode) {
        case "SUBMIT-ERROR":
            $message["type"] = "error";
            $message["text"] = "Er werd met het formulier geknoeid";
            break;
        case "VALIDATION-CODE-LENGTH":
            $message["type"] = "error";
            $message["text"] = "De kortingscode heeft niet de juiste lengte";
            $createMessage = true;
            break;
        default:
            break;
    }
    
    logToFile($message);
    
    createMessage($message);
}

$errorMessage = showMessage();


function logToFile($arrOfError) {
    
    //hoe wordt fout opgeslagen:       time      date     -   IP      -   type fout     fout zelf
    //                              [11:12:53 08/08/2015] - 127.0.0.1 - type:[error] Kortingscode is niet correct
    
    $dateTime   = date("[H:i:s d/m/Y]", time());
    $ip         = $_SERVER['REMOTE_ADDR'];
    $type       = $arrOfError["type"];
    $message    = $arrOfError["text"];
    
    $errorString = $dateTime." - ".$ip." - type:[".$type."] - ".$message."\n\r";
    
    file_put_contents("log.txt", $errorString, FILE_APPEND);
}

function createMessage($message) {
    $_SESSION["message"]["type"] = $message["type"];
    $_SESSION["message"]["message"] = $message["text"];
    
}

function showMessage() {
    
    $message;
    
    if(isset($_SESSION["message"]["type"]) && isset($_SESSION["message"]["message"])) {
        $message = array($_SESSION["message"]["type"], $_SESSION["message"]["message"]);
        unset($_SESSION["message"]["type"]);
        unset($_SESSION["message"]["message"]);
        return $message;
    }
    else {
        return false;
    }
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing error handling deel 1</title>
    
    <style>
        body {
            font-family: "Calibri", sans-serif;
        }
        
        form label,
        form input {
            display: block;
        }
        
        form input[type="submit"] {
            margin-top: 10px;
        }
        
        .error {
            background-color: #e2a3a3;
            color: #aa3c3c;
        }
        
        
    </style>
    
</head>
<body>
   
   <h1>Geef uw kortingscode op</h1>
   
   <?php if($errorMessage) : ?>
   <p class="error"><?= $message["text"] ?></p>
   <?php endif ?>
   
   <?php if(!$isValid) : ?>
   <form action="oplossing-error-handling-deel1.php" method="post">
      
       <div>
           <label for="code">Kortingscode</label>
           <input type="text" id="code" name="code">
       </div>
       
       <input type="submit" name="submit" value="Verzenden">
       
   </form>
   <?php endif ?>
   
   <?php if($isValid) : ?>
   <p>Korting toegekend</p>
   <?php endif ?>
    
</body>
</html>






