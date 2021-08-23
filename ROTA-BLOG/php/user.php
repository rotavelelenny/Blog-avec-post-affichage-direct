<?php 
session_start();
// connexion BDD
    include ("../Include/database.php");
//   Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
    // if( !isset($_SESSION['id']) ){
    //     header("Location: connexion.php");
    //     exit(); 
    // }
 // recupéré l'id de session
    $idsession = $_SESSION['id'];
    // recuperation id de l'url
    $idGet = $_GET['id'];
    // var_dump($idGet);

    // requete 
    $select = $bdd->prepare("SELECT id, pseudo, photo FROM users WHERE id = ?");
    $select->execute([$idGet]);

    // fetch
    $resultat = $select->fetch();
    // var_dump($resultat);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ROTA-BLOG - Profil utilisateur</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    </style>
</head>

    <body>
    <?php include ("../Include/header_inside_log.php"); ?>
        
        <div class="explain" id="menu">
            <div class="p_container"> 
                <a href="posts.php?id=<?php echo $idsession ?>"><p>Anecdotes</p> </a>
                <a href="posts.php?id=<?php echo $idsession ?>"><p>Artworks</p></a>
                <a href="posts.php?id=<?php echo $idsession ?>"><p>Musiques</p></a>
                <a href="posts.php?id=<?php echo $idsession ?>" style="border-right:none"><p >Tendances</p></a>
            </div>
        </div>
        <hr>   
        
        <main class="">  
           
                <div class="avatar">
                    <img class="avatar_here"src="../assets/avatar/<?php echo $resultat['photo'] ?>" alt="profil-user">
                </div>
                <p class="to_do" style="font-size:3rem">Voici ton espace utilisateur</p>
</br>
            <div class="welcome">
                <p2>Heureux de te revoir parmis nous </p2> 
                <div class="pseudo">
                    <?php echo $resultat['pseudo']; ?>
                </div>  
            </div>

            <a class="param" href="setting.php?id=<?php echo $idsession ?>"> Paramètres </a>
        </main>    
        
        <?php include ("../Include/footer.php") ?>

        <script src="../js/Popup_about.js"></script>
        <script src="../js/sticky_header.js"></script>
        <script src="../js/scroll_move.js"></script>
    </body>
</html>