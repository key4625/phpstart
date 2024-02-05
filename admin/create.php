<?php 
$title = "Crea articolo";

$add_css = '<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">';
$add_script = '<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>';
$add_script .= '<script src="/admin/includes/custom-quill.js"></script>';

include('/auth/check_login.php');
include('../includes/header.php'); 
include('../includes/menu.php'); 

?>
<div class="container">
    <?php 
    //Controllo se è impostato article allora sono sulla schermata di modifica
    if(isset($_GET['article'])){
        $articolo = show_article($_GET['article']);
    } else $articolo = null;

    if(isset($_POST['titolo'])){
        /* Controllo se devo salvare una immagine */
        $url_img = null;

        if($_FILES["link_image"]!=null){
            $target_dir = $_SERVER['DOCUMENT_ROOT']."/images/";
            $target_file = $target_dir . basename($_FILES["link_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["link_image"]["tmp_name"]);
            
            if($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "Il file non è un'immagine";
                $uploadOk = 0;
            }
            if ($_FILES["link_image"]["size"] > 500000) {
                echo "Il file supera le dimensioni di 5M";
                $uploadOk = 0;
            }
            
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "Sono consentiti solo formati JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        
            if ($uploadOk == 0) {
                echo "Il file non è corretto";
            } else {
                
                if (move_uploaded_file($_FILES["link_image"]["tmp_name"], $target_file)) {
                    $url_img = "/images/".$_FILES["link_image"]["name"];
                    //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                } else {
                    echo "Errore nel caricamento del file";
                }
            }
        }
        if(($_POST['slug'] != null)&&($_POST['slug'] != "")){   
             //chiama la funzione update_article passando anche lo slug 
            $risultato = update_article($_POST['titolo'],$_POST['slug'],$_POST['descrizione'],$url_img,$_POST['category_id']); 
        } else {
            //chiama la funzione create_article che sta dentro il functions_old.php  
            $risultato = create_article($_POST['titolo'],$_POST['descrizione'],$url_img,$_POST['category_id']); 
        }
        if($risultato == 1){
            ?>
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h3>Articolo Creato</h3>
                    <p>Il tuo articolo è stato creato/modificato con successo</p>
                </div>
            </div>
        <?php } else {
               ?>
               <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h3>Errore Articolo</h3>
                        <p>Il tuo articolo esiste già o contiene un errore.</p>
                    </div>
                </div>
            <?php 
        }
        ?>
        <div class="text-center my-4">
        <a class="btn btn-primary" href="/home"><i class="bi bi-house-door"></i> Torna alla home</a>
            <a class="btn btn-primary" href="create.php">Inserisci un altro articolo</a>
        </div>
        <?php   
    } else { ?>
        <h4>Inserisci articolo</h4>
        <form method="POST" action="create.php" id="create-form" enctype="multipart/form-data">
            <input type="hidden" name="slug" value="<?= ($articolo!=null) ? $articolo['slug'] : ''; ?>">
            <div class="mb-4">
                <label>Titolo</label>
                <input type="text" class="form-control" name="titolo" value="<?= ($articolo!=null) ? $articolo['title'] : ''; ?>">
            </div>
            <div class="mb-4">
                <label>Descrizione</label>
                <div id="editor" style="min-height: 200px;"></div>
                <textarea class="form-control" name="descrizione" row="3" style="display:none" id="hiddenArea"></textarea>
            </div>
            <div class="mb-4">
                <label>Categoria</label>
                <select class="form-control" name="category_id">
                    <?php
                    foreach($_SESSION['lista_categorie'] as $sng_cat){ ?>
                        <option value="<?= $sng_cat['id'] ?>" <?= (($articolo!=null)&&($articolo['category_id']==$sng_cat['id'])) ? "selected=selected" : ""; ?> ><?= $sng_cat['nome'] ?></option>
                   <?php
                    }
                    ?>
                    
                </select>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Inserisci immagine</label>
                <input class="form-control" name="link_image" type="file" id="formFile">
            </div>
            <?php if(($articolo!=null)&&($articolo['link_image']!=null)){ ?>
                <img src="<?= $articolo['link_image']; ?>" class="img-fluid my-4" style="max-width:500px;">
            <?php } ?>
           
            <div class="text-center mb-4">
                <input type="submit" class="btn btn-success" value="Salva">
            </div>
        </form>
    <?php } ?>
</div>
<?php include('../includes/footer.php'); ?>
