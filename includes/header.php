<?php  
//se non è già aperta apro la sessione
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/functions_old.php');
?>
<!doctype html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title : "Titolo"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="styesheet" href="/css/style.css">
    <?= isset($add_css) ? $add_css : "" ; ?>
  </head>
  <body> 