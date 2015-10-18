<?php

/*$currentTime = time();
$nextWeek = time() + (7 * 24 * 60 * 60);

echo $currentTime."<br>";
echo $nextWeek;*/

//create the date
$date = new DateTime("1904-01-21 22:35:25");
//create a timestamp of the date
//echo date_timestamp_get($date);

//21 January 1904, 10:35:25 pm //http://php.net/manual/en/function.date.php
$date2 = date("d F Y, h:i:s \p\m", date_timestamp_get($date));
//echo $date2;

//echo "<br>";

//deel 2 in het Nederlands
setlocale(LC_ALL, 'nld_nld');
$dateDutch = strftime("%d %B %Y, %H:%M:%S", date_timestamp_get($date));
//echo strftime("%d %B %Y, %H:%M:%S", date_timestamp_get($date));

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing date: deel1 en deel2</title>
</head>
<body>
   
   <p>Date in English: <?= $date2 ?></p>
   <p>Datum in het Nederlands: <?= $dateDutch ?></p>
    
</body>
</html>