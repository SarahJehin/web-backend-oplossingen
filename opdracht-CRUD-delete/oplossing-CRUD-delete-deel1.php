<?php

$deleteOKMessage = "";

try {
    
    $db = new PDO('mysql:host=localhost;dbname=bieren', 'root', '');
    
    if(isset($_POST["delete"])) {
        //echo "yayaya";
        
        $selected_id = $_POST["delete"];
        //echo $selected_id;
        
        //hieronder wordt brnaam id en moet er ook nog een placeholder gemaakt worden
        $queryDeleteBrouwer = "DELETE FROM `brouwers` WHERE brouwernr = :brouwernummer";
        
        $statement_delete = $db->prepare($queryDeleteBrouwer);
        
        $statement_delete->bindValue(":brouwernummer", $selected_id);
        
        /* //werkt niet op deze manier.
        try {
            $statement_delete->execute();
            
            $deleteOKMessage = "De datarij werd goed verwijderd";
        }
        
        catch (MySQLException $e) {
            $deleteOKMessage = "De datarij kon niet verwijderd worden. Probeer opnieuw. " . $e->getMessage();
        }*/
        
        //varaiable aanmaken waarin je gaat bewaren of de uitvoering gelukt (http://php.net/manual/en/pdostatement.execute.php)
        $delete_ok = $statement_delete->execute();
        
        if($delete_ok) {
            $deleteOKMessage = "De datarij werd goed verwijderd";
        }
        else {
            //als het niet gelukt is -> custom message + details over de fout (http://php.net/manual/en/pdo.errorinfo.php)
            $deleteOKMessage = "De datarij kon niet verwijderd worden. Omwille van: " . $statement_delete->errorInfo()[2];;
        }
        
    }
    
    //onderstaande ga je pas na je delete uitvoeren, zodat je de recentste versie van je tabel krijgt zonder je pagina te refreshen
    $querySelectBrouwers = "SELECT * FROM `brouwers`";
    
    $statementSelect = $db->prepare($querySelectBrouwers);
    $statementSelect->execute();
    
    $arrBieren = array();
    
    //alle rijen gaan opvangen en in de array steken
    while( $row = $statementSelect->fetch(PDO::FETCH_ASSOC) )
    {
        //elke rij toevoegen aan de array
        $arrBieren[]	=	$row;
    }
    //var_dump($arrBieren);
    
}
catch( PDOException $e )
{
    $messageContainer	=	'Er ging iets mis: ' . $e->getMessage();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing CRUD delete deel 1</title>
    
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
        
        td input[type="submit"] {
            background-image: url(icon-delete.png);
            content: "";
            color: rgba(0, 0, 0, 0);
            width: 20px;
            cursor: pointer;
        }
        
        
        
        
        
    </style>
</head>
<body>
   
   <h1>Oplossing CRUD delete deel 1</h1>
   
   <p><?= $deleteOKMessage ?></p>
   
   <table>
       
       <thead>
           <tr>
              <!-- http://php.net/manual/en/function.array-keys.php -->
              <?php for($column = 0; $column < count($arrBieren[0]); $column++) : ?>
               <th><?php echo(array_keys($arrBieren[0])[$column]) ?></th>
               <?php endfor ?>
               <th></th>
           </tr>
       </thead>
       
       <tbody>
           <?php foreach($arrBieren as $bier) : ?>
           <tr>
               <td><?= $bier["brouwernr"] ?></td>
               <td><?= $bier["brnaam"] ?></td>
               <td><?= $bier["adres"] ?></td>
               <td><?= $bier["postcode"] ?></td>
               <td><?= $bier["gemeente"] ?></td>
               <td><?= $bier["omzet"] ?></td>
               <td><abbr title="Verwijderen"><form method="post" action="oplossing-CRUD-delete-deel1.php"><input type="submit" name="delete" value="<?=$bier['brouwernr']?>"></form></abbr></td>
           </tr> 
           <?php endforeach ?>
       </tbody>
       
   </table>
    
</body>
</html>