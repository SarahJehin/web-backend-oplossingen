<?php

$deleteOKMessage = "";
$show_confirmation = false;

try {
    
    $db = new PDO('mysql:host=localhost;dbname=bieren', 'root', '');
    
    
    if(isset($_POST["delete_confirmation"])) {
        
        $id_to_delete = $_POST["delete_confirmation"];
        $show_confirmation = true;
    }
    
    if(isset($_POST["delete"])) {
        //echo "yayaya";
        
        $selected_id = $_POST["delete"];
        //echo $selected_id;
        
        //hieronder wordt brnaam id en moet er ook nog een placeholder gemaakt worden
        $queryDeleteBrouwer = "DELETE FROM `brouwers` WHERE brouwernr = :brouwernummer";
        
        $statement_delete = $db->prepare($queryDeleteBrouwer);
        
        $statement_delete->bindValue(":brouwernummer", $selected_id);
        
        /*
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
    
    if(isset($_POST["no_delete"])) {
        $show_confirmation = false;
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
    <title>Oplossing CRUD delete deel 2</title>
    
    <style>
        
        body {
            font-family: "Calibri", sans-serif;
        }
        
        h1 {
            border-bottom: 1px #ccc solid;
        }
        
        .confirmation {
            color: #b94a48;
            background-color: #f2dede;
            border: 1px solid #eed3d7;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
        
        .show {
            display: block;
        }
        
        .confirmation p {
            margin: 0;
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
        
        tbody tr.selected_delete {
            color: #b94a48;
            background-color: #f2dede;
        }       
        
        
        
    </style>
</head>
<body>
   
   <h1>Oplossing CRUD delete deel 2</h1>
   
   <p><?= $deleteOKMessage ?></p>
   
   <div class="confirmation <?php if($show_confirmation) { echo "show"; } ?>">
       <p>Bent u zeker dat u deze datarij wil verwijderen?</p>
       <form method="post" action="oplossing-CRUD-delete-deel2.php">
           <button type="submit" name="delete" value="<?= $id_to_delete ?>">Ja!</button>
           <button type="submit" name="no_delete" value="">Néééééé</button>
       </form>
   </div>
   
   
   <table>
       
       <thead>
           <tr>
              <?php for($column = 0; $column < count($arrBieren[0]); $column++) : ?>
               <th><?php echo(array_keys($arrBieren[0])[$column]) ?></th>
               <?php endfor ?>
               <th></th>
           </tr>
       </thead>
       
       <tbody>
           <?php foreach($arrBieren as $bier) : ?>
           <tr class="<?php if($show_confirmation && $bier["brouwernr"] == $id_to_delete) {echo "selected_delete";} ?>">
               <td><?= $bier["brouwernr"] ?></td>
               <td><?= $bier["brnaam"] ?></td>
               <td><?= $bier["adres"] ?></td>
               <td><?= $bier["postcode"] ?></td>
               <td><?= $bier["gemeente"] ?></td>
               <td><?= $bier["omzet"] ?></td>
               <td><abbr title="Verwijderen"><form method="post" action="oplossing-CRUD-delete-deel2.php"><input type="submit" name="delete_confirmation" value="<?=$bier['brouwernr']?>"></form></abbr></td>
           </tr> 
           <?php endforeach ?>
       </tbody>
       
   </table>
    
</body>
</html>