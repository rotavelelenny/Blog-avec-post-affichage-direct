<?php
// connexion à la Bdd
$bdd =  new PDO("mysql:host=localhost;dbname=blog", "root", "");


// afficher le contenu d'une variable(donc POST)
    // var_dump( $_POST );

// envoyer les information saisi dans ce formulaire(POST)
    // echo $_POST['titre'];
    // echo $_POST['texte']; 
            // mais il faut que uniquement quand je 
            // clique sur envoyer ça envois les 2infos sans qu'il
            // n'en manque 1 élément à saisie(titre et texte)
   
            // si j'envoi (submit), alors tu va afficher mon echo
                //  if(lacondition){
                //       leNOM de la fonction[son paramètre]
                //   }
    if( isset($_POST['submit']) ){
        $titre = $_POST['titre'];
        $texte = $_POST['texte'];
    
// sécuriser
    if( $titre !== '' AND $texte !== ''){
            // '' veut dire empty donc vide
            // !== veut dire différent(!)
        // on continue
        // donc dans les else nous mettons les erreurs/ce qui n'est pas bon
   
        // me connecter à la bdd juste pour cette partie en particulier
        $bdd =  new PDO("mysql:host=localhost;dbname=blog", "root", "afpalenny");

        // preparer une requête
        $insert = $bdd->prepare("INSERT INTO posts(titre, texte) VALUES(?, ?)");
        // envoyer cette requête
        $insert->execute([$titre, $texte]);

        echo "votre post a bien été posté";


    }else{
        echo "veuillez remplir les champs!";
    }

}
    // requête
    $select = $bdd->prepare("SELECT * FROM posts");
    $select->execute();

    // va chercher les info 
    $resultat = $select->fetchAll();

 

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    </style>
    <style>
        body{
            text-align: center;
            display:flex;
            align-items:center;
            flex-direction:column;
            font-family: 'Righteous', cursive;
            background-color: grey;
        }
        .post{
            
            margin-left:5%;
            margin-top:5%;
            width:62%;
            background-color:greenyellow;
            padding:30px;
        }
        .boxtext{
            margin-left:5%;
            display:flex;
            justify-content:center;
            margin-top:5%;
            width:68%;
            background-color:#cccc;
            padding:10px;
            border-radius:10px;
            color: black;
            font-family: 'Righteous', cursive;
            /* font-size: 1rem; */
        }
        form{
            display:flex;
            flex-direction:column;
        }
        h{
            font-size:6rem;
            padding:40px;
        }
        p{
            color:white;
        }
        a{
            margin-left: 700px;
            justify-content: right;
            text-decoration: none;
            color: #9624248c;
            letter-spacing: 2px;
            font-size: 0.5rem;
        }
        p, h1{
            letter-spacing:10px;
        }
        .accueil{
            position: fixed;
            top: 5%;
            left:87%;
            margin: 10px;
            margin-right:10px;
        }
        .submit{
            color:greenyellow;
            background-color:black;
            width:50%;
            height:60%;
            margin:40px;
            padding:30px;
            margin-left:45%;
            letter-spacing:5px;
            border-radius:20px;
            font-family: 'Righteous', cursive;
        }
    </style>
</head>
<body>
<!-- titre -->
    <h>MON BLOG</h>
    <div>
        <img class="accueil" src="../assets/logo.png" alt="Logo rond - Rotavele: noir, gris et blanc avec typographie pixels" width="180px" heigt="180px" />
    </div>   
<!-- formulaire -->
    <form class="boxtext"action="" method="POST">
        <input class="boxtext" placeholder="Veuillez écrire votre titre ici" type="text" name="titre"> 
        <!-- le name=quelque chose sert a mettre en lien la variable cité dans php -->
        <textarea class="boxtext" placeholder="Vous pouvez vous lâchez les nerfs ici..." name="texte" id="" cols="30" rows="10"></textarea>
        <input class="submit" type="submit" name="submit">
    </form>

    <?php
        // boucler dans un tableau et collecter les infos puis l'afficher quelques part
        foreach($resultat as $result){

            // var_dump($result);

            echo "<div class='post'>
                    <h1>" . $result['titre'] . "</h1>
                    <p>" . $result['texte'] . "</p>
                    <a href='supprimer.php?id=". $result['id'] ."'> Supprimer</a>
                </div>";

        }
    ?>
    <!-- post -->
    <!-- peut etre supprimé car réecris differement au dessus -->
            <!-- <div class="post">
                <h1>Titre de mon post</h1>
                <p>Paragraphe de mon post</p>
            </div> -->

</body>
</html>
