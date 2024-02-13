<?php 
$title = "Homepage";
include('includes/header-script.php');
include('includes/header.php'); 
include('includes/menu.php'); 
?>
<div class="container">
    <h4>Benvenuti</h4>
    <div class="row">
    <!-- Mostro gli ultimi articoli e la paginazione -->
    <?php
        foreach(show_articles() as $article) { ?>
            <div class="col-12 col-md-4">
                <div class="card">                 
                    <img src="<?= ($article['link_image']!=null) ? $article['link_image'] : 'images/placeholder.png' ; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $article['title']; ?></h5>
                        <p class="card-text"><?php echo $article['description']; ?></p>
                        <a href="articoli/<?php echo $article['slug']; ?>" class="btn btn-primary">Leggi tutto</a>
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
            <?php if ($page*$RECORDS_PER_PAGE< count_articles()): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?=$page+1?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<?php include('includes/footer.php'); ?>
