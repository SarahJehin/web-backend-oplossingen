<?php

$view_result = false;

if(isset($_POST["submit"])) {
    
    if($_POST["regex"] != "" && $_POST["string"] != "") {
        $character_to_replace = $_POST["regex"];
        $string = $_POST["string"];

        // met preg replace gaan werken: preg_replace($regEx, $replaceString, $searchString);
        $result = preg_replace("/".$character_to_replace."/", "<span class='replacer'>#</span>", $string);
    }
    else {
        $result = "Gelieve beide velden in te vullen";
    }
    
    //echo($result);
    $view_result = true;
    
}



?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oplossing REGEX</title>
    <style>
        body {
            font-family: "Calibri", sans-serif;
        }
        
        h1 {
            border-bottom: 1px #ccc solid;
        }
        
        div label {
            display: block;
        }
        
        textarea {
            width: 300px;
            height: 100px;
        }
        
        
        span.replacer {
            color: red;
            font-weight: bold;
        }
        
        li {
            padding: 5px;
            margin-bottom: 5px;
        }
        
        span.regex {
            background-color: #1e5719;
            color: #a5d999;
            padding: 5px;
            margin-right: 20px;
            border-radius: 5px;
        }
        
    </style>
    
</head>
<body>
   
   <h1>Regex tester</h2>
   
   <form method="post" action="oplossing-regular-expressions.php">
       
       <div>
          <!-- hier ga je een letter ingeven die in de verwerkte zin vervangen wordt door een # -->
           <label for="regex">Regex:</label>
           <input type="text" name="regex" id="regex">
       </div>
       
       <div>
          <!-- hier ga je de zin schrijven waarvan je een letter wil vervangen-->
           <label for="string">String:</label>
           <textarea id="string" name="string"></textarea>
       </div>
       
       <input type="submit" name="submit" value="Test!">
       
   </form>
   
   <?php if($view_result) : ?>
   <p>Resultaat: <?php echo($result) ?></p>
   <?php endif ?>
   
   <!-- lijst aanmaken met verschillende regex uitvoeringen en hun resultaat -->
   
   <ul>
       <!-- match elke kleine a tot d, elke grote A tot D en elke kleine u-z en elke grote U-Z -->
       <li><span class="regex">[a-dA-Du-zU-Z]</span><span class="result">Memor# ##n #h#nge the sh#pe of # room; it ##n #h#nge the #olor of # ##r. #n# memories ##n #e #istorte#. The#'re j#st #n interpret#tion, the#'re not # re#or#, #n# the#'re irrele##nt if #o# h##e the f##ts.</span></li>
       
       <!-- match colour of (|) color -> haakjes () wijzen op een verzameling (?) -->
       <li><span class="regex">(colour|color)</span><span class="result">Zowel # als # zijn correct Engels.</span></li>
       
       <!-- match elke 1 gevolgd door 3 willekeurige nummers \d{3} -->
       <li><span class="regex">1\d{3}</span><span class="result"># # 9784 # 0231 # 8745</span></li>
       
       <!-- match elk zinsdeel dat er als volgt uit ziet: 2 nummer \d{2} gevolgd door ofwel een / (moet ge-escaped worden met \), - of . (moet ge-escaped worden, want staat anders voor elk karakter) (\/|-|\.), gevolgd door weer 2 nummers \d{2}, gevolgd door weer een /, - of . (\/|-|\.), gevolgd door 4 nummers \d{4} -->
       <li><span class="regex">\d{2}(\/|-|\.)\d{2}(\/|-|\.)\d{4}</span><span class="result"># en # en #</span></li>
       
   </ul>
   
   
   
   
    
</body>
</html>


