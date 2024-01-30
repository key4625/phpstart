<?php 
include_once('../auth/check_login.php');
if(isset($_GET['del_article'])){
    include_once($_SERVER['DOCUMENT_ROOT'].'/admin/functions.php');
    $delete = delete_article($_GET['del_article']);
    header("Location:/admin/index.php");
} else {
    include('../includes/header.php'); 
    include('../includes/menu.php'); 


    ?>
    <div class="container">
        <div class="d-flex justify-content-between my-3">
            <h4>Lista articoli</h4>
            <a href="create.php" class="btn btn-primary"><i class="bi bi-plus"></i> Crea nuovo</a>
        </div>
        <table class="table table-striped">
            <tr><th>Titolo</th><th>Azione</th></tr>
            <?php foreach($arr_articoli as $article) { ?>
                <tr >
                    <td><?php echo $article['title']; ?></td>
                    <td style="width:200px; text-align:end;">
                        <a href="create.php?article=<?php echo $article['slug']; ?>" class="btn btn-success"><i class="bi bi-pencil"></i></a>
                        <a href="index.php?del_article=<?php echo $article['slug']; ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php include('../includes/footer.php'); 
} ?>
