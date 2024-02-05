<?php 
include_once('../auth/check_admin.php');
include('../includes/header-script.php');
if(isset($_GET['del_article'])){
    //include_once($_SERVER['DOCUMENT_ROOT'].'/admin/functions_old.php');
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
            <?php 
            foreach(show_articles() as $article) { ?>
                <tr >
                    <td><?php echo $article['title']; ?></td>
                    <td style="width:200px; text-align:end;">
                        <a href="create.php?article=<?php echo $article['id']; ?>" class="btn btn-success"><i class="bi bi-pencil"></i></a>
                        <a href="index.php?del_article=<?php echo $article['id']; ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <nav class="mt-4" aria-label="paginazione">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?=$page-1?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                </li>
                <?php endif; ?>
                <?php if ($page*$records_per_page < count_articles()): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?=$page+1?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        
    </div>
    
    <?php include('../includes/footer.php'); 
} ?>
