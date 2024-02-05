<?php include('includes/header-script.php');
foreach($_SESSION['lista_categorie'] as $sng_cat){
    if($sng_cat['slug'] == $nomecat){
        $idcat = $sng_cat['id'];
        $nomecat = $sng_cat['nome'];
    }
} 
$title = $nomecat;
include('includes/header.php');
include('includes/menu.php');

?>
<div class="container">
    <h4><?php echo $nomecat ?></h4>
    <div class="row">
    <?php
        foreach(show_category_articles($idcat) as $article) { ?>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img src="<?= ($article['link_image']!=null) ? $article['link_image'] : '/images/placeholder.png' ; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $article['title']; ?></h5>
                        <p class="card-text"><?php echo $article['description']; ?></p>
                        <a href="/articoli/<?php echo $article['slug']; ?>" class="btn btn-primary">Leggi tutto</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
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
<?php include('includes/footer.php'); ?>