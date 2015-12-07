<?php

session_start();

$password = "";
unset($_SESSION["message"]);
//unset($_SESSION["message_type"]); 

if(isset($_POST["generate_password"])) {
    
    //eerste kijken of er al een e-mail adres ingevuld is, indien ja --> bijhouden in e-mail session
    if(isset($_POST["email"])) {
        $_SESSION["email"] = $_POST["email"];
    }
    //random paswoord gaan aanmaken
    //generate_password(length, smallabc, capsABC, numbers, specials)
    $password = generate_password(8, true, true, true, false);
    //paswoord gaan opslagen in session
    $_SESSION["password"] = $password;
    //terug naar de registratiepagina gaan
    header("Location: registratie-form.php");
}
//let op ! => de session moet gecleared worden zodra de gebruiker is toegevoegd aan de database


if(isset($_POST["submit"])) {
    //geldigheid e-mail adres nakijken (ongeldig --> redirecten naar registratie-form + gepaste boodschap) http://php.net/manual/en/filter.examples.validation.php
    if(isset($_POST["email"])) {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) && $_POST["email"] != "" ) {
            $_SESSION["email"] = $_POST["email"];
            //echo("valid e-mail");
            
            try {
        
                //connectie met database aanmaken:
                $db = new PDO('mysql:host=localhost;dbname=opdracht-security-login', 'root', '');
                //echo("connectie geslaagd");

                //controleren of e-mailadres al in database voorkomt (indien ja --> redirecten naar registratie-form + gepaste boodschap)
                $query_email_exists = "SELECT email FROM users WHERE email = :email";

                $statement_email_exists = $db->prepare($query_email_exists);

                //de placeholder de juiste waarde geven
                $statement_email_exists->bindValue(":email", $_POST["email"]);

                //statement uitvoeren
                $statement_email_exists->execute();

                //resultaten gaan ophalen
                $arrUsersEmail = array();

                 while( $row = $statement_email_exists->fetch(PDO::FETCH_ASSOC) )
                {
                    //elke rij toevoegen aan de array
                    $arrUsersEmail[]	=	$row;
                }

                //dan met if statement gaan kijken of de lengte van $arrUsersEmail = 0, dan mag je gaan toevoegen aan de database, want dan bestaat het nog niet
                if(count($arrUsersEmail) == 0) {
                    //query om aan database toe te voegen
                    $query_insert_user = "INSERT INTO users
                                            VALUES(null, :email, :salt, :hashed_password, NOW());";

                    //willekeurige salt creëren
                    $salt = uniqid(mt_rand(), true);
                    //echo($salt);

                    //salt concateneren met ingevulde password
                    $salted_password = $salt.$_POST["password"];

                    //SHA512-hash dit salted password
                    $hashed_salted_password = hash("sha512", $salted_password);

                    $statement_insert_user = $db->prepare($query_insert_user);

                    //de placeholders hun waarde gaan toekennen
                    $statement_insert_user->bindValue(":email", $_POST["email"]);
                    $statement_insert_user->bindValue(":salt", $salt);
                    $statement_insert_user->bindValue(":hashed_password", $hashed_salted_password);

                    //de insert gaan uitvoeren
                    $statement_insert_user->execute();

                    //checken of user succesvol is toegevoegd aan database:
                    $query_check_last_row = "SELECT * FROM `users` ORDER BY id DESC LIMIT 1";

                    $statement_check_last_row = $db->prepare($query_check_last_row);

                    $statement_check_last_row->execute();

                    $arrLastInserted = array();

                    while( $row = $statement_check_last_row->fetch(PDO::FETCH_ASSOC) )
                    {
                        //elke rij toevoegen aan de array
                        $arrLastInserted[]	=	$row;
                    }
                    //er kan normaal maar 1 resultaat inde $arrLastInserted zitten omdat je een limit 1 doet.
                    if($arrLastInserted[0]["email"] == $_SESSION["email"]) {
                        //succes!
                        //cookie aanmaken e-mailadres geconcateneerd met een ',' en gevolgd door de SHA512 hash van het e-mailadres geconcateneerd met de salt (30 dagen geldig)
                        $hashed_salted_email = hash("sha512", $_SESSION["email"] . $arrLastInserted[0]["salt"]);
                        $cookie_value = $_SESSION["email"] . "," . $hashed_salted_email;
                        $login_cookie = setcookie("login", $cookie_value, time()+60*60*24*30);

                        //session verwijderen //zodat paswoord niet meer ongeëncrypteerd beschikbaar is (enkel indien er een paswoord gegenereerd is)
                        unset($_SESSION["password"]);

                        //redirecten naar dashboard.php
                        header("Location: dashboard.php");
                    }

                }
                //anders (als het e-mail adres dus al wel voorkomt in de database)
                else {
                    $_SESSION["message"] = "Er is al een account aangemaakt met dit e-mail adres.";
                    $_SESSION["message_type"] = "registratie_message";
                    header("Location: registratie-form.php");
                }
            }
            catch( PDOException $e )
            {
                echo('Er ging iets mis: ' . $e->getMessage());
            }
            
        }
        else {
            //show "invalid" message
            //echo("invalid e-mail");
            $_SESSION["message"] = "Dit e-mail adres is niet geldig, probeer opnieuw.";
            $_SESSION["message_type"] = "registratie_message";
            header("Location: registratie-form.php");
        }
    }
    else {
        $_SESSION["message"] = "Dit e-mail adres is niet geldig, probeer opnieuw.";
        $_SESSION["message_type"] = "registratie_message";
        header("Location: registratie-form.php");
    }
    
    
}



//functie die random paswoord gaat genereren aan de hand van de opgegeven lengte en welke tekens erin moeten zitten (zijn telkens bools die op true staan als de tekens erin moeten zitten)
function generate_password($length, $smallOK, $capsOK, $numberOK, $specialOK) {
    
    $alphabetSmall  = "abcdefghijklmnopqrstuwxyz";
    $alphabetCaps   = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
    $numbers        = "0123456789";
    $specials       = "&$!?%-_+#/*";
    
    //$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $alphabet = "";
    
    if($smallOK) {
        $alphabet = $alphabetSmall;
    }
    
    if($capsOK) {
        $alphabet .= $alphabetCaps;
    }
    
    if($numberOK) {
        $alphabet .= $numbers;
    }
    
    if($specialOK) {
        $alphabet .= $specials;
    }
    
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, strlen($alphabet)-1);
        $password[$i] = $alphabet[$n];
    }
    $password = implode("", $password);
    return $password;
}

//echo(generate_password(8, true, true, true, true));



?>