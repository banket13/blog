<?php
session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');

identification();

$vue='addUser.phtml';
$title="nouvel utilisateur";
$erreur=false;
$user=false;
$data=[
	'name' =>'',
	'firstName' => '',
	'mail' => '' ,
	'password' => '',
	'password2' => '',
	'pseudo' => '',
	'role' => ''
];

try{ 
	if (array_key_exists("name",$_POST)){


		$data=[
			'name' => $_POST['name'],
			'firstName' => $_POST['firstName'],
			'mail' => $_POST['mail'],
			'password' => $_POST['password'], 
			'password2' => $_POST['password2'],
			'pseudo' => $_POST['pseudo'],
			'role' => $_POST['role']
		];


		$mail=$_POST['mail'];
		//vérification que c est bien une adresse mail

		if (filter_var($mail, FILTER_VALIDATE_EMAIL)==false){
			$erreur="ce n'est pas une adresse mail";
		} 
		else{
			if ($_POST['password']!=$_POST['password2']){
				$erreur="les mots de passe sont différents";
			}
			else{
				$data=[
					'name' => $_POST['name'],
					'firstName' => $_POST['firstName'],
					'mail' => $mail ,
					'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
					'pseudo' => $_POST['pseudo'],
					'role' => $_POST['role']
				];



				/** 1 : connexion au serveur de BDD - SGBDR */
				$dbh = connexion();

				/**2 : Prépare ma requête SQL */
				$sth = $dbh->prepare('INSERT INTO users VALUES (NULL, :name, :firstName, :mail, :password, :pseudo, :role)');

				/** 3 : executer la requête */
				$sth->execute($data);
				$data=[
					'name' =>'',
					'firstName' => '',
					'mail' => '' ,
					'password' => '',
					'password2' => '',
					'pseudo' => '',
					'role' => ''
				];
				$user="contact bien enregistré";
			}
		}
	}
}
catch(PDOException $e){
	$vue = 'erreur.phtml';
	//Si une exception est envoyée par PDO (exemple : serveur de BDD innaccessible) on arrive ici
	$messageErreur =  'Une erreur de connexion a eu lieu :'.$e->getMessage();
}


include('tpl/layout.phtml');