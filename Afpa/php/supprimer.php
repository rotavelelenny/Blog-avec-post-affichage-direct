<?php

// récuperer mon id
$idDuGet =$_GET['id'];

// connexion
$bdd =  new PDO("mysql:host=localhost;dbname=blog", "root", "");


// envoyer la requête
$delete = $bdd->prepare("DELETE FROM posts WHERE id = ?");
// besoin de l'id?
$delete->execute ([$idDuGet] );

// renvoyer vers la page index 
header("Location:index.php");





?>

<!-- 
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
            margin-top:5%;
            width:68%;
            background-color:greenyellow;
            padding:30px;
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
            text-decoration:none;
            color:#ccc;
        }
        p, h1{
            letter-spacing:10px;
        }
        .accueil{
            position: absolute;
            top: 10%;
            left:85%;
            margin: auto 0;
        }
    </style>
</head>
<body>
    <h>SUPPRESSIONS</h>
    <div>
        <img class="accueil" src="./assets/logo.png" alt="LOGO" width="200px" heigt="200px" />
    </div> 
</body>
</html> -->
