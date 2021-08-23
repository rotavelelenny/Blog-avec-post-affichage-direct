<?php
session_start();
    // connexion bdd
include ("Include/database.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> ROTA-BLOG - Index</title>
    <link rel="stylesheet" href="css/index_style.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    </style>
</head>
<body> 
    <div class="container_index">
        
        <div class="left_index">  
            <h1>ROTA BLOG</h1>
        </div>
        
        <div class="right_index">
            <a class="connect" href="php/connexion.php">Se connecter</a>
            <!-- fun snake -->  
            <div class="view_port">
                <div class="cylon_eye"></div>
            </div>
            <a class="sign_up" href="php/inscription.php">Inscription</a>
        </div>

    </div>


</body>
</html>