<?php
session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');

identification();

$vue='addArticle.phtml';
$title="nouvel article";

//Initialisation des erreurs à false
$erreur = '';

//Tableau correspondant aux valeurs à récupérer dans le formulaire.
$values = [
'titre'=>'',
'article'=>'',
'tag'=>'',
'date'=>''];


$tab_erreur =
[
'titre'=>'Le titre doit etre renseigné !',
'article'=>'article vide!',
'tag'=>'ajouter au moins un tag'
];

try
{

    if(array_key_exists('titre',$_POST))
    {
        foreach($values as $champ => $value)
        {
            if(isset($_POST[$champ]) && trim($_POST[$champ])!='')
                $values[$champ] = $_POST[$champ];
            elseif(isset($tab_erreur[$champ]))   
                $erreur.= '<br>'.$tab_erreur[$champ];
            else
                $values[$champ] = '';
        }



        if($erreur =='')
        {
            
            $type = new SplFileInfo($_FILES["picture"]['name']);
            $uploads_dir = '../upload/image_'.$_POST['titre'].".".$type->getExtension(); 

            //$values['dateCreated'] = date('Y-m-d h:i:s');
                $values['article_user_id']=$_SESSION['user_id'];

            $dbh = connexion();

            /**2 : Prépare ma requête SQL */
            $sth = $dbh->prepare('INSERT INTO article (article_user_id, article_title, article_texte, article_commentaire, article_date) VALUES(:article_user_id,:titre, :article, :tag, :date)');

            /** 3 : executer la requête */
            $sth->execute($values);


            $file=$_FILES["picture"]['tmp_name'];
            move_uploaded_file($file, $uploads_dir);
        }

    }
}
catch(PDOException $e)
{
    $erreur.='Une erreur de connexion a eu lieu :'.$e->getMessage();
}










include('tpl/layout.phtml');