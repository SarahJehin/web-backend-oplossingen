<?php

$messageContainer = "";
static $count = 1;

try {
    
    //connectie maken - instantie van de databse maken, paramters: host, dbname, login, paswoord  (bij paswoord moet er blijkbaar niets staan bij mij)
    $db = new PDO('mysql:host=localhost;dbname=bieren', 'root', '');
    $messageContainer = "Connectie geslaagd";
    
    //query definiëren
    $queryString = 'select *
                    from bieren
                    JOIN brouwers
                    on(bieren.brouwernr = brouwers.brouwernr)
                    WHERE bieren.naam like "du%" and brouwers.brnaam LIKE "%a%"';
    
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
    <title>Oplossing CRUD query</title>
    
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
    
    <p><?php echo $messageContainer ?></p>
    
    <!-- test -->
    <!--
    <ul>
        <?php foreach($arrTableRows as $row) : ?>
        <li>Naam is <?php echo $row["naam"] ?> en adres is <?php echo $row["adres"] ?></li>
        <?php endforeach ?>
    </ul>
    -->
    
    <table>
        
        <thead>
            <tr>
                <th>#</th>
                <th>biernr (PK)</th>
                <th>naam</th>
                <th>brouwernr</th>
                <th>soortnr</th>
                <th>alcohol</th>
                <th>brnaam</th>
                <th>adres</th>
                <th>postcode</th>
                <th>gemeente</th>
                <th>omzet</th>
            </tr>
        </thead>
        
        <tbody>
            
            <?php foreach($arrTableRows as $row) : ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $row["biernr"] ?></td>
                <td><?= $row["naam"] ?></td>
                <td><?= $row["brouwernr"] ?></td>
                <td><?= $row["soortnr"] ?></td>
                <td><?= $row["alcohol"] ?></td>
                <td><?= $row["brnaam"] ?></td>
                <td><?= $row["adres"] ?></td>
                <td><?= $row["postcode"] ?></td>
                <td><?= $row["gemeente"] ?></td>
                <td><?= $row["omzet"] ?></td>
            </tr>
            <?php endforeach ?>
            
        </tbody>
        
        
        
    </table>
    
    
</body>
</html>








