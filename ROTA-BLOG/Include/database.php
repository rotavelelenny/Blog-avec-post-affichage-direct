<?php
// I try to connect my databse
try{
$bdd = new PDO("mysql:host=localhost;dbname=rotablog","root", ""); 
// if i have a mistake about something, for example the name of the database(blog) 
// That will show an error message  
}
catch (PDOException $e)
{
    print "Erreur : " . $e->getMessage() ."<br/>";
}
