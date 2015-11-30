<?php

$deleteOKMessage = "";
$show_confirmation = false;
$show_edit = false;
$no_results = false;
$no_results_message = "";
$updateOKMessage = "";

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
            $deleteOKMessage = "De datarij kon niet verwijderd worden. Omwille van: " . $statement_delete->errorInfo()[2];
        }
        
    }
    
    if(isset($_POST["no_delete"])) {
        $show_confirmation = false;
    }
    
    
    if(isset($_POST["edit_info"])) {
        //echo "you want to edit something?";
        $show_edit = true;
        $edit_brouwernummer = $_POST["edit_info"];
        //hier moet een select inkomen die alle waarden van de aangeklikte rij selecteert
        $query_select_edit_brouwer = "SELECT * FROM `brouwers` WHERE brouwernr = :brouwernummer";
        
        $statement_select_edit_brouwer = $db->prepare($query_select_edit_brouwer);
        $statement_select_edit_brouwer->bindValue(":brouwernummer", $edit_brouwernummer);
        
        $statement_select_edit_brouwer->execute();
        
        //de waarden van de geselecteerde brouwer gaan opslagen in een variabele:
        $selected_brouwer = $statement_select_edit_brouwer->fetch(PDO::FETCH_ASSOC);
        
        //gaan checken of de brouwer bestaat
        if($selected_brouwer) {  
            //okay
        }
        else {
            $no_results = true;
            $no_results_message = "Brouwerij werd niet gevonden. Probeer opnieuw.";
        }
        
        //echo $selected_brouwer["brnaam"];
        
    }
    
    
    if(isset($_POST["edit"])) {
        //echo "update in progress";
        
        $id_to_update = $_POST["brouwernummer"];
        
        $query_update_brouwer = "UPDATE brouwers 
                                        SET     brnaam      = :brnaam,
                                                adres       = :adres,
                                                postcode    = :postcode,
                                                gemeente    = :gemeente,
                                                omzet       = :omzet
                                        WHERE brouwernr = :brouwernr";
        
        $statement_update = $db->prepare($query_update_brouwer);
        
        $statement_update->bindValue(":brouwernr", $id_to_update);
        $statement_update->bindValue(":brnaam", $_POST["brnaam"]);
        $statement_update->bindValue(":adres", $_POST["adres"]);
        $statement_update->bindValue(":postcode", $_POST["postcode"]);
        $statement_update->bindValue(":gemeente", $_POST["gemeente"]);
        $statement_update->bindValue(":omzet", $_POST["omzet"]);
        
        
        $update_ok = $statement_update->execute();
        
        if($update_ok) {
            $updateOKMessage = "Aanpassing succesvol doorgevoerd!";
        }
        else {
            //als het niet gelukt is -> custom message + details over de fout (http://php.net/manual/en/pdo.errorinfo.php)
            $updateOKMessage = "Aanpassing is niet gelukt. Probeer opnieuw of neem contact op met de systeembeheerder wanneer deze fout blijft aanhouden";
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
    <title>Oplossing CRUD update deel 1</title>
    
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
        
         
        .update_box {
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
            background-color: rgba(255, 255, 255, 0);
            content: "";
            color: rgba(0, 0, 0, 0);
            width: 16px;
            cursor: pointer;
            border: none;
        }
        
        td input[name="delete_confirmation"] {
            background-image: url(icon-delete.png);
        }
        
        td input[name="edit_info"] {
            background-image: url(icon-edit.png);
        }
        
        tbody tr.selected_delete {
            color: #b94a48;
            background-color: #f2dede;
        }    
        
        
        form div label {
            display: block;
        }
        
        input[name="edit"] {
            margin-top: 20px;
        }
        
        
       
        
        
        
    </style>
</head>
<body>
   
   <h1>Oplossing CRUD update deel 1</h1>
   
   <?php if($updateOKMessage != "") : ?>
   <?php if($update_ok) : ?>
   <p><?= $updateOKMessage ?></p>
   <?php else : ?>
    <p>Aanpassing is niet gelukt. Probeer opnieuw of neem contact op met de <a href="mailto:sarah.jehin@student.kdg.be">systeembeheerder</a> wanneer deze fout blijft aanhouden</p>
    <?php endif; endif; ?>
   
   <div class="update_box <?php if($show_edit) { echo "show"; } ?>">
       
       <?php if(!$no_results) : ?>
       
       <h2>Brouwerij <?= $selected_brouwer["brnaam"]." ( #".$selected_brouwer["brouwernr"]." )" ?>  wijzigen</h2>
       
       <form method="post" action="oplossing-CRUD-update-deel1.php">
           
           
           <?php for($column = 1; $column < count($arrBieren[0]); $column++) : $columnName = array_keys($arrBieren[0])[$column]; ?>
               
               <div>
                   <label for="<?= $columnName ?>"><?= $columnName ?>:</label>
                   <input type="text" name="<?= $columnName ?>" id="<?= $columnName ?>" value="<?= $selected_brouwer[$columnName] ?>">
               </div>
               
            <?php endfor ?>
            <!-- je gaat een input hidden nodig hebben om je id(PK) in op te slagen, want dit is het enige echte unieke waaraan je de geupdate brouwerij kan herkennen -->
           <input type="hidden" name="brouwernummer" value="<?= $selected_brouwer["brouwernr"] ?>">
           <input type="submit" name="edit" value="Wijzigen">
           
       </form>
       
       <?php else : ?>
       
       <p><?= $no_results_message ?></p>
       
       <?php endif; ?>
       
   </div>
   
   
   
   <h2>Overzicht van de brouwers:</h2>
   
   <p><?= $deleteOKMessage ?></p>
   
   <div class="confirmation <?php if($show_confirmation) { echo "show"; } ?>">
       <p>Bent u zeker dat u deze datarij wil verwijderen?</p>
       <form method="post" action="oplossing-CRUD-update-deel1.php">
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
               <td><abbr title="Verwijderen"><form method="post" action="oplossing-CRUD-update-deel1.php"><input type="submit" name="delete_confirmation" value="<?=$bier['brouwernr']?>"></form></abbr></td>
               <td><abbr title="Wijzigen"><form method="post" action="oplossing-CRUD-update-deel1.php"><input type="submit" name="edit_info" value="<?=$bier['brouwernr']?>"></form></abbr></td>
           </tr> 
           <?php endforeach ?>
       </tbody>
       
   </table>
    
</body>
</html>