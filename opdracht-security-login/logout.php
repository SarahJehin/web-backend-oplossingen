<?php

session_start();

//cookie unsetten
setcookie ("login", "", 1);
setcookie ("login", false);
unset($_COOKIE["login"]);
//setcookie("login", "", time()-3600);

unset($_SESSION["email"]);

//logout message in session steken
$_SESSION["message"] = "U bent uitgelogd. Tot de volgende keer!";
$_SESSION["message_type"] = "login_message";
//doorverwijzen naar login pagina waar message verschijnt
header("Location: login-form.php");


?>


