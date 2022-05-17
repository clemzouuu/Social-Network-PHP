<?php 

session_start();
$id = $_SESSION["id"];
// Page accessible seulement si $_SESSION["connecte"]
if(!$_SESSION["connecte"]) {   //    Demander l'accessibilité 
    http_response_code(302);
    header('Location: login_page.php');
    exit(); 
    
}

$group_id = filter_input(INPUT_GET, "group_id", FILTER_VALIDATE_INT);


require("includes/pdo.php");




$marequetee = $pdo->prepare("SELECT * FROM groupe WHERE group_id = :group_id");  
$marequetee->execute([
    ":group_id" => $group_id
]);
$categoriess = $marequetee->fetchAll();


$ma= $pdo->prepare("SELECT user FROM admin WHERE group_id = :group_id");  
$ma->execute([
    ":group_id" => $group_id
]);
$c = $ma->fetch();
echo $c[0];

if($id == $c){
    echo "les bogoss de la mort qui tue";

    if($_SERVER["REQUEST_METHOD"] == "POST")  {
        $name = filter_input(INPUT_POST, "name");
        $content = filter_input(INPUT_POST, "content"); 
        $admin = filter_input(INPUT_POST, "admin"); 
        $admin_id = filter_input(INPUT_POST, "admin_id"); 
        
        require("includes/pdo.php");

        // Si le mot de passe est changé, on l'update dans la base de donnée
        
        if($name) {
        
            $maRequete = $pdo->prepare("UPDATE groupe SET name = :name WHERE group_id = :group_id");  
            $maRequete->execute([
                ":name" => $name,
                ":group_id" => $group_id
            ]);
        
        }

        if($content) {
        
            $maRequete = $pdo->prepare("UPDATE groupe SET content = :content WHERE group_id = :group_id");  
            $maRequete->execute([
                ":content" => $content,
                ":group_id" => $group_id
            ]);
        
        }

        // PROBLÈME 
        
        if($admin && $admin_id) {
            //$maRequete = $pdo->prepare("UPDATE groupe SET admin=:admin WHERE group_id = :group_id"); 
            $maRequete = $pdo->prepare("INSERT INTO admin (user,group_id) values(:user,:group_id)");     
            $maRequete->execute([
                ":user" => $admin,
                ":group_id" => $admin_id
            ]);
        
        }
        
    }  
    // Permet de modifier la photo de profil 
    if (isset($_FILES['photo']['tmp_name'])) {
        $retour = copy($_FILES['photo']['tmp_name'], $_FILES['photo']['name']);
        if($retour) {
            $image = '<img src="' . $_FILES['photo']['name'] . '">';

            require("includes/pdo.php");

            $maRequete = $pdo->prepare("UPDATE groupe  SET profile_picture= :profile_picture WHERE group_id = :group_id");  
            $maRequete->execute([   
                ":profile_picture" => $image,
                ":group_id" => $group_id
            ]);
            $_SESSION["profile_picture"] = $image;
        }

    }

    // Permet de modifier la photo de couverture
    if (isset($_FILES['photo2']['tmp_name'])) {
        $retour = copy($_FILES['photo2']['tmp_name'], $_FILES['photo2']['name']);
        if($retour) {
            $image2 = '<img src="' . $_FILES['photo2']['name'] . '">';

            require("includes/pdo.php");

            $maRequete = $pdo->prepare("UPDATE groupe SET seconde_picture= :second_picture WHERE group_id = :group_id");  
            $maRequete->execute([   
                ":second_picture" => $image2,
                ":group_id" => $group_id
            ]);
            $_SESSION["second_picture"] = $image2;
        }
    }
}

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

    <form method="post" enctype="multipart/form-data">
    
        <?php foreach($categoriess as $categori): ?> 
            
                <td><?= $categori["name"]?></td><br>
                <td><?= $categori["content"]?></td><br>
                <td><?= $categori["profile_picture"]?></td><br>
                <td><?= $categori["seconde_picture"]?></td><br>
                <td><?= $categori["admin"]?></td><br>
                
            <?php endforeach; ?>
            <a href="main.php">Retour</a>
            <form method="post" enctype="multipart/form-data">
            <span>Modifier la photo de profil </span><input type="file" name="photo">
            <input type="submit">
        </form>

        <form method="post" enctype="multipart/form-data">
            <span>Modifier la photo de couverture </span><input type="file" name="photo2">
            <input type="submit">
        </form>

        <form method="post">
            <label for="text">Modifier le nom de la page </label>
            <input type="text" name="name" id="name" /><br/>

            <label for="login">Modifier sa description</label>
            <input type="text" name="content"/><br/>

            <label for="login">Ajouter un admin</label>
            <input type="text" name="admin"/><br/>

            <label for="login">Ajouter l'id de l'admin</label>
            <input type="text" name="admin_id"/><br/>


            <input type="submit" value="Enregistrer" class="button" id="submit"/>
        </form>
    </form>
           




</body>
</html>