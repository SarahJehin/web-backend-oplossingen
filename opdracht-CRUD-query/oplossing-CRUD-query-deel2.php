<!-- DEEL 2 -->
<?php

$messageContainer = "";
static $count = 1;
$arrBeerRowsExists = false;

try {
    
    //connectie maken - instantie van de databse maken, paramters: host, dbname, login, paswoord  (bij paswoord moet er blijkbaar niets staan bij mij)
    $db = new PDO('mysql:host=localhost;dbname=bieren', 'root', '');
    $messageContainer = "Connectie geslaagd";
    
    //query definiëren
    $queryString = 'select brnaam, brouwernr
                    from brouwers';
    
    //echo $queryString;
    
    //query klaarzetten
    $statement_select_all = $db->prepare($queryString);
    
    //query uitvoeren:
    $statement_select_all->execute();
    
    //array aanmaken om alle waardes van de tabel in op te vangen
    $arrTableRows = array();
    
    //dan ga je met een while loop alle rijen overlopen zolang er rijen zijn en al hun waardes in de array hierboven steken
    //fetch(PDO::FETCH_ASSOC) wijst erop dat je er een associatieve array van gaat maken, zodat je de kolommen kan aanspreken met hun naam ipv index)
    while ( $row = $statement_select_all->fetch(PDO::FETCH_ASSOC) )
    {
        //elke rij toevoegen aan de array
        $arrTableRows[]	=	$row;
    }
    
    //gaan kijken of het form gesubmit is //als er geklikt wordt, moet je ook de geselecteerde value laten staan (http://www.w3schools.com/tags/att_option_selected.asp)
    if(isset($_GET["submit"])) {
        //echo "yay";
        $arrBeerRowsExists = true;
        //gaan kijken of er een brouwer geselecteerd is
        if(isset($_GET["brouwer"])) {
            //echo "yayay";
            //je gaat wat de gebruiker selecteerde opslaan in een variabele, maar je mag deze variabele niet rechtstreeks gebruiken, maar wel via placeholder (veiliger)
            $brouwernummer = $_GET["brouwer"];
            
            $queryString2 = 'select naam
                             from bieren
                             where brouwernr like :brouwernummer';
            
            $statement_select_beer_from_brewer = $db->prepare($queryString2);
            
            //voor meer beveiliging ga je een placeholder aanmaken voor de get-variabele en die ga je gebruiken in de query
            $statement_select_beer_from_brewer->bindValue(":brouwernummer", $brouwernummer);
            
        }
        else {
            $queryString2 = 'select naam
                             from bieren';
            $statement_select_beer_from_brewer = $db->prepare($queryString2);
        }
        
        $statement_select_beer_from_brewer->execute();
        
        $arrBeerRows = array();
    
        //dan ga je met een while loop alle rijen overlopen zolang er rijen zijn en al hun waardes in de array hierboven steken
        while ( $row = $statement_select_beer_from_brewer->fetch(PDO::FETCH_ASSOC) )
        {
            //elke rij toevoegen aan de array, maar een rij bestaat enkel uit de naam nu
            $arrBeerRows[]	=	$row;
        }
        
    }
    
}

catch ( PDOException $e )
{
    $messageContainer	=	'Er ging iets mis: ' . $e->getMessage();
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing CRUD query - deel 2</title>
    
    <style>
        
        body {
            font-family: "Calibri", sans-serif;
        }
        
        h1 {
            border-bottom: 1px #ccc solid;
        }
        
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        
        table th,
        table td {
            border: 1px #aaa solid;
            padding: 5px 10px;
        }
        
        thead tr {
            background-color: #ddd;
        }
        
        tbody tr:nth-child(odd) {
            background-color: #F1F1F1;
        }
        
        
        
    </style>
    
</head>
<body>
    
    <h1>Oplossing CRUD query</h1>
    
    <!--<p><?php echo $messageContainer ?></p>-->
    
    
    
    <form method="get" action="oplossing-CRUD-query-deel2.php">
        
        <!--<select>
            <option value="1">Achouffe</option>
            <option value="2">Alken</option>
            <option value="3">Ambly</option>
            <option value="4">Anker</option>
            <option value="6">Artois</option>
            <option value="8">Bavik</option>
            <option value="9">Belle Vue - Molenbeek</option>
            <option value="10">Belle Vue - Zuun</option>
            <option value="11">Belle Vue</option>
            <option value="12">Bie (De)</option>
            <option value="13">Binchoise</option>
            <option value="14">Bios</option>
            <option value="15">Blaugies</option>
            <option value="17">Bocq</option>
            <option value="18">Boelens</option>
            <option value="19">Boon</option>
            <option value="20">Bosteels</option>
            <option value="21">Brunehaut</option>
            <option value="22">Cantillon</option>
        </select>-->
        
        <select name="brouwer">
            <option value="empty">Kies een brouwerij...</option>
            <?php foreach($arrTableRows as $row) : ?>
            <option value="<?= $row["brouwernr"] ?>" <?php if($arrBeerRowsExists) : ?>
                <?php if( $brouwernummer == $row['brouwernr'] ) { echo 'selected';} ?>
                <?php endif ?>><?= $row["brnaam"] ?>
            </option>
            <?php endforeach ?>
        </select>
        
        <input type="submit" name="submit" value="Geef mij alle bieren van deze brouwerij">
        
    </form>
    
    <?php if($arrBeerRowsExists) : ?>
    <table>
        
        <thead>
            <tr>
                <th>#</th>
                <th>naam</th>
            </tr>
        </thead>
        
        <tbody>
            
            <?php foreach($arrBeerRows as $row) : ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $row["naam"] ?></td>
            </tr>
            <?php endforeach ?>
            
        </tbody>
        
        
        
    </table>
    <?php endif ?>
    
</body>
</html>
