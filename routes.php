<?php

require_once __DIR__.'/router.php';

//Queste qui sono le route che definiscono ciascun url quale pagina del sito deve mostrare

//Inserite qui le url delle pagine
get('/', 'index.php');
get('/home', 'index.php');
get('/chisono', '/views/chisono.php');
get('/profilo', '/views/profile.php');
get('/login', '/auth/login.php');
get('/registrazione', '/auth/registration.php');

//url categoria e singoli articoli
get('/categoria/$nomecat', '/views/cat-article.php');
get('/articoli/$art_slug', '/views/article.php');

// Questa è per le pagine che non esistono
any('/404','404.php');