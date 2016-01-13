<?php

class Bieren {
    
    protected $name;
    protected $status;
    protected $db;
    
    
    function __construct() {
        
        //session_start();
        
        try {

            //connectie maken - instantie van de databse maken, parameters: host, dbname, login, paswoord  (bij paswoord moet er blijkbaar niets staan bij mij)
            $this->db = new PDO('mysql:host=localhost;dbname=bieren', 'root', '');
            //echo("connectie geslaagd");

        }

        catch ( PDOException $e )
        {
            $messageContainer	=	'Er ging iets mis: ' . $e->getMessage();
            echo($messageContainer);
        }
    }
    
    function test() {
        echo("Hello :p");
    }
    
    function overview() {
        echo("Overview");
    }
    
    function insert() {
        echo("Insert");
    }
    
    function delete() {
        echo("Delete");
    }
    
    function update() {
        echo("Update");
    }
    
}


?>