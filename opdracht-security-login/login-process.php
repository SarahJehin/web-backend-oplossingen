<?php

session_start();

//de message session terug leegmaken, zodat er geen foute messages in kunnen blijven staan
unset($_SESSION["message"]);
//unset($_SESSION["message_type"]); 

if(isset($_POST["submit"])) {
    
    //alle data escapen om js-injection tegen te gaan: http://php.net/manual/en/function.htmlspecialchars.php
    $_SESSION["email"] = htmlspecialchars($_POST["email"], ENT_QUOTES);
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES);
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES);
    
    
    try {
        
        //connectie met database aanmaken:
        $db = new PDO('mysql:host=localhost;dbname=opdracht-security-login', 'root', '');
        //echo("connectie geslaagd");
    
        //controleren of e-mailadres in database voorkomt
        $query_select_user = "SELECT * FROM users WHERE email = :email";
        
        $statement_select_user = $db->prepare($query_select_user);
        
        //de placeholder de juiste waarde geven
        $statement_select_user->bindValue(":email", $_SESSION["email"]);
        
        //statement uitvoeren
        $statement_select_user->execute();
        
        //resultaten gaan ophalen
        $arrUsersEmail = array();
        
         while( $row = $statement_select_user->fetch(PDO::FETCH_ASSOC) )
        {
            //elke rij toevoegen aan de array
            $arrUsersEmail[]	=	$row;
        }
        
        if(count($arrUsersEmail) != 0) {
            //salt van geselecteerde e-mail adres gaan ophalen:
            $salt = $arrUsersEmail[0]["salt"];
            
            //salted password = salt.password (dus niet password.salt)
            $salted_input_password = $salt.$password;
            
            //het gesalte input password gaan hashen om dan te vergelijken met dat in de database
            $hashed_salted_input_password = hash("sha512", $salted_input_password);
            
            //checken of het gehashte paswoord klopt:
            if($hashed_salted_input_password == $arrUsersEmail[0]["hashed_password"]) {
                //cookie aanmaken e-mailadres geconcateneerd met een ',' en gevolgd door de SHA512 hash van het e-mailadres geconcateneerd met de salt (30 dagen geldig)
                $hashed_salted_email = hash("sha512", $_SESSION["email"] . $salt);
                $cookie_value = $_SESSION["email"] . "," . $hashed_salted_email;
                $login_cookie = setcookie("login", $cookie_value, time()+60*60*24*30);
                
                //redirecten naar dashboard.php
                header("Location: dashboard.php");
            }
            else {
                //als het paswoord niet overeen komt --> gepaste foutboodschap laten zien en redirecten naar login_form.php
                $_SESSION["message"] = "Sorry, uw account werd niet gevonden. Zeker dat uw paswoord juist is?";
                $_SESSION["message_type"] = "login_message";
                header("Location: login-form.php");
            }
            
            
        }
        else {
            //email komt niet voor in database + redirecten naar logi met gepaste foutboodschap
            $_SESSION["message"] = "Sorry, uw account werd niet gevonden. Zeker dat uw e-mail adres juist is?";
            $_SESSION["message_type"] = "login_message";
            header("Location: login-form.php");
        }
        
        
        
    }
    catch( PDOException $e )
    {
        echo('Er ging iets mis: ' . $e->getMessage());
    }
    
}




?>
