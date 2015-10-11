<?php

$articles = array("article1" => array("titel" => "Weet jij welk dier dit is?",
                                      "datum" => "6/10/15",
                                      "inhoud" => "In Thailand is een dier aangetroffen dat op een kruising lijkt tussen een krokodil en een buffel. Maar wat het precies is, schijnt niemand te weten.
Het bizarre dier, met een schubbige huid en een lange reptielachtige kaak, werd ontdekt in de provincie Sisaket. Het dier heeft de ledematen en hoeven van een zoogdier, zoals een buffel. Dorpelingen beweren dat het dier werd gebaard door een buffel die al gezonde nakomelingen heeft gehad. Dit dier stierf kort na de geboorte. Volgens de lokale nieuwssite Thai Rath geloven de locals dat het dier hen geluk zal brengen.",
                                      "afbeelding" => "img/which_animal.jpg",
                                      "afbeeldingBeschrijving" => "Foto van vreemd dier, mengeling tussen buffel en krokodil"),
                  
                  "article2" => array("titel" => "Goed geprobeerd: autodief rijdt de zee in om te ontsnappen aan politie",
                                      "datum" => "6/10/15",
                                      "inhoud" => "Een verdienstelijke poging, zonder meer: om te ontsnappen aan de politie reed deze Australiër in Perth recht de zee in. Een bizar einde van een achtervolging die bijna twee uur geduurd heeft.
Langs strand en duinen, de chauffeur van de Toyota Landcruiser wist de politie flink aan het lijntje te houden. Uiteindelijk waren het toch de agenten die aan het langste eind zouden trekken. Door zijn opvallende rijstijl was hij in eerste instantie in hun vizier beland, meer dan waarschijnlijk gaat het om een gestolen voertuig. Maar zelfs in het water gaf de vreemde vogel de strijd niet op: voor de dienders der wet zat er niets anders op dan ook een nat pak te halen. 

Een politiehelikopter hield de dolle capriolen intussen scherp in de gaten, met deze memorabele beelden als resultaat. Het gestolen voertuig werd uiteindelijk aan land getrokken.",
                                      "afbeelding" => "img/car_in_water.jpg",
                                      "afbeeldingBeschrijving" => "Foto van autodief die door politie uit water getrokken wordt"),
                  
                  "article3" => array("titel" => "Microsoft gaat slimme batterijen maken die véél langer meegaan, omdat ze zich aanpassen aan wat jij doet",
                                      "datum" => "4/10/2015",
                                      "inhoud" => "We weten allemaal hoe vervelend het is als de batterij van onze laptop het begeeft, natuurlijk nét als je toestel niet meer in garantie is. Maar een onderzoeksgroep van Microsoft wil daar verandering in brengen, door slimme batterijen te maken. Er zouden verschillende batterijen ingebouwd worden, gemaakt uit verschillende materialen. De ene zou dan bijvoorbeeld sneller leeglopen, maar meer kracht geven. En welke batterij gebruikt wordt, hangt af van wat je doet.
                                      Op dit moment is de werking van de batterij in je laptop redelijk simpel: je hebt een grote lithium-ion batterij die kracht levert aan je computer, als de hardware zegt dat dat nodig is. Als je dus een spelletje aan het spelen bent of een film bekijkt, dan zullen je processor en je grafische kaart aangeven dat ze meer elektrische power nodig hebben om het goed te laten verlopen. Maar als je bijvoorbeeld gewoon dit artikel aan het lezen bent, dan vraagt de processor maar een beetje kracht.
<br>
Om de levensduur van de batterijen te verlengen, werd tot nu toe vooral gefocust op het bouwen van batterijen met een hogere capaciteit. Alleen: onze computers hebben veel sneller meer elektrische capaciteit nodig dan onze batterijen verbeteren. En dat is waarom Microsoft een nieuwe oplossing bedacht.",
                                      
                                      "afbeelding" => "img/smart_battery.jpg",
                                      "afbeeldingBeschrijving" => "De uitvinders met hun batterijen")
                 );
                                      

//var_dump($_GET);
//var_dump($_GET["id"]);

/*
if(isset($_GET["id"])) {
    //toon volledige artikel (dus alle karakters)
    //lees meer link moet weg
    //titel in head tag moet weg
}*/

//dus variabele aanmaken om te controleren of het volledige artikel wordt weergeven:
$volledig_artikel = false;

$artikel_bestaat = true; //om te zien of het artikel bestaat

if(isset($_GET["id"])) { //je gaat het id ophalen uit de url, omdat je daar?id=blabla zet maak je een variabele id aan.
    $volledig_artikel = true;
    $huidig_artikel = $_GET["id"]; //je gaat de key van het huidige artikel ophalen
    //nu gaan checken of het een id is die in onze array voorkomt, zoeken op array  --> http://php.net/manual/en/function.array-key-exists.php
    if(array_key_exists ( $huidig_artikel , $articles )) {
        $articles = array($articles[$huidig_artikel]); //je hermaakt de array naar dat er maar 1 artikel in zit, hetgeen waarvan we de id hebben opgehaald, zo zal de foreach alleen dit meekrijgen als er een id ge-isset is
    }
    else {
        $artikel_bestaat = false;
    }
}
else {
    $volledig_artikel = false;
}


