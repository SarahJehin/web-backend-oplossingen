<?php

session_start();


$message_exists = false;

if(isset($_SESSION["notification"]) && isset($_SESSION["not_type"])) {
    $message_exists = true;
    $notification = $_SESSION["notification"];
    $not_type = $_SESSION["not_type"];
}

if(isset($_SESSION["email"]) && isset($_SESSION["message"])) {
    $email = $_SESSION["email"];
    $message = $_SESSION["message"];
}


unset($_SESSION["notification"]);
unset($_SESSION["not_type"]); 
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing mail - Contact form</title>
    <style>
        
        body {
            font-family: "Calibri", sans-serif;
            color: #459165;
        }
        
        h1 {
            border-bottom: 1px #9ed0b3 solid;
        }

        .messages.error {
            background-color: #fcc;
            color: #d55;
            border-radius: 5px;
        }
        
        .messages.success {
            background-color: #9ed0b3;
            color: #266741;
            border-radius: 5px;
        }

        .messages p {
            padding: 2px 5px;
        }
        
        form div {
            margin-bottom: 15px;
        }
        
        form .text_input label {
            display: block;
        }
        
        input[type="email"],
        textarea,
        input[type="submit"] {
            border: 1px solid #459165;
            border-radius: 5px;
            padding: 2px 5px;
            font-family: inherit;
            font-size: inherit;
        }
        
        form textarea {
            width: 280px;
            height: 100px;
            min-width: 10px;
            max-width: 400px;
            max-height: 200px;
        }
        
        input[type="submit"] {
            background-color: #9ed0b3;
            color: #459165;
            cursor: pointer;
            padding: 5px 10px;
            font-size: 1.2em;
        }
        
        input[type="submit"]:hover {
            background-color: #459165;
            color: #fff;
        }
        
    </style>
</head>
<body>
   
   
   <h1>Contacteer ons</h1>
   
   <?php if($message_exists) : ?>
       <div class="messages <?= $not_type ?>">
           <p><?php echo($notification) ?></p>
       </div>
   <?php endif; ?>
   
   <div class="form_location">
       <form method="post" action="contact.php">
       <!--<form method="post">-->

           <div class="text_input">
               <label for="email">E-mailadres:</label>
               <input type="email" id="email" name="email" required value="<?php if(isset($_SESSION['email'])) { echo($email); } ?>">
           </div>

           <div class="text_input">
               <label for="message">Boodschap:</label>
               <textarea id="message" name="message" required><?php if(isset($_SESSION['message'])) { echo($message); } ?></textarea>
           </div>

           <div>
               <input type="checkbox" id="copy" name="copy" value="copy">
               <label for="copy">Stuur een kopie naar mezelf.</label>
           </div>

           <input type="submit" name="submit" value="Verzenden">

       </form>    
    </div>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        //document ready method : https://learn.jquery.com/using-jquery-core/document-ready/
        $(function(){
            //$test = "test";
            //console.log($test);
            
            $("form").submit(handleForm);
            
            
            function handleForm ( e ) {
                //resultaten gaan ophalen met serialize //results is dan iets als volgend: email=sasasa%40test.bb&message=sasas
                var results = $("form").serialize();
                //console.log(results);
                
                //ajax call maken
                $.ajax({
                    type: "POST",
                    url: "contact-API.php", //hier ga je de url in meegeven van waar je de data gaat ophalen
                    data: results, //hier ga je de data van je form meegeven aan de ajax call op volgende wijze: email=sasasa%40test.bb&message=sasas
                    success: function(data) {
                        //functie die uitgevoerd wordt wanneer de post-data correct werd doorgestuurd
                        
                        //console.log("AJAX call gelukt");
                        //data is hetgene wat we terugkrijgen van de ajax call, wat er in contact-API dus geechoed wordt.
                        //console.log('Data: ' + data +  ' (type: ' + typeof( data ) + ')');
                        //console.log(data);
                        //dat wat we terugkrijgen (de data) moeten we parsen om leesbaar te maken voor javascript
                        //met JSON.parse gaan we de teruggekregen data omzetten in een object
                        console.log(data);
                        data = JSON.parse(data);
                        //console.log(data);
                        if(data["type"] == "success") {
                            //fade formulier langzaam uit en laat de boodschap "Bedankt! Uw bericht is goed verzonden!" infaden op dezelfde plek als het formulier
                            //http://api.jquery.com/fadeout/  (fadeOut(duration, functionOnComplete) (als het eerste is uitgefaded, mag het tweede infaden
                            $("form").fadeOut(500, function(){
                                $(".form_location").append("<p>Bedankt! Uw bericht is goed verzonden!</p>").hide().fadeIn(500);
                            });
                        }
                        if(data["type"] == "error") {
                            $(".err").html("");
                            $(".form_location").prepend("<p class='err'>Oeps, er ging iets mis. Probeer opnieuw!</p>").hide().fadeIn(500);
                        }
                        
                      }
                })
                
                return false;
            }
            
        
        });
    </script>
    
    
</body>
</html>




