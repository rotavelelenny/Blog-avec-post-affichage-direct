<?php
session_start();
// Connect database 
    require_once ('../Include/database.php');
    //! 6 -Redirection vers la page d'entrée du code
    if(isset($_GET['section'])){
        $section = htmlspecialchars($_GET['section']);
    } else {
        $section = "";
    }


    // traitement du formulaire
        //! 0 - Demande de l'adresse mail
    if(isset($_POST['recup_submit'],$_POST['recup_mail'])) {
        //! 1a - Sécurisation mail
            //  signifier que la variable n'est pas vide
        if(!empty($_POST['recup_mail'])) {
            $recup_mail =  htmlspecialchars($_POST['recup_mail']);
              // test de validitée de la saisie du mail 
            if(filter_var($recup_mail,FILTER_VALIDATE_EMAIL)){
            
                // echo "OK";

                    //! 2a - vérification validitée mail
                    // vérifier l'existance de l'utilisateur via son mail dans la base de donée
                $mailexist = $bdd->prepare('SELECT id,pseudo FROM users WHERE mail = ?');
                $mailexist-> execute(array($recup_mail));
                $mailexist_count = $mailexist->rowCount();

                    // ! 3 - Stockage du mail dans :
                if($mailexist_count == 1){

                    $pseudo = $mailexist->fetch();
                    $pseudo = $pseudo['pseudo'];
                    var_dump($pseudo);

                    $_SESSION['recup_mail'] = $recup_mail;  
                        //! 4 - voir screenshot(mdp_forgotten - generate_code_affichage)
                    $recup_code = "";
                    for($i=0; $i < 8; $i++) {
                        $recup_code .= mt_rand(0,9);
                    }
                        // vérifier ma variable
                        // var_dump($recup_code);
                    // Stockage du code dans : 
                        

                        //! 5 - Table de "récupération" - voir screenshot(bdd)
                        // creer une table pour correspondance entre recup_mail et recup_code
                            //  requête si le mail est deja present dans la table recuperation
                            $mail_recup_exist = $bdd->prepare('SELECT id FROM recuperation WHERE mail = ?');
                            $mail_recup_exist->execute(array($recup_mail));
                            $mail_recup_exist = $mail_recup_exist->rowCount();
                                // si le mail existe déjà dans la table recuperation de la bdd, mise à jour
                                // ! - voir screenshot (mdp_forgotten - generate_code_affichage Bx2)
                            if($mail_recup_exist == 1){
                                $recup_insert = $bdd->prepare('UPDATE recuperation SET code = ? WHERE mail = ?');
                                $recup_insert->execute(array($recup_code,$recup_mail));
                                // sinon dans la table recuperation
                            }else{
                                 // enregistrer dans la bdd vers table recuperation
                            $recup_insert = $bdd->prepare('INSERT INTO recuperation(mail,code) VALUES (?, ?)');
                            $recup_insert->execute(array($recup_mail,$recup_code));
                            }

                            // mail
                            $header="MIME-Version: 1.0\r\n";
                            $header.='From:"Lenny Vazeille"<lenny.v.dev@mail.com>'."\n";
                            $header.='Content-Type:text/html; charset="utf-8"'."\n";
                            $header.='Content-Transfer-Encoding: 8bit';
                            $message = '
                            <html>
                            <head>
                                <title>Récupération de mot de passe - ROTA BLOG</title>
                                <meta charset="utf-8" />
                            </head>
                            <body>
                                 <font color="#303030";>
                                 <div align="center">
                                    <table width="600px">
                                        <tr>
                                            <td>
                                                
                                                <div align="center">Bonjour <b>'.$pseudo.'</b>,</div>
                                                Voici votre code de récupération: <b>'.$recup_code.'</b> <br /> <br/>
                                                A très vite sur <a href="http://localhost:8080/ROTA-BLOG">Rota Blog</a> !
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td background="http://localhost:8080/ROTA-BLOG/Include/header_inside_log.php" height="5px"></td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <font size="2">
                                                 Ceci est un email automatique, merci de ne pas y répondre
                                                </font>
                                            </td>
                                        </tr>
                                    </table>
                                 </div>
                                 </font>
                            </body>
                            </html>
                            ';
                            mail($recup_mail, "Récupération de mot de passe - ROTA BLOG", $message, $header);
                            header('Location:http://localhost:8080/ROTA-BLOG/php/mdp_forgotten.php?section=code');
                }else{
                    $error = "L'adresse mail saisie n'est pas enregistrée'";
                }

            } else {

                echo "Adresse mail invalide";
            }
        // si la variable est vide
        }else{
            $error = "Veuillez entrer votre adresse mail";
        }

    }
    //! 6 -Redirection vers la page d'entrée du code - voir screenshot (mdp_forgotten - B)
    if(isset($_POST['verif_submit'],$_POST['verif_code'])) {
        if(!empty($_POST['verif_code'])) {
            $verif_code = htmlspecialchars($_POST['verif_code']);
            $verif_req = $bdd->prepare('SELECT id FROM recuperation WHERE mail = ? AND code = ?');
            $verif_req->execute(array($_SESSION['recup_mail'], $verif_code));
            $verif_req = $verif_req->rowCount();
            if($verif_req == 1) {
                $upd_req = $bdd->prepare('UPDATE recuperation SET confirme = 1 WHERE mail = ?');
                $upd_req->execute(array($_SESSION['recup_mail']));
                header('Location:http://localhost:8080/ROTA-BLOG/php/mdp_forgotten.php?section=changemdp');
            } else {
                $error = "Code invalide";
            }
        }else{
            $error = "Veuillez saisir le code de confirmation";
        }
    }
    if(isset($_POST['change_submit'])) {
        // éviter le changement des "name" et risquez une attaque mal-intentionnée. C'est pourquoi il faut faire une verification en 2 temps de mdp et mdpc
        if(isset($_POST['change_mdp'], $_POST['change_mdpc'])) {
            $verif_confirme = $bdd->prepare('SELECT confirme FROM recuperation WHERE mail = ?');
            $verif_confirme->execute(array($_SESSION['recup_mail']));
            $verif_confirme = $verif_confirme->fetch();
            $verif_confirme = $verif_confirme['confirme'];
            if($verif_confirme == 1 ){
                // puis les sécuriser
                $mdp = htmlspecialchars($_POST['change_mdp']);
                $mdpc = htmlspecialchars($_POST['change_mdpc']);
                if(!empty($mdp) AND !empty($mdpc)) {
                    // vérifier si le mdp et la confirmation mdp sont identiques
                    if($mdp == $mdpc) {
                        // hashage
                            $mdp = sha1($mdp);
                            // mise à jour du mot de passe dans la base de donnée
                            $ins_mdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE mail = ?');
                            $ins_mdp->execute(array($mdp,$_SESSION['recup_mail']));
                            //  suppression de la requête apres récupération du mdp
                            $del_req = $bdd->prepare('DELETE FROM recuperation WHERE mail = ?');
                            $del_req->execute(array($_SESSION['recup_mail']));
                            // redirectipon apres mise à jour du mot de passe vers la page connexion
                            header('Location:http://localhost:8080/ROTA-BLOG/php/connexion.php');
                    } else {
                        $error = "Vos 2 mots de passes ne sont pas identiques";
                    }    
                } else {
                    $error = "Veuillez valider le lien du mail, via le code de vérification envoyé à votre adresse mail";
                }
            } else {
                $error = "Veuillez remplir tous les champs";
            }
        } else {
            $error = "veuillez remplir tous les champs";
        }
    }
?>