// Zoek functie  --> array doorzoeken en key returnen: http://php.net/manual/en/function.array-search.php, maar beter http://stackoverflow.com/questions/12315536/search-for-php-array-element-containing-string
//onderstaande werkt al voor hele zoekwoorden, maar nog niet voor halve woorden (bvb zoeken op auto geeft niets, maar op autodief geeft wel een resultaat)
if(isset($_GET["search"])) {
$searchword = $_GET["search"];
$matches = "";
    foreach($articles as $key1 => $keyVal){
        foreach($keyVal as $k=>$v) {
            if(preg_match("/\b$searchword\b/i", $v)) {
                $matches = $k;
                echo $matches." van ";
                echo $key1;
                header("Location: "."oplossing-get-deel1.php?id=".$key1);
            }
        }
    }
    //header("Location: "."oplossing-get-deel1.php?id=".$searchword);
}
//echo $matches;

/*if(isset($_GET["search"])) {
    //var_dump($_GET["search"]);
    $key_where_found = array_search ( $_GET["search"] , $articles[0] );
    var_dump( $key_where_found);
}*/

/*$arr = array("bla", "test", "zoek me");
$key_where_found = array_search($_GET["search"] , $arr );
var_dump( $key_where_found);


$array = array('blue', 'red', 'green', 'red');

$keyt = array_search('green', $array); 
//echo($keyt);*/

/*$example = array('An example','Another example','One Example','Last example');
$searchword = 'last';
$matches = "";
foreach($example as $k=>$v) {
    if(preg_match("/\b$searchword\b/i", $v)) {
        $matches = $k;
    }
}
echo $matches;*/


//test voor werking 2de foreach van array:
//$test_array = array("een", "twee", "drie", "vier");
//$test_array = array("eersteplaats" => "een", "tweedeplaats" => "twee", "derdeplaats" => "drie", "vierdeplaats" => "vier");


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php if(!$artikel_bestaat): ?>
    <title>Oplossing get deel 1 - artikel bestaat niet</title>
    <?php endif ?>
    <title>Oplossing get deel 1<?php if(isset($_GET["id"])) {echo " - ".$articles[0]["titel"];} ?></title>
    
    <style>
        
    body {
        font-family: "Calibri", sans-serif;
    }
    
    h1 {
        font-size: 3em;
        text-align: center;
        border-bottom: 2px #000 solid;
    }
        
    .artikels {
        width: 1250px;
        margin: 20px auto;
    }
        
    .artikel:nth-child(3) {
        margin-right: 0;
    }
    
    .artikel {
        background-color: #e5e5e5;
        float: left;
        width: 24%;
        margin-right: 25px;
        padding: 50px;
    }
    
    h2 {
        font-size: 2em;
        margin: 0;
        border-bottom: 1px solid #ccc;
    }
    
    .artikel img {
        width: 100%;
        height: auto;
        margin: 0;
    }
    
    p~p {
        font-size: 1.2em;
    }
    
    .artikel a {
        float: right;
        font-size: 1.2em;
    }
    
    .artikels::before, .artikels::after {
        line-height: 0;
        content: "";
        display: table;
    }
    
    .artikels::after {
        clear: both;
    }
    
    .volledig_artikel img {
        float: right;
        width: 35%;
        height: auto;
    }
    
    </style>
    
</head>
<body>
  
  <h1>Nieuwsoverzicht</h1>
   
   
   <?php if($artikel_bestaat) : ?>
   <div class="artikels">
       
       <!-- eigen probeersel --> <!-- voor elke // moet terug < ? php of < ? = komen zonder spaties
       //foreach($articles as $value): ?>
       <div class="artikel">
           <h2> //$value["titel"] ?></h2>
           <p> //$value["datum"] ?></p>
           <img src=" //$value["afbeelding"] ?>" alt=" //$value["afbeeldingBeschrijving"] ?>">
           <p> //substr($value["inhoud"], 0, 50) ?>...</p>
           <a href="oplossing-get-deel1.php?id=article1">Lees meer ></a>
       </div>
       <?php //endforeach ?>-->
       
       
       <!-- na uitleg van Pascal met 2de soort foreach adhv een key en een value http://php.net/manual/en/control-structures.foreach.php -->
       <?php foreach($articles as $key => $value): ?>
       <div class="<?php if(!$volledig_artikel) {echo "artikel";} else{echo "volledig_artikel";} ?>">
           <h2><?= $value["titel"] ?></h2>
           <p><?= $value["datum"] ?></p>
           <img src="<?= $value["afbeelding"] ?>" alt="<?= $value["afbeeldingBeschrijving"] ?>">
           <p><?php if(!$volledig_artikel/* || $_GET["id"] != $key*/) { echo substr($value["inhoud"], 0, 50)."...";} else if($_GET["id"] == $key) {echo $value["inhoud"];} ?></p>
           <?php if(!$volledig_artikel) : ?><a href="oplossing-get-deel1.php?id=<?=$key?>">Lees meer ></a> <?php endif ?>
       </div>
       <?php endforeach ?>
       
   </div>
   <?php else :?>
   <p>Dit artikel bestaat niet. Sorry!</p>
   <?php endif ?>
    
    <?php if(!$volledig_artikel) : ?>
    <form action="oplossing-get-deel1.php" method="get">
        <input type="search" name="search">
        <input type="submit" name="submit" value="Zoek">
    </form>
    <?php endif ?>
    
    
    <!-- test voor werking 2de foreach van array: -->
    <?php /*foreach($test_array as $key => $value): ?>
       <div>
           <p>Op plaats <?= $key ?> in de array staat de waarde <?= $value ?></p>
       </div>
       <?php endforeach */?>
    
</body>
</html>

