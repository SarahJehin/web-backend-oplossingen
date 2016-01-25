<?php

session_start();

$show_message = false;

//als je gaat je net ingelogd bent //Auth::check wijst op de authentificatie van een user, dus iemand die ingelogd is
if(!isset($_SESSION["first_login"]) && Auth::check()) {
    //omdat je first_login hier op 1 zet, zullen onderstaande statements niet meer uitgevoerd worden totdat je terug uitlogt en de session terug ge-unset wordt
    $_SESSION["first_login"] = 1;
    //hier ga je ook de first_logout session aanmaken, zodat als je op uitloggen klikt, de session bestaat (waarna ze weer ge-unset wordt)
    $_SESSION["first_logout"] = 1;
    
    Session::flash('flash_message', 'Pfieuw, het aanmelden is goed verlopen! Welkom!');
    //header('Location: '.$_SERVER['REQUEST_URI']);
}
//de session first_logout kan enkel bestaan als je minstens 1x ingelogd bent geweest, anders kan de session nooit aangemaakt geweest zijn
if(isset($_SESSION["first_logout"]) && !Auth::check()) {
    //als je uitlogt ga je ook de session first_login unsetten zodat je ze weer kan activeren bij het inloggen
    unset($_SESSION["first_login"]);
    
    //als je uitlogt ga je ze ook weer unsetten, zodat ze weer niet kan bestaan tot je terug inlogt
    unset($_SESSION["first_logout"]);
    
    Session::flash('flash_message', 'Je bent afgemeld. Tot de volgende keer!');
    
}
//als de user ingelogd is ga je checken of de vorige pagina de register pagina was, indien ja, dan krijg je een bevestiging van registratie
if(Auth::check()) {
    $previous_page = $_SERVER['HTTP_REFERER'];
    preg_match("/[^\/]+$/", $_SERVER['HTTP_REFERER'], $matches);
    $last_word = $matches[0];
    if($last_word == "register") {
        Session::flash('flash_message', 'Pfieuw, het registreren is gelukt! Welkom!');
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#spark-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="spark-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Registreer</a></li>
                    @else
                        <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/tasks') }}">Todos</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    
    <!-- hieronder komt een divje voor messages/notifaction van de session in te steken -->
    <?php if($show_message) : ?>
    <div class="">
        <?php $message ?>
    </div>
    <?php endif; ?>
    
    @if (Session::has('flash_message'))
        <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
    @endif
    
    
    

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
