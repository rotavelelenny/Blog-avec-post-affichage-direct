<?php
session_start();
    // Connexion Bdd
    include ("../Include/database.php");

    // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
    if( !isset($_SESSION["id"]) ){
        header("Location: connexion.php");
        exit(); 
    }
// recupéré l'id de session
$idsession = $_SESSION['id'];

//recupere les données du get 
$idGet = $_GET['id'];
// requete select 
$select = $bdd->prepare("SELECT * FROM posts WHERE id = ?");
$select->execute([$idGet]);
// fetch
$resultat = $select->fetch();

// si je passe clic sur submit
if( isset($_POST['modifSubmit']) ){

    // recuperation 
    $titre = $_POST['modifTitre'];
    $texte = $_POST['modifText'];

    // securiser
    if( !empty($titre) AND !empty($texte) ){
        // envoyer la requete

        $update = $bdd->prepare("UPDATE posts SET titre = ? , texte = ? WHERE id = ?");
        $update->execute([$titre, $texte, $idGet]);
       echo "Vos modifications ont bien été prises en compte !";
    }else{
        echo "veuillez remplire les champs !";
    }
}

$updateshow = $bdd->prepare("SELECT * FROM posts WHERE id = ?");
$updateshow->execute([',,']);
$modifshow = $updateshow->fetch();


?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ROTA-BLOG - Modification - Post</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/footer.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        </style>
    </head>

    <body>
        <?php Include ("../Include/header_inside_log.php");?>

        
        <div class="explain">
            <div class="p_container"> 
                <a href="posts.php?id=<?php echo $idsession ?>"><p>Anecdotes</p> </a>
                <a href="posts.php?id=<?php echo $idsession ?>"><p>Artworks</p></a>
                <a href="posts.php?id=<?php echo $idsession ?>"><p>Musiques</p></a>
                <a href="posts.php?id=<?php echo $idsession ?>" style="border-right:none"><p >Tendances</p></a>
            </div>
            </br></br>
            <h1>Voici le post que vous souhaitez modifier :</h1>
        </div>

        <div class="modif_post" style="text-align:center;">
            <h1 class="post_title"> <?php echo $resultat['titre']; ?> </h1>
            <p class="post_text"> <?php echo $resultat['texte']; ?> </p>
        </div>
    
        <span>&#8681;</span>

        <form action="" method="POST">
        <h1>Modifier le titre ainsi que son contenu</br> ou uniquement le contenu (renseigner le titre original):</h1>
            <input class="boxtext article" type="text" name="modifTitre" placeholder="Nouveau titre">
            <textarea class="boxtext article" name="modifText" id="" cols="30" rows="10" placeholder="Nouveau contenu"></textarea>
            <input class="submit" type="submit" name="modifSubmit">
        </form>

        <?php include ("../Include/footer.php") ?>

        <script src="../js/Popup_about.js"></script>
        <script src="../js/sticky_header.js"></script>
    </body>
</html>