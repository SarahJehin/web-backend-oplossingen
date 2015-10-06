<!-- Sarah Jehin -->

<?php


// Eerste probeersel
function jaarlijkse_waarde1($jaar) {
    
    static $nieuwe_waarde    = 100000;
    $rentevoet               = 8;
    
    if($jaar != 10) {
        $nieuwe_waarde = floor($nieuwe_waarde+($nieuwe_waarde*$rentevoet/100));
        echo $nieuwe_waarde.", ";
        $jaar++;
        jaarlijkse_waarde1($jaar);
    }
}

// Tweede probeersel
function jaarlijkse_waarde2($huidig_jaar, $beginwaarde, $rentevoet, $totaal_jaren) {
    
    $nieuwe_waarde   = $beginwaarde;
    
    if($huidig_jaar != $totaal_jaren) {
        $nieuwe_waarde = floor($nieuwe_waarde+($nieuwe_waarde*$rentevoet/100));
        echo $nieuwe_waarde.", ";
        $huidig_jaar++;
        jaarlijkse_waarde2($huidig_jaar, $nieuwe_waarde, $rentevoet, $totaal_jaren);
    }
}

//$waardes_alle_jaren = jaarlijkse_waarde2(0, 100000, 8, 10);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing functions recursive deel 1</title>
</head>
<body>
   
   <p>Beginwaarde is €100000, stjging per jaar = <?= jaarlijkse_waarde1(0); ?></p>
   
   <p>Beginwaarde is €100000, stjging per jaar = <?= jaarlijkse_waarde2(0, 100000, 8, 10) ?></p>
    
</body>
</html>


