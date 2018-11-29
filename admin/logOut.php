<?php
session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');


identification();

session_unset();


$vue='logOut.phtml';
$title = 'logout';


include('tpl/layout.phtml');