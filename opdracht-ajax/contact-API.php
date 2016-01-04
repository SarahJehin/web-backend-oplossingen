<?php

//gaan checken of pagina opgeroepen werd door ajax call //echoes XMLHttpRequest
/*if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {



//met de if(isset($_POST["xxx"])) ga je kijken of er variabelen aangemaakt zijn met de naam "xxx" omdat we een serialize hebben gedaan van alle info van het formulier, zouden we hier dus al die info moeten kunnen ophalen
//zowel de waarde van de post van email, als van message, als van copy zitten in de results (serialized) en kunnen we dus opvragen

/*if(isset($_POST["email"])) {
    //echo($_POST["email"]);
    echo json_encode($_POST["email"]);
}*/

/*if(isset($_POST["message"])) {
    //echo($_POST["email"]);
    echo json_encode($_POST["message"]);
}*/

/*if(isset($_POST["copy"])) {
    //echo($_POST["email"]);
    echo json_encode($_POST["copy"]);
}*/ /*
    if(isset($_POST["email"]) && isset($_POST["message"])) {
        //maak dan een variabele $ajaxMessage aan. Deze bevat een key 'type' met als waarde 'success'.
        $ajax_message["type"] = "success";
        echo(json_encode($ajax_message));
    }
    
}*/


/* IMPLEMENTATIE VAN OORSPRONKELIK contact.php */

session_start();

//if isset($_POSt("submit") gaat hier niet werken omdat deze niet wordt meegegeven als data (email en message wel)
//if(isset($_POST["submit"])) {
    
if(isset($_POST["email"])) {
    
    //echo("yay");
    
    if($_POST["email"] == "" || $_POST["message"] == "") {
        $_SESSION["notification"] = "Gelieve een geldig e-mailadres en een boodschap in te vullen";
        $_SESSION["not_type"] = "error";
        header("Location: contact-form.php");
    }
    
    $admin = "sarah.jehin@student.kdg.be";
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["message"] = $_POST["message"];
    
    try {
        //connectie met database aanmaken:
        $db = new PDO('mysql:host=localhost;dbname=opdracht-mail', 'root', '');

        $query_insert_message = "INSERT INTO contact_messages
                                    VALUES( null, 
                                            :email, 
                                            :message, 
                                            now())";

        $statement_insert_message = $db->prepare($query_insert_message);
        
        $statement_insert_message->bindValue(":email", $_POST["email"]);
        $statement_insert_message->bindValue(":message", $_POST["message"]);
        

        $insert_ok = $statement_insert_message->execute();
        
        if($insert_ok) {
            
            //email naar admin sturen
            //e-mail parameters bepalen //http://php.net/manual/en/function.mail.php
            $aan        = $admin;
            $afzender   = $_POST["email"];
            $titel      = "Nieuwe contactboodschap!";
            $body       = "<p>Je hebt een nieuw bericht ontvangen van " . $afzender . " :</p>";
            $body       .= '<p>"' . $_POST["message"] . '"</p>';
            $body       .= "<p>--Einde van bericht--</p>";
            $headers    = 'MIME-Version: 1.0' . "\r\n";
            $headers    .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            //extra headers:
            $headers    .= 'From: ' . $afzender . "\r\n";
            $headers 	.= 'Reply-To: ' . $afzender  . "\r\n";
            
            
            $mail_sent = mail( $aan, $titel, $body, $headers );
            
            //checken of "stuur naar mezelf" aangevinkt is, indien ja moet er ook nog een mail naar de zender gestuurd worden
            if(isset($_POST["copy"])) {
                //echo("kopietjes verstuurd");
                
                $aan        = $_POST["email"];
                $afzender   = $admin;
                $titel      = "kopie van je bericht";
                $body       = "<p>Hierbij vind je een kopie van het bericht dat je naar " . $afzender . " hebt gestuurd :</p>";
                $body       .= '<p>"' . $_POST["message"] . '"</p>';
                $body       .= "<p>--Einde van bericht--</p>";
                $headers    = 'MIME-Version: 1.0' . "\r\n";
                $headers    .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                //extra headers:
                $headers    .= 'From: ' . $admin . "\r\n";
                $headers 	.= 'Reply-To: ' . $admin  . "\r\n";


                $copy_mail_sent = mail( $aan, $titel, $body, $headers );
                
            }
            
            if($mail_sent) {
                if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
                    if(isset($_POST["email"]) && isset($_POST["message"])) {
                        //maak dan een variabele $ajaxMessage aan. Deze bevat een key 'type' met als waarde 'success'.
                        $ajax_message["type"] = "success";
                        echo(json_encode($ajax_message));
                    }

                }
                else {
                    $_SESSION["notification"] = "Uw bericht werd goed verzonden!";
                    $_SESSION["not_type"] = "success";
                    unset($_SESSION["email"]);
                    unset($_SESSION["message"]); 
                    header("Location: contact-form.php");
                }
            }
            else {
                if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
                    //maak dan een variabele $ajaxMessage aan. Deze bevat een key 'type' met als waarde 'success'.
                    $ajax_message["type"] = "error";
                    echo(json_encode($ajax_message));
                }
                else {
                    $_SESSION["notification"] = "Er is iets misgelopen, probeer opnieuw!";
                    $_SESSION["not_type"] = "error";
                    header("Location: contact-form.php");
                }
            }
            
        }
        else {
            $_SESSION["notification"] = "Kon niet opgeslagen worden in database";
            $_SESSION["not_type"] = "error";
            header("Location: contact-form.php");
        }
        
        
    }
    catch( PDOException $e )
    {
        //echo('Er ging iets mis: ' . $e->getMessage());
    }
    
    
}





?>