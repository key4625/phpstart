<?php 

global $RECORDS_PER_PAGE, $SITEURL, $SITENAME, $MAILFROM, $MAILFROMNAME, $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME, $MAILHOST, $MAILUSER, $MAILPASS, $MAILPORT;
//Configurazione di base
$SITEURL = "http://webdesign";
$SITENAME = "Web Design";

//Configurazione per l'invio di email
$MAILFROM = "michele.cappannari@keysoluzioni.it";
$MAILFROMNAME = "Michele Cappannari";
$MAILHOST = "out.postassl.it";
$MAILUSER = "michele.cappannari@keysoluzioni.it";
$MAILPASS = "" ;
$MAILPORT = "465";

//Configurazione per la paginazione
$RECORDS_PER_PAGE = 12;

//Parametri connessione DB
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'webdesign';

?>