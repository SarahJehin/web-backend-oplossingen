<!-- Sarah Jehin -->


<?php


$rijen      = 10;
$kolommen   = 10;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing looping statement for deel 1</title>
    <style>
    
        td {
            border: 1px solid black;
            padding: 20px;
        }
    
    </style>
</head>
<body>
   
   <table>
       <!-- use php together with html: http://stackoverflow.com/questions/10258345/php-simple-foreach-loop-with-html -->
       <!-- use php together with html: http://www.onlamp.com/pub/a/php/2001/05/03/php_foundations.html -->
      
        <?php for($rijnummer = 0; $rijnummer <= $rijen; $rijnummer++) : ?>
            <tr>
                <?php for($kolomnummer = 0; $kolomnummer <= $kolommen; $kolomnummer++) : ?>
                <td>kolom</td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
       
       
   </table>
    
</body>
</html>

