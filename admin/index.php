<?php
session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');


identification();


$vue='index.phtml';
$title = 'Dashboard';


include('tpl/layout.phtml');



