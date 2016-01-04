<?php

class Artikel {
    
    protected $name;
    protected $status;
    protected $db;
    
    
    function __construct() {
        
        //session_start();
        
        try {

            //connectie maken - instantie van de databse maken, parameters: host, dbname, login, paswoord  (bij paswoord moet er blijkbaar niets staan bij mij)
            $this->db = new PDO('mysql:host=localhost;dbname=opdracht-mod-rewrite-blog', 'root', '');
            //echo("connectie geslaagd");

        }

        catch ( PDOException $e )
        {
            $messageContainer	=	'Er ging iets mis: ' . $e->getMessage();
            echo($messageContainer);
        }
    }
    
    
    public function insertArtikel( $titel, $artikel, $kernwoorden, $datum ) {
        
        //hier ga je het artikel aan de database toevoegen --> vergeet niet met parameters te werken
        
        $insert_artikel_query = "INSERT INTO artikels VALUES (null, :titel, :artikel, :kernwoorden, :datum)";
        
        //query klaarzetten:
        $statement_insert = $this->db->prepare($insert_artikel_query);
        
        //placeholders voorzien om sql injection tegen te gaan
        $statement_insert->bindValue(":titel", $titel);
        $statement_insert->bindValue(":artikel", $artikel);
        $statement_insert->bindValue(":kernwoorden", $kernwoorden);
        $statement_insert->bindValue(":datum", $datum);
        
        $insert_ok = $statement_insert->execute();
        
        return $insert_ok;
        
        /*if($insert_ok) {
            $_SESSION['notification'] = "Het artikel werd toegevoegd";
            //redirecten naar overzicht
            header("Location: ../artikel-overzicht.php");
        }
        else {
            $_SESSION['notification'] = "Het artikel kon niet worden toegevoegd. Probeer opnieuw.";
            //alles in session steken:
            
            //redirecten naar artikel-toevoegen-form
            header("Location: ../artikel-toevoegen-form.php");
        }*/
        
        
    }
    
    
    public function getAllArtikels() {
        
        $selectByKernwoordQuery = "SELECT * FROM artikels";
        
        $statementSelectByKernwoord = $this->db->prepare($selectByKernwoordQuery);
        
        $statementSelectByKernwoord->execute();
    
        //array aanmaken om alle waardes van de tabel in op te vangen
        $arrArtikels = array();
    
        //dan ga je met een while loop alle rijen overlopen zolang er rijen zijn en al hun waardes in de array hierboven steken
        //fetch(PDO::FETCH_ASSOC) wijst erop dat je er een associatieve array van gaat maken, zodat je de kolommen kan aanspreken met hun naam ipv index)
        while ( $row = $statementSelectByKernwoord->fetch(PDO::FETCH_ASSOC) )
        {
            //elke rij toevoegen aan de array
            $arrArtikels[]	=	$row;
        }
        
        //var_dump($arrArtikels);
        return $arrArtikels;
        
    }
    
    
    
    public function getArtikelByYear( $year ) {
        
        //je gaat de % er hier al aan toevoegn, omdat je dat niet kan na een bindvalue (misschien omdat deze tussen '' of "" wordt gezet)
        $year = $year."%";
        
        $selectByYearQuery = "SELECT * FROM artikels WHERE Datum LIKE :year";
        
        $statementSelectByYear = $this->db->prepare($selectByYearQuery);
        
        $statementSelectByYear->bindValue(":year", $year);
        
        $statementSelectByYear->execute();
        //echo($selectByYearQuery);
    
        //array aanmaken om alle waardes van de tabel in op te vangen
        $arrArtikels = array();
    
        //dan ga je met een while loop alle rijen overlopen zolang er rijen zijn en al hun waardes in de array hierboven steken
        //fetch(PDO::FETCH_ASSOC) wijst erop dat je er een associatieve array van gaat maken, zodat je de kolommen kan aanspreken met hun naam ipv index)
        while ( $row = $statementSelectByYear->fetch(PDO::FETCH_ASSOC) )
        {
            //elke rij toevoegen aan de array
            $arrArtikels[]	=	$row;
        }
        
        //var_dump($arrArtikels);
        return $arrArtikels;
        
        /*foreach($arrArtikels as $row) 
        {
            echo($row["Titel"]." en datum is ".$row["Datum"]."<br>");
        }*/
        
    }
    
    public function getArtikelByKernwoord( $kernwoord ) {
        
        //je gaat de % er hier al aan toevoegn, omdat je dat niet kan na een bindvalue (misschien omdat deze tussen '' of "" wordt gezet)
        $kernwoord = "%".$kernwoord."%";
        
        $selectByKernwoordQuery = "SELECT * FROM artikels WHERE Kernwoorden LIKE :kernwoord";
        
        $statementSelectByKernwoord = $this->db->prepare($selectByKernwoordQuery);
        
        $statementSelectByKernwoord->bindValue(":kernwoord", $kernwoord);
        
        $statementSelectByKernwoord->execute();
    
        //array aanmaken om alle waardes van de tabel in op te vangen
        $arrArtikels = array();
    
        //dan ga je met een while loop alle rijen overlopen zolang er rijen zijn en al hun waardes in de array hierboven steken
        //fetch(PDO::FETCH_ASSOC) wijst erop dat je er een associatieve array van gaat maken, zodat je de kolommen kan aanspreken met hun naam ipv index)
        while ( $row = $statementSelectByKernwoord->fetch(PDO::FETCH_ASSOC) )
        {
            //elke rij toevoegen aan de array
            $arrArtikels[]	=	$row;
        }
        
        
        //var_dump($arrArtikels);
        return $arrArtikels;
        
    }
    
    public function getArtikelByWoord( $woord ) {
        
        //je gaat de % er hier al aan toevoegn, omdat je dat niet kan na een bindvalue (misschien omdat deze tussen '' of "" wordt gezet)
        $woord = "%".$woord."%";
        
        $selectByWoordQuery = "SELECT * from artikels where Titel LIKE :woord OR Artikel LIKE :woord OR Kernwoorden LIKE :woord";
        
        $statementSelectByWoord = $this->db->prepare($selectByWoordQuery);
        
        $statementSelectByWoord->bindValue(":woord", $woord);
        
        $statementSelectByWoord->execute();
    
        //array aanmaken om alle waardes van de tabel in op te vangen
        $arrArtikels = array();
    
        //dan ga je met een while loop alle rijen overlopen zolang er rijen zijn en al hun waardes in de array hierboven steken
        //fetch(PDO::FETCH_ASSOC) wijst erop dat je er een associatieve array van gaat maken, zodat je de kolommen kan aanspreken met hun naam ipv index)
        while ( $row = $statementSelectByWoord->fetch(PDO::FETCH_ASSOC) )
        {
            //elke rij toevoegen aan de array
            $arrArtikels[]	=	$row;
        }
        
        
        //var_dump($arrArtikels);
        return $arrArtikels;
        
    }
    
}


?>