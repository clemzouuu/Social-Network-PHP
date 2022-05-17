<?php 
session_start();

 
$id = $_SESSION["id"];
$login = $_SESSION["login"];
require("includes/pdo.php");
 

// Page accessible seulement si $_SESSION["connecte"]
if(!$_SESSION["connecte"]) {
    http_response_code(302);
    header('Location: main.php');
    exit(); 
}

require("includes/pdo.php");
$marequetee = $pdo->prepare("SELECT * FROM twitter_id where id = :id");  
$marequetee->execute([
    ":id" =>$id
]);
$categoriess = $marequetee->fetchAll();


$marequete = $pdo->prepare("SELECT name,content,created,answer,answering_person,twit_id FROM all_twits ORDER BY created DESC");
$marequete->execute();
$categories = $marequete->fetchAll();

$answer = filter_input(INPUT_POST, "answer"); 
$tweet_number = filter_input(INPUT_POST, "tweet_number"); 


$m = $pdo->prepare("SELECT name,group_id from groupe");  
$m->execute();
$c = $m->fetchAll();

if($_SERVER["REQUEST_METHOD"] == "POST")  {
$tweet = filter_input(INPUT_POST, "tweet"); 
$answer = filter_input(INPUT_POST, "answer"); 
$tweet_number = filter_input(INPUT_POST, "tweet_number"); 


    if($tweet) {
        $maRequetee = $pdo->prepare("INSERT INTO all_twits (id,content,name) values (:id,:content,:name)");  
        $maRequetee->execute([
            ":content" => $tweet,
            ":id" => $id,
            ":name" => $login
        ]);
        header('Location: main.php');
        exit();
    }

    if($answer) {
        $maR = $pdo->prepare("INSERT INTO tweet_answers (name,content,tweet_id) values(:pseudo,:content,:tweet)");  
 
        $maR->execute([
            ":content" => $answer,
            ":pseudo" => $_SESSION["login"],
            ":tweet" => $tweet_number
        ]);
        header('Location: main.php');
        exit();
    }

}
    
    
?>

 <!DOCTYPE html>
 <html lang="fr">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <style>
        <?php include "styles.css" ?>
    </style>
 </head>
 <body>

    <header>
        <img src="img/Group_2.png" alt="logo_social_network">
            <a href="recherche.php">Rechercher par nom</a>
    </header>

    <div id="main">

        <div id="tweet">
            <form method="POST">
                <?php foreach($categoriess as $categori): ?> 
                    <td><?= $categori["profile_picture"]?></td>
                <?php endforeach; ?>

                <input type="text" name="tweet" id="submit1" placeholder="Exprimez vous !"/>
                <input type="submit" value="Envoyer" id="submit"/>
            </form>
        </div>

        <div id="content">
            <p>Tous les tweets</p>
            <?php foreach($categories as $categorie): ?>
                <tr>
                    <form method="POST">
                        <?= "Tweet N°",$categorie["twit_id"]?></td><br>
                        <td><?= $categorie["content"] ?></td><br>
                        <td><?=$categorie['name'],", " ?></td>
                        <td><?="à ",$categorie["created"] ?></td><br>
                        <?php 
                            $mareq = $pdo->prepare("SELECT name,content FROM tweet_answers WHERE tweet_id=:tweet");
                            $mareq->execute([
                                ":tweet" => $categorie["twit_id"]
                            ]);
                            $catp = $mareq->fetch();
                            if($catp) echo "Réponse de ",$catp["name"]," : ",$catp["content"];
                        ?>
                        <br><br>
                        
                    </form>
                </tr>
            <?php endforeach; ?>
            


                        
            

            <form method="POST">
                <input type="text" name="answer" placeholder="Commentez"/>
                <input type="text" name="tweet_number">
                <input type="submit" value="Commentez" />
            </form>
            
            
            


        </div>

        <nav id="belongings">
            <p>Amis</p>
            <p>Page(s)</p>
            <?php foreach($c as $ca): ?> 
                <a href="afficher_page.php?group_id=<?=$ca["group_id"] ?>"> 
                <?=$ca["name"]?></a><br>
            <?php endforeach; ?>

            <a href="page.php"><p>Créer une Page</p></a>
        </nav>

        <div id="infos">
            <?php foreach($categoriess as $categori): ?>
                <tr>
                    <a href="index_2.php"><td><?= $categori["profile_picture"]?></td></a><br>
                   
                        <td><?=$categori['login'] ?></td><br>
                        <td><?= $categori["city"] ?></td><br>
                        <td><?= $categori["school"] ?></td><br>
                        <td><?= $categori["speciality"]?></td><br>
                        <td><?= $categori["age"] ?><span> ans </span></td><br>
                    </tr>
                <?php endforeach; ?>
                <a href="index_2.php">Profil</a><br>
                <a href="index.php">Deconnexion</a> 
        </div>
        
        
    </div>
    
    

     
    
     
 </body>
 </html>