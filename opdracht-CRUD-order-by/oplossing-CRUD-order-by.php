<?php

//$ascending = true;

try {
    
    $db = new PDO('mysql:host=localhost;dbname=bieren', 'root', '');
    
    //standaard staat je tabel alfabetisch (asc) gesorteerd op je PK (biernr)
    $sort_column = "bieren.biernr";
    $sort_asc_desc = "asc";
    
    //je moet checken of de get variabele geset is en op welke kolom en op welke waarde (asc of desc), dan moet je op basis daarvan een query gaan uitvoeren
    if(isset($_GET["sort"])) {
                                 //explode(delimiter, oorspronkelijke string
        $arrOfSortingDefinition = explode("-", $_GET["sort"]);
        $sort_column = $arrOfSortingDefinition[0];
        $sort_asc_desc = $arrOfSortingDefinition[1];
        //echo($sort_column.$sort_asc_desc);
        //var_dump($arrOfSortingDefinition);
    }
  
    //in de query ga je bij order by dan zeggen op welke kolom en hoe hij gesorteerd moet worden
    $query_select_all = "SELECT bieren.biernr, bieren.naam, brouwers.brnaam, soorten.soort, bieren.alcohol  FROM `bieren`
                        join brouwers
                        on(bieren.brouwernr = brouwers.brouwernr)
                        join soorten
                        on(bieren.soortnr = soorten.soortnr)
                        order by " . $sort_column . " " . $sort_asc_desc;
    
    
    $statement_select_all = $db->prepare($query_select_all);
    
    $statement_select_all->execute();
    
    //je sort "type" moet dan geswitcht worden, want je hebt er op geklikt, dus hij is nu anders gesorteerd (hij kan alleen descending worden als het de huidige kolom is)
    //als er dus desc in de querystring staat, ga je van $sort_asc_desc -> asc maken (dit is niet zichtbaar voor de mensen) --> ga je vanonder in tr th nog nodig hebben
    //als beneden $sort_asc_desc = asc is, dan ga je descending als class printen, wat dus met de oorspronkelijke waarde van in de querystring overeen komt
    //hieronder ga je de $sort_asc_desc dus eigenlijk altijd klaarzetten voor de volgende klik (het zal dus constant wisselen tussen asc - desc - asc - desc ...
    //KORTWEG : als er dus desc in de querystring staat, ga je van $sort_asc_desc -> asc maken --> klaarzetten voor volgende klik
    if(isset($_GET["sort"])) {
			$sort_asc_desc = ($arrOfSortingDefinition[1] != "desc") ? "desc" : "asc";
		}
    
    $arrBieren = array();
    
    //alle rijen gaan opvangen en in de array steken
    while( $row = $statement_select_all->fetch(PDO::FETCH_ASSOC) )
    {
        //elke rij toevoegen aan de array
        $arrBieren[]	=	$row;
    }
    //var_dump($arrBieren);
    
    $arrEchteKolomnamen = kolomnamenVoorTabel(array_keys($arrBieren[0]));
    

    
    
}
catch( PDOException $e )
{
    $messageContainer	=	'Er ging iets mis: ' . $e->getMessage();
}



//onderstaande functie gaat de kolomnamen van de database omzetten naar de gewenste kolomnamen in de tabel op de pagina
function kolomnamenVoorTabel ( $arrRuweKolomnamen) {
    
    //var_dump($arrRuweKolomnamen);
    $arrEchteKolomnamen = array();
    
    for($index = 0; $index < count($arrRuweKolomnamen); $index++) {
        switch ($arrRuweKolomnamen[$index]) {
            case "biernr":
                $arrEchteKolomnamen[$index] = "Biernummer (PK)";
                break;
            case "naam":
                $arrEchteKolomnamen[$index] = "Bier";
                break;
            case "brnaam":
                $arrEchteKolomnamen[$index] = "Brouwer";
                break;
            case "soort":
                $arrEchteKolomnamen[$index] = "Soort";
                break;
            case "alcohol":
                $arrEchteKolomnamen[$index] = "Alcoholpercentage";
                break;
            default:
                $arrEchteKolomnamen[$index] = "Not known";
                break;
        }
        
    }
    //var_dump($arrEchteKolomnamen);
    return $arrEchteKolomnamen;
}



//echo($sort_asc_desc.$sort_column);

?>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing CRUD order by</title>
    
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
        
        th a {
            color: #414141;
        }
        
        th a:hover {
            color: #4660aa;
        }
        
        thead tr {
            background-color: #ddd;
        }
        
        tbody tr:nth-child(odd) {
            background-color: #F1F1F1;
        }
        
        .order a
        {
            padding-right:20px;
            background-repeat:no-repeat;
            background-position:right;
        }
        
        .ascending a
        {
            background-image: url("icon-asc.png");
        }

        .descending a
        {
            background-image: url("icon-desc.png");
        }
        
    </style>
    
</head>
<body>
   
   <h2>Oplossing CRUD order by</h2>
   
   
   <table>
      
       <thead>
           <tr>
               <!--de $sort_asc_desc hieronder is altijd die van de volgende waarde (de beginwaarde is dus eigenlijk desc, want standaard zet je 'm op asc (line 11), maar op line 41 ga je 'm al switchen naar desc (de volgende waarde dus) Maar hoe komt het dan dat de class van th van de PK standaard op ascending staat ipv descending terwijl de 2 voorwaarden van de if toch kloppen?-->
              <?php for($column = 0; $column < count($arrBieren[0]); $column++) : ?>
               <th class="order <?= ($sort_asc_desc == "asc" && $sort_column == (array_keys($arrBieren[0])[$column]))? 'descending' : 'ascending' ?>"><a href="oplossing-CRUD-order-by.php?sort=<?php echo(array_keys($arrBieren[0])[$column]."-"); echo($sort_asc_desc); ?>"><?php echo($arrEchteKolomnamen[$column])?></a></th>
               <?php endfor ?>
           </tr>
       </thead>
       
       <tbody>
           <?php foreach($arrBieren as $bier) : ?>
           <tr>
               <td><?= $bier["biernr"] ?></td>
               <td><?= $bier["naam"] ?></td>
               <td><?= $bier["brnaam"] ?></td>
               <td><?= $bier["soort"] ?></td>
               <td><?= $bier["alcohol"] ?></td>
           </tr> 
           <?php endforeach ?>
       </tbody>
       
   </table>
   
    
</body>
</html>








