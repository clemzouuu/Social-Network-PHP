<?php session_start(); 
require("includes/pdo.php");

$_SESSION["connecte"] = false;


$passwordd = filter_input(INPUT_POST, "password");
$id = filter_input(INPUT_POST, "id"); 

if($id && $passwordd) {
    
    $maRequete = $pdo->prepare("UPDATE twitter_id SET actif=1 WHERE login=:login");  
    $maRequete->execute([
        ":login" =>$id
    ]);

    $_SESSION["connecte"] = true;
    $_SESSION["login"] = $login; 
    //$_SESSION["id"] = $data[0]["id"];
    $_SESSION["id"] = $pdo->lastInsertId();
    http_response_code(302);
    header('Location: main.php'); 
    exit(); 

    }
    else{ 
        ?>
        <script type="text/javascript">
            alert("Erreur")
        </script>
        <?php
    }


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
    <style>
        <?php include "login.css" ?>
    </style>

</head>
<body>
    <header>
        <img src="img/Group_2.png" alt="logo_social_network" height="150px" width ="150px">
        <p>Partagez vos connaissances !</p>
    </header>


    <div class="box">
        <h1>Inscription</h1>

        <h1>Connexion</h1>
        <div class="connexion">
            <form method="POST">
                <label for="login">Entrez l'identifiant</label>
                <input type="text" name="id" id="login" /><br/>

                <label for="password">Entrez le mot de passe</label>
                <input type="password" name="password" id="password" /><br/>
                
                <input type="submit" name="submit" value="Se connecter" class="button" />
            </form>
        </div> 
    </div>

</body>
</html>