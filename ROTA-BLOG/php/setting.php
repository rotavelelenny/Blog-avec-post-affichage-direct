<?php
session_start();
// db connect 
include ("../Include/database.php");

    // recupéré l'id de session
    $idsession = $_SESSION['id'];

    // si la personne n'est pas connecté je la redirige vers deconnexion
    if( !isset($idsession) ){

        header("Location: deconnexion.php");
    }
    
    // Changement du mot de passe
    // si je clique sur submit 
    if( isset($_POST['submit']) ){

        // stocke les inputs dans les variables
        $ancienmdp = htmlspecialchars($_POST['ancienmdp']) ;
        $nouveaumdp = htmlspecialchars($_POST['nouveaumdp']) ;
        $confirmmdp = htmlspecialchars($_POST['confirmmdp']) ;

        // verifier si les champs son vide
        if( !empty($ancienmdp) AND !empty($nouveaumdp) AND !empty($confirmmdp)){

            // requete select 
            $select = $bdd->prepare("SELECT mdp FROM users WHERE id = ?");
            $select->execute([$idsession]);

            // va chercher les infos
            $infouser = $select->fetch();


            // si le mot de passe hasher est le meme que l'ancien mdp
            if( password_verify($ancienmdp, $infouser[0]) ){

                // si les nouveau mdp correspondent

                if($nouveaumdp === $confirmmdp){

                    // hasher le new mdp
                    $passwordhasher = password_hash($nouveaumdp, PASSWORD_DEFAULT);


                    // requete update
                    $update = $bdd->prepare("UPDATE users SET mdp = ? WHERE id = ?");
                    $update->execute([$passwordhasher, $idsession]);

                    $erreur = "Votre Mot de passe a été mis à jour ! ";

                }else{
                    $erreur = "Attention ! Les nouveaux mots de passe ne sont pas identiques !";
                }
            }else{
                $erreur=" L'ancien mot de passe ne correspond pas !";
            }
        }else{
            $erreur = "Veuillez remplir les champs !";
        }
    }

//  fin du changement du mot de passe
    // ------------------------------------------------------------------------------------------------------------------------------------------
// Changement du pseudo


    if( isset($_POST['submitpseudo'])){


        // recupération de l'input
        $pseudo = htmlspecialchars($_POST['pseudo']) ;

        if( !empty($pseudo)){


            // requete select
            $selectpseudo = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
            $selectpseudo->execute([$pseudo]);

            // comptage pour vérifier si le pseudo saisi existe
            $compte = $selectpseudo->rowCount();

            if($compte === 0){

                // envoyer la requête 
                $updatepseudo = $bdd->prepare("UPDATE users SET pseudo = ? WHERE id = ? ");
                $updatepseudo->execute([$pseudo, $idsession]);

                $erreurpseudo ="Votre pseudo a bien été mis à jour !";

            }else{

                $erreurpseudo ="Ce pseudo est déjà utilisé !";
            }
        }
        else{

            $erreurpseudo = "Veuillez remplir le champ !";
        }

    }

// ------------------------------------------------------------------------------------------------------------------------------------------



if(isset($_POST['submitphoto'])){


        $photo = $_FILES['photo']['name'];
        $target_dir = '../assets/avatar/';
        $target_file_blog = $target_dir . basename($_FILES['photo']['name']);
    
        //Select file type
        $imageFileType = strtolower(pathinfo($target_file_blog,PATHINFO_EXTENSION));
    
        //Valid extensions
        $extension_arr = array("jpg","jpeg","png","gif");
    
        //CHecking if extension exists
        if(in_array($imageFileType,$extension_arr))
        {
            if(!empty($photo))
            {
                $add = $bdd->prepare("UPDATE users SET photo = ? WHERE id = ?");
                
                //Execute query
                $add->execute([$photo, $idsession]);
                var_dump($photo);
                if($add !== 0)
                {
                    //Then uploading picture
                    move_uploaded_file($_FILES['photo']['tmp_name'],$target_dir.$photo);
                
                    $erreur = "Votre photo a bien été mise à jour";
    
                }


                $erreurphoto = "Une erreur est survenue. La photo n'a pas été envoyé !";
            }

        }else{
            $erreurphoto = "Attention fichier trop volumineuse. L'image doit être de 2Mo maximum!";
        }

    }else{
        $erreurphoto = "Nous acceptons uniquement les extensions suivantes : jpg, jpeg, png, gif !";
    }  



    $selectuser = $bdd->prepare("SELECT * FROM users WHERE id = ?");
    $selectuser->execute([$idsession]);

    $result = $selectuser->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> ROTA-BLOG - Modifier profil utilisateur</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/header.css">
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        </style>
    </head>

    <body>
        
    <?php Include ("../Include/header_inside_log.php");?>

    

        <h1> setting</h1>
        <a class="profil" href="user.php?id=<?php echo $idsession ?>"> RETOUR AU PROFILE </a>
        <div class="container_setting">

            <div class="left_setting setting">

                <form action="" method="post">
                    <p> 
                        <?php 
                            if( isset($erreur)){
                                echo $erreur;
                            }
                        ?>
                    </p>
                    <h3>Modification du mot de passe</h3>
                    <input class="boxtext" type="text" name="ancienmdp" placeholder="ancienmdp">
                    <input class="boxtext" type="text" name="nouveaumdp" placeholder="nouveaumdp">
                    <input class="boxtext" type="text" name="confirmmdp" placeholder="confirmmdp">
                    <input class="submit" type="submit" name="submit">
                </form>
                
            </div>
</div>
            <div class="right_setting setting">
                    <!-- --------------------------------------------- modification du pseudo -------------------------------------------------- -->
                <form action="" method="POST">
                    <p> 
                        <?php 
                            if( isset($erreurpseudo)){
                                echo $erreurpseudo;
                            }
                        ?>
                    </p>
                    <h3>Modification du Pseudo</h3>
                    <hr>
                    <input class="boxtext" type="text" name="pseudo" placeholder="Nouveau Pseudo">
                    <input class="submit" type="submit" name="submitpseudo">
                </form>

                    <!-- --------------------------------------------- modification de l'image -------------------------------------------------- -->
                <form action="" method="POST" enctype='multipart/form-data' >
                    <p> 
                        <?php 
                            if( isset($erreurphoto)){
                                echo $erreurphoto;
                            }
                        ?>
                    </p>
                    <h3>Modification de l'image</h3>
                    <input  type="file" name="photo">
                    <input class="submit" type="submit" name="submitphoto">
                </form>

                <div class="img">
                    <img src=" <?php echo $result['photo'] ?> " alt="">
                </div>
                
            </div>

        </div>
        <div id="particles-js" class="background"></div>
        <?php include ("../Include/footer.php") ?>

        <script src="../js/Popup_about.js"></script>
        <script src="../js/sticky_header.js"></script>
        <script src="../js/particles.js"></script>
        <script src="../js/particles.min.js"></script>
        <script src="../js/app.js"></script>
    </body>

</html>