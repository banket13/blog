<?php
session_start();

include('../config/config.php');
include('../lib/bdd.lib.php');

$vue='login.phtml';
$title="Log in";
$erreur=false;


//Ici il faut afficher le formulaire de login et tester les données quand il est posté !



try{
    if(array_key_exists('email',$_POST)){
        
        $data=[
			'email' => $_POST['email'],
			'password' => $_POST['password']
		];



        /** 1 : connexion au serveur de BDD - SGBDR */
        $dbh = connexion();

        /**2 : Prépare ma requête SQL */
        $sth = $dbh->prepare('SELECT * FROM users WHERE user_email = :email');
        
        /** 3 : executer la requête */
        $sth->execute(array('email'=>$data['email']));
        
        /** 4 : recupérer les résultats 
         * On utilise FETCH car un seul résultat attendu
        */
        $user = $sth->fetch(PDO::FETCH_ASSOC);
        

        

        if($user==false){
            $erreur='identification impossible';
        }
        else{
            $hash=$user['user_password'];
            if (password_verify($data['password'], $hash)) {
                $_SESSION['connect'] = true;
                $_SESSION['nom']= $user['user_nom'];
                $_SESSION['user_id']=$user['user_id'];
                header('location:index.php');
            } else {
                $erreur='identification impossible';
            }
        }
    }
}
catch(PDOException $e)
{
    $vue = 'erreur.phtml';
    //Si une exception est envoyée par PDO (exemple : serveur de BDD innaccessible) on arrive ici
    $messageErreur =  'Une erreur de connexion a eu lieu :'.$e->getMessage();
}


include('tpl/layout.phtml');
