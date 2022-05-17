<?php 

$search = filter_input(INPUT_POST, "search"); 

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
        <form method="POST">
            <input type="text" placeholder="Rechercher" name="search"/>
            <input type="submit" value="Envoyer" id="submit"/>

        </form>
                <?php 
                    require("includes/pdo.php");
                    $marequete = $pdo->prepare("SELECT * FROM twitter_id WHERE login LIKE '%$search%'");
                    $marequete->execute();
                    $categories = $marequete->fetchAll();
                    if($search){ 
                        foreach($categories as $categori){ ?>
                            <td><?= $categori["login"]?></td>
                            <td><?=$categori['city']?></td>
                            <td><?=$categori["school"]?></td>
                            <td><?=$categori["speciality"]?></td>
                            <td><?=$categori["age"]?></td> 
                            <td><?=$categori["profile_picture"]?>
                            <?php
                        }?>
                        

                        
                    <input type="submit" value="Ajouter en ami" id="submit"/>
                        
                        
                <?php
                    }
                 ?>
                 
                
   

</body>
</html>