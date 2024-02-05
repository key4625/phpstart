<?php 
include('includes/header-script.php');
$articolo_da_visualizzare = show_article_slug($art_slug); 
$title = $articolo_da_visualizzare['title'];
include('includes/header.php');
include('includes/menu.php');
 ?>
<div class="container">
    <?php 
    echo "<h3>".$articolo_da_visualizzare['title']."</h3>";
    ?>
    <?php 
    if($articolo_da_visualizzare['link_image']!=null) {
        echo '<img src="'.$articolo_da_visualizzare['link_image'].'" class="img-fluid" style="max-height:400px;">';
    }
    ?>
    <p><?php echo $articolo_da_visualizzare['description']; ?></p>
   
    
</div>
<?php include('includes/footer.php'); ?>
