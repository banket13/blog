<?php
session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');


identification();

$vue='listUser.phtml';
$title='liste utilisateur';



try
{
    /** 1 : connexion au serveur de BDD - SGBDR */
    $dbh = connexion();

    /**2 : Prépare ma requête SQL */
    $sth = $dbh->prepare('SELECT * FROM users ');

    /** 3 : executer la requête */
    $sth->execute();

    /** 4 : recupérer les résultats 
     * On utilise FETCH car un seul résultat attendu
    */
    $auteurs = $sth->fetchAll(PDO::FETCH_ASSOC);

   

}
catch(PDOException $e)
{
    $vue = 'erreur.phtml';
    //Si une exception est envoyée par PDO (exemple : serveur de BDD innaccessible) on arrive ici
    $messageErreur =  'Une erreur de connexion a eu lieu :'.$e->getMessage();
}

include('tpl/layout.phtml');