<?php  
//Questo server per far visualizzare gli errori php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//se non è già aperta apro la sessione
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Valore di default per la paginazione
global $page; 
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

//includo i file necessari
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions/functions.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/admin/functions_old.php');

//includo le classi
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/models/Category.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/models/Article.php');
?>