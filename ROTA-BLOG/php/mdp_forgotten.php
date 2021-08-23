<?php
    include ("../php/mdp_forgotten_base.php")

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>ROTA BLOG - Mot de passe oublié</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/header.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
</style>
</head>
    <body>

    <article>
        <h1>Récupération du mot de passe</h1>
        <?php if($section == 'code'){ ?>
            Un code de vérification vous a été envoyé par mail à l'adresse suivante: <?= $_SESSION['recup_mail'] ?>
        <br /> <br />

        <form method="POST"> 
            <p class="to_do">Veuillez entrer le code qui vous a été envoyé sur votre adresse mail</p>
            <input class="boxtext" type="text" placeholder="Code de vérification" name="verif_code" required>
            <button class="submit" type="submit" name="verif_submit">Envoyer</button>
        </form>  

        <?php } elseif ($section == "changemdp") {?>
            Nouveau mot de passe pour <?= $_SESSION['recup_mail'] ?>
            <br /> <br />
        <form method="POST"> 
            <p class="to_do">Veuillez entrer le code qui vous a été envoyé sur votre adresse mail</p>
            <input class="boxtext" type="password" placeholder="Nouveau mot de passe" name="change_mdp" required>
            <input class="boxtext" type="password" placeholder="Confirmation du mot de passe" name="change_mdpc" required>
            <button class="submit" type="submit" name="change_submit">Envoyer</button>
        </form> 

        <?php } else { ?>

        <form method="POST"> 
            <p class="to_do">Afin de récupérer votre mot de passe, veuillez renseigner votre adresse mail ci-dessous.<br></br>Un mot de passe provisoire vous sera alors envoyé.</p>
            <input class="boxtext" type="email" placeholder="Votre adresse mail" name="recup_mail" required>
            <button class="submit" type="submit" name="recup_submit">Envoyer</button>
        </form> 

        <?php } ?>

    </article>

<?php if(isset($error)) { echo '<span style="color:red">'.$error.'</span>'; } else { echo ""; } ?>


        <script src="../js/sticky_header.js"></script>
    </body>

</html>