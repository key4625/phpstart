<?php  
//se non è già aperta apro la sessione
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions//functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/functions_old.php');
?>