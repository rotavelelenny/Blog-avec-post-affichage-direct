<?php
session_start();
// connexion BDD
include ("../Include/database.php");

    // verifie si la personne exist et que ses champs correspondent avec la bdd
    $select = $bdd->prepare("SELECT id, pseudo, mdp FROM users WHERE pseudo = ?");
    $select->execute([$pseudo]);
    // va chercher les info dans la BDD
    $resultat = $select->fetch();


if (!$_SESSION['admin']){
    header('Location:../php/connexion.php')
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ROTA BLOG - Admin - Back Office</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    </style>
</head>

    <body>
        <?php include ("../Include/header_outside_log_login.php") ?>

        <div class="explain">
            <h1>Veuillez vous connecter pour partagez vos :</h1>
            <div class="p_container"> 
                <p>Anecdotes</p> 
                <p>Artworks</p>
                <p>Musiques</p> 
                <p style="border-right:none">Tendances</p>
                <div class="view_port">
                    <div class="cylon_eye"></div>
                </div>
            </div>
        </div>

        <form action="" method="POST"> 
            <h1>Se connecter</h1>

                <input class="boxtext" type="text" name="pseudo" placeholder="Pseudo" required>
                <input class="boxtext" type="text" name="mdp" placeholder="Mot de passe" required>
                <a href="mdp_forgotten.php">Mot de passe oublié</a>
                <br> 
                <div class="g-recaptcha" data-sitekey="6LfIRHsaAAAAAMuLznLa7TVeT0u8ZMGOfWNrBtZp" data-theme="light"></div>
                <br>        
                <input class="submit" type="submit" name="submit">
                
                <?php 
                if( isset($erreur)){
                    echo $erreur;
                }
                ?>
        </form>

        <?php include ("../Include/footer.php") ?>

        <script src="../js/Popup_about.js"></script>
        <script src="../js/sticky_header.js"></script>
    </body>
</html>