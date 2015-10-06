<!-- Sarah Jehin -->

<?php

$text                           = file_get_contents("text-file.txt");
$text_chars                     = str_split($text);
$text_chars_sorted_backwards    = $text_chars;

arsort($text_chars_sorted_backwards);

$text_chars_sorted_reversed     = array_reverse($text_chars_sorted_backwards);

$array_unique_chars             = array();
$array_amount_each_char         = array();


foreach($text_chars_sorted_reversed as $value) {
    if(!in_array($value, $array_unique_chars)) {
        $array_unique_chars[] = $value; //een array aanmaken om te bepalen hoeveel verschillende karakters er in totaal voorkomen
        $array_amount_each_char[$value] = 1; //als de value "r" is wordt in deze array het aantal keer r op 1 gezet (want het is de eerste keer dat je hem tegenkomt)
    }
    else {
        $array_amount_each_char[$value]++; //elke volgende keer dat je de r tegenkomt ga je het aantal van "r" verhogen met 1
    }
}

$unique_chars                   = count($array_unique_chars);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing looping statement foreach deel 1</title>
</head>
<body>
   
   <p>Aantal unieke karakters in de tekst: <?= $unique_chars ?></p>
   
   <p>Alle karakters + hoe vaak ze voorkomen:</p>
   <p><?= var_dump($array_amount_each_char) ?></p>
    
</body>
</html>


