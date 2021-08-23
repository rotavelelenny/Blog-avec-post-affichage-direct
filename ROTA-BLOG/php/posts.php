<?php
session_start();
    // Connexion Bdd
include ("../Include/database.php");
 // recupéré l'id de session
    $idsession = $_SESSION['id'];
 // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
    if( !isset($_SESSION['id']) ){
        header("Location: connexion.php");
        exit(); 
    }

    if( isset( $_POST['submit'] ) ){

        // recupéré les données de mes inputs
        $titre = $_POST['titre'];
        $texte = $_POST['texte'];
        $IdPseudo = $_SESSION['id'];

        // sécurisé
        if( $titre !== '' AND $texte !== ''){
            // requete
            $insert = $bdd->prepare("INSERT INTO posts(IdPseudo, titre, texte, date) VALUES(?, ?, ?, NOW())");
            $insert->execute([$IdPseudo, $titre, $texte]);
       
            // var_dump($insert);
           $erreur = "votre article a bien été posté !";

        }else{
            $erreur = "veuillez remplir les champs !";
        }
    }
    
    // Pour afficher les articles postés
        // requete
    $select = $bdd->prepare("SELECT * FROM posts INNER JOIN users ON posts.IdPseudo = users.id ORDER BY date DESC");
    $select->execute();
        // Va chercher les infos 
    $resultatpost = $select->fetchAll();

     // Pour afficher l'identité de l'user
    $idGet = $_GET['id'];
     // requete 
    $selectusers = $bdd->prepare("SELECT id, pseudo, photo FROM users WHERE id = ?");
    $selectusers->execute([$idGet]);
      // Va chercher les infos
    $resultat = $selectusers->fetch();
    
    
        

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> ROTA-BLOG - Accueil - Post</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/header.css">
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        </style>
    </head>

    <body>
            <?php Include ("../Include/header_inside_log.php");?>
    <div id="particles-js" class="background">
            <div class="explain" id="menu">
            <h1>Partagez vos :</h1>
                <div class="p_container"> 
                    <a href="posts.php?id=<?php echo $idsession ?>"><p>Anecdotes</p> </a> 
                    <a href="posts.php?id=<?php echo $idsession ?>"><p>Artworks</p></a>
                    <a href="posts.php?id=<?php echo $idsession ?>"><p>Musiques</p></a>
                    <a href="posts.php?id=<?php echo $idsession ?>" style="border-right:none"><p >Tendances</p></a>
                </div>
            </div>
        
            <div class="user">
                <div class="pseudo">Ton pseudo :
                    <?php echo $resultat['pseudo']; ?>
                </div> 
                <a class="profil" href="user.php?id=<?php echo $idsession ?>">
                    <img class="avatar_here" id="avatar" src="../assets/avatar/<?php echo $resultat['photo'] ?>" alt="profil-user">
                    Ton profil 
                </a>
            </div>

        <div class="main_post" id="main_post">
            
            
            <form class="poster"action="" method="POST">    
                <p> 
                    <?php 
                        if( isset($erreurphoto)){
                            echo $erreurphoto;
                        }
                    ?>
                </p>
                <input class="boxtext article" type="text" name="titre" placeholder="Titre">
                <textarea class="boxtext article" name="texte" id="" cols="200" rows="20"placeholder="Ecrivez ici votre texte"></textarea>       
                <input type="hidden" name="date" value="<?php echo $date ?>" />
                <input class="submit" type="submit" name="submit" value="valider">
            </form>

          

                <?php
                foreach($resultatpost as $result){      

                echo "<div class='post' id='post'>
                      
                        <h1 class='post_pseudo'>By : " . $result["pseudo"] . "</h1>
                        <h1 class='post_title'>" . $result["titre"] . "</h1>
                        <p class='post_text'>" . $result["texte"] . "</p>
                        <div class='container_modif'>
                            <a class='supp param' href='supprimer.php?id=" . $result['id'] . "'> Supprimer </a>
                            <a class='param' href='modification.php?id=" . $result['id'] . "'> Modifier </a>
                        </div>

                    </div>";
                    
                }?>
         

        </div>       
    </div>
        <?php require_once ("../Include/footer.php");?>

</script>
        <script src="../js/Popup_about.js"></script>
        <script src="../js/sticky_header.js"></script>
        <script src="../js/scroll_move.js"></script>
        <script src="../js/particles.js"></script>
        <script src="../js/particles.min.js"></script>
        <script src="../js/app.js"></script>
    </body>
</html>