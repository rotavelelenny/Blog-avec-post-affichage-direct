<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> ROTA-BLOG - Header_user_Profile - Inside</title>
    <link rel="stylesheet" href="../css/header.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap');
</style>
</head>

<body>

    <div class="header sticky_top" id="header_sticky">
        <a class="name_site" href="../php/posts.php?id=<?php echo $idsession ?>" >ROTA BLOG</a>
            <div class="header-right">  
                <!-- <a class="inscription appear" href="php/connexion.php">Inviter tes ami(e)s</a> -->
                <a class="back_page" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"> RETOUR </a>
                
                <a class="back_all" href="../php/deconnexion.php">Se déconnecter </a> 
                
            </div>
    </div>
    <script src="js/sticky_header.js"></script>
</body>
</html>
    