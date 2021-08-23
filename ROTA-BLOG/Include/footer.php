
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> ROTA-BLOG - Footer</title>
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/Popup_about.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap');
</style>
</head>

<body>

    <footer>
        <div class="container_son">

            <div id="btnPopup" class="about_blog">About</div>
            <div id="overlay" class="overlay">
                <div id="popup" class="popup">  
                    <span id="btnClose" class="btnClose">&times;</span>
                    <div class="explain_about">
                        <h2>
                            Pourquoi un blog?
                        </h2>
                        <p1>
                            J'ai créé ce blog afin d'aborder le <strong>CRUD</strong> &#40;Creat. Read. Update. Delete&#41;. 
                            Comprenant un système de postage &#40;POST&#41; d'article ainsi qu'un profil utilisateur 
                            <br>J'ai souhaité me perfectionner dans la façon de rédiger mes codes, autant concernant l'<strong>arborescence</strong> que le <strong>POO</strong>.
                            </br>
                        </p1> 
                
                        <h2>
                            Pour qui ce blog est-il?
                        </h2> 
                            <p1>

                            </p1>
                
                        <h2>
                            Comment ai-je conçu ce blog?
                        </h2>
                            <p1>
                                <br>L'utilisation du language PHP et les techniques de sécurisation nécessaire à une inscritpion <strong>Login</strong> à une page web type.
                                <br>La protection des données des utilisateur via le hashage des mots de passe, fait parti intégrante des sites fiable. Lors du renvoi d'un mot de passe oublié, hasher les données envoyées ou récupéré écarte toutes possibilitées de récupération d'informations sur l'identité d'un utilisateur.
                                <br>Ce projet m'a permis d'aborder plusieurs techniques différentes, me questionner, chercher de la documentation, des tutoriels pour ainsi améliorer en continue ce blog.
                                <br>Concevoir une base de données &#40;MySql&#41; avec l'aide du Designer, ou encore de MySqlWorkbench pour le maquettage en amont du projet.
                                <br>Un projet comme celui-ci est très formateur afin d'élaborer une partie utilisateur &#40;User&#41;autrement dit une <strong>Interface utilisateur</strong> et une partie administrateur &#40;Admin&#41;nommé <strong>Back-office</strong>. Penser conception avant réalisation, et savoir organiser mon travail via du maquettage et de la logique de conception &#40;UX/UI&#41;.
                            </p1>
                
                        <h2>
                            De quoi ce blog est-il composé?
                        </h2>
                            <p1>
                                
                            </p1>
                    </div>
                </div>
            </div>
        
            <p2 class="by">Développé par Lenny VAZEILLE - 2021</p2>
        
        </div>
    </footer>
    <script src="../js/Popup_about.js"></script>
</body>
</html>