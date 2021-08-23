<?php
session_start();
    // connexion bdd
include ("../Include/database.php");
// recupéré l'id de session
// $idsession = $_SESSION['id'];
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
// if( !isset($_SESSION['id']) ){
//     header("Location: inscription.php");
//     exit(); 
// }


    // si je click sur envoyer 
    if( isset($_POST['submit']) ){

        // recupéré les  donnes en post et les sécurisé
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $mdp2 = htmlspecialchars($_POST['mdp2']);
        $mail = htmlspecialchars($_POST['mail']);
var_dump($_POST);

        // verification si les inputs ne sont pas vide
        if( !empty($pseudo) AND !empty($mdp) AND !empty($mdp2) AND !empty($mail)){

            // si les mdp sont identique 
            if($mdp === $mdp2){
                
                // alors, verifions si la personne existe ou pas dans la base de données
                $select = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
                $select->execute([$pseudo]);

                //compte si ya quelqun
                $exist = $select->rowCount();
                // si il n'y a personne alors
                // hasher le mot de passe 
                // insérer les valeurs des inputs saisies dans bdd
                if($exist === 0){

                    //hasher le mot de passe 
                    $mdpHasher = password_hash($mdp, PASSWORD_DEFAULT);
                    // requete insert
                    $insert = $bdd->prepare("INSERT INTO users(pseudo, mdp, mail)VALUES(?, ?, ?)");
                    $insert->execute([$pseudo, $mdpHasher, $mail]);
                    
                    // var_dump($_POST);
                    
                    // Recaptcha pour éviter les bots
                    require '../assets/recaptcha/autoload.php';
                    if(isset($_POST['g-recaptcha-response'])){
                        if(isset($_POST['submit'])){
                            $recaptcha = new \ReCaptcha\ReCaptcha('6LfIRHsaAAAAAMByA3H4gSWjhNjS8DsW23heZe4w');
                            $resp = $recaptcha->verify($_POST['g-recaptcha-response']);
                    
                            if ($resp->isSuccess()) {
                                echo "Captcha Valide";
                            
                            } else {
                                $errors = $resp->getErrorCodes();
                                echo "Veuillez valider Captcha";
                                // var_dump($errors);
                            }    
                        
                    
                        }else{
                        echo "Captcha non rempli" ;
                        }
                    }

                echo "Bienvenue nouveau Rota-blogeur";
                   // Verified!
                    // je le redirige vers la page utilisateur
                    header('Location: posts.php?id=' . $resultat['id']);
                }else{
                    echo "Vous êtes déjà inscrit. Veuillez vous connecter !";
                }
            }else{
                echo  "Les mots de passe ne sont pas identiques !";
            }
        }else{
            echo "Veuillez remplir les champs !";
        } 
} 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> ROTA-BLOG - Inscription</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    </style>
</head>
<body>
<?php include ("../Include/header_outside_log.php") ?>
        
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
        <!-- fun snake -->  
    <form action="" method="POST"> 
        <h1>Inscritpion</h1>
            <input class="boxtext" type="text" name="pseudo" placeholder="Pseudo" required>
            <input class="boxtext" type="text" name="mdp" placeholder="Mot de passe" required>
            <input class="boxtext" type="text" name="mdp2" placeholder="Saisir le mot de passe à nouveau" required>
            <input class="boxtext" type="email" name="mail" placeholder="email" required>

            <a href="./mdp_forgotten.php">Mot de passe oublié</a>
            <br> 
            <div class="g-recaptcha" data-sitekey="6LfIRHsaAAAAAMuLznLa7TVeT0u8ZMGOfWNrBtZp" data-theme="light"></div>
            <input class="submit" type="submit" name="submit">      
            
            <p> 
            <?php 
                if( isset($erreur)){
                    echo $erreur;
                }
            ?>
            </p>
    </form>

<?php include ("../Include/footer.php") ?>
    <script src="../js/Popup_about.js"></script>
    <script src="../js/sticky_header.js"></script>
</body>
</html>