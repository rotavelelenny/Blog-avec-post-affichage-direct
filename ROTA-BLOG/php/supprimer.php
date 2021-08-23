<?php
session_start();
// recupéré mon id
$idDuGet = $_GET['id'];

// connexion
include ("../Include/database.php");

// envoyer la requete
$delete = $bdd->prepare("DELETE FROM posts WHERE id = ?");
$delete->execute( [$idDuGet] );

// renvoyer vers la page index
$idsession = $_SESSION['id'];

header("Location: posts.php?id=$idsession");


