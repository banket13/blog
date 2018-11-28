<?php
session_start();

include('../config/config.php');
include('../lib/bdd.lib.php');

$vue='login.phtml';
$title="conexion";

$login=$_POST['email'];
//Ici il faut afficher le formulaire de login et tester les données quand il est posté !

//$_SESSION['connect'] = true;

try
{
    /** 1 : connexion au serveur de BDD - SGBDR */
    $dbh = connexion();

    /**2 : Prépare ma requête SQL */
    $sth = $dbh->prepare('SELECT * FROM users WHERE user_email LIKE $login');

    /** 3 : executer la requête */
    $sth->execute();

    /** 4 : recupérer les résultats 
     * On utilise FETCH car un seul résultat attendu
    */
    $users = $sth->fetch(PDO::FETCH_ASSOC);

   if(){

   }
   else{$_SESSION['connect'] = true;}

}
catch(PDOException $e)
{
    $vue = 'erreur.phtml';
    //Si une exception est envoyée par PDO (exemple : serveur de BDD innaccessible) on arrive ici
    $messageErreur =  'Une erreur de connexion a eu lieu :'.$e->getMessage();
}


include('tpl/layout.phtml');
