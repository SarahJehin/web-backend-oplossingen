<!-- Sarah Jehin -->

<?php

$boodschappenlijstje = array("melk", "kaas", "koekjes", "kreem");
$index = 0;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing looping statements while 2</title>
</head>
<body>
  <!-- eerste mogelijkheid, maar mix van php en html mag eigenlijk niet:--> <!--
   <ul>
   <?php /*while($index < count($boodschappenlijstje)) {
        echo "<li>".$boodschappenlijstje[$index]."</li>"; //enige probleem is nog dat het li element binnen de php staat...
        $index++;
} */?>
   </ul>-->
    
    <!-- Tweede mogelijkheid -->
    
    <ul>
   <?php while($index < count($boodschappenlijstje)) : ?>
        <li><?= $boodschappenlijstje[$index]?></li>
        <?php $index++; endwhile; ?>
   </ul>
    
</body>
</html>


