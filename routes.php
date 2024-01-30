<?php

require_once __DIR__.'/router.php';

//Inserite qui le url delle pagine
get('/', 'index.php');
get('/home', 'index.php');
get('/chisono', 'chisono.php');

//url categoria e singoli articoli
get('/categoria/$nomecat', 'category.php');
get('/articoli/$art_slug', 'single.php');

// Questa è per le pagine che non esistono
any('/404','404.php');