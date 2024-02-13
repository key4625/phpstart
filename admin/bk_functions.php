<?php
/*
// Impostazioni generali 
$nome_file = $_SERVER['DOCUMENT_ROOT']."/admin/data/articoli.json";
$cat_file = $_SERVER['DOCUMENT_ROOT']."/admin/data/categorie.json";
$utente_scelto = "prova";
$pass_scelta = password_hash("prova", PASSWORD_BCRYPT);

//  Apro il file JSON, leggo il contenuto e lo salvo dentro un array chiamato arr_articoli 
$arr_articoli = array();
$arr_categorie = array();
if(file_exists($nome_file)){
    $dati_json = file_get_contents("$nome_file");    //leggo contenuto
    $arr_articoli = json_decode($dati_json, true); 
} else {
    $json_articoli =  json_encode($arr_articoli);
    file_put_contents($nome_file, $json_articoli);
}
if(file_exists($cat_file)){
    $dati_json_cat = file_get_contents("$cat_file");    //leggo contenuto
    $arr_categorie = json_decode($dati_json_cat, true); 
} else {
    $json_categorie =  json_encode($arr_categorie);
    file_put_contents($cat_file, $json_categorie);
}
$_SESSION['articoli_json'] = $arr_articoli;
$_SESSION['nome_file'] = $nome_file;
$_SESSION['lista_categorie'] = $arr_categorie;

// Mostra gli articoli in homepage (max numero numArticles) 
function show_index_articles(int $numArticles) {
    $arr_articoli = $_SESSION['articoli_json'];
    $start = count($arr_articoli)-1;
    $new_array = array();
    if(count($arr_articoli)<$numArticles) {
        $numArticles = $start;
    } 
    for($i=$start;$i>$start-$numArticles-1;$i--){
        $new_array[] = $arr_articoli[$i];       
    } 
    return $new_array;
}

//  Mostra tutti gli articoli di una categoria 
function show_category_articles(int $idCategory) {
    $arr_articoli = $_SESSION['articoli_json'];
    $new_array = array();
    foreach($arr_articoli as $articolo){        
        if($articolo['category_id'] == $idCategory) $new_array[] = $articolo;
    }
    return $new_array;
}

//  Mostra il singolo articolo a partire dallo slug
function show_article($slug){
    $arr_articoli = $_SESSION['articoli_json'];
    $articolo = null;
    foreach($arr_articoli as $singolo){
        if($singolo['slug'] == $slug) $articolo = $singolo;
    }
    return $articolo;
}

// Scrive un nuovo articolo nel file json 
function create_article($title,$description,$link_image,$category_id) {
    $arr_articoli = $_SESSION['articoli_json'];
    $nome_file = $_SESSION['nome_file'];
    $nuovo_articolo = new Article();
    $nuovo_articolo->slug = slugify($title);
    $nuovo_articolo->title = $title;
    $nuovo_articolo->description = $description;
    if($link_image != null) $nuovo_articolo->link_image = $link_image;
    $nuovo_articolo->category_id = $category_id;
    $nuovo_articolo->date_created = date("Y-m-d H:i:s");
    //aggiungi alla variabile arr_articoli altro oggetto di tipo articolo
    $isDuplicated = false;
    foreach($arr_articoli as $singolo){
        if($singolo['slug']== $nuovo_articolo->slug){
            $isDuplicated=true;
        }
    }
    if(!$isDuplicated){
        try {
            $arr_articoli[] = $nuovo_articolo; 
            //con il metodo json_encode trasformo la variabile array in una stringa di formato json
            $json_articoli =  json_encode($arr_articoli);
            //salvo la stringa in un file
            file_put_contents($nome_file, $json_articoli);
            return 1;
        } catch (Exception $ex){
            return 0;
        }
    } else return 2;
}

function update_article($title,$slug,$description,$link_image,$category_id) {
    $arr_articoli = $_SESSION['articoli_json'];
    $nome_file = $_SESSION['nome_file'];
    $nuovo_articolo = null;
    foreach($arr_articoli as $singolo){
        if($singolo['slug'] == $slug){
            $nuovo_articolo = $singolo;
        } 
    }
    $nuovo_articolo['slug'] = slugify($title);
    $nuovo_articolo['title'] = $title;
    $nuovo_articolo['description'] = $description;
    $nuovo_articolo['link_image'] = $link_image;
    $nuovo_articolo['category_id'] = $category_id;
    $nuovo_articolo['date_created'] = date("Y-m-d H:i:s");

    $newData = array_filter($arr_articoli, function ($var) use ($slug) { 
        return ($var['slug'] != $slug); 
    });
    $isDuplicated = false;
    foreach($newData as $sng_slug){
        if($sng_slug['slug']== $nuovo_articolo['slug']){
            $isDuplicated=true;
        }
    }
    if(!$isDuplicated){
        //aggiungi alla variabile arr_articoli altro oggetto di tipo articolo
        try {
           
            $newData[] = $nuovo_articolo; 
            //con il metodo json_encode trasformo la variabile array in una stringa di formato json
            $json_articoli =  json_encode(array_values($newData));
            //salvo la stringa in un file
            file_put_contents($nome_file, $json_articoli);
            return 1;
        } catch (Exception $ex){
            return 0;
        }
    } else return 2;
}

// Cancella dal json l'articolo con l'id selezionato 
function delete_article($slug) {
    $arr_articoli = $_SESSION['articoli_json'];
    $nome_file = $_SESSION['nome_file'];
    $newData = array_filter($arr_articoli, function ($var) use ($slug) { 
        return ($var['slug'] != $slug); 
    }); 
    $delete = file_put_contents($nome_file, json_encode(array_values($newData))); 
    return $delete?true:false; 
}

// Crea uno slug a partire da un testo 
function slugify($text, string $divider = '-')
{
  // replace non letter or digits by divider
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  // trim
  $text = trim($text, $divider);
  // remove duplicate divider
  $text = preg_replace('~-+~', $divider, $text);
  // lowercase
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}

function get_category_name($name){
    switch ($id) {
        case 1:
            return "Generale";
            break;
        case 2:
            echo "i equals 1";
            break;
        case 3:
            echo "i equals 2";
            break;
    }
}
// Definizione dell'oggetto (o classe) articolo 
class Article {
    public string $slug;
    public string $title;
    public int $category_id;
    public string $description;
    public string $link_image;
    public string $date_created;
}
*/



?>