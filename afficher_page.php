<?php 

session_start();

$id = filter_input(INPUT_GET, "group_id", FILTER_VALIDATE_INT);


// Page accessible seulement si $_SESSION["connecte"]
if(!$_SESSION["connecte"]) {   //    Demander l'accessibilité 
    http_response_code(302);
    header('Location: login_page.php');
    exit(); 
}

$group_id = "a";

require("includes/pdo.php");

$marequetee = $pdo->prepare("SELECT * FROM groupe WHERE group_id = :group_id");  
$marequetee->execute([
    ":group_id" => $id
]);
$categoriess = $marequetee->fetchAll();

$m = $pdo->prepare("SELECT name,group_id from groupe WHERE group_id = :group_id");  
$m->execute([
    ":group_id" => $id
]);
$c = $m->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

        <?php foreach($categoriess as $categori): ?> 
                <td><?= $categori["name"]?></td><br>
                <td><?= $categori["content"]?></td><br>
                <td><?= $categori["profile_picture"]?></td><br>
                <td><?= $categori["seconde_picture"]?></td><br>
            <?php endforeach; ?>

        

            <a href="modifier_page.php?group_id=<?=$c["group_id"] ?>"> 
                Modifier la page </a><br>


                
           


</body>
</html>