<!-- Sarah Jehin -->

<?php

//alle gegevens:
$huidig_jaar = 0;
$aantal_jaren = 10;
$rentevoet = 8;
$beginbedrag = 100000;
$bedragen_lijst = array();

//array met alle gegevens in: huidig jaar, aantal jaren, rente, beginbedrag, array van vorige kapitalen
$gegevens_hans = array("huidig_jaar" => $huidig_jaar, "aantal_jaren" => $aantal_jaren, "rentevoet" => $rentevoet, "huidig_bedrag" => $beginbedrag, "bedragen_lijst" => $bedragen_lijst);

//dubbel werk gedaan door variabele $nieuw_bedrag en huidig_jaar aan te maken --> maar is zo duidelijker voor mij
function winst_berekenen($array_gegevens) {
    $nieuw_bedrag = $array_gegevens["huidig_bedrag"];
    $huidig_jaar = $array_gegevens["huidig_jaar"];
    
    if($huidig_jaar != $array_gegevens["aantal_jaren"]) {
        $rente = floor($nieuw_bedrag*$array_gegevens["rentevoet"]/100);
        $nieuw_bedrag += $rente;
        $array_gegevens["huidig_bedrag"] = $nieuw_bedrag;
        $array_gegevens["bedragen_lijst"][$huidig_jaar] = "Huidige bedrag = ".$nieuw_bedrag." (= +".$rente." tov vorige bedrag)";
        $array_gegevens["huidig_jaar"]++;
        return winst_berekenen($array_gegevens);
    }
    else {
        return $array_gegevens;
    }
}

$bedragen_hans = winst_berekenen($gegevens_hans);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing functions recursive deel 1</title>
</head>
<body>
   
   <ul><?php foreach($bedragen_hans["bedragen_lijst"] as $value): ?>
       <li><?= $value ?></li>
       <?php endforeach ?>
   </ul>
   
    
</body>
</html>