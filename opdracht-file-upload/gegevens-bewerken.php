<?php


session_start();


//de message session terug leegmaken, zodat er geen foute messages in kunnen blijven staan
unset($_SESSION["message"]);
unset($_SESSION["message_type"]); 

if(isset($_COOKIE["login"])){
    //de cookie gaan uiteenhalen
    $arrCookie = explode(",", $_COOKIE["login"]);
    $email = $arrCookie[0];
    $hashed_email = $arrCookie[1];
}

if(isset($_POST["submit"])) {
    
    //nieuw e-mailadres ophalen en in session steken:
    $_SESSION["email"] = $_POST["new_email"];
    
    //$_FILES geeft multidimensionele array terug met volgende keys:
                //name      = naam van het bestand               (vb: Half girl - half Angelina Jolie.jpg)
                //type      = type bestand op basis van header   (vb: image/jpeg)
                //tmp_name  = voorlopige naam                    (vb: C:\xampp\tmp\php5ED9.tmp)
                //size      = grootte van het bestand            (vb: int(224614) --> (224 614 bytes))
                //error     = als er iets misging
    //var_dump($_FILES["photo"]);
    //echo($_FILES["photo"]["tmp_name"]);
    //echo($_FILES["photo"]["type"]);
    
    /* ** ERROR ** */    
    //als je een error krijgt -> betekenissen = http://php.net/manual/en/features.file-upload.errors.php
                // 1 = overschrijden van maximumgrootte (php_value upload_max_filesize    110M)
                // 4 = er is geen file geüpload
    //echo($_FILES["photo"]["error"]);
    if($_FILES["photo"]["error"] > 0 && $_FILES["photo"]["error"] != 4) {
        $_SESSION["message"] = "Er is iets misgelopen. Misschien was je file te groot ?";
        $_SESSION["message_type"] = "gegevens_message";
        header("Location: gegevens-wijzigen-form.php");
    }
    
    //als de error toch 4 is wil dat zeggen dat er geen bestand opgegeven is en dat ze dus misschien alleen hun e-mailadres willen updaten
    if($_FILES["photo"]["error"] == 4) {
        try {
                //connectie met database aanmaken:
                $db = new PDO('mysql:host=localhost;dbname=opdracht-file-upload', 'root', '');

                $query_update_user = "UPDATE users
                                        SET     email = :new_email
                                        WHERE   email = :email";

                $statement_update_user = $db->prepare($query_update_user);

                $statement_update_user->bindValue(":new_email", $_SESSION["email"]);
                $statement_update_user->bindValue(":email", $email);

                $update_ok = $statement_update_user->execute();
                
                if($update_ok) {
                    $_SESSION["message"] = "Gegevens werden succesvol gewijzigd";
                    $_SESSION["message_type"] = "gegevens_message";
                    
                    //de session van de email = $_POST["new_email"] en de session van de salt wordt opgehaald uit de gegevens-wijzigen-form.php
                    $hashed_salted_email = hash("sha512", $_SESSION["email"] . $_SESSION["salt"]);
                    $cookie_value = $_SESSION["email"] . "," . $hashed_salted_email;
                    //cookie opnieuw instellen (=nodig omdat je op de gegevens wijzigen pagina het emailadres gaat ophalen uit de cookie
                    $login_cookie = setcookie("login", $cookie_value, time()+60*60*24*30);
                    
                    header("Location: gegevens-wijzigen-form.php");
                }
                else {
                    //echo("mail =" . $email . " en photo = " . $new_file_name . " en nieuw mail = " . $_SESSION["email"]);
                    $_SESSION["message"] = "Er is iets misgelopen bij het wijzigen, probeer opnieuw.";
                    $_SESSION["message_type"] = "gegevens_message";
                    header("Location: gegevens-wijzigen-form.php");
                }
            }
            catch( PDOException $e )
            {
                echo('Er ging iets mis: ' . $e->getMessage());
            }
    }
    
    else {
        /* ** TYPE ** */
        //alle toegelaten types worden opgeslagen in een array zodat we latfer gemakkelijk meerdere types kunnen toevoegen (of enkele weghalen)
        $allowed_types = array("png", "jpeg", "gif");
        //standaard wordt het type als "niet toegelaten" gezet
        $type_ok = false;
        //type geeft image/[echte_type] weer -> dus hier gaan we het echte type uit ophalen adhv een explode
        $type_arr = explode("/", $_FILES["photo"]["type"]);
        $type = $type_arr[1]; //zal waarschijnlijk jpeg, gif of png zijn
        //echo($type);

        //gaan checken of het type bestand overeen komt met één van de toegelaten types, indien ja -> type_ok = true
        foreach($allowed_types as $allowed_type) {
            if($type == $allowed_type) {
                //echo("ok");
                $type_ok = true;
                break;
            }
        }
        //echo($type_ok);


        /* ** GROOTTE ** */
        //echo($_FILES["photo"]["size"]);
        //de max toegelaten grootte bepalen (in bytes) (2Mb)
        $allowed_size = 2000000;
        //standaard voldoet de grootte niet
        $size_ok = false;
        //grootte gaan ophalen
        $size = $_FILES["photo"]["size"];

        if($size <= $allowed_size) {
            $size_ok = true;
        }
        //echo($size_ok);

        if(!$type_ok || !$size_ok) {
            $_SESSION["message"] = "Er is iets misgelopen. Misschien was je file te groot of misschien was je bestand van het verkeerde type?";
            $_SESSION["message_type"] = "gegevens_message";
            header("Location: gegevens-wijzigen-form.php");
        }

        //als je tot hier geraakt wil het zeggen dat aan alle voorwaarden voldaan werd
        //image naam gaan samenstellen
        //huidige tijd opvragen (seconden verstreken sinds Unix Epoch (January 1 1970 00:00:00 GMT))
        $timestamp = time();
        $file_name = $_FILES["photo"]["name"];
        $new_file_name = $timestamp . "_" . $file_name;

        //een constante gaan definiëren om te bepalen dit php bestand zich bevindt (__FILE__ = huidige bestand = gegevens-bewerken.php)
        define('ROOT', dirname(__FILE__));
        //echo(ROOT);
        //zolang de file al voorkomt in de doelmap, moeten we er een nieuwe naam voor genereren
        while (file_exists(ROOT . "/img/" . $new_file_name)) {
            //Als het bestand reeds bestaat in de map, moet er een nieuwe file name aangemaakt worden op basis van de timestamp
            $new_file_name = $timestamp . "_" . $file_name;
        }

        //nog een laatste extra controle --> als de file nog niet bestaat gaan we hem toevoegen
        if(!file_exists(ROOT . "/img/" . $new_file_name)) {
            //echo("mag toegevoegd worden");
            //toevoegen move_uploaded_file($filename, $destination) --> filename moet altijd de tmp_name zijn !! (destination is incl. de nieuwe naam van het bestand)
            move_uploaded_file($_FILES["photo"]["tmp_name"], (ROOT . "/img/" . $new_file_name));

            //profielfoto toevoegen aan database (als de foto correct geüpload is)
            if(file_exists(ROOT . "/img/" . $new_file_name)) {
                try {
                    //connectie met database aanmaken:
                    $db = new PDO('mysql:host=localhost;dbname=opdracht-file-upload', 'root', '');

                    $query_update_user = "UPDATE users
                                            SET     email = :new_email,
                                                    profile_picture = :photo
                                            WHERE   email = :email";

                    $statement_update_user = $db->prepare($query_update_user);

                    $statement_update_user->bindValue(":new_email", $_SESSION["email"]);
                    $statement_update_user->bindValue(":photo", $new_file_name);
                    $statement_update_user->bindValue(":email", $email);

                    $update_ok = $statement_update_user->execute();

                    if($update_ok) {
                        $_SESSION["message"] = "Gegevens werden succesvol gewijzigd";
                        $_SESSION["message_type"] = "gegevens_message";

                        //de session van de email = $_POST["new_email"] en de session van de salt wordt opgehaald uit de gegevens-wijzigen-form.php
                        $hashed_salted_email = hash("sha512", $_SESSION["email"] . $_SESSION["salt"]);
                        $cookie_value = $_SESSION["email"] . "," . $hashed_salted_email;
                        //cookie opnieuw instellen (=nodig omdat je op de gegevens wijzigen pagina het emailadres gaat ophalen uit de cookie
                        $login_cookie = setcookie("login", $cookie_value, time()+60*60*24*30);

                        header("Location: gegevens-wijzigen-form.php");
                    }
                    else {
                        //echo("mail =" . $email . " en photo = " . $new_file_name . " en nieuw mail = " . $_SESSION["email"]);
                        $_SESSION["message"] = "Er is iets misgelopen bij het wijzigen, probeer opnieuw.";
                        $_SESSION["message_type"] = "gegevens_message";
                        header("Location: gegevens-wijzigen-form.php");
                    }
                }
                catch( PDOException $e )
                {
                    echo('Er ging iets mis: ' . $e->getMessage());
                }
            }

        }
    }
    
}


?>




