<?php

session_start();


$message_exists = false;

if(isset($_SESSION["notification"]) && isset($_SESSION["not_type"])) {
    $message_exists = true;
}



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
       <div class="messages <?= $_SESSION["not_type"] ?>">
           <p><?php echo($_SESSION["notification"]) ?></p>
       </div>
   <?php endif; ?>
   
   <form method="post" action="contact.php">
       
       <div class="text_input">
           <label for="email">E-mailadres:</label>
           <input type="email" id="email" name="email" required value="<?php if(isset($_SESSION['email'])) { echo($_SESSION['email']); } ?>">
       </div>
       
       <div class="text_input">
           <label for="message">Boodschap:</label>
           <textarea id="message" name="message" required><?php if(isset($_SESSION['message'])) { echo($_SESSION['message']); } ?></textarea>
       </div>
       
       <div>
           <input type="checkbox" id="copy" name="copy" value="copy">
           <label for="copy">Stuur een kopie naar mezelf.</label>
       </div>
       
       <input type="submit" name="submit" value="Verzenden">
       
   </form>    
    
    
</body>
</html>