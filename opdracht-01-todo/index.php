<?php

function __autoload ( $className ){
    include "classes/".$className.".php";
}

session_start();
//test voor de klasse
//$todo = new Todo("schilderen", "not_done");

//onderstaande bool is true als er geen todo's zijn (dan moet de eerste p zichtbaar zijn), deze wordt false van zodra er een waarde in de array steekt
$emptyTodoList = true;


$emptyNotDone = false;
$emptyDone = true;


//alles in één grote array steken
$todo_array = array();

if(isset($_POST["toevoegen"])) {    
    
    if(isset($_SESSION["todos_array"])) {
        $todo_array = $_SESSION["todos_array"];
    }
    $todo_array[] = new Todo($_POST["new_todo"], "not_done");
    $_SESSION["todos_array"] = $todo_array;
}

if(isset($_POST["toggleToDo"])) {
    $indexOfToggledToDo = $_POST["toggleToDo"];
    //echo $indexOfToggledToDo;
    $todo_array = $_SESSION["todos_array"];
    //changeStatus van aangeklikte todo aanroepen om de status te veranderen
    $todo_array[$indexOfToggledToDo]->changeStatus();
}

if(isset($_POST["deleteToDo"])) {
    $indexOfDeletion = $_POST["deleteToDo"];
    $todo_array = $_SESSION["todos_array"];
    unset($todo_array[$indexOfDeletion]);
    $_SESSION["todos_array"] = $todo_array;
}


if(count($todo_array) > 0) {
    $emptyTodoList = false;
}

//checken of er nog waarden in de not_done lijst staan (als deze leeg is = schouderklopje)
foreach($todo_array as $value) {
    if($value->getStatus() == "not_done") {
        $emptyNotDone = false;
        break;
    }
    $emptyNotDone = true;
}

//checken of er nog waarden in de done lijst staan (als deze leeg is = werk aan de winkel)
foreach($todo_array as $value) {
    if($value->getStatus() == "done") {
        $emptyDone = false;
        break;
    }
    $emptyDone = true;
}



if(isset($_POST["delete"])) {
    session_destroy();
}


?>




<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Opdracht 01 - TODO</title>
    <link href="style-todo.css" type="text/css" rel="stylesheet">
</head>
<body>
    
    <h1>TODO app</h1>
    
    <?php if($emptyTodoList) : ?>
    <!-- onderstaande is enkel zichtbaar indien er nog geen één todo is -->
    <p>Je hebt nog geen TODO's toegevoegd. Zo weinig werk of meesterplanner?</p>
    <?php endif ?>

    
    <?php if($emptyTodoList == false) : ?>
    <div>
    <h2>Nog te doen</h2>
    <ul>
        <!-- hierin komt een foreach die voor elke waarde in de array $todo_array waarvan de status not done is, een list element met form en button's in gaat maken -->
        <?php if($emptyTodoList == false) :foreach($todo_array as $id => $value) : if($value->getStatus() == "not_done") : ?>
        <li>
            <form action="index.php" method="post">
                <button title="Status wijzigen" name="toggleToDo" value="<?php echo ($id) ?>" class="status not_done"><?php echo $value->getName() ?></button>
                <button title="Verwijderen" name="deleteToDo" value="<?php echo ($id) ?>">x</button>
            </form>
        </li>
        <?php endif; endforeach; endif?>
    </ul>
    
    <!--onderstaande mag alleen zichtbaar zijn als er geen not done's meer zijn, alleen maar done's -->
    <?php if($emptyTodoList == false && $emptyNotDone) : ?>
    <p>Schouderklopje, alles is gedaan!</p>
    <?php endif ?>
    
    <h2>Done and done!</h2>
    <ul>
        <!-- hierin komt een foreach die voor elke waarde in de array $todo_array waarvan de status done is, een list element met form en button's in gaat maken -->
        <?php foreach($todo_array as $id => $value) : if($value->getStatus() == "done") : ?>
        <li>
            <form action="index.php" method="post">
                <button title="Status wijzigen" name="toggleToDo" value="<?php echo ($id) ?>" class="status done"><?php echo $value->getName() ?></button>
                <button title="Verwijderen" name="deleteToDo" value="<?php echo ($id) ?>">x</button>
            </form>
        </li>
        <?php endif; endforeach ?>
    </ul>
    
    <!-- onderstaande mag alleen zichtbaar zijn als er wel not done's zijn, maar nog geen done's -->
    <?php if($emptyTodoList == false && $emptyDone) : ?>
    <p>Werk aan de winkel...</p>
    <?php endif ?>
    
    </div>
    <?php endif ?>
    
    
    <h1>TODO toevoegen</h1>
    
    <form action="index.php" method="post">
        
        <div>
            <label for="new_todo">Beschrijving: </label>
            <input type="text" id="new_todo" name="new_todo">
        </div>
        
        <input type="submit" id="toevoegen" name="toevoegen" value="Toevoegen">
        
    </form>
    <?php if($emptyTodoList == false) : ?>
    <form action="index.php" method="post">
        <input type="submit" id="delete" name="delete" value="Verwijder alle todo's">
    </form>
    <?php endif ?>
    
    <!-- testcode voor de klasse -->
    <!--
    <p><?= $todo->getName() ?></p>
    <p><?= $todo->getStatus() ?></p>
    <p><?php $todo->changeStatus() ?></p>
    <p><?= $todo->getStatus() ?></p>
    -->
</body>
</html>